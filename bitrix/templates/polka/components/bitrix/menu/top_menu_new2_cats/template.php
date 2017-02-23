<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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
if (empty($arResult))
	return;
?>
<ul class="top_menu2_list">
<?foreach($arResult as $itemIdex => $arItem):?>
	<a href="<?=$arItem["LINK"]?>">
		<li class="col-xs-2">
			<span class="sprite sprite-<?=$arItem['PARAMS']['icon']?>"></span>
			<span class="link_name"><?=$arItem["TEXT"]?></span>
		</li>
	</a>
<?endforeach;?>
</ul>