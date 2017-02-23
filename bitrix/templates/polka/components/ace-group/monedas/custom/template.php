<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/components/ace-group/monedas/script/site.php';

?>

	<span class="sprite sprite-currency" style="vertical-align:text-top"></span>
	<span><?=GetMessage("ACEGROUP_MONEDAS_R_R_R_S_S_R")?></span>
	<select id="gfwe" class="selectBlock3">
		<? foreach ($arResult['CURRENCY_LIST'] as $el) { ?>
				<? $selected = !strcasecmp($arResult['CURRENT_CURRENCY'], $el['CURRENCY']) ? true : false; ?>
				<option <?=$selected ? 'selected="1"' : ''?> name="<?=$el['CURRENCY']?>" class="cur_selector"><?=$el['CURRENCY']?></option>
		<? } ?>
	</select>

<script>
$(document).ready(function() {
	$("select#gfwe").change(function(){
		var v = $(this).children(":selected").attr('name');
		document.cookie = "currency="+ v +";path=/";
		document.location.reload();
	});
})
</script>