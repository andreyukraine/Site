<?php

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$APPLICATION->SetTitle("Отзывы");

echo '<div class="col-xs-8">';

$APPLICATION->IncludeComponent(
	"micros:comment", 
	".default", 
	array(
		"COMPONENT_TEMPLATE" => ".default",
		"COUNT" => "10",
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"MAX_DEPTH" => "3",
		"ASNAME" => "NAME",
		"SHOW_DATE" => "Y",
		"OBJECT_ID" => "42228",
		"CAN_MODIFY" => "N",
		"JQUERY" => "N",
		"MODERATE" => "Y",
		"NON_AUTHORIZED_USER_CAN_COMMENT" => "Y",
		"USE_CAPTCHA" => "Y",
		"AUTH_PATH" => "/auth/",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"PAGER_TEMPLATE" => "pagination",
		"DISPLAY_TOP_PAGER" => "Y",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"PAGER_TITLE" => "",
		"PAGER_SHOW_ALWAYS" => "Y",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "Y"
	),
	false
);

echo '</div>';

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");