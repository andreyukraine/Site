<?

require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/php_interface/classes/Tools.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/php_interface/classes/ProductResponce.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/bitrix/php_interface/classes/ForgottenBasket.php';
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/classes/general/captcha.php");
require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/components/ace-group/monedas/script/site.php';
define('BX_CRONTAB_SUPPORT', true);

//AddEventHandler("sale", "OnBasketAdd", array("ForgottenBasket", "AddPresentToBasket"));
//AddEventHandler("sale", "OnBasketUpdate", array("ForgottenBasket", "AddPresentToBasket")); 

AddEventHandler('sale', 'OnOrderAdd', Array('mail_new', 'OnOrderAdd_mail'));
AddEventHandler('sale', 'OnSaleStatusOrder', Array('mail_new', 'OnSaleStatusOrder_mail'));
AddEventHandler('sale', 'OnOrderCancelSendEmail', Array('mail_new', 'OnOrderCancel_mail'));
AddEventHandler('sale', 'OnOrderNewSendEmail', array('mail_new', 'on_send_new_order'));
AddEventHandler('sale', 'OnOrderPaySendEmail', array('mail_new', 'on_send_pay_order'));

AddEventHandler("search", "BeforeIndex", Array("mySearch", "BeforeIndexHandler"));
AddEventHandler("sale", "OnSaleComponentOrderOneStepPersonType", Array("myBasketOrder", "change_persontype_sort"));

//* by sunny at 20 may 2016 for order status send EventHandler
AddEventHandler("sale", "OnOrderStatusSendEmail", "MyOnOrderStatusSendEmail");
//* end by sunny at 20 may 2016 for order status send EventHandler





// CModule::IncludeModule('iblock'); 
// Bitrix\Iblock\PropertyIndex\Manager::DeleteIndex($iblockId); 
// Bitrix\Iblock\PropertyIndex\Manager::markAsInvalid($iblockId);

//* by sunny at 20 may 2016 for order status send EventFunction

















function MyOnOrderStatusSendEmail($ID, &$eventName, &$arFields, $val)
{
    CModule::IncludeModule("sale");
    $arOrder = CSaleOrder::GetByID($ID);
    $order_props = CSaleOrderPropsValue::GetOrderProps($ID);

    while ($arProps = $order_props->Fetch())
    {
        if ($arProps["CODE"] == "NAME") {
            $arFields['NAME'] = $arProps["VALUE"];
        }
    }

}
//* end by sunny at 20 may 2016 for order status send EventFunction

class myBasketOrder
{
    function change_persontype_sort(&$arResult, &$arUserResult, &$arParams)
    {
        include_once(DIR_SITE . '/include/cart-check-ebook.php');
        $res = new makano_cart_check();
        if ($res->has_ebook) {
            $arUserResult['PERSON_TYPE_ID'] = 4;
            foreach ($arResult['PERSON_TYPE'] as $k => &$v)
                $v['CHECKED'] = ($k == $arUserResult['PERSON_TYPE_ID'] ? true : false);
            unset($v);
        }
    }
}



// регистрируем обработчик
//AddEventHandler("search", "BeforeIndex", "BeforeIndexHandlerBitrix");
// // создаем обработчик события "BeforeIndex"
//function BeforeIndexHandlerBitrix($arFields)
//{
//   if(!CModule::IncludeModule("iblock")) // подключаем модуль
//      return $arFields;
//   if($arFields["MODULE_ID"] == "iblock")
//   {
//      $db_props = CIBlockElement::GetProperty(                        // Запросим свойства индексируемого элемента
//                                    $arFields["PARAM2"],         // BLOCK_ID индексируемого свойства
//                                    $arFields["ITEM_ID"],          // ID индексируемого свойства
//                                    array("sort" => "asc"),       // Сортировка (можно упустить)
//                                    Array("CODE"=>"BOOKINIST")); // CODE свойства (в данном случае артикул)
//      if($ar_props = $db_props->Fetch())
//         $arFields["TITLE"] .= " ".$ar_props["VALUE"];   // Добавим свойство в конец заголовка индексируемого элемента
//   }
//   return "BeforeIndexHandlerBitrix();";
//   //return $arFields; // вернём изменения
//} 









