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
if(!function_exists('str_limit')) {
	function str_limit($str='', $words=0, $sym=0){
		$str = preg_replace("~(<.*?>|\r\n|\s{2,})~iu", ' ', $str);
		if($words) $str = implode(" ", array_slice(explode(" ", $str), 0, $words));
		if($sym) $str = preg_replace('~^(.{1,'.$sym.'}).*~us', '$1', $str);
		return $str;
	}
}
$this->setFrameMode(true);

		$this->AddEditAction($arResult['ID'], $arResult['EDIT_LINK'], $strElementEdit);
		$this->AddDeleteAction($arResult['ID'], $arResult['DELETE_LINK'], $strElementDelete, $arElementDeleteParams);
		$strMainID = $this->GetEditAreaId($arResult['ID']);
		$section = CIBlockElement::GetList(array(), array('ID' => $arResult['ID']), false, false, array('IBLOCK_SECTION_ID'))->Fetch();
		$section = $section["IBLOCK_SECTION_ID"];
		$arSections = CIBlockSection::GetNavChain(false, $section)->Fetch();
		$arItemIDs = array(
			'ID' => $strMainID.'_buy_link',
			'PICT' => $strMainID.'_pict',
			'SECOND_PICT' => $strMainID.'_secondpict',
			'MAIN_PROPS' => $strMainID.'_main_props',

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
			'BASKET_PROP_DIV' => $strMainID.'_basket_prop'
		);
		$strObName = 'ob'.preg_replace("/[^a-zA-Z0-9_]/", "x", $strMainID); 
		$productTitle = (
			isset($arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'])&& $arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'] != ''
			? $arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']
			: $arResult['NAME']
		);
		$imgTitle = (
			isset($arResult['IPROPERTY_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_TITLE']) && $arResult['IPROPERTY_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_TITLE'] != ''
			? $arResult['IPROPERTY_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_TITLE']
			: $arResult['NAME']
		);
	?>
