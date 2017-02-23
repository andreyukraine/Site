<?php 
	ini_set('display_errors', 'on'); error_reporting(E_ALL);
	require_once('lib/global.php');
	function smarket_get_products(){
		global $config_smarket;
		$query1 = "SELECT 
			CAST(a.plu_cod as INT) as IE_XML_ID, 
			a.name as IE_NAME,
			CAST(a.comment as varchar(max)) as IE_DETAIL_TEXT,
			'text' as IE_DETAIL_TEXT_TYPE,
			CAST(a.kol_tmp as INT) IE_ACTIVE,
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
			a.tara as CP_WEIGHT,
			b.TEXT as IC_GROUP0,
			d.TEXT as IC_GROUP1,
			e.TEXT as IC_GROUP2
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
			WHERE 
					a.name <> ''
					and (
						h.kol = (select max(h1.kol) from tovar_o h1 where a.nnt = h1.nnt and h1.code2 = 1)
						or h.kol is null
					)
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
				a.price3,
				a.price31,
				a.isGoodPrice,
				a.isNew,
				h.kol,
				a.tara,
				a.tlink,
				CAST(a.comment as varchar(max))
			order by a.plu_cod desc
		";

		$a = model('db', $config_smarket)->sql($query1); $max = 0;
		// debug($a);
		if(!empty($a->items)) foreach ($a->items as &$i) {
			// foreach ($i as &$j) {
				// $j = iconv('cp1251', 'utf8', $j); 
			// } unset($j);
			$i['IE_CODE'] = preg_replace('~\-{2,}~', '-', translit($i['IE_NAME']));
			$i['IC_CODE0'] = preg_replace('~\-{2,}~', '-', translit($i['IC_GROUP0']));
			$i['IC_CODE1'] = preg_replace('~\-{2,}~', '-', translit($i['IC_GROUP1']));
			$i['IC_CODE2'] = preg_replace('~\-{2,}~', '-', translit($i['IC_GROUP2']));
			$i['IE_DETAIL_PICTURE'] = $i['IE_XML_ID'].'.jpg'; 
			$i['IE_PREVIEW_PICTURE'] = $i['IE_XML_ID'].'.jpg'; 
			$i['CV_CURRENCY_1'] = 'UAH';
			$i['IP_PROP7'] = $i['IE_XML_ID'];
			$i['IE_ACTIVE'] = empty($i['IE_ACTIVE'])?'Y':'N';
			if(empty($i['CP_WEIGHT']) && !preg_match('~ebooks~i', $i['IC_CODE0'])) $i['CP_WEIGHT'] = 250;
			$i['CP_WEIGHT'] *= 1000;
			$i['IP_PROP114'] = (empty($i['IP_PROP114'])?0:1);
			$i['CP_QUANTITY'] = (int)$i['CP_QUANTITY'];
			if(!empty($i['IP_PROP81']) && $i['IP_PROP81']!='0.00') { $tmp = $i['CV_PRICE_1']; $i['CV_PRICE_1'] = $i['IP_PROP81']; $i['IP_PROP81'] = $tmp; }
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
		if(file_put_contents(dirname(__FILE__).'/tovari_full.csv', $str)) return 1; return 0;
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
			<h1 class="text-center">Синхронизация товаров Smarket -> Битрикс</h1>
			<ol>
				<li>Экспорт товаров из Smarket-a ... <?php $a = smarket_get_products(); echo ($a->max?'('.$a->max.') Ok':'Ошибка'); ?></li>
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