class mySearch
{
    function BeforeIndexHandler($arFields)
    {
        $arrIblock = array(2);
        $arDelFields = array("DETAIL_TEXT", "PREVIEW_TEXT");
        if (CModule::IncludeModule('iblock') && $arFields["MODULE_ID"] == 'iblock' && in_array($arFields["PARAM2"], $arrIblock) && intval($arFields["ITEM_ID"]) > 0) {
            $dbElement = CIblockElement::GetByID($arFields["ITEM_ID"]);
            if ($arElement = $dbElement->Fetch()) {
                foreach ($arDelFields as $value) {
                    if (isset($arElement[$value]) && strlen($arElement[$value]) > 0) {
                        $arFields["BODY"] = preg_replace('~' . preg_quote(CSearch::KillTags($arElement[$value])) . '~su', '', $arFields["BODY"]);
                    }
                }
            }
        }
        return $arFields;
    }
}

class mail_new
{
    static function getOwnerEmail($order)
    {
        $res = CSaleOrderPropsValue::GetOrderProps($order);
        while ($row = $res->Fetch()) {
            if ($row['IS_EMAIL'] == 'Y') {
                return $row['VALUE'];
            }
        }
        if ($order = CSaleOrder::GetByID($order)) {
            if ($user = CUser::GetByID($order['USER_ID'])->Fetch()) {
                return $user['EMAIL'];
            }
        }
        return $false;
    }

    private static function getOrderCoupons($order_id)
    {
        CModule::IncludeModule("sale");

        $query = CSaleBasket::GetList(
            array(),
            array('ORDER_ID' => $order_id),
            false,
            false,
            array('DISCOUNT_NAME', 'DISCOUNT_COUPON')
        );

        while ($arResult = $query->GetNext())
        {
            if ($arResult['DISCOUNT_COUPON']) {
                $arDiscount[] = $arResult['DISCOUNT_NAME'] . ' #' . $arResult['DISCOUNT_COUPON'];
            }
        }

        return implode(', ', $arDiscount);

    }

    function OnOrderAdd_mail($ID, $val)
    {
        $dbBasketItems = CSaleBasket::GetList(
            array(
                "NAME" => "ASC",
                "ID" => "ASC"
            ),
            array(
                "FUSER_ID" => CSaleBasket::GetBasketUserID(),
                "LID" => SITE_ID,
                "DELAY" => "N",
                "CAN_BUY" => "Y",
                "ORDER_ID" => "NULL"
            ),
            false,
            false,
            array()
        );
        $zak = "Корзина заказа:<br /><table border='1' cellpadding='5' cellspacing='0'>";
        $zak = $zak . "<tr><td align='center'>Товар</td><td align='center'>Цена</td><td align='center'>Кол-во</td><td align='center'>Сумма</td></tr>";
        while ($arItem = $dbBasketItems->Fetch()) {
            $st = (int)$arItem["QUANTITY"] * $arItem["PRICE"];
            $kol_vo = (int)$arItem["QUANTITY"];
            $zak = $zak . "<tr><td align='left'>" . "<a href='" . $arItem["DETAIL_PAGE_URL"] . "'>" . $arItem["NAME"] . "</a></td><td align='left'>" . $arItem["PRICE"] . "</td><td align='left'>" . $kol_vo . "</td><td align='left'>" . $st . "</td></tr>";
        }
        $arDeliv = CSaleDelivery::GetByID($val["DELIVERY_ID"]);
        $zak = $zak . "<tr><td align='left' colspan='3'><b>Доставка: </b>" . $arDeliv["NAME"] . "</td><td align='left'>" . $val["PRICE_DELIVERY"] . "</td></tr>";
        $zak = $zak . "<tr><td align='left' colspan='3'><b>Итого:</b></td><td align='left'>" . CCurrencyLang::CurrencyFormat($val['PRICE'], $val['CURRENCY'], true) . "</td></tr>";
        $zak = $zak . "</table>";
        $EMAIL = mail_new::getOwnerEmail($ID);
        $arEventFields = array(
            "ORDER_ID" => $ID,
            "SOSTAV" => $zak,
            "ORDER_USER" => $arUser_name,
            "EMAIL" => $EMAIL,
            "BCC" => '',
            "PRICE" => (int)$val["PRICE"] . " грн",
            "SALE_EMAIL" => "test@nmark.com.ua"

        );

        CEvent::SendImmediate("TEST_NEW_ORDER", s1, $arEventFields, "N", 78);
    }

