<?php

function create_csv($obj, $filename, $path = false) {

	$path = $path ? $path : dirname(DIR_SITE) . '/makano/csv/';

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
	if(file_put_contents($path . $filename .'.csv', $str));
	return 1;
}

//array to xml for create_xml_orders function
function array_to_xml( $data, &$xml) {
	// convert array to xml

	foreach( $data as $key => $value ) {
		
		if( is_array($value) ) {
			
			if( is_numeric($key) ){
				$key = 'Item'; //dealing with <0/>..<n/> issues
			}
			$subnode = $xml->addChild($key);
				
			array_to_xml($value, $subnode);
		} else {
			$xml->addChild("$key",htmlspecialchars("$value"));
		}
		
	}
}

//создание xml
function create_xml_orders($data, $path = false) {

	$path = $path ? $path : dirname(DIR_SITE) . '/makano/xml/';

	if( gettype($data) == 'object' || $data->max ) {

		// initializing or creating array
		$orders = array();
		
		

		foreach ($data->items as $item)
		{
			$orders[$item['Order']][$item['Article']] = $item;
			
			//если цена в валюте переводим по курсу в грн
			if($item['Currency'] != "UAH" ){
				$orders[$item['Order']][$item['Article']]['Cost'] = 
				strval(round($orders[$item['Order']][$item['Article']]['Cost'] * round($orders[$item['Order']][$item['Article']]['CurVal']),0,PHP_ROUND_HALF_ODD));
				
			}
		}
		// creating xml for each order
		print_c($orders);
		
		foreach ($orders as $key => $order)
		{
			// creating object of SimpleXMLElement
			$xml = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8" standalone="yes"?><Zakaz/>');
			
			// function call to convert array to xml
			array_to_xml($order, $xml);

			//saving generated xml file;
			$xml->asXML($path . $key .'.xml');
		}

		// return ok answer
		return 1;

	} else {

		// return fail answer
		return 0;

	}

}

// создание xml makano вариант
function create_xml_orders_old($obj){
	if(gettype($obj)!='object' || !$obj->max) return 0;
	$str = ''; $last_id = 0; $j = count($obj->items);
	foreach ($obj->items as &$i) {
		$id = $i['Order']; if(!$last_id) $last_id = $id;
		$str .= "\r\n\t".'<Record>';
		foreach ($i as $k=>$v) $str.= "\r\n\t\t<".$k.'>'.$v.'</'.$k.'>';
		$str .= "\r\n\t".'</Record>';
		if($last_id != $id || $j==1) {
			$str = '<?xml version = "1.0" encoding="utf-8" standalone="yes" ?>'."\r\n".'<Zakaz>'.$str."\r\n".'</Zakaz>';
			file_put_contents(dirname(__FILE__).'/orders/'.$id.'.xml', $str); $str = '';
		} $j--;
	} unset($i);
	return 1;
}


// функция вывода массива в консоль браузера
function print_c($message)
{
	echo '<script>';
	echo 'console.log('. json_encode( $message ) .')';
	echo '</script>';
}