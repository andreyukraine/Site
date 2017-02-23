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
// my_debug($arResult['ITEMS']);
$this->setFrameMode(true);
$sort_section_list = (@$_GET['sort']?$_GET['sort']:1);
$order_section_list = (@$_GET['order']?$_GET['order']:'');
$sort_arr = array(
	array('id'=>1, 'name'=>'новизне',),
	array('id'=>2, 'name'=>'цене', ),
	array('id'=>3, 'name'=>'названию',),
);
if(!function_exists('makano_limit_string')) {
	function makano_limit_string($str='', $words_l=1, $syms_l=0){
		$res = strip_tags($str); $res = preg_split("~(\r\n|\s)~", $res);
		$res = implode(" ", array_slice($res, 0, $words_l));
		return $res;
	}
}
include_once($_SERVER["DOCUMENT_ROOT"].'/include/cart-check-ebook.php');
$checkcart = new makano_cart_check();

if (!empty($arResult['ITEMS']))
{
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
	if (!empty($arResult['SKU_PROPS'])) {
		foreach ($arResult['SKU_PROPS'] as &$arProp) {
			$templateRow = '';
			if ('TEXT' == $arProp['SHOW_MODE']) {
				if (5 < $arProp['VALUES_COUNT']) {
					$strClass = 'bx_item_detail_size full';
					$strWidth = ($arProp['VALUES_COUNT']*20).'%';
					$strOneWidth = (100/$arProp['VALUES_COUNT']).'%';
					$strSlideStyle = '';
				} else {
					$strClass = 'bx_item_detail_size';
					$strWidth = '100%';
					$strOneWidth = '20%';
					$strSlideStyle = 'display: none;';
				}
				$templateRow .= '<div class="'.$strClass.'" id="#ITEM#_prop_'.$arProp['ID'].'_cont">'.
					'<span class="bx_item_section_name_gray">'.htmlspecialcharsex($arProp['NAME']).'</span>'.
					'<div class="bx_size_scroller_container"><div class="bx_size"><ul id="#ITEM#_prop_'.$arProp['ID'].'_list" style="width: '.$strWidth.';">';
				foreach ($arProp['VALUES'] as $arOneValue) {
					$arOneValue['NAME'] = htmlspecialcharsbx($arOneValue['NAME']);
					$templateRow .= '<li data-treevalue="'.$arProp['ID'].'_'.$arOneValue['ID'].'" data-onevalue="'.$arOneValue['ID'].'" style="width: '.$strOneWidth.';" title="'.$arOneValue['NAME'].'"><i></i><span class="cnt">'.$arOneValue['NAME'].'</span></li>';
				}
				$templateRow .= '</ul></div>'.
					'<div class="bx_slide_left" id="#ITEM#_prop_'.$arProp['ID'].'_left" data-treevalue="'.$arProp['ID'].'" style="'.$strSlideStyle.'"></div>'.
					'<div class="bx_slide_right" id="#ITEM#_prop_'.$arProp['ID'].'_right" data-treevalue="'.$arProp['ID'].'" style="'.$strSlideStyle.'"></div>'.
					'</div></div>';
			} elseif ('PICT' == $arProp['SHOW_MODE']) {
				if (5 < $arProp['VALUES_COUNT']) {
					$strClass = 'bx_item_detail_scu full';
					$strWidth = ($arProp['VALUES_COUNT']*20).'%';
					$strOneWidth = (100/$arProp['VALUES_COUNT']).'%';
					$strSlideStyle = '';
				} else {
					$strClass = 'bx_item_detail_scu';
					$strWidth = '100%';
					$strOneWidth = '20%';
					$strSlideStyle = 'display: none;';
				}
				$templateRow .= '<div class="'.$strClass.'" id="#ITEM#_prop_'.$arProp['ID'].'_cont">'.
					'<span class="bx_item_section_name_gray">'.htmlspecialcharsex($arProp['NAME']).'</span>'.
					'<div class="bx_scu_scroller_container"><div class="bx_scu"><ul id="#ITEM#_prop_'.$arProp['ID'].'_list" style="width: '.$strWidth.';">';
				foreach ($arProp['VALUES'] as $arOneValue) {
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

	$strElementEdit = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT");
	$strElementDelete = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE");
	$arElementDeleteParams = array("CONFIRM" => GetMessage('CT_BCS_TPL_ELEMENT_DELETE_CONFIRM'));
?>
			<div class="sort_block_section">
				<div class="sort_wrapper">
					Сортировать по: 
					<span class="sort_selector_span">
						<?php foreach ($sort_arr as $sa) if($sa['id']==$sort_section_list) { echo $sa['name']; break; } ?>
					</span>
					<ul class="sort_list_section">
						<?php foreach ($sort_arr as $sa) { 
							$get = $_GET;
							$get['sort'] = $sa['id'];
							$get['order'] = ($order_section_list?'':'desc');
						?>
						<li class="sort_<?php echo $sa['id'] ?>"><a href="?<?php echo http_build_query($get); ?>"><?php echo $sa['name']; ?></a></li>
						<?php } ?>
					</ul>
				</div>
				<?php if ($arParams["DISPLAY_TOP_PAGER"]) { ?>
				<? echo $arResult["NAV_STRING"]; ?>
				<? } ?>
			</div>
			<div class="section-items1">
				<? foreach ($arResult['ITEMS'] as $key => $arItem) {
					$section = CIBlockElement::GetList(array(), array('ID' => $arItem['ID']), false, false, array('IBLOCK_SECTION_ID'))->Fetch();
					$section = $section["IBLOCK_SECTION_ID"];
					$arSections = CIBlockSection::GetNavChain(false, $section)->Fetch();
					$catalog_vars = CCatalogProduct::GetByID($arItem['ID']);
					/*if(!empty($arParams['DOP_PROPS']) 
						&& $arItem['PROPERTIES'][$arParams['DOP_PROPS']]['VALUE'] != str_replace('+', ' ', $arParams['SEARCH'])) continue;*/
					$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], $strElementEdit);
					$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], $strElementDelete, $arElementDeleteParams);
					$strMainID = $this->GetEditAreaId($arItem['ID']);
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
				<div class="item_box">
					<div class="col-xs-2 img_box">
						<div>
							<? if(in_array('101', $arSections)) { ?>
							<div class='ebook_hover'>eBook</div>
							<? } ?>
							<? if(is_array($arItem['DETAIL_PICTURE']) && isset($arItem['DETAIL_PICTURE']['SRC'])) { ?>
							<a href="<? echo $arItem['DETAIL_PICTURE']['SRC']; ?>" class="fancybox">
							<? } ?>
								<img src="<? echo $arItem['PREVIEW_PICTURE']['SRC']; ?>" <? echo (in_array('101', $arSections))?'class="ebookimg"':''; ?> alt="" />
							<? if(is_array($arItem['DETAIL_PICTURE']) && isset($arItem['DETAIL_PICTURE']['SRC'])) { ?>
							</a>
							<? } ?>
						</div>
					</div>
					<div class="col-xs-8 item_desc">
						<div class="bx_catalog_item_title">
							<a href="<? echo $arItem['DETAIL_PAGE_URL']; ?>" title="<? echo $productTitle; ?>">
								<? echo $productTitle; ?>
							</a>
						</div>
						<?php if(!empty($arItem['PROPERTIES']['AUTHOR_XMLID']['VALUE_ELEMENTS'])) { ?>
						<div class="autor">
							<?php foreach ($arItem['PROPERTIES']['AUTHOR_XMLID']['VALUE_ELEMENTS'] as $author) { ?>
							<a href="<?php echo $author['DETAIL_PAGE_URL']; ?>"><?php echo $author['NAME']; ?></a>
							<?php } ?>
						</div>
						<?php } ?>
						<?
							$preview_text = (@$arItem['PREVIEW_TEXT']?$arItem['PREVIEW_TEXT']:preg_replace('~^(.{0,180}).*$~us', '$1...', preg_replace('~<.*?>~s', '', $arItem['DETAIL_TEXT'])));
						?>
						<div class="desc_text"><?php echo $preview_text; ?></div>
						<div class="more"><a href="<? echo $arItem['DETAIL_PAGE_URL']; ?>" title="<? echo $productTitle; ?>">Подробнее...</a></div>
					</div>
					<div class="col-xs-2 price_block no-padding">
						<div class="bx_catalog_item_price">
							<? if($catalog_vars['QUANTITY'] != 0) { ?>
							<div id="<? echo $arItemIDs['PRICE']; ?>" class="bx_price">
								<? if(!empty($arItem['PROPERTIES']['PRICE_OLD']['VALUE']) && $arItem['PROPERTIES']['PRICE_OLD']['VALUE'] != '0.00' && site::ConvertPrice($arItem['PROPERTIES']['PRICE_OLD']['VALUE']) != site::ConvertPrice($arItem['MIN_PRICE']['PRINT_VALUE']) ) { ?>
								<s class="price-old"><?php echo CCurrencyLang::CurrencyFormat(str_replace(" ", "", site::ConvertPrice($arItem['PROPERTIES']['PRICE_OLD']['VALUE'])), site::getCurrency(), true) ?></s>
								<? } ?>
								<? if (!empty($arItem['MIN_PRICE'])) { ?>
								<? if ('N' == $arParams['PRODUCT_DISPLAY_MODE'] && isset($arItem['OFFERS']) && !empty($arItem['OFFERS'])) { ?>
								<? echo GetMessage('CT_BCS_TPL_MESS_PRICE_SIMPLE_MODE', array(
										'#PRICE#' => str_raplace(" ", "", site::ConvertPrice($arItem['MIN_PRICE']['PRINT_DISCOUNT_VALUE'])),
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
							<? } ?>
						</div>
						<div class="catalog_item_quantity">
							<? if($catalog_vars['QUANTITY'] == 0) { ?>
							<p class="catalog_item_quantity_text quantity_null">Нет на складе</p>
							<button class="bx_bt_order" data-togglenext></button>
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
							<? if ($arItem['CAN_BUY']) { ?>
							<? if ('Y' == $arParams['USE_PRODUCT_QUANTITY']) { /* Remove comment to use product quantity ?>
							<div class="bx_catalog_item_controls_blockone"><div style="display: inline-block;position: relative;">
								<a id="<? echo $arItemIDs['QUANTITY_DOWN']; ?>" href="javascript:void(0)" class="bx_bt_button_type_2 bx_small" rel="nofollow">-</a>
								<input type="text" class="bx_col_input" id="<? echo $arItemIDs['QUANTITY']; ?>" name="<? echo $arParams["PRODUCT_QUANTITY_VARIABLE"]; ?>" value="<? echo $arItem['CATALOG_MEASURE_RATIO']; ?>">
								<a id="<? echo $arItemIDs['QUANTITY_UP']; ?>" href="javascript:void(0)" class="bx_bt_button_type_2 bx_small" rel="nofollow">+</a>
								<span id="<? echo $arItemIDs['QUANTITY_MEASURE']; ?>"><? echo $arItem['CATALOG_MEASURE_NAME']; ?></span>
							</div></div>
							<? */} ?>
							<div id="<? echo $arItemIDs['BASKET_ACTIONS']; ?>" class="bx_catalog_item_controls_blocktwo">
								<?php if($catalog_vars['QUANTITY'] != 0) { ?>
								<?php if(
									$checkcart->has_book && preg_match('~^/catalog/ebooks/~', $arItem['DETAIL_PAGE_URL'])
								) { ?>
								<button class="bx_bt_button bx_medium" onclick="alert('В корзине одновременно не может находится электронный и обычный товар. Пожалуйста, завершите оформление предыдущего заказа.');"></button>
								<?php } else if(
									$checkcart->has_ebook && !preg_match('~^/catalog/ebooks/~', $arItem['DETAIL_PAGE_URL'])
								) { ?>
								<button class="bx_bt_button bx_medium" onclick="alert('В корзине одновременно не может находится электронный и обычный товар. Пожалуйста, завершите оформление предыдущего заказа.');"></button>
								<?php } else { ?>
								<a id="<? echo $arItemIDs['BUY_LINK']; ?>" class="bx_bt_button bx_medium" href="javascript:void(0)" rel="nofollow">
								<? /*if ($arParams['ADD_TO_BASKET_ACTION'] == 'BUY')
									{
										echo ('' != $arParams['MESS_BTN_BUY'] ? $arParams['MESS_BTN_BUY'] : GetMessage('CT_BCS_TPL_MESS_BTN_BUY'));
									} else {
										echo ('' != $arParams['MESS_BTN_ADD_TO_BASKET'] ? $arParams['MESS_BTN_ADD_TO_BASKET'] : GetMessage('CT_BCS_TPL_MESS_BTN_ADD_TO_BASKET'));
									}*/ ?>
								</a>
								<?php } ?>
								<?php } else { ?>
									<?/*<a href="<? echo $arItem['DETAIL_PAGE_URL']; ?>" title="<? echo $productTitle; ?>">Заказать</a>*/?>
								<?php } ?>
								<a href="<?=$arItem['DETAIL_PAGE_URL']?>"><div class="detail_button sprite_detail_button"></div></a>
							</div>
							<? if ($arParams['DISPLAY_COMPARE']) { ?>
							<div class="bx_catalog_item_controls_blocktwo">
								<a id="<? echo $arItemIDs['COMPARE_LINK']; ?>" class="bx_bt_button_type_2 bx_medium" href="javascript:void(0)"><? echo $compareBtnMessage; ?></a>
							</div>
							<? } ?>
							<? } else { ?>
							<div id="<? echo $arItemIDs['NOT_AVAILABLE_MESS']; ?>" class="bx_catalog_item_controls_blockone">
								<span class="bx_notavailable"><?
									// echo ('' != $arParams['MESS_NOT_AVAILABLE'] ? $arParams['MESS_NOT_AVAILABLE'] : GetMessage('CT_BCS_TPL_MESS_PRODUCT_NOT_AVAILABLE'));
								?></span>
							</div>
							<? if ($arParams['DISPLAY_COMPARE'] || $showSubscribeBtn) { ?>
							<div class="bx_catalog_item_controls_blocktwo">
								<? if ($arParams['DISPLAY_COMPARE']) { ?>
								<a id="<? echo $arItemIDs['COMPARE_LINK']; ?>" class="bx_bt_button_type_2 bx_medium" href="javascript:void(0)"><? echo $compareBtnMessage; ?></a>
								<? } ?>
								<? if ($showSubscribeBtn) { ?>
								<a id="<? echo $arItemIDs['SUBSCRIBE_LINK']; ?>" class="bx_bt_button_type_2 bx_medium" href="javascript:void(0)"><?
									echo ('' != $arParams['MESS_BTN_SUBSCRIBE'] ? $arParams['MESS_BTN_SUBSCRIBE'] : GetMessage('CT_BCS_TPL_MESS_BTN_SUBSCRIBE'));
									?></a>
								<? } ?>
							</div>
							<? } ?>
							<? } ?>
							<div style="clear: both;"></div>
						</div>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="<? echo ($arItem['SECOND_PICT'] ? 'bx_catalog_item double' : 'bx_catalog_item'); ?> hide">
					<div class="bx_catalog_item_container" id="<? echo $strMainID; ?>">
						<a id="<? echo $arItemIDs['PICT']; ?>" href="<? echo $arItem['DETAIL_PAGE_URL']; ?>" class="bx_catalog_item_images" style="background-image: url('<? echo $arItem['PREVIEW_PICTURE']['SRC']; ?>')" title="<? echo $imgTitle; ?>">
							<?if ('Y' == $arParams['SHOW_DISCOUNT_PERCENT']) { ?>
							<div id="<? echo $arItemIDs['DSC_PERC']; ?>" class="bx_stick_disc right bottom" style="display:<? echo (0 < $arItem['MIN_PRICE']['DISCOUNT_DIFF_PERCENT'] ? '' : 'none'); ?>;">-<? echo $arItem['MIN_PRICE']['DISCOUNT_DIFF_PERCENT']; ?>%</div>
							<? } ?>
							<? if ($arItem['LABEL']) { ?>
							<div id="<? echo $arItemIDs['STICKER_ID']; ?>" class="bx_stick average left top" title="<? echo $arItem['LABEL_VALUE']; ?>"><? echo $arItem['LABEL_VALUE']; ?></div>
							<? } ?>
						</a>
						<? if ($arItem['SECOND_PICT']) { ?>
						<a 
							id="<? echo $arItemIDs['SECOND_PICT']; ?>" 
							href="<? echo $arItem['DETAIL_PAGE_URL']; ?>" 
							class="bx_catalog_item_images_double" 
							style="background-image: url('<? echo (!empty($arItem['PREVIEW_PICTURE_SECOND']) ? $arItem['PREVIEW_PICTURE_SECOND']['SRC'] : $arItem['PREVIEW_PICTURE']['SRC']); ?>');"
							title="<? echo $imgTitle; ?>">
							<? if ('Y' == $arParams['SHOW_DISCOUNT_PERCENT']) { ?>
							<div id="<? echo $arItemIDs['SECOND_DSC_PERC']; ?>" class="bx_stick_disc right bottom" style="display:<? echo (0 < $arItem['MIN_PRICE']['DISCOUNT_DIFF_PERCENT'] ? '' : 'none'); ?>;">-<? echo $arItem['MIN_PRICE']['DISCOUNT_DIFF_PERCENT']; ?>%</div>
							<? } ?>
							<? if ($arItem['LABEL']) { ?>
							<div id="<? echo $arItemIDs['SECOND_STICKER_ID']; ?>" class="bx_stick average left top" title="<? echo $arItem['LABEL_VALUE']; ?>"><? echo $arItem['LABEL_VALUE']; ?></div>
							<? } ?>
						</a>
						<? } ?>
						<div class="bx_catalog_item_title">
							<a href="<? echo $arItem['DETAIL_PAGE_URL']; ?>" title="<? echo $productTitle; ?>">
								<? echo $productTitle; ?>
							</a>
						</div>
						<div class="bx_catalog_item_price">
							<div id="<? echo $arItemIDs['PRICE']; ?>" class="bx_price">
								<? if(!empty($arItem['PROPERTIES']['PRICE_OLD']['VALUE'])) { ?>
								<s class="price-old"><?php echo str_replace(" ", "", site::ConvertPrice($arItem['PROPERTIES']['PRICE_OLD']['VALUE'])), ' ', site::getCurrency(); ?></s>
								<? } ?>
								<? if (!empty($arItem['MIN_PRICE'])) { ?>
								<? if ('N' == $arParams['PRODUCT_DISPLAY_MODE'] && isset($arItem['OFFERS']) && !empty($arItem['OFFERS'])) { ?>
								<? echo GetMessage('CT_BCS_TPL_MESS_PRICE_SIMPLE_MODE', array(
									'#PRICE#' => str_replace(" ", "", site::ConvertPrice($arItem['MIN_PRICE']['PRINT_DISCOUNT_VALUE'])),
									'#MEASURE#' => GetMessage(
										'CT_BCS_TPL_MESS_MEASURE_SIMPLE_MODE',
										array(
											'#VALUE#' => $arItem['MIN_PRICE']['CATALOG_MEASURE_RATIO'],
											'#UNIT#' => $arItem['MIN_PRICE']['CATALOG_MEASURE_NAME']
										)
									)
								)); ?>
								<? } else { ?>
								<? echo str_replace(" ", "", site::ConvertPrice($arItem['MIN_PRICE']['PRINT_DISCOUNT_VALUE'])); ?>
								<? } ?>
								<? echo ' '.site::GetCurrency(); ?>
								<? if ('Y' == $arParams['SHOW_OLD_PRICE'] && $arItem['MIN_PRICE']['DISCOUNT_VALUE'] < $arItem['MIN_PRICE']['VALUE']) { ?>
								<span><? echo str_replace(" ", "", site::ConvertPrice($arItem['MIN_PRICE']['PRINT_VALUE'])); echo ' '.site::GetCurrency(); ?></span>
								<? } ?>
								<? } ?>
							</div>
						</div>
						<? 
							$showSubscribeBtn = false;
							$compareBtnMessage = ($arParams['MESS_BTN_COMPARE'] != '' ? $arParams['MESS_BTN_COMPARE'] : GetMessage('CT_BCS_TPL_MESS_BTN_COMPARE'));
						?>
						<? if (!isset($arItem['OFFERS']) || empty($arItem['OFFERS'])) { ?>
						<div class="bx_catalog_item_controls">
							<? if ($arItem['CAN_BUY']) { ?>
							<? if ('Y' == $arParams['USE_PRODUCT_QUANTITY']) { ?>
							<div class="bx_catalog_item_controls_blockone">
								<div style="display: inline-block;position: relative;">
									<a id="<? echo $arItemIDs['QUANTITY_DOWN']; ?>" href="javascript:void(0)" class="bx_bt_button_type_2 bx_small" rel="nofollow">-</a>
									<input type="text" class="bx_col_input" id="<? echo $arItemIDs['QUANTITY']; ?>" name="<? echo $arParams["PRODUCT_QUANTITY_VARIABLE"]; ?>" value="<? echo $arItem['CATALOG_MEASURE_RATIO']; ?>">
									<a id="<? echo $arItemIDs['QUANTITY_UP']; ?>" href="javascript:void(0)" class="bx_bt_button_type_2 bx_small" rel="nofollow">+</a>
									<span id="<? echo $arItemIDs['QUANTITY_MEASURE']; ?>"><? echo $arItem['CATALOG_MEASURE_NAME']; ?></span>
								</div>
							</div>
							<? } ?>
							<div id="<? echo $arItemIDs['BASKET_ACTIONS']; ?>" class="bx_catalog_item_controls_blocktwo">
								<a id="<? echo $arItemIDs['BUY_LINK']; ?>" class="bx_bt_button bx_medium" href="javascript:void(0)" rel="nofollow">
								<? if ($arParams['ADD_TO_BASKET_ACTION'] == 'BUY')
									{
										echo ('' != $arParams['MESS_BTN_BUY'] ? $arParams['MESS_BTN_BUY'] : GetMessage('CT_BCS_TPL_MESS_BTN_BUY'));
									} else {
										echo ('' != $arParams['MESS_BTN_ADD_TO_BASKET'] ? $arParams['MESS_BTN_ADD_TO_BASKET'] : GetMessage('CT_BCS_TPL_MESS_BTN_ADD_TO_BASKET'));
									} ?>
								</a>
							</div>
							<? if ($arParams['DISPLAY_COMPARE']) { ?>
							<div class="bx_catalog_item_controls_blocktwo">
								<a id="<? echo $arItemIDs['COMPARE_LINK']; ?>" class="bx_bt_button_type_2 bx_medium" href="javascript:void(0)"><? echo $compareBtnMessage; ?></a>
							</div>
							<? } ?>
							<? } else { ?>
							<div id="<? echo $arItemIDs['NOT_AVAILABLE_MESS']; ?>" class="bx_catalog_item_controls_blockone">
								<span class="bx_notavailable"><?
									echo ('' != $arParams['MESS_NOT_AVAILABLE'] ? $arParams['MESS_NOT_AVAILABLE'] : GetMessage('CT_BCS_TPL_MESS_PRODUCT_NOT_AVAILABLE'));
								?></span>
							</div>
							<? if ($arParams['DISPLAY_COMPARE'] || $showSubscribeBtn) { ?>
							<div class="bx_catalog_item_controls_blocktwo">
								<? if ($arParams['DISPLAY_COMPARE']) { ?>
								<a id="<? echo $arItemIDs['COMPARE_LINK']; ?>" class="bx_bt_button_type_2 bx_medium" href="javascript:void(0)"><? echo $compareBtnMessage; ?></a>
								<? } ?>
								<? if ($showSubscribeBtn) { ?>
								<a id="<? echo $arItemIDs['SUBSCRIBE_LINK']; ?>" class="bx_bt_button_type_2 bx_medium" href="javascript:void(0)"><?
									echo ('' != $arParams['MESS_BTN_SUBSCRIBE'] ? $arParams['MESS_BTN_SUBSCRIBE'] : GetMessage('CT_BCS_TPL_MESS_BTN_SUBSCRIBE'));
									?></a>
								<? } ?>
							</div>
							<? } ?>
							<? } ?>
							<div style="clear: both;"></div>
						</div>
						<? if (isset($arItem['DISPLAY_PROPERTIES']) && !empty($arItem['DISPLAY_PROPERTIES'])) { ?>
						<div class="bx_catalog_item_articul">
							<? foreach ($arItem['DISPLAY_PROPERTIES'] as $arOneProp) { ?>
							<br><strong><? echo $arOneProp['NAME']; ?></strong> 
							<? echo (is_array($arOneProp['DISPLAY_VALUE']) ? implode('<br>', $arOneProp['DISPLAY_VALUE']) : $arOneProp['DISPLAY_VALUE']); ?>
							<? } ?>
						</div>
						<? } $emptyProductProperties = empty($arItem['PRODUCT_PROPERTIES']); ?>
						<? if ('Y' == $arParams['ADD_PROPERTIES_TO_BASKET'] && !$emptyProductProperties) { ?>
						<div id="<? echo $arItemIDs['BASKET_PROP_DIV']; ?>" style="display: none;">
							<? if (!empty($arItem['PRODUCT_PROPERTIES_FILL'])) { ?>
							<? foreach ($arItem['PRODUCT_PROPERTIES_FILL'] as $propID => $propInfo) { ?>
							<input type="hidden" name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]" value="<? echo htmlspecialcharsbx($propInfo['ID']); ?>">
							<? if (isset($arItem['PRODUCT_PROPERTIES'][$propID])) unset($arItem['PRODUCT_PROPERTIES'][$propID]); ?>
							<? } ?>
							<? } $emptyProductProperties = empty($arItem['PRODUCT_PROPERTIES']); ?>
							<?if (!$emptyProductProperties) { ?>
							<table>
								<? foreach ($arItem['PRODUCT_PROPERTIES'] as $propID => $propInfo) { ?>
								<tr><td><? echo $arItem['PROPERTIES'][$propID]['NAME']; ?></td>
									<td>
										<? if('L' == $arItem['PROPERTIES'][$propID]['PROPERTY_TYPE'] && 'C' == $arItem['PROPERTIES'][$propID]['LIST_TYPE']) { ?>
										<? foreach($propInfo['VALUES'] as $valueID => $value) { ?>
										<label>
											<input type="radio" name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]" value="<? echo $valueID; ?>" <? echo ($valueID == $propInfo['SELECTED'] ? '"checked"' : ''); ?>><? echo $value; ?>
										</label>
										<br>
										<? } ?>
										<? } else { ?>
										<select name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]">
											<? foreach($propInfo['VALUES'] as $valueID => $value) { ?>
											<option value="<? echo $valueID; ?>" <? echo ($valueID == $propInfo['SELECTED'] ? 'selected' : ''); ?>><? echo $value; ?></option>
											<? } ?>
										</select>
										<? } ?>
									</td>
								</tr>
								<? } ?>
							</table>
							<? } ?>
						</div>
						<? } ?>
						<? 
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
									'PICT_ID' => ('Y' == $arItem['SECOND_PICT'] ? $arItemIDs['SECOND_PICT'] : $arItemIDs['PICT']),
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
						?>
						<script type="text/javascript">
							var <? echo $strObName; ?> = new JCCatalogSection(<? echo CUtil::PhpToJSObject($arJSParams, false, true); ?>);
						</script>
						<? } else { ?>
						<? if ('Y' == $arParams['PRODUCT_DISPLAY_MODE']) { $canBuy = $arItem['JS_OFFERS'][$arItem['OFFERS_SELECTED']]['CAN_BUY']; ?>
						<div class="bx_catalog_item_controls no_touch">
							<? if ('Y' == $arParams['USE_PRODUCT_QUANTITY']) { ?>
							<div class="bx_catalog_item_controls_blockone">
								<a id="<? echo $arItemIDs['QUANTITY_DOWN']; ?>" href="javascript:void(0)" class="bx_bt_button_type_2 bx_small" rel="nofollow">-</a>
								<input type="text" class="bx_col_input" id="<? echo $arItemIDs['QUANTITY']; ?>" name="<? echo $arParams["PRODUCT_QUANTITY_VARIABLE"]; ?>" value="<? echo $arItem['CATALOG_MEASURE_RATIO']; ?>">
								<a id="<? echo $arItemIDs['QUANTITY_UP']; ?>" href="javascript:void(0)" class="bx_bt_button_type_2 bx_small" rel="nofollow">+</a>
								<span id="<? echo $arItemIDs['QUANTITY_MEASURE']; ?>"></span>
							</div>
							<? } ?>
							<div id="<? echo $arItemIDs['NOT_AVAILABLE_MESS']; ?>" class="bx_catalog_item_controls_blockone" style="display: <? echo ($canBuy ? 'none' : ''); ?>;">
								<span class="bx_notavailable"><?
									echo ('' != $arParams['MESS_NOT_AVAILABLE'] ? $arParams['MESS_NOT_AVAILABLE'] : GetMessage('CT_BCS_TPL_MESS_PRODUCT_NOT_AVAILABLE'));
								?></span>
							</div>
							<div id="<? echo $arItemIDs['BASKET_ACTIONS']; ?>" class="bx_catalog_item_controls_blocktwo" style="display: <? echo ($canBuy ? '' : 'none'); ?>;">
								<a id="<? echo $arItemIDs['BUY_LINK']; ?>" class="bx_bt_button bx_medium" href="javascript:void(0)" rel="nofollow"><?
								if ($arParams['ADD_TO_BASKET_ACTION'] == 'BUY')
								{
									echo ('' != $arParams['MESS_BTN_BUY'] ? $arParams['MESS_BTN_BUY'] : GetMessage('CT_BCS_TPL_MESS_BTN_BUY'));
								}
								else
								{
									echo ('' != $arParams['MESS_BTN_ADD_TO_BASKET'] ? $arParams['MESS_BTN_ADD_TO_BASKET'] : GetMessage('CT_BCS_TPL_MESS_BTN_ADD_TO_BASKET'));
								}
								?></a>
							</div>
							<? if ($arParams['DISPLAY_COMPARE']) { ?>
							<div class="bx_catalog_item_controls_blocktwo">
								<a id="<? echo $arItemIDs['COMPARE_LINK']; ?>" class="bx_bt_button_type_2 bx_medium" href="javascript:void(0)"><? echo $compareBtnMessage; ?></a>
							</div>
							<? } ?>
							<div style="clear: both;"></div>
						</div>
						<? unset($canBuy); } else { ?>
						<div class="bx_catalog_item_controls no_touch">
							<a class="bx_bt_button_type_2 bx_medium" href="<? echo $arItem['DETAIL_PAGE_URL']; ?>"><?
							echo ('' != $arParams['MESS_BTN_DETAIL'] ? $arParams['MESS_BTN_DETAIL'] : GetMessage('CT_BCS_TPL_MESS_BTN_DETAIL'));
							?></a>
						</div>
						<? } ?>
						<div class="bx_catalog_item_controls touch">
							<a class="bx_bt_button_type_2 bx_medium" href="<? echo $arItem['DETAIL_PAGE_URL']; ?>"><?
								echo ('' != $arParams['MESS_BTN_DETAIL'] ? $arParams['MESS_BTN_DETAIL'] : GetMessage('CT_BCS_TPL_MESS_BTN_DETAIL'));
							?></a>
						</div>
						<?
							$boolShowOfferProps = ('Y' == $arParams['PRODUCT_DISPLAY_MODE'] && $arItem['OFFERS_PROPS_DISPLAY']);
							$boolShowProductProps = (isset($arItem['DISPLAY_PROPERTIES']) && !empty($arItem['DISPLAY_PROPERTIES']));
							if ($boolShowProductProps || $boolShowOfferProps) { ?>
						<div class="bx_catalog_item_articul">
							<? if ($boolShowProductProps) { ?>
							<? foreach ($arItem['DISPLAY_PROPERTIES'] as $arOneProp) { ?>
							<br><strong><? echo $arOneProp['NAME']; ?></strong>
							<?
								echo (
									is_array($arOneProp['DISPLAY_VALUE'])
									? implode(' / ', $arOneProp['DISPLAY_VALUE'])
									: $arOneProp['DISPLAY_VALUE']
								);
							?>
							<? } ?>
							<? } ?>
							<? if ($boolShowOfferProps) { ?>
							<span id="<? echo $arItemIDs['DISPLAY_PROP_DIV']; ?>" style="display: none;"></span>
							<? } ?>
						</div>
						<? } ?>
						<?if ('Y' == $arParams['PRODUCT_DISPLAY_MODE']) { ?>
						<?if (!empty($arItem['OFFERS_PROP'])) { $arSkuProps = array(); ?>
						<div class="bx_catalog_item_scu" id="<? echo $arItemIDs['PROP_DIV']; ?>">
							<?
								foreach ($arSkuTemplate as $code => $strTemplate)
								{
									if (!isset($arItem['OFFERS_PROP'][$code]))
										continue;
									echo '<div>', str_replace('#ITEM#_prop_', $arItemIDs['PROP'], $strTemplate), '</div>';
								}
								foreach ($arResult['SKU_PROPS'] as $arOneProp)
								{
									if (!isset($arItem['OFFERS_PROP'][$arOneProp['CODE']]))
										continue;
									$arSkuProps[] = array(
										'ID' => $arOneProp['ID'],
										'SHOW_MODE' => $arOneProp['SHOW_MODE'],
										'VALUES_COUNT' => $arOneProp['VALUES_COUNT']
									);
								}
								foreach ($arItem['JS_OFFERS'] as &$arOneJs)
								{
									if (0 < $arOneJs['PRICE']['DISCOUNT_DIFF_PERCENT'])
									{
										$arOneJs['PRICE']['DISCOUNT_DIFF_PERCENT'] = '-'.$arOneJs['PRICE']['DISCOUNT_DIFF_PERCENT'].'%';
										$arOneJs['BASIS_PRICE']['DISCOUNT_DIFF_PERCENT'] = '-'.$arOneJs['BASIS_PRICE']['DISCOUNT_DIFF_PERCENT'].'%';
									}
								} unset($arOneJs); ?>
						</div>
						<? 
							if ($arItem['OFFERS_PROPS_DISPLAY']) {
								foreach ($arItem['JS_OFFERS'] as $keyOffer => $arJSOffer) { $strProps = '';
									if (!empty($arJSOffer['DISPLAY_PROPERTIES'])) {
										foreach ($arJSOffer['DISPLAY_PROPERTIES'] as $arOneProp) {
											$strProps .= '<br>'.$arOneProp['NAME'].' <strong>'.(
												is_array($arOneProp['VALUE'])
												? implode(' / ', $arOneProp['VALUE'])
												: $arOneProp['VALUE']
											).'</strong>';
										}
									}
									$arItem['JS_OFFERS'][$keyOffer]['DISPLAY_PROPERTIES'] = $strProps;
								}
							}
							$arJSParams = array(
								'PRODUCT_TYPE' => $arItem['CATALOG_TYPE'],
								'SHOW_QUANTITY' => ($arParams['USE_PRODUCT_QUANTITY'] == 'Y'),
								'SHOW_ADD_BASKET_BTN' => false,
								'SHOW_BUY_BTN' => true,
								'SHOW_ABSENT' => true,
								'SHOW_SKU_PROPS' => $arItem['OFFERS_PROPS_DISPLAY'],
								'SECOND_PICT' => $arItem['SECOND_PICT'],
								'SHOW_OLD_PRICE' => ('Y' == $arParams['SHOW_OLD_PRICE']),
								'SHOW_DISCOUNT_PERCENT' => ('Y' == $arParams['SHOW_DISCOUNT_PERCENT']),
								'ADD_TO_BASKET_ACTION' => $arParams['ADD_TO_BASKET_ACTION'],
								'SHOW_CLOSE_POPUP' => ($arParams['SHOW_CLOSE_POPUP'] == 'Y'),
								'DISPLAY_COMPARE' => $arParams['DISPLAY_COMPARE'],
								'DEFAULT_PICTURE' => array(
									'PICTURE' => $arItem['PRODUCT_PREVIEW'],
									'PICTURE_SECOND' => $arItem['PRODUCT_PREVIEW_SECOND']
								),
								'VISUAL' => array(
									'ID' => $arItemIDs['ID'],
									'PICT_ID' => $arItemIDs['PICT'],
									'SECOND_PICT_ID' => $arItemIDs['SECOND_PICT'],
									'QUANTITY_ID' => $arItemIDs['QUANTITY'],
									'QUANTITY_UP_ID' => $arItemIDs['QUANTITY_UP'],
									'QUANTITY_DOWN_ID' => $arItemIDs['QUANTITY_DOWN'],
									'QUANTITY_MEASURE' => $arItemIDs['QUANTITY_MEASURE'],
									'PRICE_ID' => $arItemIDs['PRICE'],
									'TREE_ID' => $arItemIDs['PROP_DIV'],
									'TREE_ITEM_ID' => $arItemIDs['PROP'],
									'BUY_ID' => $arItemIDs['BUY_LINK'],
									'ADD_BASKET_ID' => $arItemIDs['ADD_BASKET_ID'],
									'DSC_PERC' => $arItemIDs['DSC_PERC'],
									'SECOND_DSC_PERC' => $arItemIDs['SECOND_DSC_PERC'],
									'DISPLAY_PROP_DIV' => $arItemIDs['DISPLAY_PROP_DIV'],
									'BASKET_ACTIONS_ID' => $arItemIDs['BASKET_ACTIONS'],
									'NOT_AVAILABLE_MESS' => $arItemIDs['NOT_AVAILABLE_MESS'],
									'COMPARE_LINK_ID' => $arItemIDs['COMPARE_LINK']
								),
								'BASKET' => array(
									'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
									'PROPS' => $arParams['PRODUCT_PROPS_VARIABLE'],
									'SKU_PROPS' => $arItem['OFFERS_PROP_CODES'],
									'ADD_URL_TEMPLATE' => $arResult['~ADD_URL_TEMPLATE'],
									'BUY_URL_TEMPLATE' => $arResult['~BUY_URL_TEMPLATE']
								),
								'PRODUCT' => array(
									'ID' => $arItem['ID'],
									'NAME' => $productTitle
								),
								'OFFERS' => $arItem['JS_OFFERS'],
								'OFFER_SELECTED' => $arItem['OFFERS_SELECTED'],
								'TREE_PROPS' => $arSkuProps,
								'LAST_ELEMENT' => $arItem['LAST_ELEMENT']
							);
							if ($arParams['DISPLAY_COMPARE']) $arJSParams['COMPARE'] = array(
								'COMPARE_URL_TEMPLATE' => $arResult['~COMPARE_URL_TEMPLATE'],
								'COMPARE_PATH' => $arParams['COMPARE_PATH']
							);
						?>
						<script type="text/javascript">
						var <? echo $strObName; ?> = new JCCatalogSection(<? echo CUtil::PhpToJSObject($arJSParams, false, true); ?>);
						</script>
						<? } ?>
						<? } ?>
						<? } ?>
					</div>
				</div>
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
			<? if ($arParams["DISPLAY_BOTTOM_PAGER"]) echo $arResult["NAV_STRING"]; ?>
			<? } ?>
<script>
	$(function() {
		var sort = '<? if(isset($sort_section_list)) { echo strtolower($sort_section_list); } else {echo "undefined";} ?>';
		var order = '<? if(isset($order_section_list)) { echo strtolower($order_section_list); } else {echo "undefined";} ?>';
		if(order == 'desc') {
			$('.sort_selector_span').addClass('desc');
		}
		$('.sort_'+sort).addClass('selected');
		if(order == 'desc') {
			$('.sort_'+sort).addClass('desc');
		}
		$(document).on('click', '.sort_selector_span', function() {
			$(this).toggleClass('selected');
			$('.sort_list_section').slideToggle(500);
		});
		$(function() {
			$('.fancybox').fancybox();
		});
	});
</script>