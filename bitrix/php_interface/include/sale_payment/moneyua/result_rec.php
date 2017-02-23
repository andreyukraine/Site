<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) { die(); }

$success =
	isset($_POST['RETURN_UNIQ_ID']) &&
	isset($_POST['RETURN_MERCHANT']) &&
	isset($_POST['RETURN_ADDVALUE']) &&
	isset($_POST['RETURN_CLIENTORDER']) &&
	isset($_POST['RETURN_AMOUNT']) &&
	isset($_POST['RETURN_RESULT']) &&
	isset($_POST['RETURN_COMISSION']) &&
	isset($_POST['TEST_MODE']) &&
	isset($_POST['PAYMENT_DATE']) &&
	isset($_POST['RETURN_PMEMAIL']) &&
	isset($_POST['RETURN_TPHONE']) &&
	isset($_POST['RETURN_COMMISSTYPE']) &&
	isset($_POST['RETURN_TYPE']) &&
	isset($_POST['RETURN_HASH'])
;

$log = @file_get_contents($file = dirname(__FILE__).'/money.ua.log.txt');
file_put_contents($file, $log.PHP_EOL.date('Y-m-d H:i:s').';'.$_SERVER['REMOTE_ADDR'].';'.json_encode($_POST));
if (!$success) { die(); }

$RETURN_TYPES       = array(
	1 => 'USD',
	2 => 'RUB',
	3 => 'UAH',
	5 => 'RUB',
);
$RETURN_UNIQ_ID     = $_POST['RETURN_UNIQ_ID'];
$RETURN_MERCHANT    = $_POST['RETURN_MERCHANT'];
$RETURN_ADDVALUE    = $_POST['RETURN_ADDVALUE'];
$RETURN_CLIENTORDER = $_POST['RETURN_CLIENTORDER'];
$RETURN_AMOUNT      = (float)$_POST['RETURN_AMOUNT'];
$RETURN_RESULT      = $_POST['RETURN_RESULT'];
$RETURN_COMISSION   = $_POST['RETURN_COMISSION'];
$TEST_MODE          = $_POST['TEST_MODE'];
$PAYMENT_DATE       = $_POST['PAYMENT_DATE'];
$RETURN_PMEMAIL     = $_POST['RETURN_PMEMAIL'];
$RETURN_TPHONE      = $_POST['RETURN_TPHONE'];
$RETURN_COMMISSTYPE = $_POST['RETURN_COMMISSTYPE'];
$RETURN_TYPE        = $_POST['RETURN_TYPE'];
$RETURN_HASH        = $_POST['RETURN_HASH'];
$SECRETCODE         = CSalePaySystemAction::GetParamValue('SECRET_KEY');

$hash = md5("$RETURN_MERCHANT:$RETURN_ADDVALUE:$RETURN_CLIENTORDER:$RETURN_AMOUNT:$RETURN_COMISSION:$RETURN_UNIQ_ID:$TEST_MODE:$PAYMENT_DATE:$SECRETCODE:$RETURN_RESULT");
if ($hash != $RETURN_HASH) { die(); }

$real_order_id = explode('#', $RETURN_CLIENTORDER);
$real_order_id = $real_order_id[0];
if ($real_order_id <= 0) { die(); }
if (!($arOrder = CSaleOrder::GetByID($real_order_id))) { die(); }
if ($arOrder['PAYED'] == 'Y') { die(); }

CSalePaySystemAction::InitParamArrays($arOrder, $arOrder['ID']);

if ($success) {
	$sDescription = '';
	$sStatusMessage = '';

	$sDescription .= 'amount: '.$RETURN_AMOUNT.'; ';
	$sDescription .= 'currency: '.$RETURN_TYPES[$RETURN_TYPE].'; ';

	$sStatusMessage .= 'transaction_id: '.$RETURN_UNIQ_ID.'; ';
	$sStatusMessage .= 'order_id: '.$real_order_id.'; ';

	$arFields = array(
		'PS_STATUS' => 'Y',
		'PS_STATUS_CODE' => 'success',
		'PS_STATUS_DESCRIPTION' => $sDescription,
		'PS_STATUS_MESSAGE' => $sStatusMessage,
		'PS_SUM' => $RETURN_AMOUNT,
		'PS_CURRENCY' => $RETURN_TYPES[$RETURN_TYPE],
		'PS_RESPONSE_DATE' => date(CDatabase::DateFormatToPHP(CLang::GetDateFormat('FULL', LANG))),
	);

	CSaleOrder::PayOrder($arOrder['ID'], 'Y');
	CSaleOrder::Update($arOrder['ID'], $arFields);
	echo 'OK';
}