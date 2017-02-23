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
// echo '<xmp>'; print_r($arResult); echo '</xmp>';
$monthes = array('Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь', );

$author = CUser::GetByID($arResult['CREATED_BY']);
$author = $author->Fetch();
if ($author['PERSONAL_PHOTO']) {
	$author['PERSONAL_PHOTO'] = CFile::ShowImage($author['PERSONAL_PHOTO'], 100, 100, "border='0'", "");
}
?>
<div class="news_list_post_header"><div class="news_list_header_title"></div>
	<p>
		<small><?php echo
			$monthes[date("m", strtotime($arResult['DATE_CREATE']))-1],
			date(" d, Y", strtotime($arResult['DATE_CREATE']));
			?></small><br>
	<span style="font-size: 20px; "><? echo (
		isset($arResult["IPROPERTY_VALUES"]["ELEMENT_PAGE_TITLE"]) && $arResult["IPROPERTY_VALUES"]["ELEMENT_PAGE_TITLE"] != ''
			? $arResult["IPROPERTY_VALUES"]["ELEMENT_PAGE_TITLE"]
			: $arResult["NAME"]
		); ?></span>
	</p>

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
			<? echo ('html' == $arResult['DETAIL_TEXT_TYPE'] ? $arResult['DETAIL_TEXT'] : '<p>'.$arResult['DETAIL_TEXT'].'</p>'); ?>
		</div>
	</td>
	<?php if(!empty($arResult['DETAIL_PICTURE']['SRC'])) { ?>
	<td>
		<div class="news_list_postimage">
			<img src="<?php echo $arResult['DETAIL_PICTURE']['SRC']; ?>" alt="">
		</div>
	</td>
	<?php } ?>
</tr></tbody></table>
<div class="comments">
	<?/*$APPLICATION->IncludeComponent("bitrix:catalog.comments", "template1", array(
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
		"VK_TITLE" => "Vk",
		"TEMPLATE_THEME" => $arParams['~TEMPLATE_THEME']
	), $component, array()); */?>
	<?$APPLICATION->IncludeComponent(
		"micros:comment",
		".default",
		array(
			"COMPONENT_TEMPLATE" => ".default",
			"COUNT" => "10",
			"ACTIVE_DATE_FORMAT" => "d.m.Y",
			"MAX_DEPTH" => "3",
			"ASNAME" => "NAME",
			"SHOW_DATE" => "N",
			"OBJECT_ID" => $arResult['ID'],
			"CAN_MODIFY" => "N",
			"JQUERY" => "N",
			"MODERATE" => "Y",
			"NON_AUTHORIZED_USER_CAN_COMMENT" => "Y",
			"USE_CAPTCHA" => "Y",
			"AUTH_PATH" => "/auth/",
			"CACHE_TYPE" => "A",
			"CACHE_TIME" => "36000000",
			"PAGER_TEMPLATE" => "pagination",
			"DISPLAY_TOP_PAGER" => "Y",
			"DISPLAY_BOTTOM_PAGER" => "Y",
			"PAGER_TITLE" => "",
			"PAGER_SHOW_ALWAYS" => "Y",
			"PAGER_DESC_NUMBERING" => "N",
			"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
			"PAGER_SHOW_ALL" => "Y"
		),
		false
	);?>
</div>