<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>
<?

if (isset($_REQUEST['WEB_FORM_ID']) && $_REQUEST['WEB_FORM_ID'] == 1 && isset($_REQUEST['RESULT_ID']) && $_REQUEST['RESULT_ID'] > 0)
{
    $arJson = array('result' => 'ok');
    $arJson = array('mess' => 'как только товар поступит в продажу Вам сообщат');
    $APPLICATION -> RestartBuffer();
    echo json_encode($arJson);
    die();
}

?>
<!-- BEGIN -->
<?if ($arResult["isFormErrors"] == "Y"):?><?=$arResult["FORM_ERRORS_TEXT"];?><?endif;?>
    <!-- FORM_NOTE -->
<?=$arResult["FORM_NOTE"]?>
<? $arResult["QUESTIONS"]['customer_ip']['STRUCTURE'][0]['VALUE'] = $_SERVER['REMOTE_ADDR']; ?>
<?if ($arResult["isFormNote"] != "Y") { ?>
    <!-- FORM_HEADER -->
	<?=$arResult["FORM_HEADER"]?>
	<?php
//echo '<xmp>'; print_r($arResult['QUESTIONS']); echo '</xmp>'; ?>
	<? foreach ($arResult["QUESTIONS"] as $FIELD_SID => $arQuestion) if ($arQuestion['STRUCTURE'][0]['FIELD_TYPE'] == 'hidden') { ?>
		<? if(in_array($FIELD_SID, array('product_id', 'product_name', 'product_articul', 'product_url', 'customer_ip'))) { ?>
			<input type="hidden" name="form_<?php echo $arQuestion['STRUCTURE'][0]['FIELD_TYPE'], '_', $arQuestion['STRUCTURE'][0]['FIELD_ID']; ?>" value="<?php echo htmlspecialchars($arParams['custom_params'][$FIELD_SID]); ?>">
		<? } else echo $arQuestion["HTML_CODE"]; ?>
	<? } ?>
	<table style="width: 100%;">
		<tbody>
		<? foreach ($arResult["QUESTIONS"] as $FIELD_SID => $arQuestion) if ($arQuestion['STRUCTURE'][0]['FIELD_TYPE'] != 'hidden') { ?>
			<tr>
				<td>
					<?if (is_array($arResult["FORM_ERRORS"]) && array_key_exists($FIELD_SID, $arResult['FORM_ERRORS'])):?>
						<span class="error-fld" title="<?=$arResult["FORM_ERRORS"][$FIELD_SID]?>"></span>
					<?endif;?>
					<?=$arQuestion["CAPTION"]?><?if ($arQuestion["REQUIRED"] == "Y"):?><?=$arResult["REQUIRED_SIGN"];?><?endif;?>
					<?=$arQuestion["IS_INPUT_CAPTION_IMAGE"] == "Y" ? "<br />".$arQuestion["IMAGE"]["HTML_CODE"] : ""?>
				</td>
				<td>
					<div class="form-group">
						<input
							type="<?php echo $arQuestion['STRUCTURE'][0]['FIELD_TYPE']; ?>"
							name="form_<?php echo $arQuestion['STRUCTURE'][0]['FIELD_TYPE'], '_', $arQuestion['STRUCTURE'][0]['FIELD_ID']; ?>"
							class="form-control"
							<?php if($arQuestion['REQUIRED']=='Y') echo 'required'; ?>
							value="<?php echo htmlspecialchars($arQuestion['VALUE']); ?>"
						>
					</div>
				</td>
			</tr>
		<? } ?>
		<? if($arResult["isUseCaptcha"] == "Y") { ?>
			<tr>
				<th colspan="2"><b><?=GetMessage("FORM_CAPTCHA_TABLE_TITLE")?></b></th>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td><input type="hidden" name="captcha_sid" value="<?=htmlspecialcharsbx($arResult["CAPTCHACode"]);?>" /><img src="/bitrix/tools/captcha.php?captcha_sid=<?=htmlspecialcharsbx($arResult["CAPTCHACode"]);?>" width="180" height="40" /></td>
			</tr>
			<tr>
				<td><?=GetMessage("FORM_CAPTCHA_FIELD_TITLE")?><?=$arResult["REQUIRED_SIGN"];?></td>
				<td><input type="text" name="captcha_word" size="30" maxlength="50" value="" class="inputtext" /></td>
			</tr>
		<? } ?>
		</tbody>
		<tfoot>
		<tr>
			<th colspan="2">
				<input type="hidden" name="web_form_submit" value="<?=htmlspecialcharsbx(strlen(trim($arResult["arForm"]["BUTTON"])) <= 0 ? GetMessage("FORM_ADD") : $arResult["arForm"]["BUTTON"]);?>" />
				<div class="text-center">
					<button class="btn btn-primary" <?=(intval($arResult["F_RIGHT"]) < 10 ? "disabled=\"disabled\"" : "");?>><?=htmlspecialcharsbx(strlen(trim($arResult["arForm"]["BUTTON"])) <= 0 ? GetMessage("FORM_ADD") : $arResult["arForm"]["BUTTON"]);?></button>
				</div>
			</th>
		</tr>
		</tfoot>
	</table>
    <!-- FORM_FOOTER -->
	<?=$arResult["FORM_FOOTER"]?>
<? } ?>
<!-- END -->
