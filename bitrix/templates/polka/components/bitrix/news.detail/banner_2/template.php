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

?>
<div class="second_banner">
	<? if(!empty($arResult['DISPLAY_PICTURE']['linkkk']['VALUE'])) {
		?>
		<a href="<? echo $arResult['PROPERTIES']['linkkk']['VALUE'];?>">
			<img src="<? echo $arResult['DETAIL_PICTURE']['SRC'];?>" alt="">
		</a>
		<?
	} else {
		?>
		<img src="<? echo $arResult['DETAIL_PICTURE']['SRC'];?>" alt="">
		<?
	} ?>
</div>