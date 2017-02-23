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
use Bitrix\Main\Loader;
use Bitrix\Main\ModuleManager;
$this->setFrameMode(true);
if(!empty($_POST['user_offer']) && $_POST['user_offer'] == $arResult['ID']) {
	$arFields = array(
		"ID" => $_POST['user_offer'],
		"NAME" => $_POST['user_name'],
		"EMAIL" => $_POST['user_email'],
		"PHONE" => $_POST['user_phone'],
		"QUANTITY" => $_POST['user_quantity'],
		"PR_NAME" => $arResult['NAME'],
		"PR_ART" => $arResult['PROPERTIES']['ARTNUMBER']['VALUE'],
		"PR_URL" => $arResult['DETAIL_PAGE_URL'],
		"IP" => $_SERVER['REMOTE_ADDR']
		);
	if(CEvent::SendImmediate('USER_OFFER', 's1', $arFields)) {
		?>
		<script>
			$(function() {
				alert("Спасибо за заказ");
			});
		</script>
		<?
	};

}
$catalog_vars = CCatalogProduct::GetByID(
		$arResult['ID']
	);
$templateLibrary = array('popup');
$currencyList = '';
$cur_price_val = str_replace(" ", "", $arResult['MIN_PRICE']['PRINT_DISCOUNT_VALUE']);
$old_price_val = str_replace(" ", "", $arResult['PROPERTIES']['PRICE_OLD']['VALUE']);
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
$section = CIBlockElement::GetList(array(), array('ID' => $arResult['ID']), false, false, array('IBLOCK_SECTION_ID'))->Fetch();
$section = $section["IBLOCK_SECTION_ID"];
$arSections = CIBlockSection::GetNavChain(false, $section)->Fetch();
$strMainID = $this->GetEditAreaId($arResult['ID']);
$arItemIDs = array(
	'ID' => $strMainID,
	'PICT' => $strMainID.'_pict',
	'DISCOUNT_PICT_ID' => $strMainID.'_dsc_pict',
	'STICKER_ID' => $strMainID.'_sticker',
	'BIG_SLIDER_ID' => $strMainID.'_big_slider',
	'BIG_IMG_CONT_ID' => $strMainID.'_bigimg_cont',
	'SLIDER_CONT_ID' => $strMainID.'_slider_cont',
	'SLIDER_LIST' => $strMainID.'_slider_list',
	'SLIDER_LEFT' => $strMainID.'_slider_left',
	'SLIDER_RIGHT' => $strMainID.'_slider_right',
	'OLD_PRICE' => $strMainID.'_old_price',
	'PRICE' => $strMainID.'_price',
	'DISCOUNT_PRICE' => $strMainID.'_price_discount',
	'SLIDER_CONT_OF_ID' => $strMainID.'_slider_cont_',
	'SLIDER_LIST_OF_ID' => $strMainID.'_slider_list_',
	'SLIDER_LEFT_OF_ID' => $strMainID.'_slider_left_',
	'SLIDER_RIGHT_OF_ID' => $strMainID.'_slider_right_',
	'QUANTITY' => $strMainID.'_quantity',
	'QUANTITY_DOWN' => $strMainID.'_quant_down',
	'QUANTITY_UP' => $strMainID.'_quant_up',
	'QUANTITY_MEASURE' => $strMainID.'_quant_measure',
	'QUANTITY_LIMIT' => $strMainID.'_quant_limit',
	'BASIS_PRICE' => $strMainID.'_basis_price',
	'BUY_LINK' => $strMainID.'_buy_link',
	'ADD_BASKET_LINK' => $strMainID.'_add_basket_link',
	'BASKET_ACTIONS' => $strMainID.'_basket_actions',
	'NOT_AVAILABLE_MESS' => $strMainID.'_not_avail',
	'COMPARE_LINK' => $strMainID.'_compare_link',
	'PROP' => $strMainID.'_prop_',
	'PROP_DIV' => $strMainID.'_skudiv',
	'DISPLAY_PROP_DIV' => $strMainID.'_sku_prop',
	'OFFER_GROUP' => $strMainID.'_set_group_',
	'BASKET_PROP_DIV' => $strMainID.'_basket_prop',
);
$strObName = 'ob'.preg_replace("/[^a-zA-Z0-9_]/", "x", $strMainID);
$templateData['JS_OBJ'] = $strObName;

$strTitle = (
	isset($arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_TITLE"]) && $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_TITLE"] != ''
	? $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_TITLE"]
	: $arResult['NAME']
);
$strAlt = (
	isset($arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_ALT"]) && $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_ALT"] != ''
	? $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_ALT"]
	: $arResult['NAME']
);
?>
<div class="bx_item_detail <? echo $templateData['TEMPLATE_CLASS']; ?>" id="<? echo $arItemIDs['ID']; ?>">
<? reset($arResult['MORE_PHOTO']);
$arFirstPhoto = current($arResult['MORE_PHOTO']);
?>
	<div class="bx_item_container">
		<div class="bx_lt">
<div class="bx_item_slider" id="<? echo $arItemIDs['BIG_SLIDER_ID']; ?>">
	<div class="bx_bigimages" id="<? echo $arItemIDs['BIG_IMG_CONT_ID']; ?>">
	<div class="bx_bigimages_imgcontainer<?php if(in_array('101', $arSections)) { ?> ebookimg<?php } ?>">
	<span class="bx_bigimages_aligner">
		<?php if(in_array('101', $arSections)) { ?><div class='ebook_hover'>eBook</div><?php } ?>
		<a href="<? echo $arFirstPhoto['SRC']; ?>" class="fancybox">
			<img id="<? echo $arItemIDs['PICT']; ?>" src="<? echo $arFirstPhoto['SRC']; ?>" <? echo (in_array('101', $arSections))?'class="ebookimg"':''; ?> alt="<? echo $strAlt; ?>" title="<? echo $strTitle; ?>">
		</a>
	</span>
<?
if($arResult['CATALOG_QUANTITY']) {
	if ('Y' == $arParams['SHOW_DISCOUNT_PERCENT'])
	{
		if (!isset($arResult['OFFERS']) || empty($arResult['OFFERS']))
		{
			if (0 < $arResult['MIN_PRICE']['DISCOUNT_DIFF'])
			{
	?>
		<div class="bx_stick_disc right bottom" id="<? echo $arItemIDs['DISCOUNT_PICT_ID'] ?>"><? echo -$arResult['MIN_PRICE']['DISCOUNT_DIFF_PERCENT']; ?>%</div>
	<?
			}
		}
		else
		{
	?>
		<div class="bx_stick_disc right bottom" id="<? echo $arItemIDs['DISCOUNT_PICT_ID'] ?>" style="display: none;"></div>
	<?
		}
	}
}
if ($arResult['LABEL'])
{
?>
	<div class="bx_stick average left top" id="<? echo $arItemIDs['STICKER_ID'] ?>" title="<? echo $arResult['LABEL_VALUE']; ?>"><? echo $arResult['LABEL_VALUE']; ?></div>
<?
}
?>
	</div>
	</div>
