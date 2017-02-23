<?
define("STOP_STATISTICS", true);
define('NO_AGENT_CHECK', true);
define("DisableEventsCheck", true);
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
// error_reporting(E_ALL); ini_set('display_errors','on');

if (CModule::IncludeModule("sale"))
{
	$dbPS = CSalePaySystem::GetList(array("SORT" => "ASC"), array("ACTIVE" => "Y", "%PSA_ACTION_FILE" => "money"), false, false, array("ID", "PSA_PERSON_TYPE_ID", "PSA_ACTION_FILE"));
	if($arPS = $dbPS->Fetch())
	{
		$personTypeId = $arPS["PSA_PERSON_TYPE_ID"];
		$paySystemId = $arPS["ID"];

		$APPLICATION->IncludeComponent(
			"bitrix:sale.order.payment.receive",
			"",
			array(
				"PAY_SYSTEM_ID" => $paySystemId,
				"PERSON_TYPE_ID" => $personTypeId
			),
		false
		);
	}
}
?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>