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
	include(GetLangFileName(dirname(__FILE__).'/', '/payment.php'));

	$order_id = (strlen(CSalePaySystemAction::GetParamValue('ORDER_ID')) > 0)
		? CSalePaySystemAction::GetParamValue('ORDER_ID')
		: $GLOBALS['SALE_INPUT_PARAMS']['ORDER']['ID'];

	$amount = (strlen(CSalePaySystemAction::GetParamValue('AMOUNT')) > 0)
		? CSalePaySystemAction::GetParamValue('AMOUNT')
		: $GLOBALS['SALE_INPUT_PARAMS']['ORDER']['SHOULD_PAY'];

	$currency = (strlen(CSalePaySystemAction::GetParamValue('CURRENCY')) > 0)
		? CSalePaySystemAction::GetParamValue('CURRENCY')
		: $GLOBALS['SALE_INPUT_PARAMS']['ORDER']['CURRENCY'];

	$result_url = CSalePaySystemAction::GetParamValue('RESULT_URL');
	$server_url = CSalePaySystemAction::GetParamValue('SERVER_URL');
	$type = 'buy';

	$description = 'Order #'.$order_id;

	$order_id .= '#'.time();

	if ($currency == 'RUR') { $currency = 'RUB'; }

	$SECRETCODE = CSalePaySystemAction::GetParamValue('SECRET_KEY');
	$a['MERCHANT_INFO'] = CSalePaySystemAction::GetParamValue('MERCHANT_INFO');
	$a['PAYMENT_TYPE'] = '';
	$a['PAYMENT_RULE'] = '';
	$a['PAYMENT_AMOUNT'] = $amount.'00';
	$a['PAYMENT_ADDVALUE'] = '';
	$a['PAYMENT_INFO'] = $description;
	$a['PAYMENT_DELIVER'] = '';
	$a['PAYMENT_ORDER'] = $order_id;
	$a['PAYMENT_VISA'] = '';
	$a['PAYMENT_TESTMODE'] = CSalePaySystemAction::GetParamValue('TEST_KEY')=='Y'?1:0;
	$a['PAYMENT_RETURNRES'] = $server_url;
	$a['PAYMENT_RETURN'] = $result_url;
	$a['PAYMENT_RETURNMET'] = 2;
	$a['PAYMENT_RETURNFAIL'] = $server_url;

	$language = LANGUAGE_ID;

	if (!$action = CSalePaySystemAction::GetParamValue('ACTION')) {
		$action = 'http://www.money.ua/sale.php';
	}
?>

<?=GetMessage('PAYMENT_DESCRIPTION_PS')?> <b>www.money.ua</b>.<br /><br />
<?=GetMessage('PAYMENT_DESCRIPTION_SUM')?>: <b><?=CurrencyFormat($amount, $currency)?></b><br /><br />

<form method="POST" action="<?=$action?>" accept-charset="utf-8">
	<input type="hidden" name="PAYMENT_AMOUNT" value="<? echo $a['PAYMENT_AMOUNT']; ?>">
	<input type="hidden" name="PAYMENT_INFO" value="<?php echo $a['PAYMENT_INFO']; ?>">
	<input type="hidden" name="PAYMENT_DELIVER" value="<?php echo $a['PAYMENT_DELIVER']; ?>">
	<input type="hidden" name="PAYMENT_ADDVALUE" value="<?php echo $a['PAYMENT_ADDVALUE']; ?>">
	<input type="hidden" name="MERCHANT_INFO" value="<?php echo $a['MERCHANT_INFO']; ?>">
	<input type="hidden" name="PAYMENT_ORDER" value="<?php echo $a['PAYMENT_ORDER']; ?>">
	<input type="hidden" name="PAYMENT_TYPE" value="<?php echo $a['PAYMENT_TYPE'] = 1; ?>">
	<input type="hidden" name="PAYMENT_RULE" value="<?php echo $a['PAYMENT_RULE']; ?>">
	<input type="hidden" name="PAYMENT_VISA" value="<?php echo $a['PAYMENT_VISA']; ?>">
	<input type="hidden" name="PAYMENT_RETURNRES" value="<?php echo $a['PAYMENT_RETURNRES']; ?>">
	<input type="hidden" name="PAYMENT_RETURN" value="<?php echo $a['PAYMENT_RETURN']; ?>">
	<input type="hidden" name="PAYMENT_RETURNMET" value="<?php echo $a['PAYMENT_RETURNMET']; ?>">
	<input type="hidden" name="PAYMENT_RETURNFAIL" value="<?php echo $a['PAYMENT_RETURNFAIL']; ?>">
	<input type="hidden" name="PAYMENT_TESTMODE" value="<?php echo $a['PAYMENT_TESTMODE']; ?>">
	<?php 
		$a['PAYMENT_HASH'] = md5(implode(":", array(
			$a['MERCHANT_INFO'], $a['PAYMENT_TYPE'], $a['PAYMENT_RULE'], $a['PAYMENT_AMOUNT'], $a['PAYMENT_ADDVALUE'], $a['PAYMENT_INFO'], $a['PAYMENT_DELIVER'],
			$a['PAYMENT_ORDER'], $a['PAYMENT_VISA'], $a['PAYMENT_TESTMODE'], $a['PAYMENT_RETURNRES'], $a['PAYMENT_RETURN'], $a['PAYMENT_RETURNMET'],
			$SECRETCODE,
		))); 
	?>
	<input type="hidden" name="PAYMENT_HASH" value="<?php echo $a['PAYMENT_HASH']; ?>">
	<button><img src="//money.ua/i/slmoneyua.gif"> Webmoney USD (WMZ)</button>