<?
if ($arResult['SHOW_SLIDER'])
{
	if (!isset($arResult['OFFERS']) || empty($arResult['OFFERS']))
	{
		if (5 < $arResult['MORE_PHOTO_COUNT'])
		{
			$strClass = 'bx_slider_conteiner full';
			$strOneWidth = (100/$arResult['MORE_PHOTO_COUNT']).'%';
			$strWidth = (20*$arResult['MORE_PHOTO_COUNT']).'%';
			$strSlideStyle = '';
		}
		else
		{
			$strClass = 'bx_slider_conteiner';
			$strOneWidth = '20%';
			$strWidth = '100%';
			$strSlideStyle = 'display: none;';
		}
?>
	<div class="<? echo $strClass; ?>" id="<? echo $arItemIDs['SLIDER_CONT_ID']; ?>">
	<div class="bx_slider_scroller_container">
	<div class="bx_slide">
	<ul style="width: <? echo $strWidth; ?>;" id="<? echo $arItemIDs['SLIDER_LIST']; ?>">
<?
		foreach ($arResult['MORE_PHOTO'] as &$arOnePhoto)
		{
?>
	<li data-value="<? echo $arOnePhoto['ID']; ?>" style="width: <? echo $strOneWidth; ?>; padding-top: <? echo $strOneWidth; ?>;"><span class="cnt"><span class="cnt_item" style="background-image:url('<? echo $arOnePhoto['SRC']; ?>');"></span></span></li>
<?
		}
		unset($arOnePhoto);
?>
	</ul>
	</div>
	<div class="bx_slide_left" id="<? echo $arItemIDs['SLIDER_LEFT']; ?>" style="<? echo $strSlideStyle; ?>"></div>
	<div class="bx_slide_right" id="<? echo $arItemIDs['SLIDER_RIGHT']; ?>" style="<? echo $strSlideStyle; ?>"></div>
	</div>
	</div>
<?
	}
	else
	{
		foreach ($arResult['OFFERS'] as $key => $arOneOffer)
		{
			if (!isset($arOneOffer['MORE_PHOTO_COUNT']) || 0 >= $arOneOffer['MORE_PHOTO_COUNT'])
				continue;
			$strVisible = ($key == $arResult['OFFERS_SELECTED'] ? '' : 'none');
			if (5 < $arOneOffer['MORE_PHOTO_COUNT'])
			{
				$strClass = 'bx_slider_conteiner full';
				$strOneWidth = (100/$arOneOffer['MORE_PHOTO_COUNT']).'%';
				$strWidth = (20*$arOneOffer['MORE_PHOTO_COUNT']).'%';
				$strSlideStyle = '';
			}
			else
			{
				$strClass = 'bx_slider_conteiner';
				$strOneWidth = '20%';
				$strWidth = '100%';
				$strSlideStyle = 'display: none;';
			}
?>
	<div class="<? echo $strClass; ?>" id="<? echo $arItemIDs['SLIDER_CONT_OF_ID'].$arOneOffer['ID']; ?>" style="display: <? echo $strVisible; ?>;">
	<div class="bx_slider_scroller_container">
	<div class="bx_slide">
	<ul style="width: <? echo $strWidth; ?>;" id="<? echo $arItemIDs['SLIDER_LIST_OF_ID'].$arOneOffer['ID']; ?>">
<?
			foreach ($arOneOffer['MORE_PHOTO'] as &$arOnePhoto)
			{
?>
	<li data-value="<? echo $arOneOffer['ID'].'_'.$arOnePhoto['ID']; ?>" style="width: <? echo $strOneWidth; ?>; padding-top: <? echo $strOneWidth; ?>"><span class="cnt"><span class="cnt_item" style="background-image:url('<? echo $arOnePhoto['SRC']; ?>');"></span></span></li>
<?
			}
			unset($arOnePhoto);
?>
	</ul>
	</div>
	<div class="bx_slide_left" id="<? echo $arItemIDs['SLIDER_LEFT_OF_ID'].$arOneOffer['ID'] ?>" style="<? echo $strSlideStyle; ?>" data-value="<? echo $arOneOffer['ID']; ?>"></div>
	<div class="bx_slide_right" id="<? echo $arItemIDs['SLIDER_RIGHT_OF_ID'].$arOneOffer['ID'] ?>" style="<? echo $strSlideStyle; ?>" data-value="<? echo $arOneOffer['ID']; ?>"></div>
	</div>
	</div>
<?
		}
	}
}
?>
</div>
		</div>
		<div class="bx_rt">
