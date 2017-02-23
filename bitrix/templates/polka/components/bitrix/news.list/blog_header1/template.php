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


<div class="blog_post">
	<?foreach($arResult["ITEMS"] as $arItem) {
		$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
	<div class="news-item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
		<?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])){?>
		<div class="blog_post_header">
			<button class="blog_button">
				<p>Блог</p>
			</button>
			<div class="blog_header_info">
				<div class="blog_post_data">
					<?if($arParams["DISPLAY_DATE"]!="N" && $arItem["DISPLAY_ACTIVE_FROM"]):?>
					<span class="news-date-time"><?echo $arItem["DISPLAY_ACTIVE_FROM"]?></span>
					<?endif?>
				</div>
				<h2>
					<a href="<?echo $arItem["DETAIL_PAGE_URL"]?>"><b><?echo $arItem["NAME"]?></b></a>
				</h2>
			</div>
		</div>
		<div class="blog_photo">
			<a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><img
				class="preview_picture"
				border="0"
				src="<?php echo $arItem["PREVIEW_PICTURE"]["SRC"]?$arItem["PREVIEW_PICTURE"]["SRC"]:$arItem["DETAIL_PICTURE"]["SRC"]; ?>"
				width="150"
				alt="<?=$arItem["PREVIEW_PICTURE"]["ALT"]?>"
				title="<?=$arItem["PREVIEW_PICTURE"]["TITLE"]?>"
				style="float:left"/>
			</a>
		</div>
		<div class="blog_description">
			<?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arItem["PREVIEW_TEXT"]){?>
				<?echo $arItem["PREVIEW_TEXT"];?>
				<? } else if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arItem["DETAIL_TEXT"]) { ?>
				<?php echo preg_replace('~^(.{1,300}).*$~su', '$1', preg_replace('~<.*?>~su', '', $arItem['DETAIL_TEXT'])); ?>
			<?php } ?>
		</div>
		<? } else { ?>
		<img 
			class="preview_picture"
			border="0"
			src="<?php echo $arItem["PREVIEW_PICTURE"]["SRC"]?$arItem["PREVIEW_PICTURE"]["SRC"]:$arItem["DETAIL_PICTURE"]["SRC"]; ?>"
			width="150"
			alt="<?=$arItem["PREVIEW_PICTURE"]["ALT"]?>"
			title="<?=$arItem["PREVIEW_PICTURE"]["TITLE"]?>"
			style="float:left"
			/>
		<? } ?>
		<div class="blog_post_footer">
			<a href="<?echo $arItem["DETAIL_PAGE_URL"]?>">
				<img src="<?=SITE_TEMPLATE_PATH . '/images/plus_link.png'?>" alt="">Читать дальше
			</a>
		</div>
		<div class="blog_post_footer_strait">
			
		</div>
		<?if($arParams["DISPLAY_NAME"]!="N" && $arItem["NAME"]){ ?>
		<?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])) { ?>
		<br />
		<? } else { ?>
		<br />
		<? } ?>
		<? } ?>
		
		<?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arItem["PREVIEW_PICTURE"])):?>
			<div style="clear:both"></div>
		<?endif?>
		<?foreach($arItem["FIELDS"] as $code=>$value):?>
			<small>
			<?=GetMessage("IBLOCK_FIELD_".$code)?>:&nbsp;<?=$value;?>
			</small><br />
		<?endforeach;?>
		<?foreach($arItem["DISPLAY_PROPERTIES"] as $pid=>$arProperty):?>
			<small>
			<?=$arProperty["NAME"]?>:&nbsp;
			<?if(is_array($arProperty["DISPLAY_VALUE"])):?>
				<?=implode("&nbsp;/&nbsp;", $arProperty["DISPLAY_VALUE"]);?>
			<?else:?>
				<?=$arProperty["DISPLAY_VALUE"];?>
			<?endif?>
			</small><br />
		<?endforeach;?>
	</div>
<? } ?>
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<br /><?=$arResult["NAV_STRING"]?>
<?endif;?>
</div>


