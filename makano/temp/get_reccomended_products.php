<?php
ini_set('display_errors', 'on');
error_reporting(E_ALL);
require_once('lib/global.php');
require_once('custom_func.php');
function smarket_get_products()
{
    global $config_smarket;
    global $config_bitrix;
    $query1 = "SELECT 
			TOP 50
			CAST(a.plu_cod as INT) as IE_XML_ID, 
			a.name as IE_NAME,
			CAST(a.comment as varchar(max)) as IE_DETAIL_TEXT,
			'text' as IE_DETAIL_TEXT_TYPE,
			CAST(a.kol_tmp as INT) as IE_ACTIVE,
			a.autor as IP_PROP44,
			g.name as IP_PROP45,
			a.year as IP_PROP46,
			k.name as IP_PROP47,
			a.isbn as IP_PROP48,
			i.CCOVER as IP_PROP49,
			a.pagecount as IP_PROP52,
			j.name as IP_PROP53,
			a.isGoodPrice as IP_PROP6,
			a.isNew as IP_PROP4,
			a.price3 as CV_PRICE_1,
			a.price31 as IP_PROP81,
			h.kol as CP_QUANTITY,
			l.ParentId as IP_PROP114,
			m.ParentId as IP_PROP130,
			a.sold_count as IP_PROP131,
			a.tara as CP_WEIGHT,
			b.TEXT as IC_GROUP0,
			d.TEXT as IC_GROUP1,
			e.TEXT as IC_GROUP2,
			z.name as IC_ORIG_NAME,
			a.tlink as RECOMMEND,
			a.nnt as NNT
			FROM componen a
				LEFT JOIN groups b on CAST(a.code1 as INT) = b.key_id
				LEFT JOIN groups d on CAST(a.code3 as INT) = d.key_id
				LEFT JOIN groups e on CAST(a.code4 as INT) = e.key_id
				LEFT JOIN otdel g on CAST(a.code2 as INT) = g.code
				LEFT JOIN tovar_o h on CAST(a.nnt as INT) = h.nnt AND h.code2 = 1
				LEFT JOIN tblcover i on CAST(a.nCover as INT) = i.id
				LEFT JOIN seria_s j on CAST(a.code_s as INT) = j.id
				LEFT JOIN properties k on CAST(a.IdFormat as INT) = k.id
				LEFT JOIN AllProperties l on CAST(a.nnt as INT) = l.BaseId AND l.ParentId = 340
				LEFT JOIN AllProperties m on CAST(a.nnt as INT) = m.BaseId AND m.ParentId in (
					select id FROM properties where type = 6
				)
				LEFT JOIN AllProperties s on CAST(a.nnt as INT) = s.BaseId AND s.ParentId in (
				    select id FROM properties where type = 8
			    )
			    LEFT JOIN properties z on s.ParentId = z.id AND z.type = 8
			WHERE 
					a.name <> ''
					AND (
						h.kol = (select max(h1.kol) from tovar_o h1 where a.nnt = h1.nnt and h1.code2 = 1)
						or h.kol is null
					)
					AND a.tlink <> 0
			GROUP BY 
				a.nnt,
				a.kol_tmp,
				a.plu_cod,
				b.TEXT,
				d.TEXT,
				e.TEXT,
				a.name, 
				a.ShortName,
				j.name,
				g.name,
				a.isbn,
				a.autor,
				a.pagecount,
				a.year,
				i.CCOVER,
				k.name,
				l.ParentId,
				m.ParentId,
				a.sold_count,
				a.price3,
				a.price31,
				a.isGoodPrice,
				a.isNew,
				h.kol,
				a.tara,
				a.tlink,
				CAST(a.comment as varchar(max)),
				a.updated,
				z.name
			order by a.updated desc, a.nnt desc
		";

    $a = model('db', $config_smarket)->sql($query1);
    $max = 0;
    $items = array();
    foreach ($a->items as &$i)
        if (!empty($items[$i['IE_XML_ID']]['CP_QUANTITY'])) $items[$i['IE_XML_ID']]['CP_QUANTITY'] += $i['CP_QUANTITY'];
        else $items[$i['IE_XML_ID']] = $i;
    unset($i);
    $a->items = $items;
    $a->max = count($items);

    foreach ($a->items as &$i) {
        // echo mb_detect_encoding($i['IE_NAME']).' ';
        // foreach ($i as &$j) {
        // $j = iconv('ASCII', 'utf8', $j);
        // $j = utf8_encode($j);
        // } unset($j);
        $i['IE_CODE'] = preg_replace('~\-{2,}~', '-', translit($i['IE_NAME']));
        $i['IC_CODE0'] = preg_replace('~\-{2,}~', '-', translit($i['IC_GROUP0']));
        $i['IC_CODE1'] = preg_replace('~\-{2,}~', '-', translit($i['IC_GROUP1']));
        $i['IC_CODE2'] = preg_replace('~\-{2,}~', '-', translit($i['IC_GROUP2']));
        $i['IE_ACTIVE'] = empty($i['IE_ACTIVE']) ? 'Y' : 'N';
        $i['CP_QUANTITY'] = (int)$i['CP_QUANTITY'];
        $i['IE_DETAIL_PICTURE'] = $i['IE_XML_ID'] . '.jpg';
        $i['IE_PREVIEW_PICTURE'] = $i['IE_XML_ID'] . '.jpg';
        if (empty($i['CP_WEIGHT']) && !preg_match('~ebooks~i', $i['IC_CODE0'])) $i['CP_WEIGHT'] = 250;
        $i['CP_WEIGHT'] *= 1000;
        $i['IP_PROP114'] = (empty($i['IP_PROP114']) ? 0 : 1);
        if (!empty($i['IP_PROP81']) && $i['IP_PROP81'] != '0.00') {
            $tmp = $i['CV_PRICE_1'];
            $i['CV_PRICE_1'] = $i['IP_PROP81'];
            $i['IP_PROP81'] = $tmp;
        }
        $i['CV_CURRENCY_1'] = 'UAH';
        $i['IP_PROP7'] = $i['IE_XML_ID'];
       
        if ( $i['RECOMMEND'] == $i['IE_XML_ID'] or $i['RECOMMEND'] == $i['NNT'] ) {
            // если ссылается сам на себя ищем другой товар с ссылкой на этот
            $i['RECOMMEND'] = findBackLinkById($config_smarket, $i['NNT']);
        }

        if ( $i['RECOMMEND'] != $i['IE_XML_ID'] and isset($i['RECOMMEND']) ) {
            // если ссылка на копию товара не равна товару ищем артикул по id
            $i['RECOMMEND'] = getArtNumberById($config_smarket, $i['RECOMMEND']);
        }

        if ( !empty($i['RECOMMEND']) ) {
            // если есть ссылка на рек товар получаем реальный ID товара из базы битрикса
            $i['RECOMMEND'] = getBitrixIdByArtNumberId($config_bitrix, $i['RECOMMEND']);
        }

        $max++;

        unset($i['NNT']);
    }

    unset($i, $rItem);
    $a->max = $max;
    return $a;
}

