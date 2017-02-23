<?php
/**
 * MoneyUA Payment Module
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * @category        MoneyUA
 * @package         MoneyUA.MoneyUA
 * @version         0.0.1
 * @author          MoneyUA
 * @copyright       Copyright (c) 2014 MoneyUA
 * @license         http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 *
 * EXTENSION INFORMATION
 *
 * 1C-Bitrix        14.0
 * MoneyUA API       https://www.MoneyUA.com/ru/doc
 *
 */

global $MESS;
$MESS['LP_MODULE_NAME'] = 'Платежная система MoneyUA';
$MESS['LP_MODULE_DESC'] = 'Обработчик для платежной системы MoneyUA';

$MESS['LP_SECRET_KEY'] = 'Секретный ключ';
$MESS['LP_SECRET_KEY_DESC'] = '';
$MESS['LP_PUBLIC_KEY'] = 'Публичный ключ';
$MESS['LP_PUBLIC_KEY_DESC'] = '(идентификатор магазина, <a target="_blank" href="http://www.MoneyUA.com/admin/business">получить публичный ключ</a>)';
$MESS['LP_AMOUNT'] = 'Сумма для списания при оплате в магазине';
$MESS['LP_CURRENCY'] = 'Валюта платежа';
$MESS['LP_ORDER_ID'] = 'Уникальный ID покупки в Вашем магазине';
$MESS['LP_RESULT_URL'] = 'URL на который будет переадресация после покупки';
$MESS['LP_RESULT_URL_DESC'] = '(этот параметр можно указать единоразово в настройках магазина)';
$MESS['LP_SERVER_URL'] = 'URL API для уведомлений о статусе покупки';
$MESS['LP_SERVER_URL_DESC'] = '(этот параметр можно указать единоразово в настройках магазина)';
$MESS['LP_TYPE'] = 'Тип оплаты';
$MESS['LP_TYPE_DESC'] = '(<b>buy</b> - покупка, <b>donate</b> - пожертвование)';
$MESS['LP_PRIVATE_KEY'] = 'Приватный ключ';
$MESS['LP_PRIVATE_KEY_DESC'] = '(<a target="_blank" href="https://www.MoneyUA.com/admin/business">получить приватный ключ</a>)';
$MESS['LP_ACTION'] = 'URL для отправки формы';
$MESS['LP_ACTION_DESC'] = '(атрибут action формы для приёма платежей)';