<? if ('Y' == $arParams['DISPLAY_NAME']) { ?>
<div class="bx_item_title">
	<h1>
		<span>
			<?
	echo (
		isset($arResult["IPROPERTY_VALUES"]["ELEMENT_PAGE_TITLE"]) && $arResult["IPROPERTY_VALUES"]["ELEMENT_PAGE_TITLE"] != ''
		? $arResult["IPROPERTY_VALUES"]["ELEMENT_PAGE_TITLE"]
		: $arResult["NAME"]
	); ?>
		</span>
	</h1>
</div>
<? } ?>
<?
$useBrands = ('Y' == $arParams['BRAND_USE']);
$useVoteRating = ('Y' == $arParams['USE_VOTE_RATING']);
if ($useBrands || $useVoteRating)
{
?>
	<div class="bx_optionblock">
<?
	if ($useVoteRating)
	{
		?><?$APPLICATION->IncludeComponent(
			"bitrix:iblock.vote",
			"stars",
			array(
				"IBLOCK_TYPE" => $arParams['IBLOCK_TYPE'],
				"IBLOCK_ID" => $arParams['IBLOCK_ID'],
				"ELEMENT_ID" => $arResult['ID'],
				"ELEMENT_CODE" => "",
				"MAX_VOTE" => "5",
				"VOTE_NAMES" => array("1", "2", "3", "4", "5"),
				"SET_STATUS_404" => "N",
				"DISPLAY_AS_RATING" => $arParams['VOTE_DISPLAY_AS_RATING'],
				"CACHE_TYPE" => $arParams['CACHE_TYPE'],
				"CACHE_TIME" => $arParams['CACHE_TIME']
			),
			$component,
			array("HIDE_ICONS" => "Y")
		);?><?
	}
	if ($useBrands)
	{
		?><?$APPLICATION->IncludeComponent("bitrix:catalog.brandblock", ".default", array(
			"IBLOCK_TYPE" => $arParams['IBLOCK_TYPE'],
			"IBLOCK_ID" => $arParams['IBLOCK_ID'],
			"ELEMENT_ID" => $arResult['ID'],
			"ELEMENT_CODE" => "",
			"PROP_CODE" => $arParams['BRAND_PROP_CODE'],
			"CACHE_TYPE" => $arParams['CACHE_TYPE'],
			"CACHE_TIME" => $arParams['CACHE_TIME'],
			"CACHE_GROUPS" => $arParams['CACHE_GROUPS'],
			"WIDTH" => "",
			"HEIGHT" => ""
			),
			$component,
			array("HIDE_ICONS" => "Y")
		);?><?
	}
?>
	</div>
<?
}
unset($useVoteRating, $useBrands);
?>
<?
if (!empty($arResult['DISPLAY_PROPERTIES']) || $arResult['SHOW_OFFERS_PROPS'])
{
?>
<div class="item_info_section">
	
<?
	if (!empty($arResult['DISPLAY_PROPERTIES']))
	{
?>
	<dl>
<?
		foreach ($arResult['DISPLAY_PROPERTIES'] as &$arOneProp) if(!empty($arOneProp['VALUE']))
		{
?>
		<?php if($arOneProp['ID'] == 114) { echo "<a href='/catalog/?q=1&s=BOOKINIST'>"; } ?><dt><? echo $arOneProp['NAME']; ?></dt><dd>
		<? 
			switch($arOneProp['ID']) {
				case 44:
					$autor = str_replace(' ', '+', $arOneProp['VALUE']);
					echo "<a href='/catalog/?q={$autor}&s=AUTOR'>";
					break;
				case 45:
					$autor = str_replace(' ', '+', $arOneProp['VALUE']);
					echo "<a href='/catalog/?q={$autor}&s=IZDATELSTVO'>";
					break;
				case 53:
					$autor = str_replace(' ', '+', $arOneProp['VALUE']);
					echo "<a href='/catalog/?q={$autor}&s=SERIA'>";
					break;
			}
			switch($arOneProp['ID']) {
				case 114: break;
				default:
					echo (
						is_array($arOneProp['DISPLAY_VALUE']) ? implode(' / ', $arOneProp['DISPLAY_VALUE']) : $arOneProp['DISPLAY_VALUE'] ); 
			}
			switch($arOneProp['ID']) {
				case 114:
				case 44:
				case 45:
				case 53:
					echo "</a>";
					break;
			}
		?>
			</dd><?
		}
		unset($arOneProp);
?>
			<? $res_keys = $APPLICATION->IncludeComponent(
				"bitrix:isale.keys.list",
				"polka",
				Array(
					'PRODUCT_ID'=>$arResult['ID']
				)
			);
			?>
		<?php $arr = @$arResult['PROPERTIES']['MORE_FORMATS']['VALUE']; if(!empty($arr)) {?>
		<dt>Доступные расширения</dt>
		<dd>
			<?php
				$res = CFILE::GetList(array(), array("@ID"=>implode(',', $arr))); $k = 0;
				while($res_arr = $res->GetNext()){
					echo ($k++?' | ':'');
					if(!empty($res_keys['ITEMS']) || str_replace(" ", "", $arResult['MIN_PRICE']['PRINT_DISCOUNT_VALUE'])=='0.00') echo '<a href="/upload/'.$res_arr['SUBDIR'].'/'.$res_arr["FILE_NAME"].'">';
					echo '<b>', preg_replace('~^.*\.~', '', $res_arr["FILE_NAME"]), '</b>';
					if(!empty($res_keys['ITEMS']) || str_replace(" ", "", $arResult['MIN_PRICE']['PRINT_DISCOUNT_VALUE'])=='0.00') echo '</a>'; 
				}
			?>
		</dd>
		<?php } ?>
	</dl>
<?
	}
	if ($arResult['SHOW_OFFERS_PROPS'])
	{
?>
	<dl id="<? echo $arItemIDs['DISPLAY_PROP_DIV'] ?>" style="display: none;"></dl>
<?
	}
?>
</div>
<?
}
if ('' != $arResult['PREVIEW_TEXT'])
{
	if (
		'S' == $arParams['DISPLAY_PREVIEW_TEXT_MODE']
		|| ('E' == $arParams['DISPLAY_PREVIEW_TEXT_MODE'] && '' == $arResult['DETAIL_TEXT'])
	)
	{
?>
<div class="item_info_section">
<?
		echo ('html' == $arResult['PREVIEW_TEXT_TYPE'] ? $arResult['PREVIEW_TEXT'] : '<p>'.$arResult['PREVIEW_TEXT'].'</p>');
?>
</div>
<?
	}
}
if (isset($arResult['OFFERS']) && !empty($arResult['OFFERS']) && !empty($arResult['OFFERS_PROP']))
{
	$arSkuProps = array();
?>
<div class="item_info_section" style="padding-right:150px;" id="<? echo $arItemIDs['PROP_DIV']; ?>">

<?
	foreach ($arResult['SKU_PROPS'] as &$arProp)
	{
		if (!isset($arResult['OFFERS_PROP'][$arProp['CODE']]))
			continue;
		$arSkuProps[] = array(
			'ID' => $arProp['ID'],
			'SHOW_MODE' => $arProp['SHOW_MODE'],
			'VALUES_COUNT' => $arProp['VALUES_COUNT']
		);
		if ('TEXT' == $arProp['SHOW_MODE'])
		{
			if (5 < $arProp['VALUES_COUNT'])
			{
				$strClass = 'bx_item_detail_size full';
				$strOneWidth = (100/$arProp['VALUES_COUNT']).'%';
				$strWidth = (20*$arProp['VALUES_COUNT']).'%';
				$strSlideStyle = '';
			}
			else
			{
				$strClass = 'bx_item_detail_size';
				$strOneWidth = '20%';
				$strWidth = '100%';
				$strSlideStyle = 'display: none;';
			}
?>
	<div class="<? echo $strClass; ?>" id="<? echo $arItemIDs['PROP'].$arProp['ID']; ?>_cont">
		<span class="bx_item_section_name_gray"><? echo htmlspecialcharsex($arProp['NAME']); ?></span>
		<div class="bx_size_scroller_container"><div class="bx_size">
			<ul id="<? echo $arItemIDs['PROP'].$arProp['ID']; ?>_list" style="width: <? echo $strWidth; ?>;margin-left:0%;">
<?
			foreach ($arProp['VALUES'] as $arOneValue)
			{
				$arOneValue['NAME'] = htmlspecialcharsbx($arOneValue['NAME']);
?>
<li data-treevalue="<? echo $arProp['ID'].'_'.$arOneValue['ID']; ?>" data-onevalue="<? echo $arOneValue['ID']; ?>" style="width: <? echo $strOneWidth; ?>; display: none;">
<i title="<? echo $arOneValue['NAME']; ?>"></i><span class="cnt" title="<? echo $arOneValue['NAME']; ?>"><? echo $arOneValue['NAME']; ?></span></li>
<?
			}
?>
			</ul>
			</div>
			<div class="bx_slide_left" style="<? echo $strSlideStyle; ?>" id="<? echo $arItemIDs['PROP'].$arProp['ID']; ?>_left" data-treevalue="<? echo $arProp['ID']; ?>"></div>
			<div class="bx_slide_right" style="<? echo $strSlideStyle; ?>" id="<? echo $arItemIDs['PROP'].$arProp['ID']; ?>_right" data-treevalue="<? echo $arProp['ID']; ?>"></div>
		</div>
	</div>
<?
		}
		elseif ('PICT' == $arProp['SHOW_MODE'])
		{
			if (5 < $arProp['VALUES_COUNT'])
			{
				$strClass = 'bx_item_detail_scu full';
				$strOneWidth = (100/$arProp['VALUES_COUNT']).'%';
				$strWidth = (20*$arProp['VALUES_COUNT']).'%';
				$strSlideStyle = '';
			}
			else
			{
				$strClass = 'bx_item_detail_scu';
				$strOneWidth = '20%';
				$strWidth = '100%';
				$strSlideStyle = 'display: none;';
			}
?>
	<div class="<? echo $strClass; ?>" id="<? echo $arItemIDs['PROP'].$arProp['ID']; ?>_cont">
		<span class="bx_item_section_name_gray"><? echo htmlspecialcharsex($arProp['NAME']); ?></span>
		<div class="bx_scu_scroller_container"><div class="bx_scu">
			<ul id="<? echo $arItemIDs['PROP'].$arProp['ID']; ?>_list" style="width: <? echo $strWidth; ?>;margin-left:0%;">
<?
			foreach ($arProp['VALUES'] as $arOneValue)
			{
				$arOneValue['NAME'] = htmlspecialcharsbx($arOneValue['NAME']);
?>
<li data-treevalue="<? echo $arProp['ID'].'_'.$arOneValue['ID'] ?>" data-onevalue="<? echo $arOneValue['ID']; ?>" style="width: <? echo $strOneWidth; ?>; padding-top: <? echo $strOneWidth; ?>; display: none;" >
<i title="<? echo $arOneValue['NAME']; ?>"></i>
<span class="cnt"><span class="cnt_item" style="background-image:url('<? echo $arOneValue['PICT']['SRC']; ?>');" title="<? echo $arOneValue['NAME']; ?>"></span></span></li>
<?
			}
?>
			</ul>
			</div>
			<div class="bx_slide_left" style="<? echo $strSlideStyle; ?>" id="<? echo $arItemIDs['PROP'].$arProp['ID']; ?>_left" data-treevalue="<? echo $arProp['ID']; ?>"></div>
			<div class="bx_slide_right" style="<? echo $strSlideStyle; ?>" id="<? echo $arItemIDs['PROP'].$arProp['ID']; ?>_right" data-treevalue="<? echo $arProp['ID']; ?>"></div>
		</div>
	</div>
<?
		}
	}
	unset($arProp);
?>
</div>
<?
}
?>
			<div class="clb"></div>
		</div>
