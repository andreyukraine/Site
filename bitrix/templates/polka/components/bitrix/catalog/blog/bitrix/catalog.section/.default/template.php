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
if(empty($arResult['ITEMS'])) return;

$monthes = array('Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь', );
foreach ($arResult['ITEMS'] as $key => $arItem) {
	$section = CIBlockElement::GetList(array(), array('ID' => $arItem['ID']), false, false, array('IBLOCK_SECTION_ID'))->Fetch();
	$section = $section["IBLOCK_SECTION_ID"];
	$arSections = CIBlockSection::GetNavChain(false, $section)->Fetch();
	$catalog_vars = CCatalogProduct::GetByID($arItem['ID']);
	$author = CUser::GetByID($arItem['CREATED_BY']);
	$author = $author->Fetch();
	if ($author['PERSONAL_PHOTO']) {
		$author['PERSONAL_PHOTO'] = CFile::ShowImage($author['PERSONAL_PHOTO'], 100, 100, "border='0'", "");
	}
	/*if(!empty($arParams['DOP_PROPS']) 
		&& $arItem['PROPERTIES'][$arParams['DOP_PROPS']]['VALUE'] != str_replace('+', ' ', $arParams['SEARCH'])) continue;*/

	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], $strElementEdit);
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], $strElementDelete, $arElementDeleteParams);
	$strMainID = $this->GetEditAreaId($arItem['ID']);
?>
<div class="news_list_post_header"><div class="news_list_header_title"></div>
	<a href="<?php echo $arItem['DETAIL_PAGE_URL']; ?>">
		<small><?php echo 
			$monthes[date("m", strtotime($arItem['DATE_CREATE']))-1], 
			date(" d, Y", strtotime($arItem['DATE_CREATE'])); 
		?></small><br>
		<div style="font-size: 20px; "><? echo (
			isset($arItem["IPROPERTY_VALUES"]["ELEMENT_PAGE_TITLE"]) && $arItem["IPROPERTY_VALUES"]["ELEMENT_PAGE_TITLE"] != ''
			? $arItem["IPROPERTY_VALUES"]["ELEMENT_PAGE_TITLE"]
			: $arItem["NAME"]
		); ?></div>
	</a>
</div>
<table class="news-element-table"><tbody><tr>
	<td>
		<div class="news-autor">
			<?php if(!empty($author['PERSONAL_PHOTO'])) { ?>
			<div class="author-photo">
				<img src="<?php echo $author['PERSONAL_PHOTO']; ?>" alt="">
			</div>
			<?php } ?>
			<div class="author-name">Автор: <?php echo $author['NAME'], ' ', $author['LAST_NAME']; ?></div>
			<?php
			// echo '<xmp>'; print_r($author); echo '</xmp>'; ?>
		</div>
		<div class="desc">
			<? echo ('html' == $arItem['PREVIEW_TEXT_TYPE'] ? $arItem['PREVIEW_TEXT'] : '<p>'.$arItem['PREVIEW_TEXT'].'</p>'); ?>
		</div>
	</td>
	<?php if(!empty($arItem['PREVIEW_PICTURE']['SRC'])) { ?>
	<td>
		<div class="news_list_postimage">
			<img src="<?php echo $arItem['PREVIEW_PICTURE']['SRC']; ?>" alt="">
		</div>
	</td>
	<?php } ?>
</tr></tbody></table>
<?php } ?>