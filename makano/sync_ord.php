
<?php

	require_once('lib/global.php');
	require_once('lib/tools.php');
	
	function bitrix_get_orders()
	{

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
					OR a.STATUS_ID = 'Z'
					AND b.CURRENCY = j.CURRENCY
					ORDER BY -a.ID
			";
		$a = model('db', $config_bitrix)->sql($query1);
		
		
		$a->max = count($a->items);
		
		return $a;
	}

	//Экспорт заказов из Битрикс-a
 	$i = bitrix_get_orders();
	
	//Создание XML файлов ...
	create_xml_orders($i);
	


	
	//логи в файл
	$fd = fopen("/home/bitrix/www/my_orders.txt","a"); 
	fwrite($fd, "Обращение к файлу - ".date("d.m.Y H:i")."\r\n"); 
	fclose($fd);
	
	
?>