<!-- ____________________________ -->
		<div class="right_bar">
			<?php if($arResult['CATALOG_QUANTITY']) { ?>
				<div class="item_price">
					<?if(!empty($arResult['PROPERTIES']['PRICE_OLD']['VALUE']) && $arResult['PROPERTIES']['PRICE_OLD']['VALUE']!='0.00') { ?> <s class="price-old"><?php echo CCurrencyLang::CurrencyFormat(str_replace(" ", "", $arResult['PROPERTIES']['PRICE_OLD']['VALUE']), site::getCurrency(), true); ?></s> <?}?>
					<?if($old_price_val > 0) { ?>
						<div class="item_economy_price"><p>Вы экономите: <? echo CCurrencyLang::CurrencyFormat($old_price_val-$cur_price_val, site::getCurrency(), true); ?> (<? echo ceil(($old_price_val-$cur_price_val)*100/$old_price_val).'%'; ?>)<span></p></div>
					<? } 
						$boolDiscountShow = (0 < $arResult['MIN_PRICE']['DISCOUNT_DIFF']);
					?>
						<div class="item_old_price" id="<? echo $arItemIDs['OLD_PRICE']; ?>" style="display: <? echo ($boolDiscountShow ? '' : 'none'); ?>"><? echo ($boolDiscountShow ? CCurrencyLang::CurrencyFormat(str_replace(" ", "", $arResult['MIN_PRICE']['PRINT_VALUE']), site::getCurrency(),true) : '');?></div>
						<div class="item_current_price" id="<? echo $arItemIDs['PRICE']; ?>"><? echo $arResult['MIN_PRICE']['PRINT_DISCOUNT_VALUE']; ?></div>
						<div class="item_economy_price" id="<? echo $arItemIDs['DISCOUNT_PRICE']; ?>" style="display: <? echo ($boolDiscountShow ? '' : 'none'); ?>"><? echo ($boolDiscountShow ? GetMessage('CT_BCE_CATALOG_ECONOMY_INFO', array('#ECONOMY#' => CCurrencyLang::CurrencyFormat(str_replace(" ", "", $arResult['MIN_PRICE']['PRINT_DISCOUNT_DIFF']), site::getCurrency(),true))) : ''); ?></div>
				</div>
			<?php } ?>
			<?
				if($catalog_vars['QUANTITY'] == 0) {
					?>
					<div class="item_info_section item_quantity quantity_null">
						<p class="item_quantity_text">Нет на складе</p>
					</div>
					<?
				} else {
					?>
					<div class="item_info_section item_quantity">
						<p class="item_quantity_text">На складе: <span class="item_quantity_value"><?= $catalog_vars['QUANTITY'];?></span></p>
					</div>
					<?
				}
				if(isset($catalog_vars['WEIGHT'])) {
					?>
					<div class="item_info_section item_weight">
						<p class="item_weight_text">Вес: <span class="item_weight_value"><?=$catalog_vars['WEIGHT'];?></span> кг</p>
					</div>
					<?
				}
			?>
			<div class="item_info_section">
				<?
				if (isset($arResult['OFFERS']) && !empty($arResult['OFFERS']))
				{
					$canBuy = $arResult['OFFERS'][$arResult['OFFERS_SELECTED']]['CAN_BUY'];
				}
				else
				{
					$canBuy = $arResult['CAN_BUY'];
				}
				$buyBtnMessage = ($arParams['MESS_BTN_BUY'] != '' ? $arParams['MESS_BTN_BUY'] : GetMessage('CT_BCE_CATALOG_BUY'));
				$addToBasketBtnMessage = ($arParams['MESS_BTN_ADD_TO_BASKET'] != '' ? $arParams['MESS_BTN_ADD_TO_BASKET'] : GetMessage('CT_BCE_CATALOG_ADD'));
				$notAvailableMessage = ($arParams['MESS_NOT_AVAILABLE'] != '' ? $arParams['MESS_NOT_AVAILABLE'] : GetMessageJS('CT_BCE_CATALOG_NOT_AVAILABLE'));
				$showBuyBtn = in_array('BUY', $arParams['ADD_TO_BASKET_ACTION']);
				$showAddBtn = in_array('ADD', $arParams['ADD_TO_BASKET_ACTION']);

				$showSubscribeBtn = false;
				$compareBtnMessage = ($arParams['MESS_BTN_COMPARE'] != '' ? $arParams['MESS_BTN_COMPARE'] : GetMessage('CT_BCE_CATALOG_COMPARE'));

				$ids = array(); foreach ($arResult['SECTION']['PATH'] as $i) array_push($ids, $i['ID']);
				if ($arParams['USE_PRODUCT_QUANTITY'] == 'Y')
				{
					if(in_array(101, $ids)) { ?><div style="display: none"><?php }
					if ($arParams['SHOW_BASIS_PRICE'] == 'Y')
					{
						$basisPriceInfo = array(
							'#PRICE#' => CCurrencyLang::CurrencyFormat(str_replace(" ", "", $arResult['MIN_BASIS_PRICE']['PRINT_DISCOUNT_VALUE']), site::GetCurrency(),true),
							'#MEASURE#' => (isset($arResult['CATALOG_MEASURE_NAME']) ? $arResult['CATALOG_MEASURE_NAME'] : '')
						);
				?>
						<!--<p id="<? echo $arItemIDs['BASIS_PRICE']; ?>" class="item_section_name_gray"><? echo GetMessage('CT_BCE_CATALOG_MESS_BASIS_PRICE', $basisPriceInfo); ?></p>-->
				<?
					}
				?>
					<span class="item_section_name_gray"><? echo GetMessage('CATALOG_QUANTITY');?></span>
					<?php if(in_array(101, $ids)) { ?></div><?php } ?>
					<div class="item_buttons vam">
						<?php if(in_array(101, $ids)) { ?><div style="display: none"><?php } ?>
						<span class="item_buttons_counter_block">
							<!--<a href="javascript:void(0)" class="bx_bt_button_type_2 bx_small bx_fwb" id="<? echo $arItemIDs['QUANTITY_DOWN']; ?>">-</a>-->
							<input id="<? echo $arItemIDs['QUANTITY']; ?>" type="text" class="tac transparent_input" value="<? echo (isset($arResult['OFFERS']) && !empty($arResult['OFFERS'])
									? 1
									: $arResult['CATALOG_MEASURE_RATIO']
								); ?>">
							<!--<a href="javascript:void(0)" class="bx_bt_button_type_2 bx_small bx_fwb" id="<? echo $arItemIDs['QUANTITY_UP']; ?>">+</a>-->
						</span>
						<span class="item_buttons_counter_block" id="<? echo $arItemIDs['BASKET_ACTIONS']; ?>" style="display: <? echo ($canBuy ? '' : 'none'); ?>;">
						<?php if(in_array(101, $ids)) { ?></div><?php } ?>
				<?
					if ($showBuyBtn)
					{
						if($arResult['CATALOG_QUANTITY'] > 0) {
				?>
							<a href="javascript:void(0);" class="bx_big bx_bt_button bx_cart" id="<? echo $arItemIDs['BUY_LINK']; ?>"><span></span><? echo $buyBtnMessage; ?></a>
				<?
						} else {
							?>
							<a href="javascript:void(0);" class="bx_big bx_bt_button btn_custom_offer"></a>
							<div class="layer_custom_offer"></div>
							<div class="block_custom_offer">
								<form action="" method="post" class="form_custom_offer" name="custom_offer" id="custom_offer">
									<input type="hidden" value="<?php echo $arResult['ID'];?>" name="user_offer">
									<p><label for="user_name">Ваще имя:</label><input type="text" name="user_name"></p>
									<p><label for="user_email">E-mail:</label><input type="text" name="user_email"></p>
									<p><label for="user_phone">Контактный телефон:</label><input type="text" name="user_phone"></p>
									<p><label for="user_quantity">Количество</label><input type="text" name="user_quantity" value="1"></p>
									<p><button>Отправить запрос</button></p>
								</form>
							</div>
							<?
						}
					}
					if ($showAddBtn)
					{
				?>
							<a href="javascript:void(0);" class="bx_big bx_bt_button bx_cart" id="<? echo $arItemIDs['ADD_BASKET_LINK']; ?>"><span></span><? echo $addToBasketBtnMessage; ?></a>
				<?
					}
				?>
						</span>
						<span id="<? echo $arItemIDs['NOT_AVAILABLE_MESS']; ?>" class="bx_notavailable" style="display: <? echo (!$canBuy ? '' : 'none'); ?>;"><? echo $notAvailableMessage; ?></span>
				<?
					if ($arParams['DISPLAY_COMPARE'] || $showSubscribeBtn)
					{
				?>
						<span class="item_buttons_counter_block">
				<?
						if ($arParams['DISPLAY_COMPARE'])
						{
				?>
							<a href="javascript:void(0);" class="bx_big bx_bt_button_type_2 bx_cart" id="<? echo $arItemIDs['COMPARE_LINK']; ?>"><? echo $compareBtnMessage; ?></a>
				<?
						}
						if ($showSubscribeBtn)
						{

						}
				?>
						</span>
				<?
					}
				?>
					</div>
				<?
					if ('Y' == $arParams['SHOW_MAX_QUANTITY'])
					{
						if (isset($arResult['OFFERS']) && !empty($arResult['OFFERS']))
						{
				?>
					<p id="<? echo $arItemIDs['QUANTITY_LIMIT']; ?>" style="display: none;"><? echo GetMessage('OSTATOK'); ?>: <span></span></p>
				<?
						}
						else
						{
							if ('Y' == $arResult['CATALOG_QUANTITY_TRACE'] && 'N' == $arResult['CATALOG_CAN_BUY_ZERO'])
							{
				?>
					<p id="<? echo $arItemIDs['QUANTITY_LIMIT']; ?>"><? echo GetMessage('OSTATOK'); ?>: <span><? echo $arResult['CATALOG_QUANTITY']; ?></span></p>
				<?
							}
						}
					}
				} else {
				?>
					<div class="item_buttons vam">
						<span class="item_buttons_counter_block" id="<? echo $arItemIDs['BASKET_ACTIONS']; ?>" style="display: <? echo ($canBuy ? '' : 'none'); ?>;">
				<?
					if ($showBuyBtn)
					{
				?>
							<a href="javascript:void(0);" class="bx_big bx_bt_button bx_cart" id="<? echo $arItemIDs['BUY_LINK']; ?>"><span></span><? echo $buyBtnMessage; ?></a>
				<?
					}
					if ($showAddBtn)
					{
				?>
						<a href="javascript:void(0);" class="bx_big bx_bt_button bx_cart" id="<? echo $arItemIDs['ADD_BASKET_LINK']; ?>"><span></span><? echo $addToBasketBtnMessage; ?></a>
				<?
					}
				?>
						</span>
						<span id="<? echo $arItemIDs['NOT_AVAILABLE_MESS']; ?>" class="bx_notavailable" style="display: <? echo (!$canBuy ? '' : 'none'); ?>;"><? echo $notAvailableMessage; ?></span>
					</div>
				<?
				}
				unset($showAddBtn, $showBuyBtn);
				?>
				</div>
					<?
						if($arResult['PROPERTIES']['SPECIALOFFER']['VALUE'] == 1) {
						?>
						<div class="best_price text-center">
							<img width="50" alt="Лучшая цена гарантирована" src="http://knigionline.com/images/bestprice.png" height="50">
							<p><strong>Нашли дешевле?</strong></p>
							<p><a href="">Сообщите нам</a></p>
						</div>
						<?
						}
					?>
				<? //TESTING RECCOMENDED PRODS
	 				if ($arResult['ID'] > 0)
						{
						$section_id = $arResult['IBLOCK_SECTION_ID'];
						$section_parent_id = CIBlockSection::GetByID($section_id);
						if($section_parent_id = $section_parent_id->GetNext()){
							$section_code = $section_parent_id['CODE'];
							$section_parent_id = $section_parent_id['IBLOCK_SECTION_ID'];
						}
					}
					$arRecomData = array();
					$recomCacheID = array('IBLOCK_ID' => $arParams['IBLOCK_ID']);
					$obCache = new CPHPCache();
					if ($obCache->InitCache(36000, serialize($recomCacheID), "/catalog/recommended"))
					{
						$arRecomData = $obCache->GetVars();
					}
					elseif ($obCache->StartDataCache())
					{
						if (Loader::includeModule("catalog"))
						{
							$arSKU = CCatalogSKU::GetInfoByProductIBlock($arParams['IBLOCK_ID']);
							$arRecomData['OFFER_IBLOCK_ID'] = (!empty($arSKU) ? $arSKU['IBLOCK_ID'] : 0);
							$arRecomData['IBLOCK_LINK'] = '';
							$arRecomData['ALL_LINK'] = '';
							$rsProps = CIBlockProperty::GetList(
								array('SORT' => 'ASC', 'ID' => 'ASC'),
								array('IBLOCK_ID' => $arParams['IBLOCK_ID'], 'PROPERTY_TYPE' => 'E', 'ACTIVE' => 'Y')
							);
							$found = false;
							while ($arProp = $rsProps->Fetch())
							{
								if ($found)
								{
									break;
								}
								if ($arProp['CODE'] == '')
								{
									$arProp['CODE'] = $arProp['ID'];
								}
								$arProp['LINK_IBLOCK_ID'] = intval($arProp['LINK_IBLOCK_ID']);
								if ($arProp['LINK_IBLOCK_ID'] != 0 && $arProp['LINK_IBLOCK_ID'] != $arParams['IBLOCK_ID'])
								{
									continue;
								}
								if ($arProp['LINK_IBLOCK_ID'] > 0)
								{
									if ($arRecomData['IBLOCK_LINK'] == '')
									{
										$arRecomData['IBLOCK_LINK'] = $arProp['CODE'];
										$found = true;
									}
								}
								else
								{
									if ($arRecomData['ALL_LINK'] == '')
									{
										$arRecomData['ALL_LINK'] = $arProp['CODE'];
									}
								}
							}
							if ($found)
							{
								if(defined("BX_COMP_MANAGED_CACHE"))
								{
									global $CACHE_MANAGER;
									$CACHE_MANAGER->StartTagCache("/catalog/recommended");
									$CACHE_MANAGER->RegisterTag("iblock_id_".$arParams["IBLOCK_ID"]);
									$CACHE_MANAGER->EndTagCache();
								}
							}
						}
						$obCache->EndDataCache($arRecomData);
					}
					if (!empty($arRecomData) && ($arRecomData['IBLOCK_LINK'] != '' || $arRecomData['ALL_LINK'] != ''))
					{
					?>
					<?$APPLICATION->IncludeComponent(
						"bitrix:catalog.recommended.products",
						"",
						array(
							"ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
							"ADD_PROPERTIES_TO_BASKET" => (isset($arParams["ADD_PROPERTIES_TO_BASKET"]) ? $arParams["ADD_PROPERTIES_TO_BASKET"] : ''),
							"ADDITIONAL_PICT_PROP_".$arParams['IBLOCK_ID'] => $arParams['ADD_PICT_PROP'],
							"ADDITIONAL_PICT_PROP_".$arRecomData['OFFER_IBLOCK_ID'] => $arParams['OFFER_ADD_PICT_PROP'],
							"BASKET_URL" => $arParams["BASKET_URL"],
							"CACHE_TIME" => $arParams["CACHE_TIME"],
							"CACHE_TYPE" => 'N',
							"CONVERT_CURRENCY" => $arParams["CONVERT_CURRENCY"],
							"CURRENCY_ID" => $arParams["CURRENCY_ID"],
							"HIDE_NOT_AVAILABLE" => $arParams["HIDE_NOT_AVAILABLE"],
							"ID" => $arResult['ID'],
							"LINE_ELEMENT_COUNT" => $arParams["ALSO_BUY_ELEMENT_COUNT"],
							"MESS_BTN_BUY" => $arParams['MESS_BTN_BUY'],
							"MESS_BTN_DETAIL" => $arParams["MESS_BTN_DETAIL"],
							"MESS_BTN_SUBSCRIBE" => $arParams['MESS_BTN_SUBSCRIBE'],
							"MESS_NOT_AVAILABLE" => $arParams['MESS_NOT_AVAILABLE'],
							"OFFER_TREE_PROPS_".$arRecomData['OFFER_IBLOCK_ID'] => $arParams["OFFER_TREE_PROPS"],
							"OFFER_TREE_PROPS_".$arRecomData['OFFER_IBLOCK_ID'] => $arParams["OFFER_TREE_PROPS"],
							"PAGE_ELEMENT_COUNT" => $arParams["ALSO_BUY_ELEMENT_COUNT"],
							"PARTIAL_PRODUCT_PROPERTIES" => (isset($arParams["PARTIAL_PRODUCT_PROPERTIES"]) ? $arParams["PARTIAL_PRODUCT_PROPERTIES"] : ''),
							"PRICE_CODE" => $arParams["PRICE_CODE"],
							"PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
							"PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
							"PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
							"PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
							"PRODUCT_SUBSCRIPTION" => 'N',
							"PROPERTY_CODE_".$arRecomData['OFFER_IBLOCK_ID'] => array(),
							"PROPERTY_LINK" => ($arRecomData['IBLOCK_LINK'] != '' ? $arRecomData['IBLOCK_LINK'] : $arRecomData['ALL_LINK']),
							"SHOW_DISCOUNT_PERCENT" => $arParams['SHOW_DISCOUNT_PERCENT'],
							"SHOW_IMAGE" => "Y",
							"SHOW_NAME" => "Y",
							"SHOW_OLD_PRICE" => $arParams['SHOW_OLD_PRICE'],
							"SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],
							"SHOW_PRODUCTS_".$arParams["IBLOCK_ID"] => "Y",
							"TEMPLATE_THEME" => (isset($arParams['TEMPLATE_THEME']) ? $arParams['TEMPLATE_THEME'] : ''),
							"USE_PRODUCT_QUANTITY" => $arParams['USE_PRODUCT_QUANTITY'],
						),
						$component,
						false
					); ?>
					<? }
				//END TEST
				?>
		</div>

