<?
	if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
	if (count($arResult["ITEMS"]) < 1) return;
?>



<div class="col-xs-12">
	<?foreach($arResult["ITEMS"] as $arItem){
		$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('NEWS_ELEMENT_DELETE_CONFIRM')));
	?>
	<div class="block_autt col-xs-6">
		<div class="author_list_item_photo">
			<? if(!empty($arItem['PREVIEW_PICTURE'])) { ?>
			<img src="<?=$arItem['PREVIEW_PICTURE']['SRC']?>" alt="" width="100%">
			<? } else if(!empty($arItem['DETAIL_PICTURE'])) { ?>
			<img src="<?=$arItem['DETAIL_PICTURE']['SRC']?>" alt="" width="100%">
			<? } ?>
		</div>
		<?if($arParams["DISPLAY_NAME"]!="N" && $arItem["NAME"]){?>
			<h3>
			<?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || $arResult["USER_HAVE_ACCESS"]){?>
				<a href="<?echo $arItem["DETAIL_PAGE_URL"]?>"><?echo $arItem["NAME"]?></a>
			<? } else { ?>
				<?echo $arItem["NAME"]?>
			<? } ?>
			</h3>
		<? } ?>
		<div class="author_list_desc">
			<?
			if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arItem["PREVIEW_TEXT"]) {
				echo $arItem["PREVIEW_TEXT"];
			}
			echo substr( $arItem["DETAIL_TEXT"] , 0, 100 )."...";
			?>
		</div>
		<a href="<?echo $arItem["DETAIL_PAGE_URL"]?>"><div class="detail_button sprite_detail_button"></div></a>
	</div>
	<? } ?>
</div>





<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<?=$arResult["NAV_STRING"]?>
<?endif;?>