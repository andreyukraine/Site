<?php
ini_set('display_errors', 'on'); error_reporting(E_ALL);
require_once('lib/global.php');

function smarket_get_products(){

	global $config_smarket;

	$query1 = "SELECT 
        CAST(a.plu_cod as INT) as IE_XML_ID,
        z.name AS ORIG_TITLE
    FROM componen a
        LEFT JOIN AllProperties s on CAST(a.nnt as INT) = s.BaseId AND s.ParentId in (
            select id FROM properties where type = 8
        )
        LEFT JOIN properties z on s.ParentId = z.id AND z.type = 8
    WHERE
        z.name <> ''
    GROUP BY
        a.nnt,
        a.plu_cod,
        z.name
    ORDER BY a.nnt ASC
	";

	$a = model('db', $config_smarket)->sql($query1);

    $a->max = count($a->items);

	return $a;
}

function create_csv($obj, $name){
    
	if(gettype($obj)!='object' || !$obj->max) return 0;
	foreach ($obj->items as $i) { $str = implode(';', array_keys($i)).';'.PHP_EOL; break; }
	foreach ($obj->items as $i) {
		foreach ($i as $k=>$v) {
			$v = preg_replace(array('~"~u', '~ {2,}~u', '~(^ | $)~u'), array('""', ' ', ''), $v);
			if(preg_match("~[\";\r\n]~u", $v)) $v = '"'.$v.'"';
			$str.= $v.';';
		}
		$str.=PHP_EOL;
	}
	// debug($str);
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
	<title>Синхронизация товаров</title>
	<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container">
<div class="content">
	<h1 class="text-center">Синхронизация товаров Smarket -> Битрикс</h1>
	<ol>
		<li>Экспорт товаров из Smarket-a ... <?php $a = smarket_get_products(); echo ($a->max?'('.$a->max.') Ok':'Пусто'); ?></li>
		<?php  ?>
		<li>Создание CSV ... <?php echo (create_csv($a, 'product_original_names')?'Ok':'Пусто'); ?></li>
		<?php  ?>
	</ol>
	<?php
	// debug($a); ?>
</div>
<script src="//code.jquery.com/jquery.js"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
</body>
</html>