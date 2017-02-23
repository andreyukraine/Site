<?php
/**
 * Liqpay Payment Module
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * @category        Liqpay
 * @package         liqpay.liqpay
 * @version         0.0.1
 * @author          Liqpay
 * @copyright       Copyright (c) 2014 Liqpay
 * @license         http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 *
 * EXTENSION INFORMATION
 *
 * 1C-Bitrix        14.0
 * LIQPAY API       https://www.liqpay.com/ru/doc
 *
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) { die(); }

include(GetLangFileName(dirname(__FILE__).'/', '/.description.php'));

$psTitle = GetMessage('LP_MODULE_NAME');
$psDescription = GetMessage('LP_MODULE_DESC');

$arPSCorrespondence = array(
	'SECRET_KEY' => array(
		'NAME'  => 'Секретный ключ',
		'DESCR' => '',
		'VALUE' => '',
		'TYPE'  => ''
	),
	'MERCHANT_INFO' => array(
		'NAME'  => 'Идентификатор партнера в системе Money.ua',
		'DESCR' => '',
		'VALUE' => '',
		'TYPE'  => ''
	),

	'AMOUNT' => array(
		'NAME'  => GetMessage('LP_AMOUNT'),
		'DESCR' => '',
		'VALUE' => 'SHOULD_PAY',
		'TYPE'  => 'ORDER'
	),
	'CURRENCY' => array(
		'NAME'  => GetMessage('LP_CURRENCY'),
		'DESCR' => '',
		'VALUE' => 'CURRENCY',
		'TYPE'  => 'ORDER'
	),
	'ORDER_ID' => array(
		'NAME'  => GetMessage('LP_ORDER_ID'),
		'DESCR' => '',
		'VALUE' => 'ID',
		'TYPE'  => 'ORDER'
	),
	'RESULT_URL' => array(
		'NAME'  => GetMessage('LP_RESULT_URL'),
		'DESCR' => GetMessage('LP_RESULT_URL_DESC'),
		'VALUE' => 'http://'.$_SERVER['HTTP_HOST'].'/personal/order/',
		'TYPE'  => ''
	),
	'SERVER_URL' => array(
		'NAME'  => GetMessage('LP_SERVER_URL'),
		'DESCR' => GetMessage('LP_SERVER_URL_DESC'),
		'VALUE' => 'http://'.$_SERVER['HTTP_HOST'].'/personal/ps_result.php',
		'TYPE'  => ''
	),
	'ACTION' => array(
		'NAME'  => GetMessage('LP_ACTION'),
		'DESCR' => GetMessage('LP_ACTION_DESC'),
		'VALUE' => 'http://money.ua/sale.php',
		'TYPE'  => ''
	),
	'TEST_KEY' => array(
		'NAME'  => 'Тестовый режим',
		'DESCR' => 'Y или N',
		'VALUE' => 'Y',
		'TYPE'  => ''
	),
// PAYMENT_AMOUNT – сумма оплачиваемых товаров в копейках – целое число больше нуля.
// PAYMENT_INFO = Информация о товаре - 255 символов.
// PAYMENT_DELIVER = Информация о доставке – 255 символов
// PAYMENT_ADDVALUE = Дополнительная информация клиента – 255 символов (для передачи дополнительных параметров торговой точки)
// MERCHANT_INFO = уникальный номер торговой точки в нашей системе (целое положительное число)
// PAYMENT_ORDER = уникальный номер заказа в системе торговой точки, проверяется системой на уникальность – в случае поступления заказа на оплату с уже существующим оплаченным номером – система не примет заказ, выдаст ошибку
// PAYMENT_TYPE = тип валюты, который используется при оплате:
// PAYMENT_RULE
// PAYMENT_VISA = зарезервирован для параметров оплат картами Виза/Мастер в случае пользования нашим интерфейсом.
// PAYMENT_RETURNRES = полный урл, на который будет возвращен результат транзакции.
// PAYMENT_RETURN = полный урл, на который будет возвращен клиент после оплаты в случае успешной оплаты.
// PAYMENT_RETURNFAIL = полный урл, на который будет возвращен клиент после оплаты в случае неудачной оплаты.
// PAYMENT_TESTMODE = признак режима тестирования 0 – режим нормальной работы 1 – режим тестирования.
// PAYMENT_HASH = md5-хэш для цифровой подписи параметров. Формируется следующим образом – строка из параметров, разделенные знаком «:» (двоеточие).

);