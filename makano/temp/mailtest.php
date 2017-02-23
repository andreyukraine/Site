<?php 
	$to = 'almakano@gmail.com1';
	$sub = 'test from knigionline.com VPS';
	$body = 'test';
	$headers = 'From: noreply@kniginline.com'.PHP_EOL;
	if(mail($to, $sub, $body, $headers)) echo 'Mail sent'; else echo 'Error. Mail not send';
?>