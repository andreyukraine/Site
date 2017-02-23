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
<div class="slider">
	<div id="homepage-slider" class="owl-carousel owl-theme">
		<?foreach ($arResult['ITEMS'] as $arItem):?>
		<div class="item">
			<a href="<?=$arItem['LINK']?>">
				<img src="<?=$arItem['PICT']['SRC']?>">
			</a>
		</div>
		<?endforeach;?>
	</div>
</div>