<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Оформление заказа");?>
<div class="order_page">
	<div class="order_page_breadcrumbs">
		<a href="/"><span>Главная страница</span></a>
		<?
		if($USER->IsAuthorized()) {
			?>
				<a href="/personal/"><span>Мой кабинет</span></a>
				<a href="/personal/order"><span>Мои заказы</span></a>
			<?
		}
		?>
	</div>
	<h2><?=$APPLICATION->GetTitle()?></h2>
	<h3>Информация для оплаты и доставки заказа</h3>
	<?$APPLICATION->IncludeComponent(
	"bitrix:sale.order.ajax", 
	"template1", 
	array(
		"PAY_FROM_ACCOUNT" => "Y",
		"COUNT_DELIVERY_TAX" => "N",
		"COUNT_DISCOUNT_4_ALL_QUANTITY" => "N",
		"ONLY_FULL_PAY_FROM_ACCOUNT" => "N",
		"ALLOW_AUTO_REGISTER" => "Y",
		"SEND_NEW_USER_NOTIFY" => "Y",
		"DELIVERY_NO_AJAX" => "N",
		"TEMPLATE_LOCATION" => "popup",
		"PROP_1" => array(
		),
		"PATH_TO_BASKET" => "/personal/cart/",
		"PATH_TO_PERSONAL" => "/personal/order/",
		"PATH_TO_PAYMENT" => "/personal/order/payment/",
		"PATH_TO_ORDER" => "/personal/order/make/",
		"SET_TITLE" => "Y",
		"DELIVERY2PAY_SYSTEM" => "",
		"SHOW_ACCOUNT_NUMBER" => "Y",
		"COMPONENT_TEMPLATE" => "template1",
		"DELIVERY_NO_SESSION" => "N",
		"DELIVERY_TO_PAYSYSTEM" => "d2p",
		"USE_PREPAYMENT" => "N",
		"PROP_3" => array(
		),
		"PROP_2" => array(
		),
		"ALLOW_NEW_PROFILE" => "Y",
		"SHOW_PAYMENT_SERVICES_NAMES" => "Y",
		"SHOW_STORES_IMAGES" => "N",
		"PATH_TO_AUTH" => "/auth/",
		"DISABLE_BASKET_REDIRECT" => "N",
		"PRODUCT_COLUMNS" => array(
			0 => "WEIGHT_FORMATED",
		),
		"PROP_4" => array(
		)
	),
	false
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
	<div class="order_page_payment_choose">
		<h2>Платежная система</h2>
		<div class="payment_choose_row_first">
			<div class="payment_choose_item">
				<div class="payment_choose_item_logo">
					
				</div>
				<input type="radio">Payment
			</div>
			<div class="payment_choose_item">
				<div class="payment_choose_item_logo">
					
				</div>
				<input type="radio">Payment
			</div>
			<div class="payment_choose_item">
				<div class="payment_choose_item_logo">
					
				</div>
				<input type="radio">Payment
			</div>
			<div class="payment_choose_item">
				<div class="payment_choose_item_logo">
					
				</div>
				<input type="radio">Payment
			</div>
		</div>	
		<div class="payment_choose_row">
			<div class="payment_choose_item">
				<div class="payment_choose_item_logo">
					
				</div>
				<input type="radio">Payment
			</div>
			<div class="payment_choose_item">
				<div class="payment_choose_item_logo">
					
				</div>
				<input type="radio">Payment
			</div>
			<div class="payment_choose_item">
				<div class="payment_choose_item_logo">
					
				</div>
				<input type="radio">Payment
			</div>
			<div class="payment_choose_item">
				<div class="payment_choose_item_logo">
					
				</div>
				<input type="radio">Payment
			</div>
		</div>	
		<h2>Товары в заказе</h2>
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
	</div>	
	<div class="basket_block_cart_fullinfo">
		<div class="basket_block_cart_fullinfo_weight">Общий вес: 0.85 кг</div>
		<div class="basket_block_cart_fullinfo_price">Товара на: 263.00 грн</div>
		<div class="basket_block_cart_fullinfo_nds">В том числе НДС: 0.00</div>
		<div class="basket_block_cart_fullinfo_sum">Итого: 263.00 грн</div>
	</div>
	<div class="order_page_review">
		<h2>Комментарии к заказу</h2>
		<input type="text">
	</div>
	<div class="basket_block_cart_forward">
			
		</div>
	</div>
</div>
*/
?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>