<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Заказы");
?>
<div class="order_page">
	<div class="order_page_breadcrumbs">
		<a href="/"><span>Главная страница</span></a>
		<a href="/personal"><span>Мой кабинет</span></a>
		<span>Мои заказы</span>
	</div>
	<?$APPLICATION->IncludeComponent("newmark:isale.keys.list", "", Array(
	
	),
	false
);?>

	<?$APPLICATION->IncludeComponent(
		"bitrix:sale.personal.order",
		"",
		Array(
			"SEF_MODE" => "Y",
			"SEF_FOLDER" => "/personal/order/",
			"ORDERS_PER_PAGE" => "10",
			"PATH_TO_PAYMENT" => "/personal/order/payment/",
			"PATH_TO_BASKET" => "/personal/cart/",
			"SET_TITLE" => "Y",
			"SAVE_IN_SESSION" => "N",
			"NAV_TEMPLATE" => "arrows",
			"SEF_URL_TEMPLATES" => array("list"=>"index.php","detail"=>"detail/#ID#/","cancel"=>"cancel/#ID#/",),
			"SHOW_ACCOUNT_NUMBER" => "Y",
			"VARIABLE_ALIASES" => Array(),
			"VARIABLE_ALIASES" => Array(
			)
		)
	);?>
</div>
<?/*
<div class="order_page">
	<div class="order_page_breadcrumbs">
		<span>Главная страница</span>
		<span>Мой кабинет</span>
		<span>Мои заказы</span>
	</div>
	<h2>Оформление заказа</h2>
	<h3>Информация для оплаты и доставки заказа</h3>
	<div class="order_page_inputs">
		<h2>Информация о покупателе</h2>
		<div class="order_page_input_name">
			Имя <span class="order_page_star">*</span> 
			<input type="text">
		</div>
		<div class="order_page_input_second_name">
			Отчество <span class="order_page_star">*</span> 
			<input type="text">
		</div>
		<div class="order_page_input_surname">
			Фамиля <span class="order_page_star">*</span> 
			<input type="text">
		</div>
		<div class="order_page_input_state">
			Область/Штат <span class="order_page_star">*</span> 
			<input type="text">
		</div>
		<div class="order_page_input_email">
			E-mail <span class="order_page_star">*</span> 
			<input type="text">
		</div>
		<div class="order_page_input_phone">
			Телефон <span class="order_page_star">*</span> 
			<input type="text">
		</div>
		<div class="order_page_input_index">
			Индекс <span class="order_page_star">*</span> 
			<input type="text">
		</div>
		<div class="order_page_input_city">
			Город/Страна <span class="order_page_star">*</span> 
			<input type="text">
		</div>
		<div class="order_page_input_adress">
			Адресс доставки <span class="order_page_star">*</span> 
			<input type="text">
		</div>
	</div>
</div>
</div>
</div>
<div class="new_section_items">
			<div class="container">
	<div class="promocode">
		<div class="promocode_input">
				<h3>Промо-Код</h3>
				<input type="text" placeholder="введите промо-код">
				<button>OK</button>
				<div class="promocode_description">
					Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ea, cumque, soluta. Nihil quisquam beatae ipsam laboriosam vel blanditiis nobis. Non, facilis fugit nisi laudantium Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ea, cumque, soluta. Nihil quisquam beatae ipsam laboriosam vel blanditiis nobis. Non id numquam exercitationem, aspernatur aliquid veniam.
				</div>
			</div>
		</div>
		<div class="promocode_content">
			<h2>Раздел</h2>
				<div class="authors_book_block_list">
				<div class="news_item_block">
				<div class="news_item_block_photo">
					<img src="http://lorempixel.com/100/150/" alt="">
				</div>
				<div class="news_item_info">
					<div class="new_item_name">
						Lorem Ipsum
					</div>
					<div class="news_item_author">
						dolor sit amet
					</div>
					<div class="news_item_price">
						57,00 грн
					</div>
					<div class="bx_big bx_bt_button bx_cart"></div>
					<div class="detail_button sprite_detail_button"></div>
				</div>
				<div class="news_item_desc">
					Lorem ipsum dolor sit amet, consectetur adipisicing elit. Tenetur ullam dicta iusto excepturi optio asperiores,
					 deserunt earum, facilis laudantium Lorem ipsum dolor sit amet, consectetur adipisicing elit. <a href="#">Читать дальше...</a>
				</div>
			</div>
				<div class="news_item_block news_item_block-no-margin">
				<div class="news_item_block_photo">
					<img src="http://lorempixel.com/100/150/" alt="">
				</div>
				<div class="news_item_info">
					<div class="new_item_name">
						Lorem Ipsum
					</div>
					<div class="news_item_author">
						dolor sit amet
					</div>
					<div class="news_item_price">
						57,00 грн
					</div>
					<div class="bx_big bx_bt_button bx_cart"></div>
					<div class="detail_button sprite_detail_button"></div>
				</div>
				<div class="news_item_desc">
					Lorem ipsum dolor sit amet, consectetur adipisicing elit. Tenetur ullam dicta iusto excepturi optio asperiores,
					 deserunt earum, facilis laudantium Lorem ipsum dolor sit amet, consectetur adipisicing elit. <a href="#">Читать дальше...</a>
				</div>
			</div>
			</div>
			</div>
		</div>
		</div>
*/?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>