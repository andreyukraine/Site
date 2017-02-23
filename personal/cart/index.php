<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Корзина");

if(CModule::IncludeModule("catalog")) {
	if($_REQUEST['action'] == 'ADD2BASKET' && !empty($_REQUEST['id'])) {
		$price = CPrice::GetByID($_REQUEST['id']);
		//var_dump($price);
		if(!empty($price) && $price['CAN_BUY'] == 'Y') {
			$product = CIBlockElement::GetByID($price['PRODUCT_ID'])->GetNext();
			$trade = CCatalogProduct::GetByID($price['PRODUCT_ID']);
			$arFields = array(
					"PRODUCT_ID" => $price['PRODUCT_ID'],
					"PRODUCT_PRICE_ID" => $price['ID'],
					"PRICE" => $price['PRICE'],
					"CURRENCY" => $price['CURRENCY'],
					"LID" => "s1",
					"NAME" => $product['NAME'],
					"DELAY" => 'N',
					"QUANTITY" => 1,
					"CAN_BUY" => 'Y',
					"WEIGHT" => $trade['WEIGHT']
				);
			CSaleBasket::Add($arFields);
			LocalRedirect("/personal/basket.php");
		} else {
			echo "<p class='error'>Выбраный товар не существует либо недоступен.</p>";
		}
	}
}
?>
<?/*
<div class="basket_page">
	<div class="basket_page_breadcrumbs">
		<span>Главная страница </span>
		<span> Корзина </span>
	</div>
	<h2>Корзина</h2>
	<div class="basket_block">
		<div class="basket_block_header">
			<span class="basket_block_header_item">Товары</span>
			<span class="basket_block_header_discount">Скидка</span>
			<span class="basket_block_header_weight">Вес</span>
			<span class="basket_block_header_price">Цена</span>
			<span class="basket_block_header_quantity">Количество</span>
			<span class="basket_block_header_sum">Сумма</span>
		</div>
		<div class="basket_block_cart">
			<div class="basket_block_cart_item">
				<div class="basket_block_cart_item_photo">
					<img src="http://lorempixel.com/70/54" alt="">
				</div>
				<div class="basket_block_cart_item_text">
					Lorem ipsum
				</div>
			</div>	
			<div class="basket_block_cart_discount">
				15%
			</div>
			<div class="basket_block_cart_wight">
				0,5 кг
			</div>
			<div class="basket_block_cart_price">
				55 грн
			</div>
			<div class="basket_block_cart_quantity">
				<input type="text">
				<div class="trash_icon"></div>
				
			</div>
			<div class="basket_block_cart_sum">
				54 грн
			</div>
			<div class="basket_block_cart_postponed_button">
				<button>Отложить</button>
			</div>
		</div>
		<div class="basket_block_cart">
			<div class="basket_block_cart_item">
				<div class="basket_block_cart_item_photo">
					<img src="http://lorempixel.com/70/54" alt="">
				</div>
				<div class="basket_block_cart_item_text">
					Lorem ipsum
				</div>
			</div>	
			<div class="basket_block_cart_discount">
				15%
			</div>
			<div class="basket_block_cart_wight">
				0,5 кг
			</div>
			<div class="basket_block_cart_price">
				55 грн
			</div>
			<div class="basket_block_cart_quantity">
				<input type="text">
				<div class="trash_icon"></div>
				
			</div>
			<div class="basket_block_cart_sum">
				54 грн
			</div>
			<div class="basket_block_cart_postponed_button">
				<button>Отложить</button>
			</div>
		</div>
		<div class="basket_block_cart">
			<div class="basket_block_cart_item">
				<div class="basket_block_cart_item_photo">
					<img src="http://lorempixel.com/70/54" alt="">
				</div>
				<div class="basket_block_cart_item_text">
					Lorem ipsum
				</div>
			</div>	
			<div class="basket_block_cart_discount">
				15%
			</div>
			<div class="basket_block_cart_wight">
				0,5 кг
			</div>
			<div class="basket_block_cart_price">
				55 грн
			</div>
			<div class="basket_block_cart_quantity">
				<input type="text">
				<div class="trash_icon"></div>
				
			</div>
			<div class="basket_block_cart_sum">
				54 грн
			</div>
			<div class="basket_block_cart_postponed_button">
				<button>Отложить</button>
			</div>
		</div>	
	</div>
	<div class="basket_block_cart_promocode">
		Промо-код является идентификатором персональной скидки или бонуса, на 
		получение которых имеют право: покупатели, имеющие пластиковые дисконтные 
		карточки (введите цифры, указанные на карточке) участники рекламных акций в СМ?#65533; 
		(введите промо-код, указанный в рекламе) победители различных конкурсов,
		проводимых нашими партнерами (введите индивидуальный промо-код, полученый по электронной почте)
		<input type="text">
	</div>
	<div class="basket_block_cart_fullinfo">
		<div class="basket_block_cart_fullinfo_weight">Общий вес: 0.85 кг</div>
		<div class="basket_block_cart_fullinfo_price">Товара на: 263.00 грн</div>
		<div class="basket_block_cart_fullinfo_nds">В том числе НДС: 0.00</div>
		<div class="basket_block_cart_fullinfo_sum">Итого: 263.00 грн</div>
	</div>
	<div class="basket_block_cart_bottom_buttons">
		<a href=""><div class="basket_block_cart_back">
			
		</div></a>
		<a href=""><div class="basket_block_cart_forward">
			
		</div></a>
	</div>
</div>
*/?>
		<div class="basket_page">
			<div class="basket_page_breadcrumbs">
				<a href="/"><span>Главная страница </span></a>
				<span> Корзина </span>
			</div>
			
			<?$APPLICATION->IncludeComponent(
	"bitrix:sale.basket.basket", 
	"newmark", 
	array(
		"COUNT_DISCOUNT_4_ALL_QUANTITY" => "N",
		"COLUMNS_LIST" => array(
			0 => "NAME",
			1 => "DISCOUNT",
			2 => "WEIGHT",
			3 => "PROPS",
			4 => "DELETE",
			5 => "DELAY",
			6 => "PRICE",
			7 => "QUANTITY",
			8 => "SUM",
		),
		"AJAX_MODE" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"PATH_TO_ORDER" => "/personal/order/make/",
		"HIDE_COUPON" => "N",
		"QUANTITY_FLOAT" => "N",
		"PRICE_VAT_SHOW_VALUE" => "Y",
		"SET_TITLE" => "Y",
		"AJAX_OPTION_ADDITIONAL" => "",
		"OFFERS_PROPS" => array(
			0 => "SIZES_SHOES",
			1 => "SIZES_CLOTHES",
			2 => "COLOR_REF",
		),
		"COMPONENT_TEMPLATE" => "newmark",
		"USE_PREPAYMENT" => "N",
		"ACTION_VARIABLE" => "action"
	),
	false
);?>
			
		</div>
		<div class="clearfix"></div>
	</div>
</div>
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
						array(
							"created" => "DESC",
							"ID" => "DESC"
							),
						$arrFilter,
						false,
						array(
							"nTopCount" => $limit
							),
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
			?>
			<?
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
									<a href="<?php echo $last[0]['DETAIL_PAGE_URL'] ?>">
										<?=$last[0]['NAME']?>
									</a>
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
									<a href="<?php echo $last[1]['DETAIL_PAGE_URL'] ?>">
										<?=$last[1]['NAME']?>
									</a>
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
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>