</form>

<form method="POST" action="<?=$action?>" accept-charset="utf-8">
	<input type="hidden" name="PAYMENT_AMOUNT" value="<? echo $a['PAYMENT_AMOUNT']; ?>">
	<input type="hidden" name="PAYMENT_INFO" value="<?php echo $a['PAYMENT_INFO']; ?>">
	<input type="hidden" name="PAYMENT_DELIVER" value="<?php echo $a['PAYMENT_DELIVER']; ?>">
	<input type="hidden" name="PAYMENT_ADDVALUE" value="<?php echo $a['PAYMENT_ADDVALUE']; ?>">
	<input type="hidden" name="MERCHANT_INFO" value="<?php echo $a['MERCHANT_INFO']; ?>">
	<input type="hidden" name="PAYMENT_ORDER" value="<?php echo $a['PAYMENT_ORDER']; ?>">
	<input type="hidden" name="PAYMENT_TYPE" value="<?php echo $a['PAYMENT_TYPE'] = 2; ?>">
	<input type="hidden" name="PAYMENT_RULE" value="<?php echo $a['PAYMENT_RULE']; ?>">
	<input type="hidden" name="PAYMENT_VISA" value="<?php echo $a['PAYMENT_VISA']; ?>">
	<input type="hidden" name="PAYMENT_RETURNRES" value="<?php echo $a['PAYMENT_RETURNRES']; ?>">
	<input type="hidden" name="PAYMENT_RETURN" value="<?php echo $a['PAYMENT_RETURN']; ?>">
	<input type="hidden" name="PAYMENT_RETURNMET" value="<?php echo $a['PAYMENT_RETURNMET']; ?>">
	<input type="hidden" name="PAYMENT_RETURNFAIL" value="<?php echo $a['PAYMENT_RETURNFAIL']; ?>">
	<input type="hidden" name="PAYMENT_TESTMODE" value="<?php echo $a['PAYMENT_TESTMODE']; ?>">
	<?php 
		$a['PAYMENT_HASH'] = md5(implode(":", array(
			$a['MERCHANT_INFO'], $a['PAYMENT_TYPE'], $a['PAYMENT_RULE'], $a['PAYMENT_AMOUNT'], $a['PAYMENT_ADDVALUE'], $a['PAYMENT_INFO'], $a['PAYMENT_DELIVER'],
			$a['PAYMENT_ORDER'], $a['PAYMENT_VISA'], $a['PAYMENT_TESTMODE'], $a['PAYMENT_RETURNRES'], $a['PAYMENT_RETURN'], $a['PAYMENT_RETURNMET'],
			$SECRETCODE,
		))); 
	?>
	<input type="hidden" name="PAYMENT_HASH" value="<?php echo $a['PAYMENT_HASH']; ?>">
	<button><img src="//money.ua/i/slmoneyua.gif"> Оплатить Webmoney RUR (WMR)</button>
</form>

