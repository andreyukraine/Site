<?
$arUrlRewrite = array(
	array(
		"CONDITION" => "#^/personal/order/#",
		"RULE" => "",
		"ID" => "bitrix:sale.personal.order",
		"PATH" => "/personal/order/index.php",
	),
	array(
		"CONDITION" => "#^/bookinist/#",
		"RULE" => "",
		"ID" => "bitrix:catalog",
		"PATH" => "/bookinist/index.php",
	),
	array(
		"CONDITION" => "#^/catalog/#",
		"RULE" => "",
		"ID" => "bitrix:catalog",
		"PATH" => "/catalog/index.php",
	),
	array(
		"CONDITION" => "#^/store/#",
		"RULE" => "",
		"ID" => "bitrix:catalog.store",
		"PATH" => "/store/index.php",
	),
	array(
		"CONDITION" => "#^/news/#",
		"RULE" => "",
		"ID" => "bitrix:catalog",
		"PATH" => "/news/index.php",
	),
	array(
		"CONDITION" => "#^/#",
		"RULE" => "",
		"ID" => "bitrix:news",
		"PATH" => "/autors/index.php",
	),
	array(
		"CONDITION" => "#^/#",
		"RULE" => "",
		"ID" => "bitrix:form.result.new",
		"PATH" => "/bitrix/templates/polka/components/bitrix/catalog.section/template2/template.php",
	),
	array(
		"CONDITION" => "#^/#",
		"RULE" => "",
		"ID" => "bitrix:form.result.new",
		"PATH" => "/bitrix/templates/polka/components/bitrix/catalog/template2/bitrix/catalog.section/template2/template.php",
	),
	array(
		"CONDITION" => "#^/#",
		"RULE" => "",
		"ID" => "bitrix:form.result.new",
		"PATH" => "/bitrix/templates/polka/components/bitrix/catalog/template2/bitrix/catalog.element/.default/template.php",
	),
);

?>