<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
if(!function_exists('makano_limit_string')) {
	function makano_limit_string($str='', $words_l=1, $syms_l=0){
		$res = strip_tags($str); $res = preg_split("~(\r\n|\s)~", $res);
		$res = implode(" ", array_slice($res, 0, $words_l));
		return $res;
	}
}
if (empty($arResult['ITEMS'])) return;
	$templateLibrary = array('popup');
	$currencyList = '';
	if (!empty($arResult['CURRENCIES']))
	{
		$templateLibrary[] = 'currency';
		$currencyList = CUtil::PhpToJSObject($arResult['CURRENCIES'], false, true, true);
	}
	$templateData = array(
		'TEMPLATE_THEME' => $this->GetFolder().'/themes/'.$arParams['TEMPLATE_THEME'].'/style.css',
		'TEMPLATE_CLASS' => 'bx_'.$arParams['TEMPLATE_THEME'],
		'TEMPLATE_LIBRARY' => $templateLibrary,
		'CURRENCIES' => $currencyList
	);
	unset($currencyList, $templateLibrary);

	$arSkuTemplate = array();
	if (!empty($arResult['SKU_PROPS']))
	{
		foreach ($arResult['SKU_PROPS'] as &$arProp)
		{
			$templateRow = '';
			if ('TEXT' == $arProp['SHOW_MODE'])
			{
				if (5 < $arProp['VALUES_COUNT'])
				{
					$strClass = 'bx_item_detail_size full';
					$strWidth = ($arProp['VALUES_COUNT']*20).'%';
					$strOneWidth = (100/$arProp['VALUES_COUNT']).'%';
					$strSlideStyle = '';
				}
				else
				{
					$strClass = 'bx_item_detail_size';
					$strWidth = '100%';
					$strOneWidth = '20%';
					$strSlideStyle = 'display: none;';
				}
				$templateRow .= '<div class="'.$strClass.'" id="#ITEM#_prop_'.$arProp['ID'].'_cont">'.
'<span class="bx_item_section_name_gray">'.htmlspecialcharsex($arProp['NAME']).'</span>'.
'<div class="bx_size_scroller_container"><div class="bx_size"><ul id="#ITEM#_prop_'.$arProp['ID'].'_list" style="width: '.$strWidth.';">';
				foreach ($arProp['VALUES'] as $arOneValue)
				{
					$arOneValue['NAME'] = htmlspecialcharsbx($arOneValue['NAME']);
					$templateRow .= '<li data-treevalue="'.$arProp['ID'].'_'.$arOneValue['ID'].'" data-onevalue="'.$arOneValue['ID'].'" style="width: '.$strOneWidth.';" title="'.$arOneValue['NAME'].'"><i></i><span class="cnt">'.$arOneValue['NAME'].'</span></li>';
				}
				$templateRow .= '</ul></div>'.
'<div class="bx_slide_left" id="#ITEM#_prop_'.$arProp['ID'].'_left" data-treevalue="'.$arProp['ID'].'" style="'.$strSlideStyle.'"></div>'.
'<div class="bx_slide_right" id="#ITEM#_prop_'.$arProp['ID'].'_right" data-treevalue="'.$arProp['ID'].'" style="'.$strSlideStyle.'"></div>'.
'</div></div>';
			}
			elseif ('PICT' == $arProp['SHOW_MODE'])
			{
				if (5 < $arProp['VALUES_COUNT'])
				{
					$strClass = 'bx_item_detail_scu full';
					$strWidth = ($arProp['VALUES_COUNT']*20).'%';
					$strOneWidth = (100/$arProp['VALUES_COUNT']).'%';
					$strSlideStyle = '';
				}
				else
				{
					$strClass = 'bx_item_detail_scu';
					$strWidth = '100%';
					$strOneWidth = '20%';
					$strSlideStyle = 'display: none;';
				}
				$templateRow .= '<div class="'.$strClass.'" id="#ITEM#_prop_'.$arProp['ID'].'_cont">'.
'<span class="bx_item_section_name_gray">'.htmlspecialcharsex($arProp['NAME']).'</span>'.
'<div class="bx_scu_scroller_container"><div class="bx_scu"><ul id="#ITEM#_prop_'.$arProp['ID'].'_list" style="width: '.$strWidth.';">';
				foreach ($arProp['VALUES'] as $arOneValue)
				{
					$arOneValue['NAME'] = htmlspecialcharsbx($arOneValue['NAME']);
					$templateRow .= '<li data-treevalue="'.$arProp['ID'].'_'.$arOneValue['ID'].'" data-onevalue="'.$arOneValue['ID'].'" style="width: '.$strOneWidth.'; padding-top: '.$strOneWidth.';"><i title="'.$arOneValue['NAME'].'"></i>'.
'<span class="cnt"><span class="cnt_item" style="background-image:url(\''.$arOneValue['PICT']['SRC'].'\');" title="'.$arOneValue['NAME'].'"></span></span></li>';
				}
				$templateRow .= '</ul></div>'.
'<div class="bx_slide_left" id="#ITEM#_prop_'.$arProp['ID'].'_left" data-treevalue="'.$arProp['ID'].'" style="'.$strSlideStyle.'"></div>'.
'<div class="bx_slide_right" id="#ITEM#_prop_'.$arProp['ID'].'_right" data-treevalue="'.$arProp['ID'].'" style="'.$strSlideStyle.'"></div>'.
'</div></div>';
			}
			$arSkuTemplate[$arProp['CODE']] = $templateRow;
		}
		unset($templateRow, $arProp);
	}

	if ($arParams["DISPLAY_TOP_PAGER"])
	{
		?><? echo $arResult["NAV_STRING"]; ?><?
	}

	$strElementEdit = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT");
	$strElementDelete = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE");
	$arElementDeleteParams = array("CONFIRM" => GetMessage('CT_BCS_TPL_ELEMENT_DELETE_CONFIRM'));
