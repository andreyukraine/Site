<?php 
	ini_set('display_errors', 'on'); error_reporting(E_ALL);
	require_once('lib/global.php');
	function smarket_get_autors(){
		global $config_smarket;
		$query1 = 'SELECT 
			b.id as IE_XML_ID,
			b.isNotForSite as IE_DISABLED
			FROM properties b
			where b.name <> "" and b.type = 6
		';

		$a = model('db', $config_smarket)->sql($query1); $max = 0;
		foreach ($a->items as &$i) {
			$max++;
		} unset($i);
		$a->max = $max;
		return $a;
	}
	function create_csv($obj, $name){
		if(gettype($obj)!='object' || !$obj->max) return 0;
		$str = implode(';', array_keys($obj->items[0])).';'.PHP_EOL;
		foreach ($obj->items as $i) {
			foreach ($i as $k=>$v) {
				$v = preg_replace(array('~"~', '~ {2,}~', '~ $~'), array('""', ' ', ''), $v);
				if(preg_match("~[\";\r\n]~", $v)) $v = '"'.$v.'"';
				$str.= $v.';';
			}
			$str.=PHP_EOL;
		}
		if(file_put_contents(dirname(__FILE__).'/'.$name.'.csv', $str));
		return 1;
	}
	header('Content-type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="ru">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Синхронизация авторов</title>
		<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet">
	</head>
	<body class="container">
		<div class="content">
			<h1 class="text-center">Синхронизация авторов Smarket -> Битрикс</h1>
			<ol>
				<li>Экспорт авторов из Smarket-a ... <?php $a = smarket_get_autors(); echo ($a->max?'('.$a->max.') Ok':'Пусто'); ?></li>
				<?php  ?>
				<li>Создание CSV ... <?php echo (create_csv($a, 'autors_all')?'Ok':'Пусто'); ?></li>
				<?php  ?>
			</ol>
			<?php 
			debug($a); ?>
		</div>
		<script src="//code.jquery.com/jquery.js"></script>
		<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
	</body>
</html>