function smarket_get_skidki()
{
    global $config_smarket;
    $query1 = "SELECT a.cardcode as COUPON, a.dis_percent FROM clients a 
				WHERE a.updated >= '" . date("Y-m-d") . "'
			ORDER BY a.updated desc
		";
    $a = model('db', $config_smarket)->sql($query1);
    $max = 0;
    foreach ($a->items as &$i) {
        switch ($i['dis_percent']) {
            case 5:
                $i['DISCOUNT_ID'] = 2;
                break;
            case 6:
                $i['DISCOUNT_ID'] = 3;
                break;
            case 7:
                $i['DISCOUNT_ID'] = 4;
                break;
            case 8:
                $i['DISCOUNT_ID'] = 5;
                break;
            case 9:
                $i['DISCOUNT_ID'] = 6;
                break;
            case 10:
                $i['DISCOUNT_ID'] = 7;
                break;
            case 12:
                $i['DISCOUNT_ID'] = 8;
                break;
            case 14:
                $i['DISCOUNT_ID'] = 9;
                break;
            case 16:
                $i['DISCOUNT_ID'] = 10;
                break;
            case 18:
                $i['DISCOUNT_ID'] = 11;
                break;
            case 20:
                $i['DISCOUNT_ID'] = 12;
                break;
        }
        $max++;
    }
    unset($i);
    $a->max = $max;
    return $a;
}

function smarket_get_clients()
{
    global $config_smarket;
    $query1 = "SELECT '' as LAST_NAME, a.fullname as NAME, a.email as EMAIL, a.tel as WORK_PHONE 
			FROM clients a 
				WHERE a.email NOT IN ('')
			ORDER BY a.updated desc
		";
    $a = model('db', $config_smarket)->sql($query1);
    foreach ($a->items as &$i) {
        if (empty($i['LAST_NAME'])) {
            $i['LAST_NAME'] = preg_replace('~([\s,].*)$~u', '', $i['NAME']);
            $i['NAME'] = preg_replace('~^[^\s,]+? ~u', '', $i['NAME']);
        }
    }
    unset($i);
    return $a;
}

