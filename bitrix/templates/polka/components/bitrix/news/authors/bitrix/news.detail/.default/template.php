<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
	/* COUNT BOOKS OF AUTHOR */
	$count = CIBlockElement::GetList(
			array(),
			array('ACTIVE' => 'Y', "PROPERTY_AUTHOR_XMLID" => $arResult['XML_ID']),
			array()
		);
	/* END COUNT BOOKS OF AUTHOR */
?>
<div class="bx_news_detail author_block">
    <?if($arParams["DISPLAY_NAME"]!="N" && $arResult["NAME"]):?>
    <h2><?=$arResult["NAME"]?></h2>
    <?endif;?>
    <div class="author_backlink">
		<a href="<?=$arParams['IBLOCK_URL']?>"><< Авторы</a>
	</div>
	<div class="author_page_info">
		<div class="author_page_photo">
			<?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arResult["DETAIL_PICTURE"])){?>
			<img class="detail_picture" border="0" src="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>" alt="<?=$arResult["NAME"]?>"  title="<?=$arResult["NAME"]?>" />
			<? } else if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arResult["PREVIEW_PICTURE"])){?>
			<img class="detail_picture" border="0" src="<?=$arResult["PREVIEW_PICTURE"]["SRC"]?>" alt="<?=$arResult["NAME"]?>"  title="<?=$arResult["NAME"]?>" />
			<? } ?>
		</div>
		<div class="author_page_desc">
			<div class="author_book_search">
				<span>Найдено книг автора </span>
				<a href="/catalog/?q=<? echo str_replace(" ", "+", trim($arResult['NAME']))?>&s=AUTOR"><?=$count?></a>
			</div>
			<div class="share_author_page">
				<div style="float:left;font-size:0.9em;">Поделиться ссылкой:&nbsp;&nbsp;&nbsp;</div><br>
				<div class="addthis_toolbox addthis_default_style ">
					<a class="addthis_button_vk"></a>
					<a class="addthis_button_facebook"></a>
					<a class="addthis_button_twitter"></a>
					<a class="addthis_button_livejournal"></a>
					<a class="addthis_button_email"></a>
					<a class="addthis_button_print"></a>
					<a class="addthis_button_compact"></a>
					<a class="addthis_bubble_style"></a>
				</div>
			</div>
			<h2>Биография</h2>
			<div class="author_page_biography">
				<? 
				if(!empty($arResult['DETAIL_TEXT'])) {
					echo $arResult['DETAIL_TEXT'];
				} else {
					echo $arResult['PREVIEW_TEXT'];
				}
				?>

			</div>
		</div>
	</div>
</div>
<?php 
	if(!empty($count)) {
	global $authorsFilter; 
	$authorsFilter = array('PROPERTY_AUTHOR_XMLID'=>$arResult['XML_ID']);
?>
<h2>Книги автора</h2>
<div class="authors_book_block_list">
	<?$APPLICATION->IncludeComponent("bitrix:catalog.section", "template_autor_knigi", Array(
		"ACTION_VARIABLE" => "action",
		"ADD_PROPERTIES_TO_BASKET" => "N",
		"ADD_SECTIONS_CHAIN" => "N",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"BASKET_URL" => "/personal/basket.php",
		"BROWSER_TITLE" => "-",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "N",
		"CONVERT_CURRENCY" => "Y",
		"DETAIL_URL" => "",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_COMPARE" => "N",
		"DISPLAY_TOP_PAGER" => "N",
		"ELEMENT_SORT_FIELD" => "property_ARTNUMBER",
		"ELEMENT_SORT_FIELD2" => "",
		"ELEMENT_SORT_ORDER" => "desc",
		"ELEMENT_SORT_ORDER2" => "",
		"FILTER_NAME" => "authorsFilter",
		"HIDE_NOT_AVAILABLE" => "N",
		"IBLOCK_ID" => "2",
		"IBLOCK_TYPE" => "catalog",
		"INCLUDE_SUBSECTIONS" => "N",
		"LINE_ELEMENT_COUNT" => "3",
		"MESS_BTN_ADD_TO_BASKET" => "В корзину",
		"MESS_BTN_BUY" => "Купить",
		"MESS_BTN_DETAIL" => "Подробнее",
		"MESS_BTN_SUBSCRIBE" => "Подписаться",
		"MESS_NOT_AVAILABLE" => "Нет в наличии",
		"META_DESCRIPTION" => "-",
		"META_KEYWORDS" => "-",
		"OFFERS_LIMIT" => "5",
		"PAGE_ELEMENT_COUNT" => "20",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => ".default",
		"PAGER_TITLE" => "Товары",
		"PARTIAL_PRODUCT_PROPERTIES" => "N",
		"PRICE_CODE" => array(
			0 => "BASE",
		),
		"PRICE_VAT_INCLUDE" => "Y",
		"PRODUCT_ID_VARIABLE" => "id",
		"PRODUCT_PROPERTIES" => array(
		),
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"PRODUCT_QUANTITY_VARIABLE" => "quantity",
		"PRODUCT_SUBSCRIPTION" => "N",
		"PROPERTY_CODE" => array(
			0 => "NEWPRODUCT",
			1 => "",
		),
		"SECTION_CODE" => "",
		"SECTION_ID" => "",
		"SECTION_ID_VARIABLE" => "SECTION_ID",
		"SECTION_URL" => "",
		"SECTION_USER_FIELDS" => array(
			0 => "",
			1 => "",
		),
		"SET_META_DESCRIPTION" => "Y",
		"SET_META_KEYWORDS" => "Y",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "Y",
		"SHOW_ALL_WO_SECTION" => "Y",
		"SHOW_DISCOUNT_PERCENT" => "N",
		"SHOW_OLD_PRICE" => "N",
		"SHOW_PRICE_COUNT" => "1",
		"TEMPLATE_THEME" => "blue",
		"USE_PRICE_COUNT" => "N",
		"USE_PRODUCT_QUANTITY" => "N",
		"OFFERS_FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"OFFERS_PROPERTY_CODE" => array(
			0 => "",
			1 => "",
		),
		"OFFERS_SORT_FIELD" => "",
		"OFFERS_SORT_ORDER" => "",
		"OFFERS_SORT_FIELD2" => "",
		"OFFERS_SORT_ORDER2" => "",
		"PRODUCT_DISPLAY_MODE" => "N",
		"ADD_PICT_PROP" => "-",
		"LABEL_PROP" => "-",
		"SHOW_CLOSE_POPUP" => "N",
		"MESS_BTN_COMPARE" => "Сравнить",
		"SET_BROWSER_TITLE" => "Y",
		"OFFERS_CART_PROPERTIES" => "",
		"ADD_TO_BASKET_ACTION" => "ADD",
		"COMPONENT_TEMPLATE" => "template2",
		"CURRENCY_ID" => "UAH"
	)); ?>
</div>
<?php } ?>