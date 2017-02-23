<?php
header('Content-type: text/html; charset=utf8');
// main
ini_set('display_errors', 'on'); error_reporting(E_ALL);
require_once('lib/global.php');

$date = date("Y-m-d");
?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Синхронизация заказов</title>
	<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container">
<div class="content">
	<h1 class="text-center">Экспорт заказов из Битрикс -> Smarket</h1>
	<ol>
		<li>Экспорт заказов из Битрикс-a ... <?php $a = getBitrixOrders(); echo ($a->max?'('.$a->max.') Ok':'Ошибка'); ?></li>
		<li>Создание XML OLD... <? //echo (create_xml_orders_old($a) ? 'Ok' : 'Ошибка') ?>Disabled</li>
		<li>Создание XML NEW... <? echo (create_xml_orders($a, $path) ? 'Ok' : 'Ошибка') ?></li>
	</ol>
	<table border="1" width="100%">
		<thead><tr>
			<?php $keys = @array_keys(@$a->items[0]); if(!empty($keys)) foreach ($keys as $i) { ?>
				<th><?php echo $i; ?></th>
			<?php } ?>
		</tr></thead>
		<tbody>
		<?php if($a->max) foreach ($a->items as $i) { ?>
			<tr>
				<?php foreach ($i as $j) { ?>
					<td><div style="max-width:150px; white-space: nowrap; text-overflow: ellipsis; overflow: hidden"><?php echo $j; ?></div></td>
				<?php } ?>
			</tr>
		<?php } ?>
		</tbody></table>
</div>
<script src="//code.jquery.com/jquery.js"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
</body>
</html>