<!-- _________________________________ -->

		<div class="bx_md hide">
<div class="item_info_section">
<?
if (isset($arResult['OFFERS']) && !empty($arResult['OFFERS']))
{
	if ($arResult['OFFER_GROUP'])
	{
		foreach ($arResult['OFFER_GROUP_VALUES'] as $offerID)
		{
?>
	<span id="<? echo $arItemIDs['OFFER_GROUP'].$offerID; ?>" style="display: none;">
<?$APPLICATION->IncludeComponent("bitrix:catalog.set.constructor",
	".default",
	array(
		"IBLOCK_ID" => $arResult["OFFERS_IBLOCK"],
		"ELEMENT_ID" => $offerID,
		"PRICE_CODE" => $arParams["PRICE_CODE"],
		"BASKET_URL" => $arParams["BASKET_URL"],
		"OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
		"CACHE_TYPE" => $arParams["CACHE_TYPE"],
		"CACHE_TIME" => $arParams["CACHE_TIME"],
		"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
		"TEMPLATE_THEME" => $arParams['~TEMPLATE_THEME'],
		"CONVERT_CURRENCY" => $arParams['CONVERT_CURRENCY'],
		"CURRENCY_ID" => $arParams["CURRENCY_ID"]
	),
	$component,
	array("HIDE_ICONS" => "Y")
);?><?
?>
	</span>
<?
		}
	}
}
else
{
	if ($arResult['MODULES']['catalog'] && $arResult['OFFER_GROUP'])
	{
?><?$APPLICATION->IncludeComponent("bitrix:catalog.set.constructor",
	".default",
	array(
		"IBLOCK_ID" => $arParams["IBLOCK_ID"],
		"ELEMENT_ID" => $arResult["ID"],
		"PRICE_CODE" => $arParams["PRICE_CODE"],
		"BASKET_URL" => $arParams["BASKET_URL"],
		"CACHE_TYPE" => $arParams["CACHE_TYPE"],
		"CACHE_TIME" => $arParams["CACHE_TIME"],
		"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
		"TEMPLATE_THEME" => $arParams['~TEMPLATE_THEME'],
		"CONVERT_CURRENCY" => $arParams['CONVERT_CURRENCY'],
		"CURRENCY_ID" => $arParams["CURRENCY_ID"]
	),
	$component,
	array("HIDE_ICONS" => "Y")
);?><?
	}
}
?>
</div>
		</div>
		<div class="bx_rb" style="float:left; width:80%;">
