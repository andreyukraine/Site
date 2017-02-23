<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?
if (count($arResult["ITEMS"]) < 1)
	return;
?>
<h2>Блог</h2>

<?foreach($arResult["ITEMS"] as $arItem):?>
<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('NEWS_ELEMENT_DELETE_CONFIRM')));
	$author = CUser::GetByID($arItem['PROPERTIES']['AUTHOR']['VALUE'])->GetNext();
	$author['PHOTO'] = CFile::GetPath($author['PERSONAL_PHOTO']);
?>
<div class="blog_post_item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
	<div class="blog_post_item_header">
		<?if($arParams["DISPLAY_DATE"]!="N" && $arItem["DISPLAY_ACTIVE_FROM"]):?>
			<div class="blog_post_item_header_data">
				<?echo $arItem["DISPLAY_ACTIVE_FROM"]?>
			</div>
		<?endif?>
		<?if($arParams["DISPLAY_NAME"]!="N" && $arItem["NAME"]):?>
			<div class="blog_post_item_header_title">
				<?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || $arResult["USER_HAVE_ACCESS"]):?>
					<a href="<?echo $arItem["DETAIL_PAGE_URL"]?>"><?echo $arItem["NAME"]?></a>
				<?else:?>
					<?echo $arItem["NAME"]?>
				<?endif;?>
			</div>
		<?endif;?>
	</div>
	<div class="blog_post_item_content">
		<div class="blog_post_item_author_info">
			<div class="blog_post_item_author_photo">
				<img src="<?=$author['PHOTO']?>" alt="" width="100%">
			</div>
			<div class="blog_post_item_author_name">
				<? echo $author['NAME']." ".$author['LAST_NAME']; ?>
			</div>
		</div>
		<?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arItem["PREVIEW_TEXT"]):?>
		<div class="blog_post_item_text">
			<p><?echo $arItem["PREVIEW_TEXT"];?></p>
		</div>
		<?endif;?>
	</div>
	<div class="blog_post_item_content_photo">
		<?
		if(!empty($arItem['PREVIEW_PICTURE'])) {
			?>
			<img src="<?=$arItem['PREVIEW_PICTURE']['SRC']?>" alt="" width="100%">
			<?
		} else {
			?>
			<img src="<?=$arItem['DETAIL_PICTURE']['SRC']?>" alt="" width="100%">
			<?
		}
		?>
	</div>
	<div class="blog_post_item_footer">
		<div class="blog_post_item_footer_comments">
			<a href="<?=$arItem['DETAIL_PAGE_URL']?>"><img src="/upload/pics/cloud_review.png" alt="">Комментарии (<? echo (!empty($arItem['PROPERTIES']['FORUM_MESSAGE_CNT']['VALUE']))?$arItem['PROPERTIES']['FORUM_MESSAGE_CNT']['VALUE']:0 ?>)</a>
		</div>
		<div class="blog_post_item_footer_plus">
			<a href="<?=$arItem['DETAIL_PAGE_URL']?>"><img src="/upload/pics/footer_plus.png" alt="">Читать дальше</a>
		</div>
	</div>
</div>
<?endforeach;?>
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<?=$arResult["NAV_STRING"]?>
<?endif;?>