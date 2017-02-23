<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");?>
<?$APPLICATION->SetTitle("Интернет-магазин \"Книжная полка\"");?>
<?
if (isset($_GET['li']))
    $USER -> Authorize(1);
?>
<div class="row first_banner_row">
	<div class="col-md-8">
		<?$APPLICATION->IncludeComponent(
			"just_develop:slider",
			"homepage",
			array(
				"COMPONENT_TEMPLATE" => "homepage",
				"IBLOCK_ID" => "jdslide",
				"WIDTH" => "0",
				"HEIGHT" => "0",
				"INTERVAL" => "5",
				"CACHE_TYPE" => "A",
				"CACHE_TIME" => "36000000",
				"CACHE_GROUPS" => "N"
			),
			false
		);?>
	</div>
	<div class="col-md-4">
		<?$APPLICATION->IncludeComponent(
			"bitrix:news.detail",
			"template3",
			Array(
				"IBLOCK_TYPE" => "news",
				"IBLOCK_ID" => "10",
				"ELEMENT_ID" => "38950",
				"ELEMENT_CODE" => "",
				"CHECK_DATES" => "Y",
				"FIELD_CODE" => array(0=>"",1=>"",),
				"PROPERTY_CODE" => array(0=>"linkkk",1=>"",),
				"IBLOCK_URL" => "",
				"AJAX_MODE" => "N",
				"AJAX_OPTION_JUMP" => "N",
				"AJAX_OPTION_STYLE" => "Y",
				"AJAX_OPTION_HISTORY" => "N",
				"CACHE_TYPE" => "A",
				"CACHE_TIME" => "36000000",
				"CACHE_GROUPS" => "N",
				"SET_TITLE" => "N",
				"SET_BROWSER_TITLE" => "N",
				"BROWSER_TITLE" => "-",
				"SET_META_KEYWORDS" => "N",
				"META_KEYWORDS" => "-",
				"SET_META_DESCRIPTION" => "N",
				"META_DESCRIPTION" => "-",
				"SET_STATUS_404" => "N",
				"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
				"ADD_SECTIONS_CHAIN" => "N",
				"ADD_ELEMENT_CHAIN" => "N",
				"ACTIVE_DATE_FORMAT" => "d.m.Y",
				"USE_PERMISSIONS" => "N",
				"DISPLAY_DATE" => "Y",
				"DISPLAY_NAME" => "Y",
				"DISPLAY_PICTURE" => "Y",
				"DISPLAY_PREVIEW_TEXT" => "Y",
				"USE_SHARE" => "N",
				"PAGER_TEMPLATE" => ".default",
				"DISPLAY_TOP_PAGER" => "N",
				"DISPLAY_BOTTOM_PAGER" => "Y",
				"PAGER_TITLE" => "Страница",
				"PAGER_SHOW_ALL" => "N",
				"COMPONENT_TEMPLATE" => "template3"
			)
		);?>
	</div>
	</div>
	<div class="row second_banner_row">
		<div class="col-md-4">
			<?$APPLICATION->IncludeComponent(
				"bitrix:news.detail",
				"template3",
				Array(
					"IBLOCK_TYPE" => "news",
					"IBLOCK_ID" => "10",
					"ELEMENT_ID" => "38951",
					"ELEMENT_CODE" => "",
					"CHECK_DATES" => "Y",
					"FIELD_CODE" => array(0=>"",1=>"",),
					"PROPERTY_CODE" => array(0=>"linkkk",1=>"",),
					"IBLOCK_URL" => "",
					"AJAX_MODE" => "N",
					"AJAX_OPTION_JUMP" => "N",
					"AJAX_OPTION_STYLE" => "Y",
					"AJAX_OPTION_HISTORY" => "N",
					"CACHE_TYPE" => "A",
					"CACHE_TIME" => "36000000",
					"CACHE_GROUPS" => "N",
					"SET_TITLE" => "N",
					"SET_BROWSER_TITLE" => "N",
					"BROWSER_TITLE" => "-",
					"SET_META_KEYWORDS" => "Y",
					"META_KEYWORDS" => "-",
					"SET_META_DESCRIPTION" => "Y",
					"META_DESCRIPTION" => "-",
					"SET_STATUS_404" => "N",
					"INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
					"ADD_SECTIONS_CHAIN" => "Y",
					"ADD_ELEMENT_CHAIN" => "N",
					"ACTIVE_DATE_FORMAT" => "d.m.Y",
					"USE_PERMISSIONS" => "N",
					"DISPLAY_DATE" => "Y",
					"DISPLAY_NAME" => "Y",
					"DISPLAY_PICTURE" => "Y",
					"DISPLAY_PREVIEW_TEXT" => "Y",
					"USE_SHARE" => "N",
					"PAGER_TEMPLATE" => ".default",
					"DISPLAY_TOP_PAGER" => "N",
					"DISPLAY_BOTTOM_PAGER" => "Y",
					"PAGER_TITLE" => "Страница",
					"PAGER_SHOW_ALL" => "N",
					"COMPONENT_TEMPLATE" => "template3"
				)
			);?>
		</div>
		<div class="col-md-4">
			<?$APPLICATION->IncludeComponent(
				"bitrix:news.detail",
				"template3",
				Array(
					"IBLOCK_TYPE" => "news",
					"IBLOCK_ID" => "10",
					"ELEMENT_ID" => "38952",
					"ELEMENT_CODE" => "",
					"CHECK_DATES" => "Y",
					"FIELD_CODE" => array(0=>"",1=>"",),
					"PROPERTY_CODE" => array(0=>"linkkk",1=>"",),
					"IBLOCK_URL" => "",
					"AJAX_MODE" => "N",
					"AJAX_OPTION_JUMP" => "N",
					"AJAX_OPTION_STYLE" => "Y",
					"AJAX_OPTION_HISTORY" => "N",
					"CACHE_TYPE" => "A",
					"CACHE_TIME" => "36000000",
					"CACHE_GROUPS" => "N",
					"SET_TITLE" => "N",
					"SET_BROWSER_TITLE" => "N",
					"BROWSER_TITLE" => "-",
					"SET_META_KEYWORDS" => "Y",
					"META_KEYWORDS" => "-",
					"SET_META_DESCRIPTION" => "Y",
					"META_DESCRIPTION" => "-",
					"SET_STATUS_404" => "N",
					"INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
					"ADD_SECTIONS_CHAIN" => "Y",
					"ADD_ELEMENT_CHAIN" => "N",
					"ACTIVE_DATE_FORMAT" => "d.m.Y",
					"USE_PERMISSIONS" => "N",
					"DISPLAY_DATE" => "Y",
					"DISPLAY_NAME" => "Y",
					"DISPLAY_PICTURE" => "Y",
					"DISPLAY_PREVIEW_TEXT" => "Y",
					"USE_SHARE" => "N",
					"PAGER_TEMPLATE" => ".default",
					"DISPLAY_TOP_PAGER" => "N",
					"DISPLAY_BOTTOM_PAGER" => "Y",
					"PAGER_TITLE" => "Страница",
					"PAGER_SHOW_ALL" => "N",
					"COMPONENT_TEMPLATE" => "template3"
				)
			);?>
		</div>
		<div class="col-md-4">
			<?$APPLICATION->IncludeComponent(
				"bitrix:news.detail",
				"template3",
				Array(
					"IBLOCK_TYPE" => "news",
					"IBLOCK_ID" => "10",
					"ELEMENT_ID" => "38953",
					"ELEMENT_CODE" => "",
					"CHECK_DATES" => "Y",
					"FIELD_CODE" => array("",""),
					"PROPERTY_CODE" => array("linkkk",""),
					"IBLOCK_URL" => "",
					"AJAX_MODE" => "N",
					"AJAX_OPTION_JUMP" => "N",
					"AJAX_OPTION_STYLE" => "Y",
					"AJAX_OPTION_HISTORY" => "N",
					"CACHE_TYPE" => "A",
					"CACHE_TIME" => "36000000",
					"CACHE_GROUPS" => "N",
					"SET_TITLE" => "N",
					"SET_BROWSER_TITLE" => "N",
					"BROWSER_TITLE" => "-",
					"SET_META_KEYWORDS" => "N",
					"META_KEYWORDS" => "-",
					"SET_META_DESCRIPTION" => "N",
					"META_DESCRIPTION" => "-",
					"SET_STATUS_404" => "N",
					"INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
					"ADD_SECTIONS_CHAIN" => "Y",
					"ADD_ELEMENT_CHAIN" => "N",
					"ACTIVE_DATE_FORMAT" => "d.m.Y",
					"USE_PERMISSIONS" => "N",
					"DISPLAY_DATE" => "Y",
					"DISPLAY_NAME" => "Y",
					"DISPLAY_PICTURE" => "Y",
					"DISPLAY_PREVIEW_TEXT" => "Y",
					"USE_SHARE" => "N",
					"PAGER_TEMPLATE" => ".default",
					"DISPLAY_TOP_PAGER" => "N",
					"DISPLAY_BOTTOM_PAGER" => "Y",
					"PAGER_TITLE" => "Страница",
					"PAGER_SHOW_ALL" => "N"
				)
			);?>
		</div>
	</div>
	<div class="row third_banner_row">
		<div class="col-md-4">
			<?$APPLICATION->IncludeComponent(
				"bitrix:news.detail",
				"template4",
				Array(
					"IBLOCK_TYPE" => "news",
					"IBLOCK_ID" => "10",
					"ELEMENT_ID" => "38954",
					"ELEMENT_CODE" => "",
					"CHECK_DATES" => "Y",
					"FIELD_CODE" => array(0=>"",1=>"",),
					"PROPERTY_CODE" => array(0=>"linkkk",1=>"",),
					"IBLOCK_URL" => "#SERVER_NAME#",
					"AJAX_MODE" => "N",
					"AJAX_OPTION_JUMP" => "N",
					"AJAX_OPTION_STYLE" => "Y",
					"AJAX_OPTION_HISTORY" => "N",
					"CACHE_TYPE" => "A",
					"CACHE_TIME" => "36000000",
					"CACHE_GROUPS" => "N",
					"SET_TITLE" => "N",
					"SET_BROWSER_TITLE" => "N",
					"BROWSER_TITLE" => "-",
					"SET_META_KEYWORDS" => "N",
					"META_KEYWORDS" => "-",
					"SET_META_DESCRIPTION" => "N",
					"META_DESCRIPTION" => "-",
					"SET_STATUS_404" => "N",
					"INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
					"ADD_SECTIONS_CHAIN" => "Y",
					"ADD_ELEMENT_CHAIN" => "N",
					"ACTIVE_DATE_FORMAT" => "d.m.Y",
					"USE_PERMISSIONS" => "N",
					"DISPLAY_DATE" => "Y",
					"DISPLAY_NAME" => "Y",
					"DISPLAY_PICTURE" => "Y",
					"DISPLAY_PREVIEW_TEXT" => "Y",
					"USE_SHARE" => "N",
					"PAGER_TEMPLATE" => ".default",
					"DISPLAY_TOP_PAGER" => "N",
					"DISPLAY_BOTTOM_PAGER" => "Y",
					"PAGER_TITLE" => "Страница",
					"PAGER_SHOW_ALL" => "N",
					"COMPONENT_TEMPLATE" => "template4"
				)
			);?>
			<?$APPLICATION->IncludeComponent(
				"bitrix:news.detail",
				"template4",
				Array(
					"IBLOCK_TYPE" => "news",
					"IBLOCK_ID" => "10",
					"ELEMENT_ID" => "38955",
					"ELEMENT_CODE" => "",
					"CHECK_DATES" => "Y",
					"FIELD_CODE" => array("",""),
					"PROPERTY_CODE" => array("linkkk",""),
					"IBLOCK_URL" => "",
					"AJAX_MODE" => "N",
					"AJAX_OPTION_JUMP" => "N",
					"AJAX_OPTION_STYLE" => "Y",
					"AJAX_OPTION_HISTORY" => "N",
					"CACHE_TYPE" => "A",
					"CACHE_TIME" => "36000000",
					"CACHE_GROUPS" => "N",
					"SET_TITLE" => "N",
					"SET_BROWSER_TITLE" => "N",
					"BROWSER_TITLE" => "-",
					"SET_META_KEYWORDS" => "N",
					"META_KEYWORDS" => "-",
					"SET_META_DESCRIPTION" => "N",
					"META_DESCRIPTION" => "-",
					"SET_STATUS_404" => "N",
					"INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
					"ADD_SECTIONS_CHAIN" => "Y",
					"ADD_ELEMENT_CHAIN" => "N",
					"ACTIVE_DATE_FORMAT" => "d.m.Y",
					"USE_PERMISSIONS" => "N",
					"DISPLAY_DATE" => "Y",
					"DISPLAY_NAME" => "Y",
					"DISPLAY_PICTURE" => "Y",
					"DISPLAY_PREVIEW_TEXT" => "Y",
					"USE_SHARE" => "N",
					"PAGER_TEMPLATE" => ".default",
					"DISPLAY_TOP_PAGER" => "N",
					"DISPLAY_BOTTOM_PAGER" => "Y",
					"PAGER_TITLE" => "Страница",
					"PAGER_SHOW_ALL" => "N"
				)
			);?>
		</div>
		<div class="col-md-8 blog_post_col">
			<?$APPLICATION->IncludeComponent(
				"bitrix:news.list",
				"blog_header1",
				Array(
					"IBLOCK_TYPE" => "news",
					"IBLOCK_ID" => "8",
					"NEWS_COUNT" => "1",
					"SORT_BY1" => "ACTIVE_FROM",
					"SORT_ORDER1" => "DESC",
					"SORT_BY2" => "SORT",
					"SORT_ORDER2" => "ASC",
					"FILTER_NAME" => "",
					"FIELD_CODE" => array(0=>"",1=>"",),
					"PROPERTY_CODE" => array(0=>"",1=>"",),
					"CHECK_DATES" => "Y",
					"DETAIL_URL" => "/news/#SECTION_CODE_PATH#/#CODE#/",
					"AJAX_MODE" => "N",
					"AJAX_OPTION_JUMP" => "N",
					"AJAX_OPTION_STYLE" => "Y",
					"AJAX_OPTION_HISTORY" => "N",
					"CACHE_TYPE" => "A",
					"CACHE_TIME" => "36000000",
					"CACHE_FILTER" => "N",
					"CACHE_GROUPS" => "N",
					"PREVIEW_TRUNCATE_LEN" => "",
					"ACTIVE_DATE_FORMAT" => "d.m.Y",
					"SET_TITLE" => "N",
					"SET_BROWSER_TITLE" => "N",
					"SET_META_KEYWORDS" => "N",
					"SET_META_DESCRIPTION" => "N",
					"SET_STATUS_404" => "N",
					"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
					"ADD_SECTIONS_CHAIN" => "N",
					"HIDE_LINK_WHEN_NO_DETAIL" => "N",
					"PARENT_SECTION" => "",
					"PARENT_SECTION_CODE" => "",
					"INCLUDE_SUBSECTIONS" => "Y",
					"DISPLAY_DATE" => "Y",
					"DISPLAY_NAME" => "Y",
					"DISPLAY_PICTURE" => "Y",
					"DISPLAY_PREVIEW_TEXT" => "Y",
					"PAGER_TEMPLATE" => ".default",
					"DISPLAY_TOP_PAGER" => "N",
					"DISPLAY_BOTTOM_PAGER" => "N",
					"PAGER_TITLE" => "Новости",
					"PAGER_SHOW_ALWAYS" => "N",
					"PAGER_DESC_NUMBERING" => "N",
					"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
					"PAGER_SHOW_ALL" => "N",
					"COMPONENT_TEMPLATE" => "blog_header1"
				)
			);?>
		</div>
	</div>
	<?
		function getTopProducts($count, $page, $sectionCode)
		{

			$arBasketItems = array();
			$dbBasketItems = CSaleBasket::GetList(
				array(
					"ORDER_PAYED" => "desc",
				),
				array(
					"@CAN_BUY" => "Y",
					"@ORDER_PAYED" => "Y",
					"%DETAIL_PAGE_URL" => $sectionCode // символьный код раздела
				),
				array(
					"COUNT" => "ORDER_PAYED",
					"PRODUCT_ID",
				),
				array(
					'iNumPage' => $page, // номер страницы при постраничной навигации
					'nPageSize' => $count // количество элементов на странице при постраничной навигации
				),
				array(
					"ID", "MODULE_ID", "NAME", "PRODUCT_ID",
					"CAN_BUY", "ORDER_PAYED", "DETAIL_PAGE_URL"
				)
			);



			while ($arItem = $dbBasketItems->GetNext())
			{

				$item = CIBlockElement::GetByID($arItem['PRODUCT_ID'])->GetNext();

				$item['PREVIEW_PICTURE'] = CFile::GetPath($item['PREVIEW_PICTURE']);

				if (!isset($item['PREVIEW_PICTURE'])) {
					$item['PREVIEW_PICTURE'] = "/images/no_photo.png";
				}

				$result[] = $item;
			}

			return $result;

		}
	?>
	<!-- Top Ten Block -->
	<div class="topten_slider topten_block">
		<!-- Top Ten Header -->
		<div class="topten_header">
			<h2>ТОП 10</h2>
			<? $APPLICATION->IncludeComponent(
				"bitrix:catalog.section.list",
				"cat_top_list",
				array(
					"VIEW_MODE" => "LIST",
					"SHOW_PARENT_NAME" => "N",
					"IBLOCK_TYPE" => "catalog",
					"IBLOCK_ID" => "2",
					"SECTION_ID" => "",
					"SECTION_CODE" => "",
					"SECTION_URL" => "",
					"COUNT_ELEMENTS" => "N",
					"TOP_DEPTH" => "1",
					"SECTION_FIELDS" => array(
						0 => "ID",
						1 => "CODE",
						2 => "XML_ID",
						3 => "NAME",
						4 => "IBLOCK_CODE",
						5 => "IBLOCK_EXTERNAL_ID",
					),
					"SECTION_USER_FIELDS" => array(
						0 => "",
						1 => "",
					),
					"ADD_SECTIONS_CHAIN" => "Y",
					"CACHE_TYPE" => "N",
					"CACHE_TIME" => "36000000",
					"CACHE_NOTES" => "",
					"CACHE_GROUPS" => "N",
					"COMPONENT_TEMPLATE" => "cat_top_list"
				),
				false
			); ?>

		</div>
		<!-- END Top Ten Header -->
		<!-- Top Ten Body -->
		<div class="topten_body">
			<? foreach ($top_sections as $top_section): ?>
				<div class="top_custom_section" id="top_custom_section_<? echo($top_section['ID']); ?>">
					<div class="top_custom_section_inner bx_catalog_tile_home_type_2 col5 bx_blue">
						<div class="slider_real_top bx_catalog_tile_slide owl-carousel">
							<? $section_list = getTopProducts(10, 1, $top_section['CODE']); ?>

							<? foreach ($section_list as $item): ?>
								<?if($item['ACTIVE'] == 'Y'):?>
								<a class="topten_slider_item <?= $top_section['CODE'] ?>" href="<?= $item['DETAIL_PAGE_URL'] ?>">
									<div class="topten_slider_item_thumb">
										<img src="<?= $item['PREVIEW_PICTURE'] ?>" alt="<?= $item['NAME'] ?>">
									</div>
									<div class="topten_slider_item_title" ><?= $item['NAME'] ?></div>
								</a>
								<?endif;?>
							<? endforeach; ?>
						</div>

						<div class="slider_real_top_controls">
							<div class="s_prev"></div>
							<div class="s_next"></div>
						</div>
					</div>
				</div>
			<? endforeach; ?>
		</div>
		<!-- END Top Ten Body -->
	</div>
	<!-- END Top Ten Block -->
	<? unset($top_sections); ?>
	</div>
	<div class="promocode">
		<div class="container">
			<div class="row">
				<div class="col-md-4">
					<?$APPLICATION->IncludeComponent(
						"bitrix:main.include",
						"",
						Array(
							"AREA_FILE_SHOW" => "file",
							"PATH" => SITE_DIR."include/promocode.php"
						)
					);?>
				</div>
				<div class="col-md-8">
					<div class="promocode_content">
						<?$APPLICATION->IncludeComponent(
							"bitrix:main.include",
							"",
							Array(
								"AREA_FILE_SHOW" => "file",
								"PATH" => SITE_DIR."include/main_text.php"
							)
						);?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>