<div class="item_info_section">
<?
if ('' != $arResult['DETAIL_TEXT'])
{
?>
	<div class="social_buttons_wrap">
		<div style="float:left;font-size:0.9em;">Поделиться ссылкой:&nbsp;&nbsp;&nbsp;</div>
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
	<div class="bx_item_description">
		<div class="bx_item_section_name_gray" ><? echo GetMessage('FULL_DESCRIPTION'); ?></div>
	<div class="bx_text_description">
		<? if ('html' == $arResult['DETAIL_TEXT_TYPE']) { ?>
		<?php echo $arResult['DETAIL_TEXT']; ?>
		<?php } else { ?>
		<p>
			<? echo htmlspecialchars_decode($arResult['DETAIL_TEXT']); ?>
		</p>
		<? } ?>
	</div>
	</div>
<?
}
?>
</div>
		</div>
		<div class="clearfix"></div>
		<div class="author_info_block">
			<div class="like_comments">
				<div class="vk_share">
					<div id="vk_like"></div>
				</div>
				<div class="facebook_share">	
					<iframe src="https://www.facebook.com/plugins/like.php?app_id=161370570611784&amp;href=http://knigionline.com/product/1744-Bogosluzhenie_bibleyskoe_i_sovremennoe/&amp;send=false&amp;layout=standard&amp;width=700&amp;show_faces=true&amp;action=recommend&amp;colorscheme=light&amp;font&amp;height=80" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:700px; height:80px;" allowTransparency="true"></iframe>
				</div>
			</div>
			<?
			//RECEIVING AUTHOR INFO
			if(!empty($arResult['PROPERTIES']['AUTOR']['VALUE'])) {
				$author = trim($arResult['PROPERTIES']['AUTOR']['VALUE']);
				$author_list = array();
				$author_list = explode(', ', $author);
				$author_result = array();
				foreach($author_list as $oneauthor) {
					$res = CIBlockElement::GetList(
							array(),
							array("NAME" => "%".$oneauthor."%"),
							false,
							array('nTopCount' => 1)
						);
					while($row = $res->GetNext()) {
						$author_result[] = $row;
					}
				}
			}
			// OUTPUT AUTHOR INFO IF AUTHOR COUNT IS 1
			if(count($author_result) == 1) {
				?>
				<h2><?=$author_result[0]['NAME']?></h2>
				<div class="author_info_content">
					<div class="author_info_photo">
						<? if(!empty($author_result[0]['DETAIL_PICTURE'])) {
							$author_result[0]['DETAIL_PICTURE_SRC'] = CFile::GetPath($author_result[0]['DETAIL_PICTURE']);
							?>
							<img src="<?=$author_result[0]['DETAIL_PICTURE_SRC']?>" alt="">
							<?
						} else {
							?>
							<span>Нет изображения</span>
							<?
						}
						?>
					</div>
					<div class="author_info_desc">
						<div class="author_info_name">
							<?=$author_result[0]['NAME']?>
						</div>
						<div class="authors_books">
							<a href="/catalog/?q=<? echo str_replace(" ", "+", $author_result[0]['NAME'])?>&s=AUTOR">Все книги автора</a>
						</div>
						<div class="author_desc">
							<?=$author_result[0]['DETAIL_TEXT']?>
						</div>
					</div>
				</div>
				<?
			}
			?>
		</div>
		<div class="bx_lb" style="clear:both">
<div class="tac ovh">
</div>
<div class="tab-section-container">
<?
if ('Y' == $arParams['USE_COMMENTS'])
{
?>
<?$APPLICATION->IncludeComponent(
	"bitrix:catalog.comments",
	"template1",
	array(
		"ELEMENT_ID" => $arResult['ID'],
		"ELEMENT_CODE" => "",
		"IBLOCK_ID" => $arParams['IBLOCK_ID'],
		"URL_TO_COMMENT" => "",
		"WIDTH" => "",
		"COMMENTS_COUNT" => "5",
		"BLOG_USE" => $arParams['BLOG_USE'],
		"FB_USE" => "Y",
		"FB_APP_ID" => $arParams['FB_APP_ID'],
		"VK_USE" => $arParams['VK_USE'],
		"VK_API_ID" => $arParams['VK_API_ID'],
		"CACHE_TYPE" => $arParams['CACHE_TYPE'],
		"CACHE_TIME" => $arParams['CACHE_TIME'],
		"BLOG_TITLE" => "",
		"BLOG_URL" => $arParams['BLOG_URL'],
		"PATH_TO_SMILE" => "",
		"EMAIL_NOTIFY" => $arParams['BLOG_EMAIL_NOTIFY'],
		"AJAX_POST" => "N",
		"SHOW_SPAM" => "Y",
		"SHOW_RATING" => "Y",
		"FB_TITLE" => "",
		"FB_USER_ADMIN_ID" => "",
		"FB_COLORSCHEME" => "light",
		"FB_ORDER_BY" => "reverse_time",
		"VK_TITLE" => "",
		"TEMPLATE_THEME" => $arParams['~TEMPLATE_THEME']
	),
	$component,
	array()
);
}
?>
</div>
		</div>
			<div style="clear: both;"></div>
	</div>
	<div class="clb"></div>