<div class="announce-product-item">
	<div class="img">
			<? 	
				if(in_array('101', $arSections)) {
					echo "<div class='ebook_hover'>eBook</div>";
				}
			?>
		<a href="<? echo $arResult['DETAIL_PAGE_URL']; ?>" id="<? echo $arItemIDs['PICT']; ?>" ><img src="<?php echo $arResult['PREVIEW_PICTURE']['SRC'] ?>" <? echo (in_array('101', $arSections))?'class="ebookimg"':''; ?> alt=""></a>
	</div>
	<div class="bx_catalog_item_title"><a href="<? echo $arResult['DETAIL_PAGE_URL']; ?>" title="<? echo $productTitle; ?>"><? echo $productTitle; ?></a></div>
	<? if (isset($arResult['DISPLAY_PROPERTIES']) && !empty($arResult['DISPLAY_PROPERTIES'])) { ?>
		<div class="bx_catalog_item_articul">
		<? foreach ($arResult['DISPLAY_PROPERTIES'] as $arOneProp) { ?>
			<?php if(!preg_match('~AUTOR~i', $arOneProp['CODE'])) { ?>
			<br><strong><? echo $arOneProp['NAME']; ?></strong>
			<?
				echo (
					is_array($arOneProp['DISPLAY_VALUE'])
					? implode('<br>', $arOneProp['DISPLAY_VALUE'])
					: $arOneProp['DISPLAY_VALUE']
				);
			?>
			<?php } else { ?>
			<i><?php echo $arOneProp['DISPLAY_VALUE']; ?></i>
			<?php } ?>
		<?php } ?>
		</div>
	<? } ?>
	<div class="bx_catalog_item_price"><div id="<? echo $arItemIDs['PRICE']; ?>" class="bx_price"><?
	if(!empty($arResult['PROPERTIES']['PRICE_OLD']['VALUE'])) { ?> <s class="price-old"><?php echo CCurrencyLang::CurrencyFormat(site::ConvertPrice($arResult['PROPERTIES']['PRICE_OLD']['VALUE']), site::getCurrency(), true); ?></s> <?}
	if (!empty($arResult['MIN_PRICE']))
	{
		if ('N' == $arParams['PRODUCT_DISPLAY_MODE'] && isset($arResult['OFFERS']) && !empty($arResult['OFFERS']))
		{
			echo GetMessage(
				'CT_BCS_TPL_MESS_PRICE_SIMPLE_MODE',
				array(
					'#PRICE#' => CCurrencyLang::CurrencyFormat(site::ConvertPrice($arResult['MIN_PRICE']['PRINT_DISCOUNT_VALUE']), site::getCurrency(), true),
					'#MEASURE#' => GetMessage(
						'CT_BCS_TPL_MESS_MEASURE_SIMPLE_MODE',
						array(
							'#VALUE#' => $arResult['MIN_PRICE']['CATALOG_MEASURE_RATIO'],
							'#UNIT#' => $arResult['MIN_PRICE']['CATALOG_MEASURE_NAME']
						)
					)
				)
			);
		} else {
			echo CCurrencyLang::CurrencyFormat(site::ConvertPrice($arResult['MIN_PRICE']['PRINT_DISCOUNT_VALUE']), site::getCurrency(), true);
		}
		if ('Y' == $arParams['SHOW_OLD_PRICE'] && $arResult['MIN_PRICE']['DISCOUNT_VALUE'] < $arResult['MIN_PRICE']['VALUE'])
		{
			?> <span><? echo CCurrencyLang::CurrencyFormat(site::ConvertPrice($arResult['MIN_PRICE']['PRINT_VALUE']), site::GetCurrency(), true); ?></span><?
		}
	}
	?></div> </div>
	<?
		$showSubscribeBtn = false;
		$compareBtnMessage = ($arParams['MESS_BTN_COMPARE'] != '' ? $arParams['MESS_BTN_COMPARE'] : GetMessage('CT_BCS_TPL_MESS_BTN_COMPARE'));
		if (!isset($arResult['OFFERS']) || empty($arResult['OFFERS'])) { ?>
		<div class="bx_catalog_item_controls">
		<? if ($arResult['CAN_BUY']) {
			if ('Y' == $arParams['USE_PRODUCT_QUANTITY']) { ?>
		<div class="bx_catalog_item_controls_blockone"><div style="display: inline-block;position: relative;">
			<a id="<? echo $arItemIDs['QUANTITY_DOWN']; ?>" href="javascript:void(0)" class="bx_bt_button_type_2 bx_small" rel="nofollow">-</a>
			<input type="text" class="bx_col_input" id="<? echo $arItemIDs['QUANTITY']; ?>" name="<? echo $arParams["PRODUCT_QUANTITY_VARIABLE"]; ?>" value="<? echo $arResult['CATALOG_MEASURE_RATIO']; ?>">
			<a id="<? echo $arItemIDs['QUANTITY_UP']; ?>" href="javascript:void(0)" class="bx_bt_button_type_2 bx_small" rel="nofollow">+</a>
			<span id="<? echo $arItemIDs['QUANTITY_MEASURE']; ?>"><? echo $arResult['CATALOG_MEASURE_NAME']; ?></span>
		</div></div>
			<? } ?>
		<div id="<? echo $arItemIDs['BASKET_ACTIONS']; ?>" class="bx_catalog_item_controls_blocktwo">
			<a id="<? echo $arItemIDs['BUY_LINK']; ?>" class="bx_bt_button bx_medium" href="javascript:void(0)" rel="nofollow"><?
			/*if ($arParams['ADD_TO_BASKET_ACTION'] == 'BUY')
			{
				echo ('' != $arParams['MESS_BTN_BUY'] ? $arParams['MESS_BTN_BUY'] : GetMessage('CT_BCS_TPL_MESS_BTN_BUY'));
			}
			else
			{
				echo ('' != $arParams['MESS_BTN_ADD_TO_BASKET'] ? $arParams['MESS_BTN_ADD_TO_BASKET'] : GetMessage('CT_BCS_TPL_MESS_BTN_ADD_TO_BASKET'));
}*/
			?></a>
		</div>
			<? if ($arParams['DISPLAY_COMPARE']) { ?>
			<div class="bx_catalog_item_controls_blocktwo">
				<a id="<? echo $arItemIDs['COMPARE_LINK']; ?>" class="bx_bt_button_type_2 bx_medium" href="javascript:void(0)"><? echo $compareBtnMessage; ?></a>
			</div>
			<? } ?>
		<? } else { ?>
			<div id="<? echo $arItemIDs['NOT_AVAILABLE_MESS']; ?>" class="bx_catalog_item_controls_blockone"><span class="bx_notavailable"><?
			echo ('' != $arParams['MESS_NOT_AVAILABLE'] ? $arParams['MESS_NOT_AVAILABLE'] : GetMessage('CT_BCS_TPL_MESS_PRODUCT_NOT_AVAILABLE'));
			?></span></div><?
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
		?>
			<div style="clear: both;"></div>
			<div class="fulltext">
				<?php echo str_limit($arResult['DETAIL_TEXT'], 30); ?> 
				<a href="<? echo $arResult['DETAIL_PAGE_URL']; ?>">подробнее</a>
			</div>
		</div>
	</div>
		<?php $emptyProductProperties = empty($arResult['PRODUCT_PROPERTIES']);
		if ('Y' == $arParams['ADD_PROPERTIES_TO_BASKET'] && !$emptyProductProperties) { ?>
		<div id="<? echo $arItemIDs['BASKET_PROP_DIV']; ?>" style="display: none;">
			<? if (!empty($arResult['PRODUCT_PROPERTIES_FILL'])) {
				foreach ($arResult['PRODUCT_PROPERTIES_FILL'] as $propID => $propInfo) { ?>
					<input type="hidden" name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]" value="<? echo htmlspecialcharsbx($propInfo['ID']); ?>">
				<? if (isset($arResult['PRODUCT_PROPERTIES'][$propID])) unset($arResult['PRODUCT_PROPERTIES'][$propID]);
				}
			}
			$emptyProductProperties = empty($arResult['PRODUCT_PROPERTIES']);
			if (!$emptyProductProperties)
			{ ?>
				<table>
					<? foreach ($arResult['PRODUCT_PROPERTIES'] as $propID => $propInfo) { ?>
						<tr><td><? echo $arResult['PROPERTIES'][$propID]['NAME']; ?></td>
							<td>
							<? if(
									'L' == $arResult['PROPERTIES'][$propID]['PROPERTY_TYPE']
									&& 'C' == $arResult['PROPERTIES'][$propID]['LIST_TYPE']
								)
								{
									foreach($propInfo['VALUES'] as $valueID => $value)
									{
										?><label><input type="radio" name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]" value="<? echo $valueID; ?>" <? echo ($valueID == $propInfo['SELECTED'] ? '"checked"' : ''); ?>><? echo $value; ?></label><br><?
									}
								}
								else
								{
									?><select name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]"><?
									foreach($propInfo['VALUES'] as $valueID => $value)
									{
										?><option value="<? echo $valueID; ?>" <? echo ($valueID == $propInfo['SELECTED'] ? 'selected' : ''); ?>><? echo $value; ?></option><?
									}
									?></select>
								<? } ?>
							</td></tr>
					<? } ?>
				</table>
			<? } ?>
		</div>