    function OnSaleStatusOrder_mail($ID, $val, $arFields)
    {
        $arOrder = CSaleOrder::GetByID($ID);
        $db_props = CSaleOrderPropsValue::GetOrderProps($ID);
        $arStatus = CSaleStatus::GetByID($val);
        $arStatus_desc = $arStatus['DESCRIPTION'];
        $arStatus = $arStatus['NAME'];
        $EMAIL = "";
        $CUSTOMER_NAME = "";

        while ($arProps = $db_props->Fetch()) {
            if ($arProps['CODE'] == "EMAIL") {
                $EMAIL = $arProps["VALUE"];
            }
            if ($arProps["CODE"] == "NAME") {
                $CUSTOMER_NAME = $arProps["VALUE"];
            }
        }
        $arEventFields = array(
            "ORDER_ID" => $ID,
            "ORDER_STATUS" => $arStatus,
            "ORDER_DATE" => $arOrder["DATE_INSERT"],
            "EMAIL" => $EMAIL,
            "ORDER_DESCRIPTION" => $arStatus_desc,
            "SALE_EMAIL" => "test@nmark",
            "TEXT" => $text,
            "NAME" => $CUSTOMER_NAME,
            "ARRSTATUS" => $val,
        );

        $arFields["NAME"] = $CUSTOMER_NAME;

        if($val == 'F') {
            //CEvent::SendImmediate("SALE_STATUS_CHANGE_F", s1, $arEventFields, "F", 42);
        }

        CEvent::SendImmediate("SALE_STATUS_CHANGE_NEW", s1, $arEventFields, "N", 79);
    }

    function OnOrderCancel_mail($ID, &$eventName, &$arFields)
    {
        CEvent::SendImmediate($eventName, s1, $arFields);
    }

    function on_send_new_order($orderID, &$eventName, &$arFields)
    {
        $phone = $index = $country_name = $city_name = $address =
        $delivery_price = $delivery_name = $delivery_address =
        $pay_system_name =
        $u_name = $u_otchestvo = $u_familiya = $u_email = $u_phone = $user_name = '';
        $arOrder = CSaleOrder::GetByID($orderID);
        $order_props = CSaleOrderPropsValue::GetOrderProps($orderID);
        while ($arProps = $order_props->Fetch()) {
            if ($arProps["CODE"] == "LOCATION") {
                $arLocs = CSaleLocation::GetByID($arProps["VALUE"]);
                $country_name = $arLocs["COUNTRY_NAME_ORIG"];
                $city_name = $arLocs["CITY_NAME_ORIG"];
            }
            if ($arProps["CODE"] == "PHONE") $u_phone = htmlspecialchars($arProps["VALUE"]);
            if ($arProps["CODE"] == "INDEX") $index = $arProps["VALUE"];
            if ($arProps["CODE"] == "ADDRESS") $address = $arProps["VALUE"];
            if ($arProps['CODE'] == 'NAME') $u_name = $arProps['VALUE'];
            if ($arProps['CODE'] == 'FAMILIYA') $u_familiya = $arProps['VALUE'];
            if ($arProps['CODE'] == 'OTCHESTVO') $u_otchestvo = $arProps['VALUE'];

        }
        $delivery_address = $index . ", " . $country_name . "-" . $city_name . ", " . $address;

        if (!empty($u_name)) $user_name .= '' . $u_name;
        if (!empty($u_otchestvo)) $user_name .= ' ' . $u_otchestvo;
        if (!empty($u_familiya)) $user_name .= ' ' . $u_familiya;
        if (!empty($u_phone)) $user_name .= ', телефон: ' . $u_phone;

        if ($arOrder) {
            $delivery_price = $arOrder['PRICE_DELIVERY'];
            $arDeliv = CSaleDelivery::GetByID($arOrder["DELIVERY_ID"]);
            $arPaySystem = CSalePaySystem::GetByID($arOrder["PAY_SYSTEM_ID"]);
            // $arUser			= CUser::GetByID($arOrder["PAY_SYSTEM_ID"]);
            if ($arDeliv) {
                $delivery_name = $arDeliv["NAME"];
            }
            if ($arPaySystem) {
                $pay_system_name = $arPaySystem["NAME"];
            }
            // if ($arUser) {
            // $arUser = $arUser->Fetch();
            // if(!empty($arUser['NAME'])) $user_name.= ''.$arUser['NAME'];
            // if(!empty($arUser['LAST_NAME'])) $user_name.= ' '.$arUser['LAST_NAME'];
            // }
        }



        $arFields["DELIVERY_NAME"] = $delivery_name;
        $arFields["DELIVERY_ADDRESS"] = $delivery_address;
        $arFields["DELIVERY_PRICE"] = $delivery_price;
        $arFields["PAY_SYSTEM_NAME"] = $pay_system_name;
        $arFields["USER_NAME"] = $user_name;
        $arFields["IP"] = $_SERVER['REMOTE_ADDR'];
        $arFields["ORDER_LIST"] = preg_replace("~\n~", '<br>', $arFields["ORDER_LIST"]);
        $arFields["COUPON"] = self::getOrderCoupons($orderID);

    }

