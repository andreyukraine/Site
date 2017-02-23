<?php 
	$dir = dirname(dirname(__FILE__)).'/upload/import/';
	$a = scandir($dir); unset($a[0], $a[1]);
	foreach ($a as $i) if(preg_match('~^(.*)\.gif$~i', $i, $m)) {
		if(!file_exists($f = $dir.$m[1].'.jpg')) {
			rename($dir.$i, $f);
			echo 'File renamed: ',$i,' -> ', $m[1].'.jpg','<br>';
		}
	}
?>