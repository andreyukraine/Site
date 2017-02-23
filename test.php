<?php 
//логи в файл
	$fd = fopen("/home/bitrix/www/cron_new_test.txt","a"); 
	fwrite($fd, "Обращение к файлу - ".date("d.m.Y H:i")."\r\n"); 
	fclose($fd);
?>