?>
<div class="novelty_wrap">
<? foreach ($arResult['ITEMS'] as $key => $arItem) {
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], $strElementEdit);
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], $strElementDelete, $arElementDeleteParams);
	$strMainID = $this->GetEditAreaId($arItem['ID']);
	$catalog_vars = CCatalogProduct::GetByID($arItem['ID']);

	$arItemIDs = array(
		'ID' => $strMainID,
		'PICT' => $strMainID.'_pict',
		'SECOND_PICT' => $strMainID.'_secondpict',
		'STICKER_ID' => $strMainID.'_sticker',
		'SECOND_STICKER_ID' => $strMainID.'_secondsticker',
		'QUANTITY' => $strMainID.'_quantity',
		'QUANTITY_DOWN' => $strMainID.'_quant_down',
		'QUANTITY_UP' => $strMainID.'_quant_up',
		'QUANTITY_MEASURE' => $strMainID.'_quant_measure',
		'BUY_LINK' => $strMainID.'_buy_link',
		'BASKET_ACTIONS' => $strMainID.'_basket_actions',
		'NOT_AVAILABLE_MESS' => $strMainID.'_not_avail',
		'SUBSCRIBE_LINK' => $strMainID.'_subscribe',
		'COMPARE_LINK' => $strMainID.'_compare_link',

		'PRICE' => $strMainID.'_price',
		'DSC_PERC' => $strMainID.'_dsc_perc',
		'SECOND_DSC_PERC' => $strMainID.'_second_dsc_perc',
		'PROP_DIV' => $strMainID.'_sku_tree',
		'PROP' => $strMainID.'_prop_',
		'DISPLAY_PROP_DIV' => $strMainID.'_sku_prop',
		'BASKET_PROP_DIV' => $strMainID.'_basket_prop',
	);

	$strObName = 'ob'.preg_replace("/[^a-zA-Z0-9_]/", "x", $strMainID);

	$arJSParams = array(
		'PRODUCT_TYPE' => $arItem['CATALOG_TYPE'],
		'SHOW_QUANTITY' => ($arParams['USE_PRODUCT_QUANTITY'] == 'Y'),
		'SHOW_ADD_BASKET_BTN' => false,
		'SHOW_BUY_BTN' => true,
		'SHOW_ABSENT' => true,
		'ADD_TO_BASKET_ACTION' => $arParams['ADD_TO_BASKET_ACTION'],
		'SHOW_CLOSE_POPUP' => ($arParams['SHOW_CLOSE_POPUP'] == 'Y'),
		'DISPLAY_COMPARE' => $arParams['DISPLAY_COMPARE'],
		'PRODUCT' => array(
			'ID' => $arItem['ID'],
			'NAME' => $productTitle,
			'PICT' => ('Y' == $arItem['SECOND_PICT'] ? $arItem['PREVIEW_PICTURE_SECOND'] : $arItem['PREVIEW_PICTURE']),
			'CAN_BUY' => $arItem["CAN_BUY"],
			'SUBSCRIPTION' => ('Y' == $arItem['CATALOG_SUBSCRIPTION']),
			'CHECK_QUANTITY' => $arItem['CHECK_QUANTITY'],
			'MAX_QUANTITY' => $arItem['CATALOG_QUANTITY'],
			'STEP_QUANTITY' => $arItem['CATALOG_MEASURE_RATIO'],
			'QUANTITY_FLOAT' => is_double($arItem['CATALOG_MEASURE_RATIO']),
			'SUBSCRIBE_URL' => $arItem['~SUBSCRIBE_URL'],
			'BASIS_PRICE' => $arItem['MIN_BASIS_PRICE']
		),
		'BASKET' => array(
			'ADD_PROPS' => ('Y' == $arParams['ADD_PROPERTIES_TO_BASKET']),
			'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
			'PROPS' => $arParams['PRODUCT_PROPS_VARIABLE'],
			'EMPTY_PROPS' => $emptyProductProperties,
			'ADD_URL_TEMPLATE' => $arResult['~ADD_URL_TEMPLATE'],
			'BUY_URL_TEMPLATE' => $arResult['~BUY_URL_TEMPLATE']
		),
		'VISUAL' => array(
			'ID' => $arItemIDs['ID'],
			'PICT_ID' => $arItemIDs['PICT'],
			'QUANTITY_ID' => $arItemIDs['QUANTITY'],
			'QUANTITY_UP_ID' => $arItemIDs['QUANTITY_UP'],
			'QUANTITY_DOWN_ID' => $arItemIDs['QUANTITY_DOWN'],
			'PRICE_ID' => $arItemIDs['PRICE'],
			'BUY_ID' => $arItemIDs['BUY_LINK'],
			'BASKET_PROP_DIV' => $arItemIDs['BASKET_PROP_DIV'],
			'BASKET_ACTIONS_ID' => $arItemIDs['BASKET_ACTIONS'],
			'NOT_AVAILABLE_MESS' => $arItemIDs['NOT_AVAILABLE_MESS'],
			'COMPARE_LINK_ID' => $arItemIDs['COMPARE_LINK']
		),
		'LAST_ELEMENT' => $arItem['LAST_ELEMENT']
	);
	if ($arParams['DISPLAY_COMPARE'])
	{
		$arJSParams['COMPARE'] = array(
			'COMPARE_URL_TEMPLATE' => $arResult['~COMPARE_URL_TEMPLATE'],
			'COMPARE_PATH' => $arParams['COMPARE_PATH']
		);
	}
	unset($emptyProductProperties);

	$productTitle = (
		isset($arItem['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'])&& $arItem['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'] != ''
		? $arItem['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']
		: $arItem['NAME']
	);
	$imgTitle = (
		isset($arItem['IPROPERTY_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_TITLE']) && $arItem['IPROPERTY_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_TITLE'] != ''
		? $arItem['IPROPERTY_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_TITLE']
		: $arItem['NAME']
	);
	?>

