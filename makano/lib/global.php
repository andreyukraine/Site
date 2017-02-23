<?php

	header('Content-type: text/html; charset=utf-8');

	ini_set('display_errors', 'on');
	error_reporting(E_ALL);

	require_once 'custom_func.php';
	require_once 'tools.php';

	$config_smarket = array(
		'type'=>'mssql',
		'port'=>'65001',
		'host'=>'83.218.233.244',
		'user'=>'sa',
		'pass'=>'3008',
		'name'=>'smarket',
	);
	$config_bitrix = array(
		'type'=>'mysql',
		'port'=>'3306',
		'host'=>'localhost',
		'user'=>'makano',
		'pass'=>'@X6kaKarNeMRZH2r',
		'name'=>'bitrix',
	);

	class makano {
		public $items = array(), $max = 0, $limit = 0;
		function __get($name) { return ''; } function __call($name,$arg) { return $this; }
	}
	define ('DIR_SITE', dirname(dirname(__FILE__)));
	function debug($arg=array()) { $a = debug_backtrace(); ob_start(); echo '<div>Debug at '.preg_replace('~'.preg_quote(DIR_SITE).'~', '', @$a[0]['file']).' ('.@$a[0]['line'].') <xmp>'; print_r($arg); echo '</xmp></div>'; $res = ob_get_contents(); ob_end_clean(); echo $res; return $res; }
	
	function model($name, $arg=array()){ 
	
	if(class_exists($name)) return new $name($arg);
	if(file_exists($file = DIR_SITE.'/lib/models/'.$name.'.php')) 
	include_once($file); else eval('class '.$name.' extends makano {}'); 
	return new $name($arg); 
	
	}
	function translit($str=''){ $str=mb_strtolower($str, 'UTF-8'); $str=preg_replace("~[^\w\d\s\-а-я/]~u",'',$str);
		$str=strtr($str, array(
			'а'=>'a', 'б'=>'b',	'в'=>'v', 'г'=>'g',	'д'=>'d', 'е'=>'e', 'ё'=>'e', 'з'=>'z', 'и'=>'i', 'й'=>'y',
			'к'=>'k', 'л'=>'l',	'м'=>'m', 'н'=>'n',	'о'=>'o', 'п'=>'p',	'р'=>'r', 'с'=>'s', 'т'=>'t', 'у'=>'u',
			'ф'=>'f', 'х'=>'h',	'ы'=>'i', 'э'=>'je',' '=>'-', "ж"=>"zh", "ц"=>"ts", "ч"=>"ch", "ш"=>"sh",
			"щ"=>"shch", "ь"=>"", "ъ"=>"", "ю"=>"yu", "я"=>"ya", "ї"=>"i",  "є"=>"ie", "\r\n"=>"-", "/"=>"-"
		)); return $str;
	}

?>