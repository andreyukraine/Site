<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
$wizTemplateId = COption::GetOptionString("main", "wizard_template_id", "eshop_adapt_horizontal", SITE_ID);
$template =  ($wizTemplateId == "eshop_adapt_vertical") ? "vertical" : "";
?>
<?$APPLICATION->IncludeComponent("bitrix:catalog.viewed.products", "vertical1", array(
	"ACTION_VARIABLE" => "action",
		"ADD_PROPERTIES_TO_BASKET" => "Y",
		"ADDITIONAL_PICT_PROP_2" => "MORE_FORMATS",
		"ADDITIONAL_PICT_PROP_3" => "MORE_PHOTO",
		"BASKET_URL" => "/personal/cart/",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "0",
		"CACHE_TYPE" => "N",
		"CART_PROPERTIES_2" => array(
			0 => "",
			1 => "",
		),
		"CART_PROPERTIES_3" => array(
			0 => "",
			1 => "",
		),
		"CONVERT_CURRENCY" => "N",
		"CURRENCY_ID" => "UAH",
		"DETAIL_URL" => "",
		"HIDE_NOT_AVAILABLE" => "N",
		"IBLOCK_ID" => "",
		"LABEL_PROP_2" => "-",
		"LINE_ELEMENT_COUNT" => "5",
		"MESS_BTN_BUY" => "Купить",
		"MESS_BTN_DETAIL" => "Подробнее",
		"MESS_BTN_SUBSCRIBE" => "Подписаться",
		"OFFER_TREE_PROPS_3" => array(
			0 => "COLOR_REF",
			1 => "SIZES_SHOES",
			2 => "SIZES_CLOTHES",
		),
		"PAGE_ELEMENT_COUNT" => "2",
		"PARTIAL_PRODUCT_PROPERTIES" => "N",
		"PRICE_CODE" => array(
			0 => "BASE",
		),
		"PRICE_VAT_INCLUDE" => "Y",
		"PRODUCT_ID_VARIABLE" => "id",
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"PRODUCT_QUANTITY_VARIABLE" => "quantity",
		"PRODUCT_SUBSCRIPTION" => "N",
		"PROPERTY_CODE_2" => array(
			0 => "",
			1 => "",
		),
		"PROPERTY_CODE_3" => array(
			0 => "",
			1 => "",
		),
		"SECTION_CODE" => "",
		"SECTION_ELEMENT_CODE" => "",
		"SECTION_ELEMENT_ID" => "",
		"SECTION_ID" => "",
		"SHOW_DISCOUNT_PERCENT" => "Y",
		"SHOW_FROM_SECTION" => "N",
		"SHOW_IMAGE" => "Y",
		"SHOW_NAME" => "Y",
		"SHOW_OLD_PRICE" => "N",
		"SHOW_PRICE_COUNT" => "1",
		"SHOW_PRODUCTS_2" => "Y",
		"TEMPLATE_THEME" => "site",
		"USE_PRODUCT_QUANTITY" => "N"
	),
	false,
	array(
	"ACTIVE_COMPONENT" => "N"
	)
);?>