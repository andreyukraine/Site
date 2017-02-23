<?php 
	ini_set('display_errors', 'on'); error_reporting(E_ALL);
	require_once('lib/global.php');
	function smarket_get_products(){
		global $config_smarket;
		$query1 = "SELECT TOP 500
			CAST(a.plu_cod as INT) as IE_XML_ID, 
			CAST(a.kol_tmp as INT) IE_ACTIVE
			FROM componen a
			WHERE 
					a.name <> ''
				AND a.updated >= '".date("Ymd", strtotime('-1 day'))."'
			order by a.updated desc
		";

		$a = model('db', $config_smarket)->sql($query1); $max = 0;
		foreach ($a->items as &$i) {
			$i['IE_ACTIVE'] = empty($i['IE_ACTIVE'])?1:0;
			$max++;
		} unset($i);
		$a->max = $max;
		return $a;
	}
	function create_csv($obj){
		if(gettype($obj)!='object' || !$obj->max) return 0;
		$str = implode(';', array_keys($obj->items[0])).PHP_EOL;
		foreach ($obj->items as $i) {
			foreach ($i as $k=>$v) {
				$v = preg_replace('~"~', '""', $v);
				if(preg_match("~[\";\r\n]~", $v)) $v = '"'.$v.'"';
				$str.= $v.';';
			} $str.=PHP_EOL;
		}
		if(file_put_contents(dirname(__FILE__).'/tovari_active.csv', $str)) return 1; return 0;
	}
	function import_csv($obj){
		global $config_bitrix;
		model('db', $config_bitrix);
		if(gettype($obj)!='object' || !$obj->max) return 0;
		$arr = array('ok'=>0, 'error'=>0);
		foreach ($obj->items as $i) {
			$str = 'UPDATE b_iblock_element a SET a.`ACTIVE` = "'.($i['IE_ACTIVE']?'Y':'N').'" WHERE a.XML_ID = '.$i['IE_XML_ID'].";\r\n";
			$res = model('db')->sql($str);
			// debug($res);
			$arr[$res->max?'ok':'error']++;
		}
		return $arr['ok'];
	}
	header('Content-type: text/html; charset=utf8');
?>
<!DOCTYPE html>
<html lang="ru">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Синхронизация активности товаров</title>
		<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet">
	</head>
	<body class="container">
		<div class="content">
			<h1 class="text-center">Синхронизация товаров Smarket -> Битрикс</h1>
			<ol>
				<li>Экспорт товаров из Smarket-a ... <?php $a = smarket_get_products(); echo ($a->max?'('.$a->max.') Ok':'Ошибка'); ?></li>
				<li>Импорт CSV в Битрикс ... <?php echo (import_csv($a)?'Ok':'Ошибка'); ?></li>
			</ol>
			<table border="1" width="100%">
				<thead><tr>
					<?php $keys = @array_keys(@$a->items[0]); if(!empty($keys)) foreach ($keys as $i) { ?>
					<th><?php echo $i; ?></th>
					<?php } ?>
				</tr></thead>
				<tbody>
				<?php if($a->max) foreach ($a->items as $i) { ?>
					<tr>
						<?php foreach ($i as $k=>$j) { ?>
						<td>
							<div style="max-width:150px; white-space: nowrap; text-overflow: ellipsis; overflow: hidden"><?php echo $j; ?></div>
						</td>
						<?php } ?>
					</tr>
				<?php } ?>
			</tbody></table>
		</div>
		<script src="//code.jquery.com/jquery.js"></script>
	</body>
</html>