    function on_send_pay_order($orderID, &$eventName, &$arFields)
    {
        $arOrder = CSaleOrder::GetByID($orderID);
        $order_props = CSaleOrderPropsValue::GetOrderProps($orderID);
        while ($arProps = $order_props->Fetch()) {
            $arOrder['PROPS'][$arProps['CODE']] = $arProps;
        }
        if ($arOrder) {
            $delivery_price = $arOrder['PRICE_DELIVERY'];
            $arDeliv = CSaleDelivery::GetByID($arOrder["DELIVERY_ID"]);
            $arPaySystem = CSalePaySystem::GetByID($arOrder["PAY_SYSTEM_ID"]);
            if ($arDeliv) {
                $arOrder['DELIVERY_NAME'] = $arDeliv["NAME"];
            }
            if ($arPaySystem) {
                $arOrder['PAYSYSTEM_NAME'] = $arPaySystem["NAME"];
            }
            $dbBasketItems = CSaleBasket::GetList(array(), array("ORDER_ID" => $orderID), false, false, array('*'));
            while ($arBasketItems = $dbBasketItems->Fetch()) {
                $arBasketItems['PRICE'] = CCurrencyLang::CurrencyFormat(
                    CCurrencyRates::ConvertCurrency($arBasketItems["PRICE"], $arBasketItems['CURRENCY'], $arOrder["PS_CURRENCY"]),
                    $arOrder["PS_CURRENCY"],
                    true
                );
                $arOrder['PRODUCTS'][] = $arBasketItems;
                $arOrder['WEIGHT'] += $arBasketItems['WEIGHT'];
            }
            $arFields['ORDER_PRICE'] = SaleFormatCurrency($arOrder['PS_SUM'], $arOrder["PS_CURRENCY"]);
        }
        if (!empty($arOrder['PRODUCTS'])) foreach ($arOrder['PRODUCTS'] as &$product) {
            $arFields['ORDER_LIST'] .= $product['NAME'] . ' ' . $product['QUANTITY'] . ' шт ' . $product['PRICE'] . '<br>';
        }
        unset($product);
        $arFields['ORDER_WEIGHT'] = $arOrder['WEIGHT'];
    }
}

// $ev_name = 'SALE_NEW_ORDER';
// $arFields = array();
// $test_mail = new mail_new();
// $test_mail->on_send_new_order(1007148, $ev_name, $arFields);

function Reindex_Search()
{
    if (CModule::IncludeModule("search")) {
        $Result = false;
        $Result = CSearch::ReIndexAll(true, 5);
        while (is_array($Result)) {
            $Result = CSearch::ReIndexAll(true, 5, $Result);
        }
    }
    return "Reindex_Search();";
}

function my_debug($arg = array())
{
    if (!in_array($_SERVER['REMOTE_ADDR'], array('94.244.17.6'))) return;
    $a = debug_backtrace();
    $site_dir = dirname(dirname(dirname(__FILE__)));
    $str = '';
    foreach ($a as $k => $v) {
        $str .= ($str ? ' <= ' : '') . preg_replace('~' . preg_quote($site_dir) . '~', '', $v['file']) . ' (' . $v['line'] . ')' . '<br>';
    }
    ob_start();
    echo '<div>Debug at ' . $str . '<xmp>';
    if (is_array($arg) || is_object($arg)) print_r($arg);
    else var_dump($arg);
    echo '</xmp></div>';
    $str = ob_get_contents();
    ob_end_clean();
    echo $str;
}


AddEventHandler('form', 'onAfterResultAdd', 'my_onAfterResultAddUpdate');
function my_onAfterResultAddUpdate($WEB_FORM_ID, $RESULT_ID)
{
    // действие обработчика распространяется только на форму с ID=6
    if ($WEB_FORM_ID == 1)
    {
        $_SESSION['message_form'] = 'как только товар поступит в продажу Вам сообщат';
        // запишем в дополнительное поле 'user_ip' IP-адрес пользователя
        //CFormResult::SetField($RESULT_ID, 'user_ip', $_SERVER["REMOTE_ADDR"]);
    }
}

define('DIR_SITE', dirname(dirname(dirname(__FILE__))));

?>