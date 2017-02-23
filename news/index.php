<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Блог КнигиОнлайн");
CModule::IncludeModule("forum");
?><div class="blog_content">
	<div class="blog_breadcrumb">
		<?$APPLICATION->IncludeComponent(
	"bitrix:breadcrumb",
	"",
	Array(
	)
);?>
	</div>
	<h2 class="section_title_text">Блог</h2>
	 <?$APPLICATION->IncludeComponent(
	"bitrix:catalog",
	"blog",
	Array(
		"ACTION_VARIABLE" => "action",
		"ADD_ELEMENT_CHAIN" => "N",
		"ADD_PICT_PROP" => "-",
		"ADD_PROPERTIES_TO_BASKET" => "Y",
		"ADD_SECTION_CHAIN" => "Y",
		"ADD_SECTIONS_CHAIN" => "Y",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"ALSO_BUY_ELEMENT_COUNT" => "4",
		"ALSO_BUY_MIN_BUYES" => "1",
		"BASKET_URL" => "/personal/cart/",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "0",
		"CACHE_TYPE" => "A",
		"COMMON_ADD_TO_BASKET_ACTION" => "ADD",
		"COMMON_SHOW_CLOSE_POPUP" => "N",
		"CONVERT_CURRENCY" => "N",
		"DETAIL_ADD_DETAIL_TO_SLIDER" => "N",
		"DETAIL_ADD_TO_BASKET_ACTION" => "BUY",
		"DETAIL_BLOG_EMAIL_NOTIFY" => "Y",
		"DETAIL_BLOG_URL" => "catalog_comments",
		"DETAIL_BLOG_USE" => "Y",
		"DETAIL_BRAND_USE" => "Y",
		"DETAIL_BROWSER_TITLE" => "-",
		"DETAIL_CHECK_SECTION_ID_VARIABLE" => "N",
		"DETAIL_DETAIL_PICTURE_MODE" => "IMG",
		"DETAIL_DISPLAY_NAME" => "Y",
		"DETAIL_DISPLAY_PREVIEW_TEXT_MODE" => "H",
		"DETAIL_FB_APP_ID" => "",
		"DETAIL_FB_USE" => "Y",
		"DETAIL_META_DESCRIPTION" => "-",
		"DETAIL_META_KEYWORDS" => "-",
		"DETAIL_SHOW_BASIS_PRICE" => "Y",
		"DETAIL_SHOW_MAX_QUANTITY" => "N",
		"DETAIL_USE_COMMENTS" => "Y",
		"DETAIL_USE_VOTE_RATING" => "N",
		"DETAIL_VK_USE" => "N",
		"DETAIL_VOTE_DISPLAY_AS_RATING" => "rating",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_TOP_PAGER" => "Y",
		"ELEMENT_SORT_FIELD" => "id",
		"ELEMENT_SORT_FIELD2" => "shows",
		"ELEMENT_SORT_ORDER" => "desc",
		"ELEMENT_SORT_ORDER2" => "asc",
		"FILTER_FIELD_CODE" => array(0=>"NAME",1=>"DATE_ACTIVE_FROM",2=>"",),
		"FILTER_NAME" => "",
		"FILTER_OFFERS_FIELD_CODE" => array(0=>"PREVIEW_PICTURE",1=>"DETAIL_PICTURE",2=>"",),
		"FILTER_OFFERS_PROPERTY_CODE" => array(0=>"",1=>"",),
		"FILTER_PRICE_CODE" => array(0=>"BASE",),
		"FILTER_PROPERTY_CODE" => array(0=>"",1=>"MINIMUM_PRICE",2=>"",),
		"FILTER_VIEW_MODE" => "VERTICAL",
		"FORUM_ID" => "1",
		"HIDE_NOT_AVAILABLE" => "N",
		"IBLOCK_ID" => "8",
		"IBLOCK_TYPE" => "news",
		"INCLUDE_SUBSECTIONS" => "Y",
		"LABEL_PROP" => "-",
		"LINE_ELEMENT_COUNT" => "3",
		"LINK_ELEMENTS_URL" => "link.php?PARENT_ELEMENT_ID=#ELEMENT_ID#",
		"LINK_IBLOCK_ID" => "2",
		"LINK_IBLOCK_TYPE" => "catalog",
		"LINK_PROPERTY_SID" => "RECOMMEND",
		"LIST_BROWSER_TITLE" => "-",
		"LIST_META_DESCRIPTION" => "-",
		"LIST_META_KEYWORDS" => "-",
		"LIST_OFFERS_FIELD_CODE" => array(0=>"NAME",1=>"PREVIEW_PICTURE",2=>"DETAIL_PICTURE",3=>"",),
		"LIST_OFFERS_LIMIT" => "0",
		"LIST_OFFERS_PROPERTY_CODE" => array(0=>"ARTNUMBER",1=>"COLOR_REF",2=>"SIZES_SHOES",3=>"SIZES_CLOTHES",4=>"MORE_PHOTO",5=>"",),
		"LIST_PROPERTY_CODE" => array(0=>"",1=>"",),
		"MAIN_TITLE" => "Наличие на складах",
		"MESS_BTN_ADD_TO_BASKET" => "В корзину",
		"MESS_BTN_BUY" => "Купить",
		"MESS_BTN_COMPARE" => "Сравнение",
		"MESS_BTN_DETAIL" => "Подробнее",
		"MESS_NOT_AVAILABLE" => "Нет в наличии",
		"MESSAGES_PER_PAGE" => "10",
		"MIN_AMOUNT" => "10",
		"OFFER_ADD_PICT_PROP" => "MORE_PHOTO",
		"OFFER_TREE_PROPS" => array(0=>"COLOR_REF",1=>"SIZES_SHOES",2=>"SIZES_CLOTHES",),
		"OFFERS_CART_PROPERTIES" => array(0=>"COLOR_REF",1=>"SIZES_SHOES",2=>"SIZES_CLOTHES",),
		"OFFERS_SORT_FIELD" => "sort",
		"OFFERS_SORT_FIELD2" => "id",
		"OFFERS_SORT_ORDER" => "asc",
		"OFFERS_SORT_ORDER2" => "desc",
		"PAGE_ELEMENT_COUNT" => "10",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000000",
		"PAGER_SHOW_ALL" => "Y",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => "pagination",
		"PAGER_TITLE" => "Товары",
		"PARTIAL_PRODUCT_PROPERTIES" => "N",
		"PATH_TO_SMILE" => "/bitrix/images/forum/smile/",
		"PRICE_CODE" => array(0=>"BASE",),
		"PRICE_VAT_INCLUDE" => "Y",
		"PRICE_VAT_SHOW_VALUE" => "N",
		"PRODUCT_DISPLAY_MODE" => "Y",
		"PRODUCT_ID_VARIABLE" => "id",
		"PRODUCT_PROPERTIES" => "",
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"PRODUCT_QUANTITY_VARIABLE" => "quantity",
		"QUANTITY_FLOAT" => "N",
		"REVIEW_AJAX_POST" => "Y",
		"SECTION_ADD_TO_BASKET_ACTION" => "BUY",
		"SECTION_COUNT_ELEMENTS" => "N",
		"SECTION_ID_VARIABLE" => "SECTION_ID",
		"SECTION_TOP_DEPTH" => "1",
		"SECTIONS_SHOW_PARENT_NAME" => "N",
		"SECTIONS_VIEW_MODE" => "LIST",
		"SEF_FOLDER" => "/news/",
		"SEF_MODE" => "Y",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "Y",
		"USE_ELEMENT_COUNTER" => "Y",
		"TEMPLATE_THEME" => "site",
		"SHOW_DISCOUNT_PERCENT" => "N",
		"SHOW_OLD_PRICE" => "N",
		"USE_SALE_BESTSELLERS" => "Y",
		"USE_FILTER" => "N",
		"USE_REVIEW" => "Y",
		"USE_COMPARE" => "N",
		"USE_PRICE_COUNT" => "N",
		"SHOW_PRICE_COUNT" => "1",
		"USE_PRODUCT_QUANTITY" => "Y",
		"USE_COMMON_SETTINGS_BASKET_POPUP" => "N",
		"TOP_ADD_TO_BASKET_ACTION" => "BUY",
		"SHOW_TOP_ELEMENTS" => "Y",
		"TOP_ELEMENT_COUNT" => "9",
		"TOP_LINE_ELEMENT_COUNT" => "3",
		"TOP_ELEMENT_SORT_FIELD" => "id",
		"TOP_ELEMENT_SORT_ORDER" => "desc",
		"TOP_ELEMENT_SORT_FIELD2" => "",
		"TOP_ELEMENT_SORT_ORDER2" => "",
		"USE_ALSO_BUY" => "N",
		"USE_STORE" => "N",
		"TOP_VIEW_MODE" => "SECTION",
		"COMPONENT_TEMPLATE" => "blog",
		"STORES" => "",
		"USE_MIN_AMOUNT" => "N",
		"USER_FIELDS" => array(0=>"",1=>"",),
		"FIELDS" => array(0=>"",1=>"",),
		"SHOW_EMPTY_STORE" => "Y",
		"SHOW_GENERAL_STORE_INFORMATION" => "N",
		"STORE_PATH" => "/store/#store_id#",
		"TOP_ROTATE_TIMER" => "30",
		"USE_CAPTCHA" => "Y",
		"URL_TEMPLATES_READ" => "",
		"SHOW_LINK_TO_FORUM" => "Y",
		"DETAIL_BRAND_PROP_CODE" => array(0=>"",1=>"",),
		"TOP_PROPERTY_CODE" => array(0=>"",1=>"",),
		"DETAIL_PROPERTY_CODE" => array(0=>"",1=>"",),
		"DISPLAY_DATE" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"SEF_URL_TEMPLATES" => array("sections"=>"","section"=>"#SECTION_CODE_PATH#/","element"=>"#SECTION_CODE_PATH#/#ELEMENT_CODE#/","compare"=>"compare/",),
		"VARIABLE_ALIASES" => "",
		"VARIABLE_ALIASES" => Array(
		)
	)
);?> <?/*$APPLICATION->IncludeComponent("bitrix:news", "blog_new", array(
		"COMPONENT_TEMPLATE" => "blog_new",
		"IBLOCK_TYPE" => "news",
		"IBLOCK_ID" => "8",
		"NEWS_COUNT" => "20",
		"USE_SEARCH" => "N",
		"USE_RSS" => "N",
		"USE_RATING" => "N",
		"USE_CATEGORIES" => "N",
		"USE_REVIEW" => "Y",
		"MESSAGES_PER_PAGE" => "10",
		"USE_CAPTCHA" => "Y",
		"REVIEW_AJAX_POST" => "Y",
		"PATH_TO_SMILE" => "/bitrix/images/forum/smile/",
		"FORUM_ID" => "1",
		"URL_TEMPLATES_READ" => "",
		"SHOW_LINK_TO_FORUM" => "N",
		"USE_FILTER" => "N",
		"SORT_BY1" => "SORT",
		"SORT_ORDER1" => "ASC",
		"SORT_BY2" => "ACTIVE_FROM",
		"SORT_ORDER2" => "DESC",
		"CHECK_DATES" => "Y",
		"SEF_MODE" => "Y",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"CACHE_TYPE" => "Y",
		"CACHE_TIME" => "86400",
		"CACHE_FILTER" => "Y",
		"CACHE_GROUPS" => "N",
		"DISPLAY_NAME" => "Y",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "Y",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"ADD_SECTIONS_CHAIN" => "N",
		"ADD_ELEMENT_CHAIN" => "Y",
		"USE_PERMISSIONS" => "N",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"PREVIEW_TRUNCATE_LEN" => "250",
		"LIST_ACTIVE_DATE_FORMAT" => "f j, Y",
		"LIST_FIELD_CODE" => array(
			0 => "ID",
			1 => "CODE",
			2 => "XML_ID",
			3 => "NAME",
			4 => "TAGS",
			5 => "SORT",
			6 => "PREVIEW_TEXT",
			7 => "PREVIEW_PICTURE",
			8 => "DETAIL_TEXT",
			9 => "DETAIL_PICTURE",
			10 => "DATE_ACTIVE_FROM",
			11 => "ACTIVE_FROM",
			12 => "DATE_ACTIVE_TO",
			13 => "ACTIVE_TO",
			14 => "SHOW_COUNTER",
			15 => "SHOW_COUNTER_START",
			16 => "IBLOCK_TYPE_ID",
			17 => "IBLOCK_ID",
			18 => "IBLOCK_CODE",
			19 => "IBLOCK_NAME",
			20 => "IBLOCK_EXTERNAL_ID",
			21 => "DATE_CREATE",
			22 => "CREATED_BY",
			23 => "CREATED_USER_NAME",
			24 => "TIMESTAMP_X",
			25 => "MODIFIED_BY",
			26 => "USER_NAME",
			27 => "",
		),
		"LIST_PROPERTY_CODE" => array(
			0 => "AUTHOR",
			1 => "FORUM_MESSAGE_CNT",
			2 => "FORUM_TOPIC_ID",
			3 => "",
		),
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"META_KEYWORDS" => "-",
		"META_DESCRIPTION" => "-",
		"BROWSER_TITLE" => "NAME",
		"DETAIL_ACTIVE_DATE_FORMAT" => "d.m.Y H:i",
		"DETAIL_FIELD_CODE" => array(
			0 => "ID",
			1 => "CODE",
			2 => "XML_ID",
			3 => "NAME",
			4 => "TAGS",
			5 => "SORT",
			6 => "PREVIEW_TEXT",
			7 => "PREVIEW_PICTURE",
			8 => "DETAIL_TEXT",
			9 => "DETAIL_PICTURE",
			10 => "DATE_ACTIVE_FROM",
			11 => "ACTIVE_FROM",
			12 => "DATE_ACTIVE_TO",
			13 => "ACTIVE_TO",
			14 => "SHOW_COUNTER",
			15 => "SHOW_COUNTER_START",
			16 => "IBLOCK_TYPE_ID",
			17 => "IBLOCK_ID",
			18 => "IBLOCK_CODE",
			19 => "IBLOCK_NAME",
			20 => "IBLOCK_EXTERNAL_ID",
			21 => "DATE_CREATE",
			22 => "CREATED_BY",
			23 => "CREATED_USER_NAME",
			24 => "TIMESTAMP_X",
			25 => "MODIFIED_BY",
			26 => "USER_NAME",
			27 => "",
		),
		"DETAIL_PROPERTY_CODE" => array(
			0 => "AUTHOR",
			1 => "FORUM_MESSAGE_CNT",
			2 => "FORUM_TOPIC_ID",
			3 => "",
		),
		"DETAIL_DISPLAY_TOP_PAGER" => "N",
		"DETAIL_DISPLAY_BOTTOM_PAGER" => "Y",
		"DETAIL_PAGER_TITLE" => "Новость",
		"DETAIL_PAGER_TEMPLATE" => "",
		"DETAIL_PAGER_SHOW_ALL" => "Y",
		"PAGER_TEMPLATE" => ".default",
		"DISPLAY_TOP_PAGER" => "N",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"PAGER_TITLE" => "Новости",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "Y",
		"SEF_FOLDER" => "/",
		"SEF_URL_TEMPLATES" => array(
			"news" => "news",
			"section" => "news/#SECTION_CODE_PATH#/",
			"detail" => "news/#SECTION_CODE_PATH#/#ELEMENT_CODE#/",
		)
	), false); */ ?>
</div><br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>