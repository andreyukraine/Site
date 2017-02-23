<?php 
	ini_set('display_errors', 'on'); error_reporting(E_ALL);
	require_once('lib/global.php');
	function get_sales(){
		global $config_bitrix;
		$a = array();
		$query = 'DELETE FROM b_iblock_element_property WHERE IBLOCK_PROPERTY_ID = 132';
		$res = model('db', $config_bitrix)->sql($query);
		$query = 'INSERT INTO b_iblock_element_property (IBLOCK_PROPERTY_ID, IBLOCK_ELEMENT_ID,
			VALUE, VALUE_ENUM, VALUE_NUM, VALUE_TYPE)
			SELECT 132, PRODUCT_ID, CAST(sum(QUANTITY) as UNSIGNED), sum(QUANTITY), sum(QUANTITY), \'text\'
			FROM b_sale_basket
			WHERE ORDER_ID IS NOT NULL
			GROUP BY PRODUCT_ID';
		$res = model('db')->sql($query);
		return $res;
	}
	header('Content-type: text/html; charset=utf-8');
	$a = get_sales(); 
?>
<!DOCTYPE html>
<html lang="ru">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Синхронизация продаж в Битрикс</title>
		<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet">
	</head>
	<body class="container">
		<div class="content">
			<h1 class="text-center">Синхронизация продаж в Битрикс</h1>
			<ol>
				<li>Обновлено <?php echo $a->max; ?> значенией</li>
			</ol>
		</div>
		<script src="//code.jquery.com/jquery.js"></script>
		<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
	</body>
</html>