<?
		}
		$arJSParams = array(
			'PRODUCT_TYPE' => $arResult['CATALOG_TYPE'],
			'SHOW_QUANTITY' => ($arParams['USE_PRODUCT_QUANTITY'] == 'Y'),
			'SHOW_ADD_BASKET_BTN' => false,
			'SHOW_BUY_BTN' => true,
			'SHOW_ABSENT' => true,
			'ADD_TO_BASKET_ACTION' => 'ADD',
			'SHOW_CLOSE_POPUP' => ($arParams['SHOW_CLOSE_POPUP'] == 'Y'),
			'DISPLAY_COMPARE' => $arParams['DISPLAY_COMPARE'],
			'PRODUCT' => array(
				'ID' => $arResult['ID'],
				'NAME' => $productTitle,
				'PICT' => ('Y' == $arResult['SECOND_PICT'] ? $arResult['PREVIEW_PICTURE_SECOND'] : $arResult['PREVIEW_PICTURE']),
				'CAN_BUY' => $arResult["CAN_BUY"],
				'SUBSCRIPTION' => ('Y' == $arResult['CATALOG_SUBSCRIPTION']),
				'CHECK_QUANTITY' => $arResult['CHECK_QUANTITY'],
				'MAX_QUANTITY' => $arResult['CATALOG_QUANTITY'],
				'STEP_QUANTITY' => $arResult['CATALOG_MEASURE_RATIO'],
				'QUANTITY_FLOAT' => is_double($arResult['CATALOG_MEASURE_RATIO']),
				'SUBSCRIBE_URL' => $arResult['~SUBSCRIBE_URL'],
				'BASIS_PRICE' => $arResult['MIN_BASIS_PRICE']
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
			'LAST_ELEMENT' => $arResult['LAST_ELEMENT']
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
<?
	}
?>