</div>
</div>
</div>
<div class="clearfix"></div>
<div class="new_section_items">
			<div class="container">
		<div class="promocode">
			<?$APPLICATION->IncludeComponent(
				"bitrix:main.include",
				"",
				Array(
					"AREA_FILE_SHOW" => "file",
					"PATH" => SITE_DIR."include/promocode.php"
				)
			);?>
		</div>
		<div class="promocode_content">
			<?	
				//Receiving last products from section
				function findLast($curSection, $curElement = array(), $limit = 2, $complete = array()) {
					$arrFilter = array(
						"SECTION_ID" => $curSection,
						"!ID" => $curElement,
						"!PREVIEW_PICTURE" => FALSE,
						"ACTIVE" => 'Y',
						"INCLUDE_SUBSECTIONS" => 'Y'
						);
					$result = CIBlockElement::GetList(
						array(
							"created" => "DESC",
							"ID" => "DESC"
							),
						$arrFilter,
						false,
						array(
							"nTopCount" => $limit
							),
						array(
							"PROPERTY_AUTOR",
							"NAME",
							"ID",
							"DETAIL_PAGE_URL",
							"BUY_URL",
							"CATALOG_GROUP_1",
							"PREVIEW_PICTURE",
							"PREVIEW_TEXT",
							"DETAIL_TEXT"
							)
						);
					if($result->SelectedRowsCount() > 0) {
						while($row = $result->GetNext()) {
							if(count($complete) >= $limit) {
								return $complete;
							}
							$complete[] = $row;
							$curElement[] = $row['ID'];
						}
					}
					if(count($complete) >= $limit) {
						return $complete;
					}
					$nextSection = CIBlockSection::GetByID($curSection)->GetNext();
					if(!empty($nextSection['IBLOCK_SECTION_ID'])) {
						$complete = findLast($nextSection['IBLOCK_SECTION_ID'], $curElement, $limit, $complete);
						return $complete;
					} else {
						return $complete;
					}
				}
				$curSection = $arResult['IBLOCK_SECTION_ID'];
				$curElement = array($arResult['ID']);
				$limit = 2;
				$last = findLast($curSection, $curElement, $limit);
			?>
			<?
			if(count($last) == 2) {
				$last_0_section = CIBlockSection::GetNavChain(2, $last[0]['IBLOCK_SECTION_ID'])->GetNext();
				if($last_0_section["ID"] == 101) {
					$last[0]['IS_EBOOK'] = 'Y';
				} else {
					$last[0]['IS_EBOOK'] = 'N';
				}
				unset($last_0_section);
				$last[0]['ADD_URL'] = $APPLICATION->GetCurUri().'&action=ADD2BASKET&id='.$last[0]['ID'];
				$last[0]['PICTURE'] = CFile::GetPath($last[0]['PREVIEW_PICTURE']);
				$last_1_section = CIBlockSection::GetNavChain(2, $last[1]['IBLOCK_SECTION_ID'])->GetNext();
				if($last_1_section["ID"] == 101) {
					$last[1]['IS_EBOOK'] = 'Y';
				} else {
					$last[1]['IS_EBOOK'] = 'N';
				}
				unset($last_1_section);
				$last[1]['ADD_URL'] = $APPLICATION->GetCurUri().'&action=ADD2BASKET&id='.$last[1]['ID'];
				$last[1]['PICTURE'] = CFile::GetPath($last[1]['PREVIEW_PICTURE']);
				?>
			<h2>Новинки раздела</h2>
				<div class="authors_book_block_list">
				<div class="news_item_block">
				<div class="news_item_block_photo">
					<img src="<?=$last[0]['PICTURE']?>" <? if($last[0]['IS_EBOOK'] == "Y") { echo 'class="news_ebook_class"'; } ?>alt="" width="120px">
					<? if($last[0]['IS_EBOOK'] == "Y") { echo '<div class="ebook_hover">EBook</div>'; } ?>
				</div>
				<div class="news_item_info">
					<div class="new_item_name">
						<?=$last[0]['NAME']?>
					</div>
					<div class="news_item_author">
						<?=$last[0]['PROPERTY_AUTOR_VALUE']?>
					</div>
					<div class="news_item_price">
						<?=$last[0]['CATALOG_PRICE_1']?>
					</div>
					<a href="/personal/basket.php?action=ADD2BASKET&id=<?=$last[0]['CATALOG_PRICE_ID_1']?>"><div class="bx_big bx_bt_button bx_cart"></div></a>
					<a href="<?=$last[0]['DETAIL_PAGE_URL']?>"><div class="detail_button sprite_detail_button"></div></a>
				</div>
				<div class="news_item_desc">
					<? if(!empty($last[0]['PREVIEW_TEXT'])) {
						if(strlen($last[0]['PREVIEW_TEXT']) > 250) {
							echo preg_replace('~^(.{1,200}).*~su', '$1', preg_replace('~<.*?>~su', '', $last[0]['PREVIEW_TEXT']));
							echo "<br><a href='".$last[0]['DETAIL_PAGE_URL']."'>Читать дальше...</a>";
						} else {
							echo $last[0]['PREVIEW_TEXT'];
						}
					} else {
						if(strlen($last[0]['DETAIL_TEXT']) > 250) {
							echo preg_replace('~^(.{1,200}).*~su', '$1', preg_replace('~<.*?>~su', '', $last[0]['DETAIL_TEXT']));
							echo "<br><a href='".$last[0]['DETAIL_PAGE_URL']."'>Читать дальше...</a>";
						} else {
							echo $last[0]['DETAIL_TEXT'];
						}
					}
					?>
				</div>
			</div>
				<div class="news_item_block news_item_block-no-margin">
				<div class="news_item_block_photo">
					<img src="<?=$last[1]['PICTURE']?>" <? if($last[1]['IS_EBOOK'] == "Y") { echo 'class="news_ebook_class"'; } ?>alt="" width="120px">
					<? if($last[1]['IS_EBOOK'] == "Y") { echo '<div class="ebook_hover">EBook</div>'; } ?>
				</div>
				<div class="news_item_info">
					<div class="new_item_name">
						<?=$last[1]['NAME']?>
					</div>
					<div class="news_item_author">
						<?=$last[1]['PROPERTY_AUTOR_VALUE']?>
					</div>
					<div class="news_item_price">
						<?=$last[1]['CATALOG_PRICE_1']?>
					</div>
					<a href="/personal/basket.php?action=ADD2BASKET&id=<?=$last[1]['CATALOG_PRICE_ID_1']?>"><div class="bx_big bx_bt_button bx_cart"></div></a>
					<a href="<?=$last[1]['DETAIL_PAGE_URL']?>"><div class="detail_button sprite_detail_button"></div></a>
				</div>
				<div class="news_item_desc">
					<? if(!empty($last[1]['PREVIEW_TEXT'])) {
						if(strlen($last[1]['PREVIEW_TEXT']) > 250) {
							echo preg_replace('~^(.{1,200}).*~su', '$1', preg_replace('~<.*?>~su', '', $last[1]['PREVIEW_TEXT']));
							echo "<br><a href='".$last[1]['DETAIL_PAGE_URL']."'>Читать дальше...</a>";
						} else {
							echo $last[1]['PREVIEW_TEXT'];
						}
					} else {
						if(strlen($last[1]['DETAIL_TEXT']) > 250) {
							echo preg_replace('~^(.{1,200}).*~su', '$1', preg_replace('~<.*?>~su', '', $last[1]['DETAIL_TEXT']));
							echo "<br><a href='".$last[1]['DETAIL_PAGE_URL']."'>Читать дальше...</a>";
						} else {
							echo $last[1]['DETAIL_TEXT'];
						}
					}
					?>
				</div>
			</div>
			</div>
			<? } ?>
			</div>
		</div>
		</div>
					
		
		<?
if (isset($arResult['OFFERS']) && !empty($arResult['OFFERS']))
{
	foreach ($arResult['JS_OFFERS'] as &$arOneJS)
	{
		if ($arOneJS['PRICE']['DISCOUNT_VALUE'] != $arOneJS['PRICE']['VALUE'])
		{
			$arOneJS['PRICE']['DISCOUNT_DIFF_PERCENT'] = -$arOneJS['PRICE']['DISCOUNT_DIFF_PERCENT'];
			$arOneJS['BASIS_PRICE']['DISCOUNT_DIFF_PERCENT'] = -$arOneJS['BASIS_PRICE']['DISCOUNT_DIFF_PERCENT'];
		}
		$strProps = '';
		if ($arResult['SHOW_OFFERS_PROPS'])
		{
			if (!empty($arOneJS['DISPLAY_PROPERTIES']))
			{
				foreach ($arOneJS['DISPLAY_PROPERTIES'] as $arOneProp)
				{
					$strProps .= '<dt>'.$arOneProp['NAME'].'</dt><dd>'.(
						is_array($arOneProp['VALUE'])
						? implode(' / ', $arOneProp['VALUE'])
						: $arOneProp['VALUE']
					).'</dd>';
				}
			}
		}
		$arOneJS['DISPLAY_PROPERTIES'] = $strProps;
	}
	if (isset($arOneJS))
		unset($arOneJS);
	$arJSParams = array(
		'CONFIG' => array(
			'USE_CATALOG' => $arResult['CATALOG'],
			'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
			'SHOW_PRICE' => true,
			'SHOW_DISCOUNT_PERCENT' => ($arParams['SHOW_DISCOUNT_PERCENT'] == 'Y'),
			'SHOW_OLD_PRICE' => ($arParams['SHOW_OLD_PRICE'] == 'Y'),
			'DISPLAY_COMPARE' => $arParams['DISPLAY_COMPARE'],
			'SHOW_SKU_PROPS' => $arResult['SHOW_OFFERS_PROPS'],
			'OFFER_GROUP' => $arResult['OFFER_GROUP'],
			'MAIN_PICTURE_MODE' => $arParams['DETAIL_PICTURE_MODE'],
			'SHOW_BASIS_PRICE' => ($arParams['SHOW_BASIS_PRICE'] == 'Y'),
			'ADD_TO_BASKET_ACTION' => $arParams['ADD_TO_BASKET_ACTION'],
			'SHOW_CLOSE_POPUP' => ($arParams['SHOW_CLOSE_POPUP'] == 'Y')
		),
		'PRODUCT_TYPE' => $arResult['CATALOG_TYPE'],
		'VISUAL' => array(
			'ID' => $arItemIDs['ID'],
		),
		'DEFAULT_PICTURE' => array(
			'PREVIEW_PICTURE' => $arResult['DEFAULT_PICTURE'],
			'DETAIL_PICTURE' => $arResult['DEFAULT_PICTURE']
		),
		'PRODUCT' => array(
			'ID' => $arResult['ID'],
			'NAME' => $arResult['~NAME']
		),
		'BASKET' => array(
			'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
			'BASKET_URL' => $arParams['BASKET_URL'],
			'SKU_PROPS' => $arResult['OFFERS_PROP_CODES'],
			'ADD_URL_TEMPLATE' => $arResult['~ADD_URL_TEMPLATE'],
			'BUY_URL_TEMPLATE' => $arResult['~BUY_URL_TEMPLATE']
		),
		'OFFERS' => $arResult['JS_OFFERS'],
		'OFFER_SELECTED' => $arResult['OFFERS_SELECTED'],
		'TREE_PROPS' => $arSkuProps
	);
	if ($arParams['DISPLAY_COMPARE'])
	{
		$arJSParams['COMPARE'] = array(
			'COMPARE_URL_TEMPLATE' => $arResult['~COMPARE_URL_TEMPLATE'],
			'COMPARE_PATH' => $arParams['COMPARE_PATH']
		);
	}
}
else
{
	$emptyProductProperties = empty($arResult['PRODUCT_PROPERTIES']);
	if ('Y' == $arParams['ADD_PROPERTIES_TO_BASKET'] && !$emptyProductProperties)
	{
?>
<div id="<? echo $arItemIDs['BASKET_PROP_DIV']; ?>" style="display: none;">
<?
		if (!empty($arResult['PRODUCT_PROPERTIES_FILL']))
		{
			foreach ($arResult['PRODUCT_PROPERTIES_FILL'] as $propID => $propInfo)
			{
?>
	<input type="hidden" name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]" value="<? echo htmlspecialcharsbx($propInfo['ID']); ?>">
<?
				if (isset($arResult['PRODUCT_PROPERTIES'][$propID]))
					unset($arResult['PRODUCT_PROPERTIES'][$propID]);
			}
		}
		$emptyProductProperties = empty($arResult['PRODUCT_PROPERTIES']);
		if (!$emptyProductProperties)
		{
?>
	<table>
<?
			foreach ($arResult['PRODUCT_PROPERTIES'] as $propID => $propInfo)
			{
?>
	<tr><td><? echo $arResult['PROPERTIES'][$propID]['NAME']; ?></td>
	<td>
<?
				if(
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
						?><option value="<? echo $valueID; ?>" <? echo ($valueID == $propInfo['SELECTED'] ? '"selected"' : ''); ?>><? echo $value; ?></option><?
					}
					?></select><?
				}
?>
	</td></tr>
<?
			}
?>
	</table>
<?
		}
