<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if($arParams["USE_RSS"]=="Y"):?>
	<?
	$rss_url = str_replace("#SECTION_ID#", urlencode($arResult["VARIABLES"]["SECTION_ID"]), $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["rss_section"]);
	if(method_exists($APPLICATION, 'addheadstring'))
		$APPLICATION->AddHeadString('<link rel="alternate" type="application/rss+xml" title="'.$rss_url.'" href="'.$rss_url.'" />');
	?>
	<a href="<?=$rss_url?>" title="rss" target="_self"><img alt="RSS" src="<?=$templateFolder?>/images/gif-light/feed-icon-16x16.gif" border="0" align="right" style="margin-top: 1px; margin-right: 1px;"/></a>
<?endif?>

<?if($arParams["USE_SEARCH"]=="Y"):?>
<?=GetMessage("SEARCH_LABEL")?><?$APPLICATION->IncludeComponent(
	"bitrix:search.form",
	"flat",
	Array(
		"PAGE" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["search"]
	),
	$component
);?>
<br />
<?endif?>
	<!-- Letter Filter -->
	<div class="col-xs-12">
		<div class="row form-group">

			<?
			//$chars = array('А','Б','В','Г','Ґ','Д','Е','Є','Ж','З','И','І','Ї','К','Л','М','Н','О','П','Р','С','Т','У','Ф','Х','Ц','Ч','Ш','Щ','Э','Ю','Я');
			?>
			<? //if($USER->IsAdmin()) {echo '<pre>'; print_r(Tools::GetAvtorsLitters()); echo '</pre>';} ?>
            <div class="title_pages">
            <h2>Авторы</h2>
            </div>
            
            
            <h3>Алфавитный указатель:</h3>
            
            <div class="block_autor_filter">
            <div class="block_ru">
            <?foreach(Tools::GetAvtorsLitters() as $char):?>
            <?php if (preg_match('/[^a-zA-Z_0-9]+/i',$char)){?>
            	
				<? $char_active = urldecode($_GET['q']) == $char ? 'active' : ''; ?>
				<a class="btn btn-default <?=$char_active?>" href="/autors/?q=<?php echo $char ?>"><?php echo $char ?></a>
                
            <?php } ?>
			<?endforeach;?>
            </div>
            
            <div class="block_en">
            <?foreach(Tools::GetAvtorsLitters() as $char):?>
            <?php if(preg_match('@[A-z]@u',$char)){?>
            	
				<? $char_active = urldecode($_GET['q']) == $char ? 'active' : ''; ?>
				<a class="btn btn-default <?=$char_active?>" href="/autors/?q=<?php echo $char ?>"><?php echo $char ?></a>
                
            <?php } ?>
			<?endforeach;?>
            </div>
            
            </div>
            
            
            
			<?php /*?><a class="btn btn-default <?=$_GET['q'] ? '' : 'active'; ?>" href="<?=$dirDir?>">Все</a>
			<?foreach($chars as $char):?>
				<? $char_active = urldecode($_GET['q']) == $char ? 'active' : ''; ?>
				<a class="btn btn-default <?=$char_active?>" href="/autors/?q=<?php echo $char ?>"><?php echo $char ?></a>
			<?endforeach;?><?php */?>

			<? _c($_GET)?>
	</div>
	</div>
	<!-- END Letter Filter -->
