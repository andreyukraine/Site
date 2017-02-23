<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/**
 * @global CMain $APPLICATION
 * @global CUser $USER
 */

$dirDir     = $APPLICATION->GetCurDir();
$curPage    = $APPLICATION->GetCurPage(true);
$homepage   = $APPLICATION->GetCurDir() == '/' ? true : false;
$assets     = \Bitrix\Main\Page\Asset::getInstance();
$messages   = \Bitrix\Main\Localization\Loc::loadMessages('header.php');

if(!isset($_COOKIE['SHOW_EMPTY'])) {
	setcookie("SHOW_EMPTY", 'Y', 0, '/');
	$_COOKIE['SHOW_EMPTY'] = 'Y';
}

if(isset($_POST['coupon_sb'])) {
	if(empty($_POST['coupon_sb'])) {
		unset($_SESSION['CATALOG_USER_COUPONS']);
		echo "Вы отменили купон. Для применения введите его снова";
	}
	else if(CModule::IncludeModule("catalog")) {
		$cps = CCatalogDiscount::GetList(array(), array('COUPON' => $_POST['coupon_sb']));
		if($cps->SelectedRowsCount() > 0) {
			$rst = $cps->GetNext();
			if(CCatalogDiscountCoupon::SetCoupon($rst['COUPON'])) {
				echo 'Промо-код добавлен. Ваша скидка составляет '.$rst['NAME'];
			} else {
				echo "Купон правильный, но произошла ошибка. Обратитесь к администрации!";
			}
		} else {
			echo "Неправильный купон.";
		}
	} else {
		echo "Неизвестная ошибка. Обратитесь к администрации!";
	}
	die();
}

// FIXME: WHAT IS THAT? YOU ARE IDIOT MAKANO!!!!!
include_once $_SERVER["DOCUMENT_ROOT"] . '/makano/geoip/geoip.inc';
$gi = geoip_open($_SERVER["DOCUMENT_ROOT"] ."/makano/geoip/GeoIP.dat", GEOIP_STANDARD);
$country = geoip_country_code_by_addr($gi, $_SERVER['REMOTE_ADDR']);
//echo '<xmp>Страна: '; print_r($country); echo "</xmp>";

if( empty($_COOKIE['currency']) and !isset($_COOKIE['currency']) ){

	if(in_array($country, array('AT','AL','AD','BY','BE','BG','BA','VA','GB','HU','DE','GG','GI','NL','GR','DK','JE','IE','IS','ES','IT','XK','LV','LT','LI','LU','MT','MD','MC','NO','IM','PL','PT','MK','RU','RO','SM','RS','SK','SI','FO','FI','FR','HR','ME','CZ','CH','SE','SJ','AX','EE')))
		$_COOKIE['currency'] = 'EUR';
	else if(in_array($country, array('US','BM','GT','HN','GL','CA','CR','CU','MX','NI','CP','PA','PM','AI','AG','AR','AW','BS','BB','BZ','BO','BR','VG','VE','VI','HT','GY','GP','GD','DO','DM','KY','CO','MQ','MS','AN','TC','MF','PY','PE','PR','BL','VC','KN','LC','SR','TT','UY','FK','GF','CL','EC','SV','JM')))
		$_COOKIE['currency'] = 'USD';
	else if(in_array($country, array('RU')))
		$_COOKIE['currency'] = 'RUB';
	else $_COOKIE['currency'] = 'UAH';

}
// if $current_currency != 3 && $current_currency != 11}<span class="big">+1 (503) <span class="big">308-9541</span></span>

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?=LANGUAGE_ID?>" lang="<?=LANGUAGE_ID?>">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0, width=device-width">
	<meta http-equiv="Content-Type" content="text/html; charset=<?= LANG_CHARSET ?>">

	<link rel="shortcut icon" type="image/x-icon" href="<?=SITE_DIR?>favicon.ico" />
	<?

	$APPLICATION->addHeadString('<link href="//fonts.googleapis.com/css?family=Cuprum:400,700&amp;subset=cyrillic,latin" rel="stylesheet" type="text/css">');
	$APPLICATION->addHeadString("<style>@font-face{font-family: 'Cuprum', sans-serif;}</style>");

	$assets->addCss(SITE_TEMPLATE_PATH . '/bootstrap.min.css');
	$assets->addCss(SITE_TEMPLATE_PATH . '/bootstrap-theme.min.css');
	$assets->addCss(SITE_TEMPLATE_PATH . '/fancybox/jquery.fancybox.css');
	$assets->addCss(SITE_TEMPLATE_PATH . "/assets/vendor/owl-carousel/owl.carousel.css");
	$assets->addCss(SITE_TEMPLATE_PATH . "/assets/vendor/owl-carousel/owl.transitions.css");


	\CJSCore::Init(array('core', 'ajax', 'window', 'fx'));
	$assets->addJs(SITE_TEMPLATE_PATH . '/jquery.min.js');
	$assets->addJs(SITE_TEMPLATE_PATH . '/bootstrap.min.js');
	$assets->addJs(SITE_TEMPLATE_PATH . '/fancybox/jquery.fancybox.pack.js');
	$assets->addJs(SITE_TEMPLATE_PATH . '/script.js');
	$assets->addJs(SITE_TEMPLATE_PATH . "/assets/vendor/owl-carousel/owl.carousel.js");


	$APPLICATION->ShowMeta("robots", false);
	$APPLICATION->ShowMeta("keywords", false);
	$APPLICATION->ShowMeta("description", false);
	$APPLICATION->ShowCSS(true);
	$APPLICATION->ShowHeadStrings();
	$APPLICATION->ShowHeadScripts();

	?>

	<title><?$APPLICATION->ShowTitle(); ?></title>