<form method="POST" action="<?=$action?>" accept-charset="utf-8">
	<input type="hidden" name="PAYMENT_AMOUNT" value="<? echo $a['PAYMENT_AMOUNT']; ?>">
	<input type="hidden" name="PAYMENT_INFO" value="<?php echo $a['PAYMENT_INFO']; ?>">
	<input type="hidden" name="PAYMENT_DELIVER" value="<?php echo $a['PAYMENT_DELIVER']; ?>">
	<input type="hidden" name="PAYMENT_ADDVALUE" value="<?php echo $a['PAYMENT_ADDVALUE']; ?>">
	<input type="hidden" name="MERCHANT_INFO" value="<?php echo $a['MERCHANT_INFO']; ?>">
	<input type="hidden" name="PAYMENT_ORDER" value="<?php echo $a['PAYMENT_ORDER']; ?>">
	<input type="hidden" name="PAYMENT_TYPE" value="<?php echo $a['PAYMENT_TYPE'] = 3; ?>">
	<input type="hidden" name="PAYMENT_RULE" value="<?php echo $a['PAYMENT_RULE']; ?>">
	<input type="hidden" name="PAYMENT_VISA" value="<?php echo $a['PAYMENT_VISA']; ?>">
	<input type="hidden" name="PAYMENT_RETURNRES" value="<?php echo $a['PAYMENT_RETURNRES']; ?>">
	<input type="hidden" name="PAYMENT_RETURN" value="<?php echo $a['PAYMENT_RETURN']; ?>">
	<input type="hidden" name="PAYMENT_RETURNMET" value="<?php echo $a['PAYMENT_RETURNMET']; ?>">
	<input type="hidden" name="PAYMENT_RETURNFAIL" value="<?php echo $a['PAYMENT_RETURNFAIL']; ?>">
	<input type="hidden" name="PAYMENT_TESTMODE" value="<?php echo $a['PAYMENT_TESTMODE']; ?>">
	<?php 
		$a['PAYMENT_HASH'] = md5(implode(":", array(
			$a['MERCHANT_INFO'], $a['PAYMENT_TYPE'], $a['PAYMENT_RULE'], $a['PAYMENT_AMOUNT'], $a['PAYMENT_ADDVALUE'], $a['PAYMENT_INFO'], $a['PAYMENT_DELIVER'],
			$a['PAYMENT_ORDER'], $a['PAYMENT_VISA'], $a['PAYMENT_TESTMODE'], $a['PAYMENT_RETURNRES'], $a['PAYMENT_RETURN'], $a['PAYMENT_RETURNMET'],
			$SECRETCODE,
		))); 
	?>
	<input type="hidden" name="PAYMENT_HASH" value="<?php echo $a['PAYMENT_HASH']; ?>">
	<button><img src="//money.ua/i/slmoneyua.gif"> Оплатить Webmoney UAH (WMU)</button>
</form>

<form method="POST" action="<?=$action?>" accept-charset="utf-8">
	<input type="hidden" name="PAYMENT_AMOUNT" value="<? echo $a['PAYMENT_AMOUNT']; ?>">
	<input type="hidden" name="PAYMENT_INFO" value="<?php echo $a['PAYMENT_INFO']; ?>">
	<input type="hidden" name="PAYMENT_DELIVER" value="<?php echo $a['PAYMENT_DELIVER']; ?>">
	<input type="hidden" name="PAYMENT_ADDVALUE" value="<?php echo $a['PAYMENT_ADDVALUE']; ?>">
	<input type="hidden" name="MERCHANT_INFO" value="<?php echo $a['MERCHANT_INFO']; ?>">
	<input type="hidden" name="PAYMENT_ORDER" value="<?php echo $a['PAYMENT_ORDER']; ?>">
	<input type="hidden" name="PAYMENT_TYPE" value="<?php echo $a['PAYMENT_TYPE'] = 5; ?>">
	<input type="hidden" name="PAYMENT_RULE" value="<?php echo $a['PAYMENT_RULE']; ?>">
	<input type="hidden" name="PAYMENT_VISA" value="<?php echo $a['PAYMENT_VISA']; ?>">
	<input type="hidden" name="PAYMENT_RETURNRES" value="<?php echo $a['PAYMENT_RETURNRES']; ?>">
	<input type="hidden" name="PAYMENT_RETURN" value="<?php echo $a['PAYMENT_RETURN']; ?>">
	<input type="hidden" name="PAYMENT_RETURNMET" value="<?php echo $a['PAYMENT_RETURNMET']; ?>">
	<input type="hidden" name="PAYMENT_RETURNFAIL" value="<?php echo $a['PAYMENT_RETURNFAIL']; ?>">
	<input type="hidden" name="PAYMENT_TESTMODE" value="<?php echo $a['PAYMENT_TESTMODE']; ?>">
	<?php 
		$a['PAYMENT_HASH'] = md5(implode(":", array(
			$a['MERCHANT_INFO'], $a['PAYMENT_TYPE'], $a['PAYMENT_RULE'], $a['PAYMENT_AMOUNT'], $a['PAYMENT_ADDVALUE'], $a['PAYMENT_INFO'], $a['PAYMENT_DELIVER'],
			$a['PAYMENT_ORDER'], $a['PAYMENT_VISA'], $a['PAYMENT_TESTMODE'], $a['PAYMENT_RETURNRES'], $a['PAYMENT_RETURN'], $a['PAYMENT_RETURNMET'],
			$SECRETCODE,
		))); 
	?>
	<input type="hidden" name="PAYMENT_HASH" value="<?php echo $a['PAYMENT_HASH']; ?>">
	<button><img src="//money.ua/i/slmoneyua.gif"> Оплатить Яндекс.Деньги</button>
</form>