<?php

// получаем id на рек товар из товара который ссылается на заданный из базы s-market
function findBackLinkById($id)
{
	global $config_smarket;

    // формируем запрос к бд
    // взять внешний код и найти товар с ссылкой равной текущему товару и найденый товар не должен быть равен своей ссылке
    $qwery = "SELECT nnt AS ID FROM componen WHERE TLINK = " .$id. " AND nnt <> TLINK";
    $request = model('db', $config_smarket)->sql($qwery);

    // обрабатываем полученный результат
    if($request->max == 1) {
        return $request->items[0]['ID'];
    } elseif ($request->max == 0) {
        return '';
    }
}

// получаем артикул товара по id товара из бд с-маркета
function getArtNumberById($id)
{
	global $config_smarket;

    // формируем запрос к бд
    $qwery = "SELECT plu_cod AS ID FROM componen WHERE nnt = " . $id;
    $request = model('db', $config_smarket)->sql($qwery);

    // обрабатываем полученный результат
    if($request->max != 0) {
        return $request->items[0]['ID'];
    } elseif ($request->max == 0) {
        return '';
    }
}

//получаем реальный ID товара по внешнему коду (артикул) из бд битрикса
function getBitrixIdByArtNumberId($id)
{
	global $config_bitrix;

    $qwery1 = "SELECT t.ID FROM bitrix.b_iblock_element t WHERE XML_ID = ". intval($id) ." AND IBLOCK_ID = 2";
    $request = model('db', $config_bitrix)->sql($qwery1);
	//$request = model('db', $config_smarket)->sql($query1);

    if ($request->max == 1) {
        // если найдено возвращаем реальный id битрикса
        return $request->items[0]['ID'];
    } else {
        return '';
    }
}

//получаем заказы из битрикса
function getBitrixOrders($date = false) {

	$date = $date ? date("Y-m-d", strtotime($date)) : date("Y-m-d");

	global $config_bitrix;
	$query1 = "SELECT 
			c.XML_ID as 'Article',
			concat('\"', c.NAME, '\"') as 'name',
			b.PRICE as 'Cost',
			CAST(b.QUANTITY as UNSIGNED) as 'kol',
			a.ID as 'Order',
			a.DATE_INSERT as 'Date'
			FROM b_sale_order a 
				LEFT JOIN b_sale_basket b on a.ID = b.ORDER_ID
				LEFT JOIN b_iblock_element c on c.ID = b.PRODUCT_ID
			WHERE a.DATE_INSERT >= '". $date ."'
			ORDER BY -a.DATE_INSERT
		";
	$a = model('db', $config_bitrix)->sql($query1);
	//debug($a);
	return $a;
}