</head>
<body>

	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

	  ga('create', 'UA-83877407-1', 'auto');
	  ga('send', 'pageview');
	</script>

	<div id="panel"><?$APPLICATION->ShowPanel();?></div>

	<div class="wrap" id="bx_eshop_wrap">

		<div class="container">
			<a href="#0" class="cd-top">Top</a>
			<div class="col-xs-12 header_background">
				<div class="row">
					<div class="col-xs-10 header_block_left">
						<div class="row header_upper_row">
						<div class="header_phone">
							<span class="sprite sprite-phone"></span><span class="header_phone_text">
								<?
									if(in_array($_COOKIE['currency'], array("USD", "EUR"))) {
										$APPLICATION->IncludeComponent("bitrix:main.include", "", array("AREA_FILE_SHOW" => "file", "PATH" => SITE_DIR."include/header_phone_us.php"), false);
									} else {
										$APPLICATION->IncludeComponent("bitrix:main.include", "", array("AREA_FILE_SHOW" => "file", "PATH" => SITE_DIR."include/header_phone.php"), false);
									}
								?>
							</span>
						</div>
						<div class="header_social">
							<?$APPLICATION->IncludeComponent("bitrix:main.include", "", array("AREA_FILE_SHOW" => "file", "PATH" => SITE_DIR."include/header_social.php"), false);?>
						</div>
						<div class="login-reg">
							<?$APPLICATION->IncludeComponent("bitrix:system.auth.form", "new_polka", array(
								"REGISTER_URL" => SITE_DIR."login/",
								"PROFILE_URL" => SITE_DIR."personal/",
								"SHOW_ERRORS" => "N"
							), false, array());?>
						</div>
						<div class="siteh">
							<a class="btn-support" onclick="o=window.open;o('https://siteheart.com/webconsultation/319735?', 'siteheart_sitewindow_319735', 'width=550,height=400,top=30,left=30,resizable=yes'); return false;">
								<span class="sprite sprite-chat"></span><span class="header_link">on-line поддержка</span>
							</a>
						</div>
						<div class="currencies">
							<?$APPLICATION->IncludeComponent("ace-group:monedas", "custom", array(
								"PATH_TO_CUR" => "/bitrix/components/ace-group/monedas/script/change_currency.php"
							), false, array("ACTIVE_COMPONENT" => "Y")); ?>
						</div>
						<div class="clearfix"></div>
						</div>
						<div class="clearfix"></div>
						<div class="row header_bottom_row">
							<div class="col-xs-4">
								<a href="/">
									<img src="<?= SITE_TEMPLATE_PATH . '/images/new_logo.png' ?>" alt="Polka" width="100%" />
								</a>
							</div>
							<div class="col-xs-8 header_bottom_row_navigation">
								<div class="search_block">
									<?$APPLICATION->IncludeComponent(
	"bitrix:search.title", 
	"new_search", 
	array(
		"CATEGORY_0" => array(
			0 => "iblock_catalog",
		),
		"CATEGORY_0_iblock_catalog" => array(
			0 => "all",
		),
		"CATEGORY_0_TITLE" => GetMessage("SEARCH_GOODS"),
		"CATEGORY_OTHERS_TITLE" => GetMessage("SEARCH_OTHER"),
		"CHECK_DATES" => "N",
		"CONTAINER_ID" => "search",
		"CONVERT_CURRENCY" => "Y",
		"INPUT_ID" => "title-search-input",
		"NUM_CATEGORIES" => "1",
		"PAGE" => SITE_DIR."catalog/",
		"PREVIEW_HEIGHT" => "75",
		"PREVIEW_WIDTH" => "75",
		"PRICE_CODE" => array(
			0 => "BASE",
		),
		"SHOW_INPUT" => "Y",
		"SHOW_OTHERS" => "N",
		"SHOW_PREVIEW" => "Y",
		"TOP_COUNT" => "5",
		"COMPONENT_TEMPLATE" => "new_search",
		"ORDER" => "date",
		"USE_LANGUAGE_GUESS" => "Y",
		"PRICE_VAT_INCLUDE" => "Y",
		"PREVIEW_TRUNCATE_LEN" => "",
		"CURRENCY_ID" => "UAH"
	),
	false
);?>
								</div>
								<div class="top_menu_new1">
									<?$APPLICATION->IncludeComponent(
										"bitrix:menu",
										"top_menu_new1",
										array(
											"ROOT_MENU_TYPE" => "top",
											"MENU_CACHE_TYPE" => "N",
											"MENU_CACHE_TIME" => "36000000",
											"MENU_CACHE_USE_GROUPS" => "N",
											"MENU_CACHE_GET_VARS" => array(
											),
											"MAX_LEVEL" => "1",
											"USE_EXT" => "N",
											"ALLOW_MULTI_SELECT" => "N",
											"COMPONENT_TEMPLATE" => "top_menu_new1",
											"CHILD_MENU_TYPE" => "left",
											"DELAY" => "N"
										),
										false
									); ?>
								</div>
							</div>
							<div class="clearfix"></div>
						</div>
					</div>
					<div class="col-xs-2 header_cart_block">
						<?$APPLICATION->IncludeComponent("bitrix:sale.basket.basket.line", "new_basket", Array(
							"PATH_TO_BASKET" => "/personal/basket.php",	// Страница корзины
							"PATH_TO_PERSONAL" => "/personal/",	// Страница персонального раздела
							"SHOW_PERSONAL_LINK" => "N",	// Отображать персональный раздел
							"SHOW_NUM_PRODUCTS" => "Y",	// Показывать количество товаров
							"SHOW_TOTAL_PRICE" => "Y",	// Показывать общую сумму по товарам
							"SHOW_EMPTY_VALUES" => "Y",	// Выводить нулевые значения в пустой корзине
							"SHOW_PRODUCTS" => "Y",	// Показывать список товаров
							"POSITION_FIXED" => "N",	// Отображать корзину поверх шаблона
							"POSITION_HORIZONTAL" => "right",
							"POSITION_VERTICAL" => "top",
							"PATH_TO_ORDER" => SITE_DIR."personal/order/",	// Страница оформления заказа
							"SHOW_DELAY" => "Y",	// Показывать отложенные товары
							"SHOW_NOTAVAIL" => "Y",	// Показывать товары, недоступные для покупки
							"SHOW_SUBSCRIBE" => "Y",	// Показывать товары, на которые подписан покупатель
							"SHOW_IMAGE" => "Y",	// Выводить картинку товара
							"SHOW_PRICE" => "Y",	// Выводить цену товара
							"SHOW_SUMMARY" => "Y",	// Выводить подытог по строке
							"COMPONENT_TEMPLATE" => "template1",
							"SHOW_AUTHOR" => "N",	// Добавить возможность авторизации
							"PATH_TO_REGISTER" => SITE_DIR."login/",	// Страница регистрации
							"PATH_TO_PROFILE" => SITE_DIR."personal/",	// Страница профиля
							"BUY_URL_SIGN" => "action=ADD2BASKET"
						), false);?>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
			<div class="clearfix"></div>
			<div class="col-xs-12 header_line"></div>
			<div class="clearfix"></div>
			<div class="col-xs-12 header_menu2_block<?php if($APPLICATION->GetCurPage(true) != '/index.php') { echo ' top_menu_categories'; } else { echo ' top-menu'; } ?>">
				<?php if($APPLICATION->GetCurPage(true) != '/index.php') { ?>
				<?$APPLICATION->IncludeComponent(
						"bitrix:menu",
						"top_menu_new2_cats",
						array(
							"ROOT_MENU_TYPE" => "top2",
							"MENU_CACHE_TYPE" => "N",
							"MENU_CACHE_TIME" => "36000000",
							"MENU_CACHE_USE_GROUPS" => "N",
							"MENU_CACHE_GET_VARS" => array(
							),
							"MAX_LEVEL" => "1",
							"USE_EXT" => "N",
							"ALLOW_MULTI_SELECT" => "N",
							"COMPONENT_TEMPLATE" => "top_menu_new2_cats",
							"CHILD_MENU_TYPE" => "left",
							"DELAY" => "N"
						),
						false
					); ?>
				<? } else { ?>
				<? $APPLICATION->IncludeComponent(
						"bitrix:menu",
						"top_menu_new2",
						array(
							"ROOT_MENU_TYPE" => "top2",
							"MENU_CACHE_TYPE" => "N",
							"MENU_CACHE_TIME" => "36000000",
							"MENU_CACHE_USE_GROUPS" => "N",
							"MENU_CACHE_GET_VARS" => array(
							),
							"MAX_LEVEL" => "1",
							"USE_EXT" => "N",
							"ALLOW_MULTI_SELECT" => "N",
							"COMPONENT_TEMPLATE" => "top_menu_new2",
							"CHILD_MENU_TYPE" => "left",
							"DELAY" => "N"
						),
						false
					); ?>
				<? } ?>
			</div>
			<div class="clearfix"></div>
		</div>

		<div class="container">
			<?php if($APPLICATION->GetCurPage(true) != '/index.php') { ?>
			<div class="col-xs-3 foot-menu-left">
				<?$APPLICATION->IncludeComponent(
					"bitrix:menu",
					"catalog_vertical1",
					array(
						"ROOT_MENU_TYPE" => "left",
						"MENU_CACHE_TYPE" => "N",
						"MENU_CACHE_TIME" => "3600000",
						"MENU_CACHE_USE_GROUPS" => "Y",
						"CACHE_SELECTED_ITEMS" => "N",
						"MENU_THEME" => "site",
						"MENU_CACHE_GET_VARS" => array(
						),
						"MAX_LEVEL" => "2",
						"CHILD_MENU_TYPE" => "left",
						"USE_EXT" => "Y",
						"DELAY" => "N",
						"ALLOW_MULTI_SELECT" => "N",
						"COMPONENT_TEMPLATE" => "catalog_vertical1"
					),
					false
				); ?>
				<?$APPLICATION->IncludeComponent("bitrix:main.include", "", Array("AREA_FILE_SHOW" => "file", "PATH" => SITE_DIR."include/gift.php")); ?>
			</div>
			<?php } ?>
