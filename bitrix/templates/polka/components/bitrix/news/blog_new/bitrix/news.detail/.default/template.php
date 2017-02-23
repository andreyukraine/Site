<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
	$author = CUser::GetByID($arResult['PROPERTIES']['AUTHOR']['VALUE'])->GetNext();
	$author['PHOTO'] = CFile::GetPath($author['PERSONAL_PHOTO']);
?>
<div class="bx_news_detail">
	<div class="news_list_post_header">
		<div class="news_list_header_data">
			<?if($arParams["DISPLAY_DATE"]!="N" && $arResult["DISPLAY_ACTIVE_FROM"]):?>
		    	<?=$arResult["DISPLAY_ACTIVE_FROM"]?>
		    <?endif;?>
		</div>
		<div class="news_list_header_title">
			<?if($arParams["DISPLAY_NAME"]!="N" && $arResult["NAME"]):?>
		    	<?=$arResult["NAME"]?>
		    <?endif;?>	
		</div>
	</div>
	<div class="news_list_post_author">
		<div class="news_list_post_authorphoto">
			<img src="<?=$author['PHOTO']?>" alt="" width="100%">
		</div>
		<div class="news_list_post_authorname">
			Автор <? echo $author['NAME']." ".$author['LAST_NAME']; ?>
		</div>
	</div>
	<div class="news_list_postimage">
		<?
		if(!empty($arResult['DETAIL_PICTURE'])) {
			?>
			<img src="<?=$arResult['DETAIL_PICTURE']['SRC']?>" alt="" width="100%">
			<?
		} else {
			?>
			<img src="<?=$arResult['PREVIEW_PICTURE']['SRC']?>" alt="" width="100%">
			<?
		}
		?>
	</div>
	<div class="news_list_post_article">
		<?
		if(!empty($arResult['DETAIL_TEXT'])) {
			echo $arResult['DETAIL_TEXT'];
		} else {
			echo $arResult['PREVIEW_TEXT'];
		}
		?>
	</div>
	<div class="review_header">
		<div class="review_cloud">
			<img src="/upload/pics/cloud_review.png" alt="">
		</div>
		Комментарии (<?=$arResult['PROPERTIES']['FORUM_MESSAGE_CNT']['VALUE']?>)
	</div>
</div>