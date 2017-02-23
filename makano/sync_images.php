<?php 

	require_once('lib/global.php');

	function get_update_photos(){
		
		$dir = dirname(DIR_SITE) . '/upload/import_new/';
		
		if(is_dir($dir)) {
			
			$files = scandir($dir);
			unset($files[0], $files[1]);
			//echo($dir);
			
		} else {
			
			$files = array();
		}
		
		$res = model('temp');
		
		foreach ($files as $file) {
			echo($file);
			array_push($res->items, array(
				'IE_XML_ID'=>preg_replace('~\..*$~u', '', $file),
				'IE_PREVIEW_PICTURE'=>$file,
				'IE_DETAIL_PICTURE'=>$file,
			));
			rename( $dir.$file, dirname(DIR_SITE).'/upload/import/'.$file );
			$res->max++;
		}
		
		return $res;
	}


	//логи в файл
			$fd = fopen("/home/bitrix/www/my_images.txt","a"); 
  			fwrite($fd, "Обращение к файлу - ".date("d.m.Y H:i")."\r\n"); 
  			fclose($fd);
			
	create_csv(get_update_photos(), 'images');
?>

