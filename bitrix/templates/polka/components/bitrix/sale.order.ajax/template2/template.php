<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
	// $city = \Bitrix\Sale\Location\TypeTable::getList(array('filter' => array('=CODE' => 'CITY'), 'select' => array('ID')))->fetch();
?>

<form action="<?=$APPLICATION->GetCurPage();?>" method="POST" name="ORDER_FORM" id="ORDER_FORM" enctype="multipart/form-data">
	<input type="hidden" name="confirmorder" id="confirmorder" value="Y">
	<input type="hidden" name="profile_change" id="profile_change" value="N">
	<input type="hidden" name="is_ajax_post" id="is_ajax_post" value="Y">
	<input type="hidden" name="json" value="Y">
	<?=bitrix_sessid_post()?>
	<div id="order_form_content">
		<input type="hidden" name="PERMANENT_MODE_STEPS" value="1" />
		
		<? if(!empty($arResult["ERROR"]) && $arResult["USER_VALS"]["FINAL_STEP"] == "Y") {
			foreach($arResult["ERROR"] as $v) echo ShowError($v);
		?>
		<script type="text/javascript">
			top.BX.scrollToNode(top.BX('ORDER_FORM'));
		</script>
		<? } ?>
		
		<? 
			include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/person_type.php");
			include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/props.php");
			if ($arParams["DELIVERY_TO_PAYSYSTEM"] == "p2d") {
				include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/paysystem.php");
				include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/delivery.php");
			} else {
				include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/delivery.php");
				include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/paysystem.php");
			}
			include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/related_props.php");
			include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/summary.php");
			if(strlen($arResult["PREPAY_ADIT_FIELDS"]) > 0)
				echo $arResult["PREPAY_ADIT_FIELDS"];
		?>
	</div>
	<button id="ORDER_CONFIRM_BUTTON" class="checkout">
		<div class="basket_block_cart_forward pull-right"></div>
	</button>
</form>
<div><?$APPLICATION->IncludeComponent("bitrix:sale.ajax.delivery.calculator", "", array(), null, array('HIDE_ICONS' => 'Y')); ?></div>
<div>
	<?$APPLICATION->IncludeComponent("bitrix:sale.location.selector.steps", ".default", array(), false );?>
	<?$APPLICATION->IncludeComponent("bitrix:sale.location.selector.search", ".default", array(), false);?>
</div>