<? if($USER->IsAdmin()) {echo '<pre>'; print_r($arItem); echo '</pre>';} ?>

	<div class="item_box" id="<?php echo $arItemIDs['ID']; ?>">
		<div class="col-xs-3 img_box" id="<?php echo $arItemIDs['PICT']; ?>">
			<? 	
				$section = CIBlockElement::GetList(array(), array('ID' => $arItem['ID']), false, false, array('IBLOCK_SECTION_ID'))->Fetch();
				$section = $section["IBLOCK_SECTION_ID"];
				$arSections = CIBlockSection::GetNavChain(false, $section)->Fetch();
				if(in_array('101', $arSections)) {
					echo "<div class='ebook_hover new_prod_hover'>eBook</div>";
				}
				if(is_array($arItem['DETAIL_PICTURE']) && isset($arItem['DETAIL_PICTURE']['SRC'])) {
					?>
				<a href="<? echo $arItem['DETAIL_PICTURE']['SRC']; ?>" class="fancybox">
					<?
				}
			?>
			<img src="<? echo $arItem['PREVIEW_PICTURE']['SRC']; ?>" alt="" />
				<?
				if(is_array($arItem['DETAIL_PICTURE']) && isset($arItem['DETAIL_PICTURE']['SRC'])) {
					?>
				</a>
					<?
				}
				?>
		</div>
		<div class="col-xs-6 item_desc">
			<div class="bx_catalog_item_title">
				<a href="<? echo $arItem['DETAIL_PAGE_URL']; ?>" title="<? echo $productTitle; ?>">
					<? echo $productTitle; ?>
				</a>
				<!-- <pre><?php //print_r(makano_limit_string($arItem['DETAIL_TEXT'],40)); ?></pre> -->
			</div>
			<?php if(!empty($arItem['PROPERTIES']['AUTHOR_XMLID']['VALUE_ELEMENTS'])) { ?>
			<div class="autor">
				<?php foreach ($arItem['PROPERTIES']['AUTHOR_XMLID']['VALUE_ELEMENTS'] as $author) { ?>
				<a href="<?php echo $author['DETAIL_PAGE_URL']; ?>"><?php echo $author['NAME']; ?></a>
				<?php } ?>
			</div>
			<?php } ?>
           
			<div class="desc_text"><?php echo makano_limit_string($arItem['DETAIL_TEXT'],40);?>...</div>
			<div class="more"><a href="<? echo $arItem['DETAIL_PAGE_URL']; ?>" title="<? echo $productTitle; ?>">Подробнее...</a></div>
		</div>
		<div class="col-xs-3 price_block no-padding">
			<div class="bx_catalog_item_price">
				<?
					// var_dump(site::ConvertPrice($arItem['MIN_PRICE']['PRINT_DISCOUNT_VALUE']));
					// var_dump(site::getCurrency());
					//var_dump(site::ConvertPrice($arItem['PROPERTIES']['PRICE_OLD']['VALUE']));
					
					
					
				?>
				
				<? //if($USER->IsAdmin()) {echo '<pre>'; print_r($arItem); echo '</pre>';} ?>
                
                
				<div id="<? echo $arItemIDs['PRICE']; ?>" class="bx_price">
					<? if(!empty($arItem['PROPERTIES']['PRICE_OLD']['VALUE']) && $arItem['PROPERTIES']['PRICE_OLD']['VALUE'] != '0.00') { ?>
					<s class="price-old"><?php echo CCurrencyLang::CurrencyFormat(str_replace(" ", "", site::ConvertPrice($arItem['PROPERTIES']['PRICE_OLD']['VALUE'])), site::getCurrency(), true)?></s>
					<? } ?>
					<? if (!empty($arItem['MIN_PRICE'])) { ?>
					<? if ('N' == $arParams['PRODUCT_DISPLAY_MODE'] && isset($arItem['OFFERS']) && !empty($arItem['OFFERS'])) { ?>
					<? echo GetMessage(
						'CT_BCS_TPL_MESS_PRICE_SIMPLE_MODE',
						array(
							'#PRICE#' => CCurrencyLang::CurrencyFormat(str_replace(" ", "", site::ConvertPrice($arResult['MIN_PRICE']['PRINT_DISCOUNT_VALUE'])), site::getCurrency(), true),
							'#MEASURE#' => GetMessage(
								'CT_BCS_TPL_MESS_MEASURE_SIMPLE_MODE',
								array(
									'#VALUE#' => $arItem['MIN_PRICE']['CATALOG_MEASURE_RATIO'],
									'#UNIT#' => $arItem['MIN_PRICE']['CATALOG_MEASURE_NAME']
								)
							)
						)
					); ?>
					<? } else { ?>
					<? echo CCurrencyLang::CurrencyFormat(str_replace(" ", "", site::ConvertPrice($arItem['MIN_PRICE']['PRINT_DISCOUNT_VALUE'])), site::getCurrency(), true); ?>
					<? } ?>
					<? if ('Y' == $arParams['SHOW_OLD_PRICE'] && $arItem['MIN_PRICE']['DISCOUNT_VALUE'] < $arItem['MIN_PRICE']['VALUE']) { ?>
					<span><? echo CCurrencyLang::CurrencyFormat(str_replace(" ", "", site::ConvertPrice($arItem['MIN_PRICE']['PRINT_VALUE'])), site::getCurrency(), true); ?></span>
					<? } ?>
					<? } ?>
				</div>
			</div>
			<div class="catalog_item_quantity">
				<? if($catalog_vars['QUANTITY'] == 0) { ?>
				<p class="catalog_item_quantity_text quantity_null">Нет на складе</p>
				<span class="btn btn-primary" data-togglenext>заказать</span>
				<div class="form-order-product">
					<?$APPLICATION->IncludeComponent("bitrix:form.result.new","order_absent",Array(
						"SEF_MODE" => "Y", 
						"WEB_FORM_ID" => "1", 
						"LIST_URL" => "", 
						"EDIT_URL" => "", 
						"SUCCESS_URL" => "", 
						"CHAIN_ITEM_TEXT" => "", 
						"CHAIN_ITEM_LINK" => "", 
						"IGNORE_CUSTOM_TEMPLATE" => "Y", 
						"USE_EXTENDED_ERRORS" => "Y", 
						"CACHE_TYPE" => "A", 
						"CACHE_TIME" => "3600", 
						"SEF_FOLDER" => "/", 
						"VARIABLE_ALIASES" => Array(
						),
						'custom_params'=>array(
							'product_id'=>$arItem['ID'],
							'product_name'=>$arItem['NAME'],
							'product_url'=>'http://'.$_SERVER['HTTP_HOST'].$arItem['DETAIL_PAGE_URL'],
							'product_articul'=>$arItem['XML_ID'],
						),
					));?>
				</div>
				<? } ?>
			</div>
			<div class="bx_catalog_item_controls">
		<? if ($arItem['CAN_BUY']) {
			if ('Y' == $arParams['USE_PRODUCT_QUANTITY']) { /* Remove comment to use product quantity ?>
		<div class="bx_catalog_item_controls_blockone">
			<div style="display: inline-block;position: relative;">
				<a id="<? echo $arItemIDs['QUANTITY_DOWN']; ?>" href="javascript:void(0)" class="bx_bt_button_type_2 bx_small" rel="nofollow">-</a>
				<input type="text" class="bx_col_input" id="<? echo $arItemIDs['QUANTITY']; ?>" name="<? echo $arParams["PRODUCT_QUANTITY_VARIABLE"]; ?>" value="<? echo $arItem['CATALOG_MEASURE_RATIO']; ?>">
				<a id="<? echo $arItemIDs['QUANTITY_UP']; ?>" href="javascript:void(0)" class="bx_bt_button_type_2 bx_small" rel="nofollow">+</a>
				<span id="<? echo $arItemIDs['QUANTITY_MEASURE']; ?>"><? echo $arItem['CATALOG_MEASURE_NAME']; ?></span>
			</div>
		</div>
			<? */} ?>
		<div id="<? echo $arItemIDs['BASKET_ACTIONS']; ?>" class="bx_catalog_item_controls_blocktwo">
			<a id="<? echo $arItemIDs['BUY_LINK']; ?>" class="bx_bt_button bx_medium" href="javascript:void(0)" rel="nofollow">
			<? /*if ($arParams['ADD_TO_BASKET_ACTION'] == 'BUY')
				{
					echo ('' != $arParams['MESS_BTN_BUY'] ? $arParams['MESS_BTN_BUY'] : GetMessage('CT_BCS_TPL_MESS_BTN_BUY'));
				} else {
					echo ('' != $arParams['MESS_BTN_ADD_TO_BASKET'] ? $arParams['MESS_BTN_ADD_TO_BASKET'] : GetMessage('CT_BCS_TPL_MESS_BTN_ADD_TO_BASKET'));
				}*/ ?>
			</a>
		</div>
			<?
			if ($arParams['DISPLAY_COMPARE'])
			{
				?>
				<div class="bx_catalog_item_controls_blocktwo">
					<a id="<? echo $arItemIDs['COMPARE_LINK']; ?>" class="bx_bt_button_type_2 bx_medium" href="javascript:void(0)"><? echo $compareBtnMessage; ?></a>
				</div><?
			}
		}
		else
		{
			?><div id="<? echo $arItemIDs['NOT_AVAILABLE_MESS']; ?>" class="bx_catalog_item_controls_blockone">
				<span class="bx_notavailable">
					<? echo ('' != $arParams['MESS_NOT_AVAILABLE'] ? $arParams['MESS_NOT_AVAILABLE'] : GetMessage('CT_BCS_TPL_MESS_PRODUCT_NOT_AVAILABLE'));?>
				</span>
			</div>
			<?
			if ($arParams['DISPLAY_COMPARE'] || $showSubscribeBtn)
			{
			?>
				<div class="bx_catalog_item_controls_blocktwo"><?
				if ($arParams['DISPLAY_COMPARE'])
				{
					?><a id="<? echo $arItemIDs['COMPARE_LINK']; ?>" class="bx_bt_button_type_2 bx_medium" href="javascript:void(0)"><? echo $compareBtnMessage; ?></a><?
				}
				if ($showSubscribeBtn)
				{
				?>
				<a id="<? echo $arItemIDs['SUBSCRIBE_LINK']; ?>" class="bx_bt_button_type_2 bx_medium" href="javascript:void(0)"><?
					echo ('' != $arParams['MESS_BTN_SUBSCRIBE'] ? $arParams['MESS_BTN_SUBSCRIBE'] : GetMessage('CT_BCS_TPL_MESS_BTN_SUBSCRIBE'));
					?></a><?
				}
				?>
			</div><?
			}
		}
		?><div style="clear: both;"></div></div>
		<?
		if($arItem['PROPERTIES']['SPECIALOFFER']['VALUE'] == 1) {
			?>
			<img width="50" alt="Лучшая цена гарантирована" src="http://knigionline.com/images/bestprice.png" height="50">
			<?
		}
		?>
		</div>
		<div class="clearfix"></div>
	</div>
    
	<script type="text/javascript">
		var <? echo $strObName; ?> = new JCCatalogSection(<? echo CUtil::PhpToJSObject($arJSParams, false, true); ?>);
	</script>
	<? } ?>
	<div style="clear: both;"></div>
