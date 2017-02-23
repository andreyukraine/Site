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

include_once($_SERVER["DOCUMENT_ROOT"].'/include/cart-check-ebook.php');
$checkcart = new makano_cart_check();

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

	$strElementEdit = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT");
	$strElementDelete = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE");
	$arElementDeleteParams = array("CONFIRM" => GetMessage('CT_BCS_TPL_ELEMENT_DELETE_CONFIRM'));
?>

<?if ($arParams["DISPLAY_TOP_PAGER"]):?>
	<div class="paginations">
		<? echo $arResult["NAV_STRING"]; ?>
	</div>
<?endif;?>

<!-- Items List -->
<div class="col-xs-9 novelty_wrap mWidth">

	<?

	foreach ($arResult['ITEMS'] as $key => $arItem) {

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

		$section = CIBlockElement::GetList(array(), array('ID' => $arItem['ID']), false, false, array('IBLOCK_SECTION_ID'))->Fetch();
		$section = $section["IBLOCK_SECTION_ID"];
		$arSections = CIBlockSection::GetNavChain(false, $section)->Fetch();
		$is_e_book = in_array('101', $arSections) ? true : false;

		$hasOldPrice = (
			!empty($arItem['PROPERTIES']['PRICE_OLD']['VALUE']) &&
			$arItem['PROPERTIES']['PRICE_OLD']['VALUE'] != '0.00' &&
			$arItem['PROPERTIES']['PRICE_OLD']['VALUE'] != $arItem['MIN_PRICE']['PRINT_VALUE']
		) ? true : false;

	?>

	

		<!-- Item -->
		<div class="item_box" id="<?=$arItemIDs['ID'];?>">

			<!-- Item Image -->
			<div class="col-xs-3 img_box" id="<?=$arItemIDs['PICT'];?>">

				<?if($is_e_book):?>
				<!-- eBook Item -->
					<div class='ebook_hover new_prod_hover'>eBook</div>
				<!-- End: eBook Item -->
				<?endif;?>

				<?if(is_array($arItem['DETAIL_PICTURE']) && isset($arItem['DETAIL_PICTURE']['SRC'])): ?>
					<a href="<? echo $arItem['DETAIL_PICTURE']['SRC']; ?>" class="fancybox">
						<img src="<? echo $arItem['PREVIEW_PICTURE']['SRC']; ?>" class="<?=$is_e_book ? 'ebookimg' : ''?>" alt="" />
					</a>
				<? else: ?>
					<a href="<? echo $arItem['PREVIEW_PICTURE']['SRC']; ?>" class="fancybox">
						<img src="<? echo $arItem['PREVIEW_PICTURE']['SRC']; ?>" class="<?=$is_e_book ? 'ebookimg' : ''?>" alt="" />
					</a>
				<?endif;?>

			</div>
			<!-- End: Item Image -->

			<!-- Item Details -->
			<div class="col-xs-6 item_desc">

				<!-- Item Title -->
				<div class="bx_catalog_item_title">
					<a href="<? echo $arItem['DETAIL_PAGE_URL']; ?>" title="<? echo $productTitle; ?>">
						<? echo $productTitle; ?>
					</a>
				</div>
				<!-- End: Item Title -->

				<!-- Item Author -->
				<?if(!empty($arItem['PROPERTIES']['AUTHOR_XMLID']['VALUE_ELEMENTS'])): ?>
				<div class="autor">
					<? foreach ($arItem['PROPERTIES']['AUTHOR_XMLID']['VALUE_ELEMENTS'] as $author): ?>
						<a href="<?php echo $author['DETAIL_PAGE_URL']; ?>"><?php echo $author['NAME']; ?></a>
					<? endforeach; ?>
				</div>
				<?endif;?>
				<!-- End: Item Author -->

				<!-- Item Description -->
				<div class="desc_text"><?=makano_limit_string($arItem['DETAIL_TEXT'], 40);?> ...</div>
				<!-- End: Item Description -->

				<!-- Item Details Link -->
				<div class="more"><a href="<?=$arItem['DETAIL_PAGE_URL'];?>" title="<?=$productTitle; ?>">Подробнее...</a></div>
				<!-- End: Item Details Link -->

			</div>
			<!-- End: Item Details -->

			<!-- Item Action -->
			<div class="col-xs-3 price_block no-padding">

				<!-- Item Actions -->
				<div class="bx_catalog_item_controls pull-right text-right">


					<? if ($arItem['CAN_BUY'] && $catalog_vars['QUANTITY'] != 0): ?>

						<!-- Item Price -->
						<div id="<?=$arItemIDs['PRICE']?>" class="bx_price">

							<? if (!empty($arItem['MIN_PRICE'])): ?>

								<? if ('Y' == $arParams['SHOW_OLD_PRICE'] && $hasOldPrice) { ?>
									<span class="price-old">
										<del><?=CCurrencyLang::CurrencyFormat(str_replace(" ", "", site::ConvertPrice($arItem['PROPERTIES']['PRICE_OLD']['VALUE'])), site::getCurrency(), true) ?></del>
									</span>
								<? } ?>

								<? if ('N' == $arParams['PRODUCT_DISPLAY_MODE'] && isset($arItem['OFFERS']) && !empty($arItem['OFFERS'])) { ?>
									<span class="price"><? echo GetMessage('CT_BCS_TPL_MESS_PRICE_SIMPLE_MODE', array(
											'#PRICE#' => str_raplace(" ", "", site::ConvertPrice($arItem['MIN_PRICE']['PRINT_DISCOUNT_VALUE'])),
											'#MEASURE#' => GetMessage(
												'CT_BCS_TPL_MESS_MEASURE_SIMPLE_MODE',
												array(
													'#VALUE#' => $arItem['MIN_PRICE']['CATALOG_MEASURE_RATIO'],
													'#UNIT#' => $arItem['MIN_PRICE']['CATALOG_MEASURE_NAME']
												)
											)
										)
									); ?></span>
								<? } else { ?>
									<span class="price"><? echo CCurrencyLang::CurrencyFormat(str_replace(" ", "", site::ConvertPrice($arItem['MIN_PRICE']['PRINT_DISCOUNT_VALUE'])), site::getCurrency(), true); ?></span>
								<? } ?>

							<? endif; //!empty($arItem['MIN_PRICE'] ?>

						</div>
						<!-- End: Item Price -->
						<!-- Item Buttons -->
						<div id="<? echo $arItemIDs['BASKET_ACTIONS']; ?>" class="bx_catalog_item_controls_blocktwo">

							<? if($catalog_vars['QUANTITY'] != 0) { ?>

								<? if($checkcart->has_book && preg_match('~^/catalog/ebooks/~', $arItem['DETAIL_PAGE_URL'])) { ?>
									<button class="bx_bt_button bx_medium" onclick="alert('В корзине одновременно не может находится электронный и обычный товар. Пожалуйста, завершите оформление предыдущего заказа.');"></button>
								<? } else if($checkcart->has_ebook && !preg_match('~^/catalog/ebooks/~', $arItem['DETAIL_PAGE_URL'])) { ?>
									<button class="bx_bt_button bx_medium" onclick="alert('В корзине одновременно не может находится электронный и обычный товар. Пожалуйста, завершите оформление предыдущего заказа.');"></button>
								<? } else { ?>
									<a id="<? echo $arItemIDs['BUY_LINK']; ?>" class="bx_bt_button bx_medium" href="javascript:void(0)" rel="nofollow">
								</a>
								<? } ?>

							<? } ?>


						</div>
						<!-- End Item Buttons -->

					<? else: // if ($arItem['CAN_BUY']) ?>

						<!-- Message Not Available -->
						<div id="<?=$arItemIDs['NOT_AVAILABLE_MESS']; ?>" class="bx_catalog_item_controls_blockone">
							<p class="catalog_item_quantity_text quantity_null">
								<?= $arParams['MESS_NOT_AVAILABLE'] != '' ? $arParams['MESS_NOT_AVAILABLE'] : GetMessage('CT_BCS_TPL_MESS_PRODUCT_NOT_AVAILABLE'); ?>
							</p>
						</div>
						<!-- End: Message Not Available -->

						<!-- Subscribe Form -->
						<? if ($arParams['PRODUCT_SUBSCRIPTION'] == 'Y'): ?>
							<div class="item-subscribe">
								<button class="bx_bt_order" data-togglenext></button>
								<div class="form-order-product">
									<?$APPLICATION->IncludeComponent(
										"bitrix:form.result.new",
										"order_absent",
										array(
											"AJAX_MODE" => "Y",
											"SEF_MODE" => "Y",
											"WEB_FORM_ID" => "1",
											"LIST_URL" => "",
											"EDIT_URL" => "",
											//"SUCCESS_URL" => "/bookinist/",
											"CHAIN_ITEM_TEXT" => "",
											"CHAIN_ITEM_LINK" => "",
											"IGNORE_CUSTOM_TEMPLATE" => "Y",
											"USE_EXTENDED_ERRORS" => "Y",
											"CACHE_TYPE" => "A",
											"CACHE_TIME" => "3600",
											"SEF_FOLDER" => "/",
											"custom_params" => array(
												"product_id" => $arItem["ID"],
												"product_name" => $arItem["NAME"],
												"product_url" => "http://".$_SERVER["HTTP_HOST"].$arItem["DETAIL_PAGE_URL"],
												"product_articul" => $arItem["XML_ID"],
												"customer_ip" => "".$_SERVER["REMOTE_ADDR"]."",
											),
											"COMPONENT_TEMPLATE" => "order_absent"
										),
										false
									);?>
								</div>
							</div>
						<? endif; ?>
						<!-- End: Subscribe Form -->

					<? endif; //if ($arItem['CAN_BUY']) ?>

					<a href="<?=$arItem['DETAIL_PAGE_URL']?>"><div class="detail_button sprite_detail_button"></div></a>

					<!-- Compare Button -->
					<?if ($arParams['DISPLAY_COMPARE']):?>
						<div class="bx_catalog_item_controls_blocktwo">
							<a id="<? echo $arItemIDs['COMPARE_LINK']; ?>" class="bx_bt_button_type_2 bx_medium" href="javascript:void(0)"><?=$compareBtnMessage?></a>
						</div>
					<? endif; ?>
					<!-- Compare Button -->

					<div style="clear: both;"></div>
				</div>
				<!-- End: Item Actions -->

				<!-- Item Special Offers -->
				<?if($arItem['PROPERTIES']['SPECIALOFFER']['VALUE'] == 1):?>
					<img width="50" alt="Лучшая цена гарантирована" src="http://knigionline.com/images/bestprice.png" height="50">
				<?endif;?>
				<!-- End: Item Special Offers -->

			</div>
			<!-- End: Item Action -->

			<div class="clearfix"></div>
		</div>
		<!-- End: Item -->

		<!-- BitrixJS -->
		<script type="text/javascript">
			 var <?= $strObName; ?> = new JCCatalogSection(<?= CUtil::PhpToJSObject($arJSParams, false, true); ?>);
		</script>
		<!-- End: BitrixJS -->

	<? } //endforeach $arResult['ITEMS'] ?>

	<div style="clear: both;"></div>
</div>
<!-- End: Items List -->

<?if ($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<div class="paginations">
		<? echo $arResult["NAV_STRING"]; ?>
	</div>
<?endif;?>

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