?>

</div>
<?
	}
	if ($arResult['MIN_PRICE']['DISCOUNT_VALUE'] != $arResult['MIN_PRICE']['VALUE'])
	{
		$arResult['MIN_PRICE']['DISCOUNT_DIFF_PERCENT'] = -$arResult['MIN_PRICE']['DISCOUNT_DIFF_PERCENT'];
		$arResult['MIN_BASIS_PRICE']['DISCOUNT_DIFF_PERCENT'] = -$arResult['MIN_BASIS_PRICE']['DISCOUNT_DIFF_PERCENT'];
	}
	$arJSParams = array(
		'CONFIG' => array(
			'USE_CATALOG' => $arResult['CATALOG'],
			'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
			'SHOW_PRICE' => (isset($arResult['MIN_PRICE']) && !empty($arResult['MIN_PRICE']) && is_array($arResult['MIN_PRICE'])),
			'SHOW_DISCOUNT_PERCENT' => ($arParams['SHOW_DISCOUNT_PERCENT'] == 'Y'),
			'SHOW_OLD_PRICE' => ($arParams['SHOW_OLD_PRICE'] == 'Y'),
			'DISPLAY_COMPARE' => $arParams['DISPLAY_COMPARE'],
			'MAIN_PICTURE_MODE' => $arParams['DETAIL_PICTURE_MODE'],
			'SHOW_BASIS_PRICE' => ($arParams['SHOW_BASIS_PRICE'] == 'Y'),
			'ADD_TO_BASKET_ACTION' => $arParams['ADD_TO_BASKET_ACTION'],
			'SHOW_CLOSE_POPUP' => ($arParams['SHOW_CLOSE_POPUP'] == 'Y')
		),
		'VISUAL' => array(
			'ID' => $arItemIDs['ID'],
		),
		'PRODUCT_TYPE' => $arResult['CATALOG_TYPE'],
		'PRODUCT' => array(
			'ID' => $arResult['ID'],
			'PICT' => $arFirstPhoto,
			'NAME' => $arResult['~NAME'],
			'SUBSCRIPTION' => true,
			'PRICE' => $arResult['MIN_PRICE'],
			'BASIS_PRICE' => $arResult['MIN_BASIS_PRICE'],
			'SLIDER_COUNT' => $arResult['MORE_PHOTO_COUNT'],
			'SLIDER' => $arResult['MORE_PHOTO'],
			'CAN_BUY' => $arResult['CAN_BUY'],
			'CHECK_QUANTITY' => $arResult['CHECK_QUANTITY'],
			'QUANTITY_FLOAT' => is_double($arResult['CATALOG_MEASURE_RATIO']),
			'MAX_QUANTITY' => $arResult['CATALOG_QUANTITY'],
			'STEP_QUANTITY' => $arResult['CATALOG_MEASURE_RATIO'],
		),
		'BASKET' => array(
			'ADD_PROPS' => ($arParams['ADD_PROPERTIES_TO_BASKET'] == 'Y'),
			'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
			'PROPS' => $arParams['PRODUCT_PROPS_VARIABLE'],
			'EMPTY_PROPS' => $emptyProductProperties,
			'BASKET_URL' => $arParams['BASKET_URL'],
			'ADD_URL_TEMPLATE' => $arResult['~ADD_URL_TEMPLATE'],
			'BUY_URL_TEMPLATE' => $arResult['~BUY_URL_TEMPLATE']
		)
	);
	if ($arParams['DISPLAY_COMPARE'])
	{
		$arJSParams['COMPARE'] = array(
			'COMPARE_URL_TEMPLATE' => $arResult['~COMPARE_URL_TEMPLATE'],
			'COMPARE_PATH' => $arParams['COMPARE_PATH']
		);
	}
	unset($emptyProductProperties);
}
?>
<script type="text/javascript">
var <? echo $strObName; ?> = new JCCatalogElement(<? echo CUtil::PhpToJSObject($arJSParams, false, true); ?>);
BX.message({
	ECONOMY_INFO_MESSAGE: '<? echo GetMessageJS('CT_BCE_CATALOG_ECONOMY_INFO'); ?>',
	BASIS_PRICE_MESSAGE: '<? echo GetMessageJS('CT_BCE_CATALOG_MESS_BASIS_PRICE') ?>',
	TITLE_ERROR: '<? echo GetMessageJS('CT_BCE_CATALOG_TITLE_ERROR') ?>',
	TITLE_BASKET_PROPS: '<? echo GetMessageJS('CT_BCE_CATALOG_TITLE_BASKET_PROPS') ?>',
	BASKET_UNKNOWN_ERROR: '<? echo GetMessageJS('CT_BCE_CATALOG_BASKET_UNKNOWN_ERROR') ?>',
	BTN_SEND_PROPS: '<? echo GetMessageJS('CT_BCE_CATALOG_BTN_SEND_PROPS'); ?>',
	BTN_MESSAGE_BASKET_REDIRECT: '<? echo GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_BASKET_REDIRECT') ?>',
	BTN_MESSAGE_CLOSE: '<? echo GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_CLOSE'); ?>',
	BTN_MESSAGE_CLOSE_POPUP: '<? echo GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_CLOSE_POPUP'); ?>',
	TITLE_SUCCESSFUL: '<? echo GetMessageJS('CT_BCE_CATALOG_ADD_TO_BASKET_OK'); ?>',
	COMPARE_MESSAGE_OK: '<? echo GetMessageJS('CT_BCE_CATALOG_MESS_COMPARE_OK') ?>',
	COMPARE_UNKNOWN_ERROR: '<? echo GetMessageJS('CT_BCE_CATALOG_MESS_COMPARE_UNKNOWN_ERROR') ?>',
	COMPARE_TITLE: '<? echo GetMessageJS('CT_BCE_CATALOG_MESS_COMPARE_TITLE') ?>',
	BTN_MESSAGE_COMPARE_REDIRECT: '<? echo GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_COMPARE_REDIRECT') ?>',
	SITE_ID: '<? echo SITE_ID; ?>'
});
</script>
<script>
 $(function() {
 	$('.fancybox').fancybox();
 });
</script>