function create_csv($obj, $name)
{
    if (gettype($obj) != 'object' || !$obj->max) return 0;
    foreach ($obj->items as $i) {
        $str = implode(';', array_keys($i)) . ';' . PHP_EOL;
        break;
    }
    foreach ($obj->items as $i) {
        foreach ($i as $k => $v) {
            $v = preg_replace(array('~"~u', '~ {2,}~u', '~(^ | $)~u'), array('""', ' ', ''), $v);
            if (preg_match("~[\";\r\n]~u", $v)) $v = '"' . $v . '"';
            $str .= $v . ';';
        }
        $str .= PHP_EOL;
    }
    // debug($str);
    if (file_put_contents(dirname(__FILE__) . '/' . $name . '.csv', $str)) ;
    return 1;
}

function create_xml_orders($obj)
{
    if (gettype($obj) != 'object' || !$obj->max) return 0;
    $str = '';
    $last_id = 0;
    $j = count($obj->items);
    foreach ($obj->items as &$i) {
        $id = $i['Order'];
        if (!$last_id) $last_id = $id;
        $str .= "\r\n\t" . '<Record>';
        foreach ($i as $k => $v) $str .= "\r\n\t\t<" . $k . '>' . $v . '</' . $k . '>';
        $str .= "\r\n\t" . '</Record>';
        if ($last_id != $id || $j == 1) {
            $str = '<?xml version = "1.0" encoding="Windows-1251" standalone="yes" ?>' . "\r\n" . '<Zakaz>' . $str . "\r\n" . '</Zakaz>';
            if (!is_dir($dir = dirname($file = dirname(dirname(__FILE__)) . '/sync/' . $id . '.xml'))) mkdir($dir, 0755, true);
            file_put_contents($file, $str);
            $str = '';
        }
        $j--;
    }
    unset($i);
    return 1;
}

function bitrix_get_orders()
{
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
			WHERE a.DATE_INSERT >= '" . date("Y-m-d") . "'
			ORDER BY -a.DATE_INSERT
		";
    $a = model('db', $config_bitrix)->sql($query1);
    $a->max = count($a->items);
    return $a;
}

function bitrix_import_skidki($a)
{
    global $config_bitrix;
    if (gettype($a) != 'object' || !$a->max) return 0;
    $query = '';
    $j = 0;
    foreach ($a->items as $i) $query .= ($j++ ? ',' : '') . '("N", 1, 1, "' . @$i['COUPON'] . '", "' . @$i['DISCOUNT_ID'] . '")';
    $query = "INSERT IGNORE INTO b_catalog_discount_coupon (`ONE_TIME`, `CREATED_BY`, `MODIFIED_BY`, `COUPON`, `DISCOUNT_ID`) VALUES " . $query . ' ON DUPLICATE KEY UPDATE DISCOUNT_ID = VALUES(DISCOUNT_ID)';
    $a = model('db', $config_bitrix)->sql($query);
    $a->max = count($a->items);
    return ($a->max ? 1 : 0);
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
        <li>Экспорт товаров из Smarket-a ... <?php $a = smarket_get_products();
            echo($a->max ? '(' . $a->max . ') Ok' : 'Пусто'); ?></li>
        <?php ?>
        <li>Создание CSV ... <?php echo(create_csv($a, 'get_recc_prodd') ? 'Ok' : 'Пусто'); ?></li>
<!--        --><? //print_c($a->items); ?>
<!--        <li>Экспорт заказов из Битрикс-a ... --><?php //$b = bitrix_get_orders();
//            echo($b->max ? '(' . $b->max . ') Ok' : 'Пусто'); ?><!--</li>-->
<!--        <li>Создание XML файлов ... --><?php //echo(create_xml_orders($b) ? 'Ok' : 'Пусто'); ?><!--</li>-->
<!--        <li>Экспорт купонов из S-market-a ... --><?php //$c = smarket_get_skidki();
//            echo($c->max ? '(' . $c->max . ') Ok' : 'Пусто'); ?><!--</li>-->
<!--        <li>Импорт купонов в Битрикс ... --><?php //echo(bitrix_import_skidki($c) ? 'Ok' : 'Пусто'); ?><!--</li>-->
<!--        <li>Экспорт клиентов из S-market-a ... --><?php //$d = smarket_get_clients();
//            echo($c->max ? '(' . $c->max . ') Ok' : 'Пусто'); ?><!--</li>-->
<!--        <li>Создание CSV клиентов ... --><?php //echo(create_csv($d, 'clients') ? 'Ok' : 'Пусто'); ?><!--</li>-->
        <?php ?>
    </ol>
    <?php
    // debug($a); ?>
</div>
<script src="//code.jquery.com/jquery.js"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
</body>
</html>