<?php

	$date = date("Y-m-d");
	//$date = date('Y-m-d', strtotime('-20 days'));
	
	require_once('lib/global.php');
	
	function bitrix_get_orders()
	{

		//$date = $date ? date('Y-m-d', strtotime($date)) :  date('Y-m-d'); 
		
		global $config_bitrix;
		$query1 = "SELECT 
				c.XML_ID as 'Article', 
				concat('\"', c.NAME, '\"') as 'name',
				b.PRICE as 'Cost', b.CURRENCY as 'Currency', j.AMOUNT as 'CurVal',
				CAST(b.QUANTITY as UNSIGNED) as 'kol',
				a.ID as 'Order',
				a.DATE_INSERT as 'Date'
				FROM b_sale_order a 
					LEFT JOIN b_sale_basket b on a.ID = b.ORDER_ID
					LEFT JOIN b_iblock_element c on c.ID = b.PRODUCT_ID
					LEFT JOIN b_catalog_currency j on j.CURRENCY = b.CURRENCY
				WHERE 
					a.STATUS_ID = 'N'
					AND b.CURRENCY = j.CURRENCY
					ORDER BY -a.DATE_INSERT
			";
		$a = model('db', $config_bitrix)->sql($query1);
		//print_r($query1);
		$a->max = count($a->items);
		return $a;
	}

	

?>
<!DOCTYPE html>
<html lang="ru">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Синхронизация заказов</title>
		<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet">
	</head>
	<body class="container">
		<div class="content">
			<h1 class="text-center">Синхронизация заказов Smarket -> Битрикс</h1>
			<ol>
				<li>Экспорт заказов из Битрикс-a ... <?php $b = bitrix_get_orders(); echo($b->max ? '(' . $b->max . ') Ok' : 'Пусто'); ?></li>
				<li>Создание XML файлов ... <?php echo(create_xml_orders($b) ? 'Ok' : 'Пусто'); ?></li>
			</ol>
		</div>
		
	</body>
</html>