</div>
<script type="text/javascript">
BX.message({
	BTN_MESSAGE_BASKET_REDIRECT: '<? echo GetMessageJS('CT_BCS_CATALOG_BTN_MESSAGE_BASKET_REDIRECT'); ?>',
	BASKET_URL: '<? echo $arParams["BASKET_URL"]; ?>',
	ADD_TO_BASKET_OK: '<? echo GetMessageJS('ADD_TO_BASKET_OK'); ?>',
	TITLE_ERROR: '<? echo GetMessageJS('CT_BCS_CATALOG_TITLE_ERROR') ?>',
	TITLE_BASKET_PROPS: '<? echo GetMessageJS('CT_BCS_CATALOG_TITLE_BASKET_PROPS') ?>',
	TITLE_SUCCESSFUL: '<? echo GetMessageJS('ADD_TO_BASKET_OK'); ?>',
	BASKET_UNKNOWN_ERROR: '<? echo GetMessageJS('CT_BCS_CATALOG_BASKET_UNKNOWN_ERROR') ?>',
	BTN_MESSAGE_SEND_PROPS: '<? echo GetMessageJS('CT_BCS_CATALOG_BTN_MESSAGE_SEND_PROPS'); ?>',
	BTN_MESSAGE_CLOSE: '<? echo GetMessageJS('CT_BCS_CATALOG_BTN_MESSAGE_CLOSE') ?>',
	BTN_MESSAGE_CLOSE_POPUP: '<? echo GetMessageJS('CT_BCS_CATALOG_BTN_MESSAGE_CLOSE_POPUP'); ?>',
	BTN_MESSAGE_BASKET_REDIRECT: '<? echo GetMessageJS('CT_BCS_CATALOG_BTN_MESSAGE_BASKET_REDIRECT') ?>',
	COMPARE_MESSAGE_OK: '<? echo GetMessageJS('CT_BCS_CATALOG_MESS_COMPARE_OK') ?>',
	COMPARE_UNKNOWN_ERROR: '<? echo GetMessageJS('CT_BCS_CATALOG_MESS_COMPARE_UNKNOWN_ERROR') ?>',
	COMPARE_TITLE: '<? echo GetMessageJS('CT_BCS_CATALOG_MESS_COMPARE_TITLE') ?>',
	BTN_MESSAGE_COMPARE_REDIRECT: '<? echo GetMessageJS('CT_BCS_CATALOG_BTN_MESSAGE_COMPARE_REDIRECT') ?>',
	SITE_ID: '<? echo SITE_ID; ?>'
});
</script>
<script>
	$(function() {
		$('.fancybox').fancybox();
	});
</script>
<div class="paginations"><? if ($arParams["DISPLAY_BOTTOM_PAGER"]) { ?><? echo $arResult["NAV_STRING"]; ?><? } ?></div>