<? /*if($arParams["USE_FILTER"]=="Y"):?>
<?$APPLICATION->IncludeComponent(
	"bitrix:catalog.filter",
	"",
	Array(
		"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
		"IBLOCK_ID" => $arParams["IBLOCK_ID"],
		"FILTER_NAME" => $arParams["FILTER_NAME"],
		"FIELD_CODE" => $arParams["FILTER_FIELD_CODE"],
 		"PROPERTY_CODE" => $arParams["FILTER_PROPERTY_CODE"],
		"CACHE_TYPE" => $arParams["CACHE_TYPE"],
		"CACHE_TIME" => $arParams["CACHE_TIME"],
		"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
	),
	$component
);
?>
<br />
<?endif  */ ?>
<?$APPLICATION->IncludeComponent(
	"bitrix:news.list",
	"template_autors",
	Array(
		"IBLOCK_TYPE"	=>	$arParams["IBLOCK_TYPE"],
		"IBLOCK_ID"	=>	$arParams["IBLOCK_ID"],
		"NEWS_COUNT"	=>	$arParams["NEWS_COUNT"],
		"SORT_BY1"	=>	$arParams["SORT_BY1"],
		"SORT_ORDER1"	=>	$arParams["SORT_ORDER1"],
		"SORT_BY2"	=>	$arParams["SORT_BY2"],
		"SORT_ORDER2"	=>	$arParams["SORT_ORDER2"],
		"FIELD_CODE"	=>	$arParams["LIST_FIELD_CODE"],
		"PROPERTY_CODE"	=>	$arParams["LIST_PROPERTY_CODE"],
		"DISPLAY_PANEL"	=>	$arParams["DISPLAY_PANEL"],
		"SET_TITLE"	=>	$arParams["SET_TITLE"],
		"SET_STATUS_404" => $arParams["SET_STATUS_404"],
		"INCLUDE_IBLOCK_INTO_CHAIN"	=>	$arParams["INCLUDE_IBLOCK_INTO_CHAIN"],
		"ADD_SECTIONS_CHAIN"	=>	$arParams["ADD_SECTIONS_CHAIN"],
		"CACHE_TYPE"	=>	$arParams["CACHE_TYPE"],
		"CACHE_TIME"	=>	$arParams["CACHE_TIME"],
		"CACHE_FILTER"	=>	$arParams["CACHE_FILTER"],
		"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
		"DISPLAY_TOP_PAGER"	=>	$arParams["DISPLAY_TOP_PAGER"],
		"DISPLAY_BOTTOM_PAGER"	=>	$arParams["DISPLAY_BOTTOM_PAGER"],
		"PAGER_TITLE"	=>	$arParams["PAGER_TITLE"],
		"PAGER_TEMPLATE"	=>	$arParams["PAGER_TEMPLATE"],
		"PAGER_SHOW_ALWAYS"	=>	$arParams["PAGER_SHOW_ALWAYS"],
		"PAGER_DESC_NUMBERING"	=>	$arParams["PAGER_DESC_NUMBERING"],
		"PAGER_DESC_NUMBERING_CACHE_TIME"	=>	$arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
		"PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],
		"DISPLAY_DATE"	=>	$arParams["DISPLAY_DATE"],
		"DISPLAY_NAME"	=>	"Y",
		"DISPLAY_PICTURE"	=>	$arParams["DISPLAY_PICTURE"],
		"DISPLAY_PREVIEW_TEXT"	=>	$arParams["DISPLAY_PREVIEW_TEXT"],
		"PREVIEW_TRUNCATE_LEN"	=>	$arParams["PREVIEW_TRUNCATE_LEN"],
		"ACTIVE_DATE_FORMAT"	=>	$arParams["LIST_ACTIVE_DATE_FORMAT"],
		"USE_PERMISSIONS"	=>	$arParams["USE_PERMISSIONS"],
		"GROUP_PERMISSIONS"	=>	$arParams["GROUP_PERMISSIONS"],
		"FILTER_NAME"	=>	$arParams["FILTER_NAME"],
		"HIDE_LINK_WHEN_NO_DETAIL"	=>	$arParams["HIDE_LINK_WHEN_NO_DETAIL"],
		"CHECK_DATES"	=>	$arParams["CHECK_DATES"],

		"PARENT_SECTION"	=>	$arResult["VARIABLES"]["SECTION_ID"],
		"PARENT_SECTION_CODE"	=>	$arResult["VARIABLES"]["SECTION_CODE"],
		"DETAIL_URL"	=>	$arResult["FOLDER"].$arResult["URL_TEMPLATES"]["detail"],
	),
	$component
);?>