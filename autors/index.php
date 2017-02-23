<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");$APPLICATION->SetTitle("Авторы"); ?>
<?
global $brandsFilter;
if(!empty($_GET['q'])) {
	$GLOBALS['brandsFilter'] = $brandsFilter = array(
		'PROPERTY_SURNAME'=>htmlspecialchars_decode(urldecode($_GET['q'])).'%',
	);
}
	$GLOBALS['brandsFilter']['PROPERTY_DISABLED'] = 0;
?>
	<div class="author_page_content col-xs-9">

		<!-- Breadcrumbs -->
		<?$APPLICATION->IncludeComponent(
			"bitrix:breadcrumb",
			"template1",
			array(
				"COMPONENT_TEMPLATE" => "template1",
				"START_FROM" => "0",
				"PATH" => "",
				"SITE_ID" => "-"
			),
			false
		);?>⁠
		<!-- END Breadcrumbs -->


		<?$APPLICATION->IncludeComponent(
	"bitrix:news", 
	"authors", 
	array(
		"COMPONENT_TEMPLATE" => "authors",
		"IBLOCK_TYPE" => "autors",
		"IBLOCK_ID" => "7",
		"NEWS_COUNT" => "20",
		"USE_SEARCH" => "N",
		"USE_RSS" => "N",
		"USE_RATING" => "N",
		"USE_CATEGORIES" => "N",
		"USE_REVIEW" => "Y",
		"USE_FILTER" => "Y",
		"FILTER_NAME" => "brandsFilter",
		"FILTER_FIELD_CODE" => array(
			0 => "NAME",
			1 => "DISABLED",
			2 => "",
		),
		"SORT_BY1" => "NAME",
		"SORT_ORDER1" => "ASC",
		"SORT_BY2" => "ID",
		"SORT_ORDER2" => "ASC",
		"CHECK_DATES" => "Y",
		"SEF_MODE" => "Y",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"CACHE_TYPE" => "N",
		"CACHE_TIME" => "36000000",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "N",
		"DISPLAY_NAME" => "Y",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "Y",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"ADD_SECTIONS_CHAIN" => "N",
		"ADD_ELEMENT_CHAIN" => "Y",
		"USE_PERMISSIONS" => "N",
		"DISPLAY_DATE" => "N",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"PREVIEW_TRUNCATE_LEN" => "250",
		"LIST_ACTIVE_DATE_FORMAT" => "d.m.Y",
		"LIST_FIELD_CODE" => array(
			0 => "ID",
			1 => "CODE",
			2 => "XML_ID",
			3 => "NAME",
			4 => "PREVIEW_TEXT",
			5 => "PREVIEW_PICTURE",
			6 => "DETAIL_TEXT",
			7 => "DETAIL_PICTURE",
			8 => "IBLOCK_ID",
			9 => "IBLOCK_CODE",
			10 => "IBLOCK_NAME",
			11 => "IBLOCK_EXTERNAL_ID",
			12 => "DISABLED",
			13 => "",
		),
		"LIST_PROPERTY_CODE" => array(
			0 => "",
			1 => "",
		),
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"META_KEYWORDS" => "-",
		"META_DESCRIPTION" => "-",
		"BROWSER_TITLE" => "NAME",
		"DETAIL_ACTIVE_DATE_FORMAT" => "d.m.Y",
		"DETAIL_FIELD_CODE" => array(
			0 => "ID",
			1 => "CODE",
			2 => "XML_ID",
			3 => "NAME",
			4 => "PREVIEW_TEXT",
			5 => "PREVIEW_PICTURE",
			6 => "DETAIL_TEXT",
			7 => "DETAIL_PICTURE",
			8 => "IBLOCK_ID",
			9 => "IBLOCK_CODE",
			10 => "IBLOCK_NAME",
			11 => "IBLOCK_EXTERNAL_ID",
			12 => "",
		),
		"DETAIL_PROPERTY_CODE" => array(
			0 => "",
			1 => "",
		),
		"DETAIL_DISPLAY_TOP_PAGER" => "N",
		"DETAIL_DISPLAY_BOTTOM_PAGER" => "Y",
		"DETAIL_PAGER_TITLE" => "Автор",
		"DETAIL_PAGER_TEMPLATE" => "",
		"DETAIL_PAGER_SHOW_ALL" => "Y",
		"PAGER_TEMPLATE" => ".default",
		"DISPLAY_TOP_PAGER" => "Y",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"PAGER_TITLE" => "Авторы",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"MAX_VOTE" => "5",
		"VOTE_NAMES" => array(
			0 => "1",
			1 => "2",
			2 => "3",
			3 => "4",
			4 => "5",
			5 => "",
		),
		"MESSAGES_PER_PAGE" => "10",
		"USE_CAPTCHA" => "Y",
		"REVIEW_AJAX_POST" => "Y",
		"PATH_TO_SMILE" => "/bitrix/images/forum/smile/",
		"FORUM_ID" => "1",
		"URL_TEMPLATES_READ" => "",
		"SHOW_LINK_TO_FORUM" => "N",
		"SEF_FOLDER" => "/",
		"FILTER_PROPERTY_CODE" => array(
			0 => "",
			1 => "",
		),
		"SEF_URL_TEMPLATES" => array(
			"news" => "autors",
			"section" => "autors/",
			"detail" => "autors/#ELEMENT_CODE#/",
		)
	),
	false
); ?>


	</div>

	<div class="clearfix"></div>

	<? //FIXME: FUCKIN makano you are idiot ?>
	</div>
	<? //FIXME: FUCKIN makano you are idiot ?>

	<div class="new_section_items">
		<div class="container">
			<div class="promocode">
			<?$APPLICATION->IncludeComponent("bitrix:main.include", "", Array(
				"AREA_FILE_SHOW" => "file",
				"PATH" => SITE_DIR."include/promocode.php"
			));?>
		</div>

			<div class="promocode_content">
			<?
			//Receiving last products from section
			function findLast($curSection, $curElement = array(), $limit = 2, $complete = array()) {
				$arrFilter = array(
					"SECTION_ID" => $curSection,
					"!ID" => $curElement,
					"!PREVIEW_PICTURE" => FALSE,
					"ACTIVE" => 'Y',
					"INCLUDE_SUBSECTIONS" => 'Y'
				);
				$result = CIBlockElement::GetList(
					array("created" => "DESC", "ID" => "DESC"),
					$arrFilter,
					false,
					array("nTopCount" => $limit),
					array(
						"PROPERTY_AUTOR",
						"NAME",
						"ID",
						"DETAIL_PAGE_URL",
						"BUY_URL",
						"CATALOG_GROUP_1",
						"PREVIEW_PICTURE",
						"PREVIEW_TEXT",
						"DETAIL_TEXT"
					)
				);
				if($result->SelectedRowsCount() > 0) {
					while($row = $result->GetNext()) {
						if(count($complete) >= $limit) {
							return $complete;
						}
						$complete[] = $row;
						$curElement[] = $row['ID'];
					}
				}
				if(count($complete) >= $limit) {
					return $complete;
				}
				$nextSection = CIBlockSection::GetByID($curSection)->GetNext();
				if(!empty($nextSection['IBLOCK_SECTION_ID'])) {
					$complete = findLast($nextSection['IBLOCK_SECTION_ID'], $curElement, $limit, $complete);
					return $complete;
				} else {
					return $complete;
				}
			}
			$curSection = 433;
			$curElement = array();
			$limit = 2;
			$last = findLast($curSection, $curElement, $limit);
			if(count($last) == 2) {
				$last[0]['ADD_URL'] = $APPLICATION->GetCurUri().'&action=ADD2BASKET&id='.$last[0]['ID'];
				$last[0]['PICTURE'] = CFile::GetPath($last[0]['PREVIEW_PICTURE']);
				$last[1]['ADD_URL'] = $APPLICATION->GetCurUri().'&action=ADD2BASKET&id='.$last[1]['ID'];
				$last[1]['PICTURE'] = CFile::GetPath($last[1]['PREVIEW_PICTURE']);
				?>
				<h2>Новинки</h2>
				<div class="authors_book_block_list row">
					<div class="col-xs-6">
						<div class="news_item_block">
							<div class="news_item_block_photo">
								<img src="<?=$last[0]['PICTURE']?>" alt="" width="120px">
							</div>
							<div class="news_item_info">
								<div class="new_item_name">
									<a href="<?=$last[0]['DETAIL_PAGE_URL']?>"><?=$last[0]['NAME']?></a>
								</div>
								<div class="news_item_author">
									<?=$last[0]['PROPERTY_AUTOR_VALUE']?>
								</div>
								<div class="news_item_price">
									<?=$last[0]['CATALOG_PRICE_1']?>
								</div>
								<a href="/personal/basket.php?action=ADD2BASKET&id=<?=$last[0]['CATALOG_PRICE_ID_1']?>"><div class="bx_big bx_bt_button bx_cart"></div></a>
								<a href="<?=$last[0]['DETAIL_PAGE_URL']?>"><div class="detail_button sprite_detail_button"></div></a>
							</div>
							<div class="news_item_desc">
								<? if(!empty($last[0]['PREVIEW_TEXT'])) {
									if(strlen($last[0]['PREVIEW_TEXT']) > 250) {
										echo substr($last[0]['PREVIEW_TEXT'], 0, 250);
										echo "<br><a href='".$last[0]['DETAIL_PAGE_URL']."'>Читать дальше...</a>";
									} else {
										echo $last[0]['PREVIEW_TEXT'];
									}
								} else {
									if(strlen($last[0]['DETAIL_TEXT']) > 250) {
										echo substr($last[0]['DETAIL_TEXT'], 0, 250);
										echo "<br><a href='".$last[0]['DETAIL_PAGE_URL']."'>Читать дальше...</a>";
									} else {
										echo $last[0]['DETAIL_TEXT'];
									}
								}
								?>
							</div>
						</div>
					</div>
					<div class="col-xs-6">
						<div class="news_item_block">
							<div class="news_item_block_photo">
								<img src="<?=$last[1]['PICTURE']?>" alt="" width="120px">
							</div>
							<div class="news_item_info">
								<div class="new_item_name">
									<a href="<?=$last[0]['DETAIL_PAGE_URL']?>"><?=$last[1]['NAME']?></a>
								</div>
								<div class="news_item_author">
									<?=$last[1]['PROPERTY_AUTOR_VALUE']?>
								</div>
								<div class="news_item_price">
									<?=$last[1]['CATALOG_PRICE_1']?>
								</div>
								<a href="/personal/basket.php?action=ADD2BASKET&id=<?=$last[1]['CATALOG_PRICE_ID_1']?>"><div class="bx_big bx_bt_button bx_cart"></div></a>
								<a href="<?=$last[1]['DETAIL_PAGE_URL']?>"><div class="detail_button sprite_detail_button"></div></a>
							</div>
							<div class="news_item_desc">
								<? if(!empty($last[1]['PREVIEW_TEXT'])) {
									if(strlen($last[1]['PREVIEW_TEXT']) > 250) {
										echo substr($last[1]['PREVIEW_TEXT'], 0, 250);
										echo "<br><a href='".$last[1]['DETAIL_PAGE_URL']."'>Читать дальше...</a>";
									} else {
										echo $last[1]['PREVIEW_TEXT'];
									}
								} else {
									if(strlen($last[1]['DETAIL_TEXT']) > 250) {
										echo substr($last[1]['DETAIL_TEXT'], 0, 250);
										echo "<br><a href='".$last[1]['DETAIL_PAGE_URL']."'>Читать дальше...</a>";
									} else {
										echo $last[1]['DETAIL_TEXT'];
									}
								}
								?>
							</div>
						</div>
					</div>
				</div>
			<? } ?>
		</div>
		</div>
	</div>

	<? //FIXME: FUCKIN makano you are idiot ?>
	<div class="container">
	<? //FIXME: FUCKIN makano yÍou are idiot ?>


<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>