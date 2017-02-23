<?php 
	ini_set('display_errors', 'on'); error_reporting(E_ALL);
	require_once('lib/global.php');
	function smarket_get_products(){
		global $config_smarket;
		$query1 = "SELECT 
			CAST(a.plu_cod as INT) as IE_XML_ID, 
			a.name as IE_NAME,
			m.ParentId as IP_PROP130,
			a.sold_count as IP_PROP131
			FROM componen a
				LEFT JOIN AllProperties m on CAST(a.nnt as INT) = m.BaseId AND m.ParentId in (
					select id FROM properties where type = 6
				)
			WHERE 
					a.name <> ''
			GROUP BY 
				a.plu_cod,
				a.name, 
				m.ParentId,
				a.sold_count
			order by a.plu_cod desc
		";

		$a = model('db', $config_smarket)->sql($query1); $max = 0;
		// debug($a);
		if(!empty($a->items)) foreach ($a->items as &$i) {
			$max++;
		} unset($i);
		$a->max = $max;
		return $a;
	}
	function create_csv($obj){
		if(gettype($obj)!='object' || !$obj->max) return 0;
		foreach ($obj->items as $i) { $str = implode(';', array_keys($i)).';'.PHP_EOL; break; }
		foreach ($obj->items as $i) {
			foreach ($i as $k=>$v) {
				$v = preg_replace(array('~"~u', '~ {2,}~u', '~(^ | $)~u'), array('""', ' ', ''), $v);
				if(preg_match("~[\";\r\n]~u", $v)) $v = '"'.$v.'"';
				$str.= $v.';';
			} $str.=PHP_EOL;
		}
		if(file_put_contents(dirname(__FILE__).'/tovari_autors.csv', $str)) return 1; return 0;
	}
	header('Content-type: text/html; charset=utf8');
?>
<!DOCTYPE html>
<html lang="ru">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Синхронизация товаров</title>
		<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet">
	</head>
	<body class="container">
		<div class="content">
			<h1 class="text-center">Синхронизация авторов и товаров Smarket -> Битрикс</h1>
			<ol>
				<li>Экспорт связей авторов и товаров из Smarket-a ... <?php $a = smarket_get_products(); echo ($a->max?'('.$a->max.') Ok':'Ошибка'); ?></li>
				<li>Создание CSV ... <?php echo (create_csv($a)?'Ok':'Ошибка'); ?></li>
			</ol>
			<?php /* ?>
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
							<?php if($k=='IE_CODE') { ?>
							<div style="max-width:150px; white-space: nowrap; text-overflow: ellipsis; overflow: hidden"><?php echo $j; ?></div>
							<?php } ?>
						</td>
						<?php } ?>
					</tr>
				<?php } ?>
			</tbody></table>
			<?php */ ?>
		</div>
		<script src="//code.jquery.com/jquery.js"></script>
	</body>
</html>