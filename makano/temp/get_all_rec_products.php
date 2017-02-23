<?php
// импорт связки рекомендаций для электронной бумажной версии книги
ini_set('display_errors', 'on');
error_reporting(E_ALL);
require_once('lib/global.php');
require_once('custom_func.php');
function smarket_get_products()
{
    global $config_smarket;
    global $config_bitrix;
    $query1 = "SELECT TOP 7000
			CAST(a.plu_cod as INT) as IE_XML_ID,
			a.tlink as RECOMMEND,
			a.nnt as NNT
			FROM componen a
			LEFT JOIN tovar_o h on CAST(a.nnt as INT) = h.nnt AND h.code2 = 1
			WHERE
					a.name <> '' AND a.kol > 0
			order by a.nnt asc
	";

    $a = model('db', $config_smarket)->sql($query1);

    foreach ($a->items as &$i) {

        if ( $i['RECOMMEND'] == $i['IE_XML_ID'] or $i['RECOMMEND'] == $i['NNT'] ) {
            // если ссылается сам на себя ищем другой товар с ссылкой на этот
            $i['RECOMMEND'] = findBackLinkById($config_smarket, $i['NNT']);
        }

        if( $i['RECOMMEND'] != '' and $i['RECOMMEND'] != 0 ) {

            if ( $i['RECOMMEND'] != $i['IE_XML_ID'] and isset($i['RECOMMEND']) ) {
                // если ссылка на копию товара не равна товару ищем артикул по id
                $i['RECOMMEND'] = getArtNumberById($config_smarket, $i['RECOMMEND']);
            }

            if ( !empty($i['RECOMMEND']) ) {
                // если есть ссылка на рек товар получаем реальный ID товара из базы битрикса
                $i['RECOMMEND'] = getBitrixIdByArtNumberId($config_bitrix, $i['RECOMMEND']);
            }

        } else {

            unset($i);

        }

        if(isset($i['NNT'])) { unset($i['NNT']);}
    }

    $a->max = count($a->items);

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
        if($i['RECOMMEND']) {
            foreach ($i as $k => $v) {
                $v = preg_replace(array('~"~u', '~ {2,}~u', '~(^ | $)~u'), array('""', ' ', ''), $v);
                if (preg_match("~[\";\r\n]~u", $v)) $v = '"' . $v . '"';
                $str .= $v . ';';
            }
            $str .= PHP_EOL;
        }
    }
    // debug($str);
    if (file_put_contents(dirname(__FILE__) . '/' . $name . '.csv', $str)) ;
    return 1;
}

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
<li>Создание CSV ... <?php echo(create_csv($a, 'all_rec_products') ? 'Ok' : 'Пусто'); ?></li>
</ol>
<?php
// debug($a); ?>
</div>
<script src="//code.jquery.com/jquery.js"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
</body>
</html>