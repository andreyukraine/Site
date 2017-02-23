<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?IncludeTemplateLangFile(__FILE__);?>

<script>
var MD_FILL='<?=GetMessage("MD_JS_FILL")?>';
var MD_EMAIL_ERROR='<?=GetMessage("MD_JS_EMAIL")?>';
var MD_DELETE_MESS='<?=GetMessage("MD_DEL_MESS")?>';
</script>

<div class='md_comment' id='MDComment_Ajax_Container'>

	<?MDComment::Ajax("begin");?>

		<h2><span><?=GetMessage("MD_NAME")?></span></h2>

		<!-- Top Pagination -->
		<?if($arParams["DISPLAY_TOP_PAGER"]):?>
			<?=$arResult["NAV_STRING"]?><br />
		<?endif;?>
		<!-- End: Top Pagination -->

		<!-- Comment Form	-->
		<div class="form comment main_form" id='doComment' <?=($arResult["POST"]["PARENT"]>0)?(" style='display:none' "):("")?> >

			<?if($arParams["NON_AUTHORIZED_USER_CAN_COMMENT"]=="Y" || $USER->isAuthorized()):?>
				<form action="<?=$GLOBALS["APPLICATION"]->GetCurPage()?>" method='POST' id='add_com' onsubmit='return md_validate(this);'>
					<p style='color:green; display:none;' class='md_suc'><?=$arResult["SUCCESS"]?></p>
					<p style='color:red; display:none;'  class='md_err'><?=$arResult["ERROR_MESSAGE"]?></p>
					<span class="title"><?=GetMessage("MD_ADD_NAME")?></span>
					<input type='hidden' value='<?=$arResult["USER"]["ID"]?>' name='AUTHOR'>
					<input type="text" name='NONUSER' value='<?=($arResult["POST"]["NONUSER"])?($arResult["POST"]["NONUSER"]):($arResult["USER"][$arParams["ASNAME"]])?>' placeholder="<?=GetMessage("MD_FNAME")?>" data-value="<?=GetMessage("MD_FNAME")?>" class="w-100 reg" />
					<input type="text" name='MD_EMAIL'  value='<?=($arResult["POST"]["MD_EMAIL"])?($arResult["POST"]["MD_EMAIL"]):($arResult["USER"]["EMAIL"])?>' placeholder="<?=GetMessage("MD_EMAIL")?>" data-value="<?=GetMessage("MD_EMAIL")?>" class="email w-100 reg" />
					<div class="clear pt10"></div>
					<textarea name="MD_MASSAGE" id="message" rows="10" class="reg" placeholder='<?=GetMessage("MD_MESSAGE")?>' data-value="<?=GetMessage("MD_MESSAGE")?>"><?=$arResult["POST"]["MD_MASSAGE"]?></textarea>
					<input type='hidden' name='PARENT' value=''>
					<input type='hidden' name='ACTION' value='add'>
					<input type='hidden' name='MD_POST' value='Y'>
					<input type='hidden' name='DEPTH' value='1'>
					<?if($arParams["USE_CAPTCHA"]=="Y" && !$USER->isAuthorized()):?>
						<div class="md-captcha">
							<div class="md_text"><?=GetMessage("MD_CAP_1")?></div>
							<input type="hidden" name="captcha_sid" value="<?=$arResult["capCode"]?>">
							<img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["capCode"]?>" width="180" height="40" alt="CAPTCHA">
							<div class="md_text"><?=GetMessage("MD_CAP_2")?></div>
							<input type="text" name="captcha_word" size="30" maxlength="50" value="">
							<input type='hidden' name='clear_cache' value='Y'>
						</div>
					<? endif;?>
					<input type="submit" value="" />
				</form>
			<? else:?>
				<div style='background: #FFF;'>
					<?=GetMessage("DO_AUTH", array("#LINK#"=>$arParams["AUTH_PATH"]));?>
				</div>
			<? endif;?>
		</div>
		<!-- END: Comment Form	-->

		<!-- Comments Tree	-->
		<div class="comments">

		<? if($arResult["ITEMS"]):?>
			<? function MD_ShowTree($arItem, $arParams, $arResult) { ?>

				<!-- One Comment Tree-->
				<div class="stock">

					<div class="review-content">
						
						<div class="userAvatar">
							<img src="/bitrix/templates/polka/components/micros/comment/.default/img/avatar.jpg" alt="">
						</div>

						<div class="review-info">

							<!-- User Info-->
							<div class="userInfo">
								<span class="user-name"><?=$arItem["AUTHOR"][$arParams["ASNAME"]]?></span>&nbsp;
								<span class="review-data">(<?=$arItem["PUBLISH_DATE"]?>)</span>
							</div>
							<!-- End: User Info-->

							<!-- User Text-->
							<div class="userText">
								<p><?=$arItem["PUBLISH_TEXT"]?></p>

								<div class='md_action'>
									<? if(($arParams["NON_AUTHORIZED_USER_CAN_COMMENT"]=="Y" || $GLOBALS["USER"]->isAuthorized()) && $arItem["PROPERTIES"]["DEPTH"]["VALUE"]<$arParams["MAX_DEPTH"] ):?>
									<a href="javascript:void();"   onclick='md_add(this, <?=$arItem["ID"]?>); return false' class='md_comment' title='<?=GetMessage("MD_COMMENT")?>'><?=GetMessage("MD_COMMENT")?></a>
									<? endif;?>

								<?if(($arParams["CAN_MODIFY"]=="Y" && $arItem["PROPERTIES"]["USER"]["VALUE"]==$GLOBALS["USER"]->GetID() && $GLOBALS["USER"]->isAuthorized()) || ($GLOBALS["USER"]->isAdmin())):?>

									<? if($arItem["PROPERTIES"]["DEPTH"]["VALUE"]<$arParams["MAX_DEPTH"]):?>| <? endif;?>
									<a href="javascript:void();"  onclick='md_edit(this, <?=$arItem["ID"]?>); return false' title="<?=GetMessage("MD_EDIT")?>" class='md_edit'><?=GetMessage("MD_EDIT")?></a>

									<?if(($arItem["PROPERTIES"]["USER"]["VALUE"]==$GLOBALS["USER"]->GetID() && $GLOBALS["USER"]->isAuthorized()) || ($GLOBALS["USER"]->isAdmin())):?>
									<a href='javascript:void(0)' class='md_close' onclick='md_delete(this, <?=$arItem["ID"]?>);' title='<?=GetMessage("MD_DELETE")?>' ></a>
									<? endif;?>

									<!-- edit form -->
									<div class="form comment form_for"  id='edit_form_<?=$arItem["ID"]?>'  <?=($arResult["POST"]["COM_ID"]==$arItem["ID"])?(" style='display:block' "):("");?>>

										<form action="<?=$GLOBALS["APPLICATION"]->GetCurPage()?>" method='POST' id='add_com' onsubmit='return md_validate(this);'>
											<p style='color:green; display:none' class='md_suc'></p>
											<p style='color:red; display:none'  class='md_err'></p>
											<span class="title"><?=GetMessage("EDIT_FROM_NAME")?></span>
											<textarea name="MD_MASSAGE" id="message" rows="10" class="reg" placeholder='<?=GetMessage("MD_MESSAGE")?>' data-value="<?=GetMessage("MD_MESSAGE")?>"><?=$arItem["~PREVIEW_TEXT"]?></textarea>
											<input type='hidden' name='ACTION' value='update'>
											<input type='hidden' name='MD_POST' value='Y'>
											<input type='hidden' name='COM_ID' value='<?=$arItem["ID"]?>'>
											<input type="submit" value="" />
											<a href="javascript:void(0)" onclick='md_back(); return false' style='margin-top: -25px; text-decoration: none;'><?=GetMessage("MD_BACK_BUTTON")?></a>
										</form>

									</div>
									<!-- edit form -->

								<?endif;?>

								<? if($arParams["NON_AUTHORIZED_USER_CAN_COMMENT"]=="Y" || $GLOBALS["USER"]->isAuthorized() && $arItem["PROPERTIES"]["DEPTH"]["VALUE"]<$arParams["MAX_DEPTH"] ):?>
									<!-- add form -->
									<div class="form comment form_for"  id='add_form_<?=$arItem["ID"]?>' <?=($arResult["POST"]["PARENT"]==$arItem["ID"])?(" style='display:block' "):("")?>>
									<form action="<?=$GLOBALS["APPLICATION"]->GetCurPage()?>" method='POST' id='add_com' onsubmit='return md_validate(this);'>
									<p style='color:green; display:none' class='md_suc'></p>
									<p style='color:red; display:none'  class='md_err'></p>
									<span class="title"><?=GetMessage("MD_ADD_NAME")?></span>
									<input type='hidden' value='<?=$arResult["USER"]["ID"]?>' name='AUTHOR'>
									<input type="text" name='NONUSER' value='<?=($arResult["POST"]["NONUSER"])?($arResult["POST"]["NONUSER"]):($arResult["USER"][$arParams["ASNAME"]])?>' placeholder="<?=GetMessage("MD_FNAME")?>" data-value="<?=GetMessage("MD_FNAME")?>" class="fleft w-45 reg" />
									<input type="text" name='MD_EMAIL'  value='<?=($arResult["POST"]["MD_EMAIL"])?($arResult["POST"]["MD_EMAIL"]):($arResult["USER"]["EMAIL"])?>' placeholder="<?=GetMessage("MD_EMAIL")?>" data-value="<?=GetMessage("MD_EMAIL")?>" class="email fright w-45 reg" />
									<div class="clear pt10"></div>
									<textarea name="MD_MASSAGE" id="message" rows="10" class="reg" placeholder='<?=GetMessage("MD_MESSAGE")?>' data-value="<?=GetMessage("MD_MESSAGE")?>"></textarea>
									<input type='hidden' name='PARENT' value='<?=$arItem["ID"]?>'>
									<input type='hidden' name='ACTION' value='add'>
									<input type='hidden' name='MD_POST' value='Y'>
									<input type='hidden' name='DEPTH' value='<?=($arItem["PROPERTIES"]["DEPTH"]["VALUE"]+1)?>'>
											<?if($arParams["USE_CAPTCHA"]=="Y" && !$GLOBALS["USER"]->isAuthorized()):?>
												<div class="md-captcha">
													<div class="md_text"><?=GetMessage("MD_CAP_1")?></div>
													<input type="hidden" name="captcha_sid" value="<?=$arResult["capCode"]?>">
													<img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["capCode"]?>" width="180" height="40" alt="CAPTCHA">
													<div class="md_text"><?=GetMessage("MD_CAP_2")?></div>
													<input type="text" name="captcha_word" size="30" maxlength="50" value="">
													<input type='hidden' name='clear_cache' value='Y'>
												</div>
											<? endif;?>
									<input type="submit" value="<?=GetMessage("MD_ADD")?>" />
											<a href="javascript:void(0)" onclick='md_back(); return false' style='margin-top: -25px; text-decoration: none;'><?=GetMessage("MD_BACK_BUTTON")?></a>
									</form>

									</div>
									<!-- add form -->
								<? endif;?>

								</div>

							</div>
							<!-- End: User Text-->

						</div>

					</div>

					<?if($arItem["CHILDS"]["ITEMS"]):?>

						<!-- Comment Childs -->
						<?foreach ($arItem["CHILDS"]["ITEMS"] as $item):?>
						<?=MD_ShowTree($item, $arParams, $arResult);?>
						<?endforeach; ?>
						<!--End: Comment Childs -->

					<?endif;?>

				</div>
				<!-- End: One Comment Tree-->

			<? } //end function ?>
		
		
			<?foreach ($arResult["ITEMS"] as $k=>$arItem):?>
				<?=MD_ShowTree($arItem, $arParams, $arResult);?>
			<? endforeach;?>

		<? endif;//if arResult["ITEMS"]?>
		</div>

		<!-- END: Comments Tree	-->

		<!-- Bottom Pagination -->
		<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
		<br /><?=$arResult["NAV_STRING"]?><br>
		<?endif;?>
		<!-- End: Bottom Pagination -->



	<?MDComment::Ajax("end");?>
</div>





	