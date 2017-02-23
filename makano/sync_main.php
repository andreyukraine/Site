
<?php

	//обьявляем для крона так как он не знает дом директорию
	$_SERVER["DOCUMENT_ROOT"]="/home/bitrix/www/";
	
	
	require_once('lib/global.php');
	require_once ('/home/bitrix/www/bitrix/php_interface/classes/DiscountCard.php');
	
	function smarket_get_products($date = false)
	{

		$date = $date ? date('Ymd', strtotime($date)) :  date('Ymd');

		global $config_smarket;
			
		$query1 = "SELECT 
				CAST(a.plu_cod as INT) as IE_XML_ID, 
				a.name as IE_NAME,
				CAST(a.comment as varchar(max)) as IE_DETAIL_TEXT,
				'html' as IE_DETAIL_TEXT_TYPE,
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
						
					
					a.updated >= '" . $date . "'
					
					
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
		//print_c($date1);
		
 		
		$max = 0;
		$order   = array("\r\n", "\n", "\r", "char(13)");
		$replace = '<br />';
			
	
		foreach ($a->items as &$i) {
			
			$i['IE_CODE'] = preg_replace('~\-{2,}~', '-', translit($i['IE_NAME']));
			$i['IC_CODE0'] = preg_replace('~\-{2,}~', '-', translit($i['IC_GROUP0']));
			$i['IC_CODE1'] = preg_replace('~\-{2,}~', '-', translit($i['IC_GROUP1']));
			$i['IC_CODE2'] = preg_replace('~\-{2,}~', '-', translit($i['IC_GROUP2']));
			$i['IE_ACTIVE'] = empty($i['IE_ACTIVE']) ? 'Y' : 'N';
			$i['CP_QUANTITY'] = (int)$i['CP_QUANTITY'];
			$i['IE_DETAIL_PICTURE'] = '';
			$i['IE_PREVIEW_PICTURE'] = '';
			
			
			$i['IE_DETAIL_TEXT'] = str_replace($order, $replace, $i['IE_DETAIL_TEXT']);
			
			
			if (empty($i['CP_WEIGHT']) && !preg_match('~ebooks~i', $i['IC_CODE0'])) $i['CP_WEIGHT'] = 250;
			$i['CP_WEIGHT'] *= 1000;
			$i['IP_PROP114'] = (empty($i['IP_PROP114']) ? 0 : 'buk');
			if (!empty($i['IP_PROP81']) && $i['IP_PROP81'] != '0.00') {
				$tmp = $i['CV_PRICE_1'];
				$i['CV_PRICE_1'] = $i['IP_PROP81'];
				$i['IP_PROP81'] = $tmp;
			}
			$i['CV_CURRENCY_1'] = 'UAH';
			$i['IP_PROP7'] = $i['IE_XML_ID'];

			if ( $i['RECOMMEND'] == $i['IE_XML_ID'] or $i['RECOMMEND'] == $i['NNT'] ) {
				// если ссылается сам на себя ищем другой товар с ссылкой на этот
				$i['RECOMMEND'] = findBackLinkById($i['NNT']);
			}
			if ( $i['RECOMMEND'] != $i['IE_XML_ID'] and isset($i['RECOMMEND']) ) {
				// если ссылка на копию товара не равна товару ищем артикул по id
				$i['RECOMMEND'] = getArtNumberById($i['RECOMMEND']);
			}
			if ( !empty($i['RECOMMEND']) ) {
				// если есть ссылка на рек товар получаем реальный ID товара из базы битрикса
				$i['RECOMMEND'] = getBitrixIdByArtNumberId( $i['RECOMMEND']);
			}

			// удаляем nnt если присутствует
			if(isset($i['NNT'])) { unset($i['NNT']);}

			$max++;
		}
		unset($i);
		$a->max = $max;
		return $a;
	}

	function smarket_get_skidki($date = false)
	{

		$date = $date ? date('Y-m-d', strtotime($date)) :  date('Y-m-d');
		//один день это 86400
		$date1 = $date ? date('Ymd', strtotime($date)-604800) :  date('Ymd');
		
		global $config_smarket;
		
				
		
		$query1 = "SELECT a.cardcode as COUPON, a.dis_percent FROM clients a 
					WHERE a.updated >= '" . $date . "'
				ORDER BY a.updated desc
			";
		$a = model('db', $config_smarket)->sql($query1);
		$max = 0;
		foreach ($a->items as &$i) {
			switch ($i['dis_percent']) {
				case 5:
					$i['DISCOUNT_ID'] = 660;
					break;
				case 6:
					$i['DISCOUNT_ID'] = 661;
					break;
				case 7:
					$i['DISCOUNT_ID'] = 662;
					break;
				case 8:
					$i['DISCOUNT_ID'] = 663;
					break;
				case 9:
					$i['DISCOUNT_ID'] = 664;
					break;
				case 10:
					$i['DISCOUNT_ID'] = 665;
					break;
				case 12:
					$i['DISCOUNT_ID'] = 666;
					break;
				case 14:
					$i['DISCOUNT_ID'] = 667;
					break;
				case 16:
					$i['DISCOUNT_ID'] = 668;
					break;
				case 18:
					$i['DISCOUNT_ID'] = 669;
					break;
				case 20:
					$i['DISCOUNT_ID'] = 670;
					break;
			}
			$max++;
		}
		
		print_c($date1);
		
		unset($i);
		$a->max = $max;
		return $a;
	}

	function smarket_get_clients()
	{
		global $config_smarket;
		$query1 = "SELECT '' as LAST_NAME, a.fullname as NAME, a.cardcode as BARCODE, a.email as EMAIL, a.tel as WORK_PHONE 
				FROM clients a 
					WHERE a.email NOT IN ('')
				ORDER BY a.updated desc
			";
		$a = model('db', $config_smarket)->sql($query1);
		foreach ($a->items as &$i) {
			if (empty($i['LAST_NAME'])) {
				$i['LAST_NAME'] = preg_replace('~([\s,].*)$~u', '', $i['NAME']);
				$i['NAME'] = preg_replace('~^[^\s,]+? ~u', '', $i['NAME']);
				//$i['BARCODE'] = $i['BARCODE'];
				//print_c($i['BARCODE']);
					DiscountCard::CheckCardAndSendActivationCode(trim($i['EMAIL']),$i['BARCODE']);
				
				

			}
		}
		
		
		
		unset($i);
		return $a;
	}



	function smarket_get_autors($date = false){

		$date = $date ? date('Y-m-d', strtotime($date)) :  date('Y-m-d');

		global $config_smarket;
		$query1 = "SELECT 
				b.id as IE_XML_ID,
				b.name as IE_NAME,
				'html' as IE_DETAIL_TEXT_TYPE,
				CAST(a.Comment as varchar(max)) as IE_DETAIL_TEXT,
				b.isNotForSite as IE_DISABLED
				FROM properties b
				LEFT JOIN PropertiesComment a on CAST(a.IdProperties as INT) = b.id
				where b.name <> '' and b.type = 6 and b.Updated >= '$date'
			";

		$a = model('db', $config_smarket)->sql($query1); $max = 0;
		
		$order   = array("\r\n", "\n", "\r");
			$replace = '<br />';
		
		foreach ($a->items as &$i) {
			$i['IE_NAME'] = preg_replace('~ {2,}~', '', $i['IE_NAME']);
			$i['IE_CODE'] = preg_replace('~\-{2,}~', '-', translit($i['IE_NAME']));
			$i['IP_PROP129'] = preg_replace('~^[^ \.,]+?[ \.,]+~u', '', $i['IE_NAME']);
			
			
			
			$i['IE_DETAIL_TEXT'] = str_replace($order, $replace, $i['IE_DETAIL_TEXT']);
			
			//print_c($i['IE_DETAIL_TEXT']);
			
			
			if(empty($i['IE_DETAIL_TEXT']))
			 $i['IE_DETAIL_TEXT'] = '';
			 
			 //print_c($i);
			 
			$max++;
		} unset($i);
		
		
		
		$a->max = $max;
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



	//логи в файл
	$fd = fopen("/home/bitrix/www/my_main.txt","a"); 
	fwrite($fd, "Обращение к файлу - ".date("d.m.Y H:i")."\r\n"); 
	fclose($fd);
	
	
	//Экспорт товаров из Smarket-a
	$a = smarket_get_products($date);
	//Создание CSV ... 
	create_csv($a, 'products');
	//Лог
	//fwrite($fd, "Выгрженые продукты - ".$a."\r\n"); 
	print_c($a);
	
	//Экспорт купонов из S-market-a
	$c = smarket_get_skidki($date);
	//Импорт купонов в Битрикс
	bitrix_import_skidki($c);
	
	//Экспорт клиентов из S-market-a
	$d = smarket_get_clients();
	//Создание CSV клиентов
	create_csv($d, 'clients');
	
	
	//Экспорт авторов из Smarket-a
	$w = smarket_get_autors($date);
	//Создание CSV ...
	create_csv($w, 'autors');
	
	
	
?>
