<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?
$is_Akzii = 0;
echo ShowError($arResult["ERROR_MESSAGE"]);

$bDelayColumn  = false;
$bDeleteColumn = false;
$bWeightColumn = false;
$bPropsColumn  = false;
$bPriceType    = false;

if ($normalCount > 0):
?>
<?/*
<div id="basket_items_list">
	<div class="bx_ordercart_order_table_container">
		<div class="basket_block" id="basket_items">
			<div class="basket_block_header">
				<span class="basket_block_header_item item">Товары</span>
				<span class="basket_block_header_discount">Скидка</span>
				<span class="basket_block_header_weight">Вес</span>
				<span class="basket_block_header_price">Цена</span>
				<span class="basket_block_header_quantity">Количество</span>
				<span class="basket_block_header_sum">Сумма</span>
			</div>
		</div>
	</div>
</div>
<? foreach($arResult["GRID"]["ROWS"] as $k => $arItem) {
	?>
	<div class="basket_block_cart">
		<div class="basket_block_cart_item">
			<div class="basket_block_cart_item_photo">
				<?
					if (strlen($arItem["PREVIEW_PICTURE_SRC"]) > 0):
						$url = $arItem["PREVIEW_PICTURE_SRC"];
					elseif (strlen($arItem["DETAIL_PICTURE_SRC"]) > 0):
						$url = $arItem["DETAIL_PICTURE_SRC"];
					else:
						$url = $templateFolder."/images/no_photo.png";
					endif;
					?>
					<?if (strlen($arItem["DETAIL_PAGE_URL"]) > 0):?><a href="<?=$arItem["DETAIL_PAGE_URL"] ?>"><?endif;?>
						<div class="bx_ordercart_photo" style="background-image:url('<?=$url?>')"></div>
					<?if (strlen($arItem["DETAIL_PAGE_URL"]) > 0):?></a><?endif;?>
			</div>
			<div class="basket_block_cart_item_text">
				<?if (strlen($arItem["DETAIL_PAGE_URL"]) > 0):?><a href="<?=$arItem["DETAIL_PAGE_URL"] ?>"><?endif;?>
					<?=$arItem["NAME"]?>
				<?if (strlen($arItem["DETAIL_PAGE_URL"]) > 0):?></a><?endif;?>
				<div class="bx_ordercart_itemart">
					<?
						if ($bPropsColumn):
							foreach ($arItem["PROPS"] as $val):
								if (is_array($arItem["SKU_DATA"]))
									{
										$bSkip = false;
										foreach ($arItem["SKU_DATA"] as $propId => $arProp)
											{
												if ($arProp["CODE"] == $val["CODE"])
												{
													$bSkip = true;
													break;
												}
											}
										if ($bSkip)
										continue;
									}
								echo $val["NAME"].":&nbsp;<span>".$val["VALUE"]."<span><br/>";
							endforeach;
						endif;
					?>
				</div>
				<?
					if (is_array($arItem["SKU_DATA"]) && !empty($arItem["SKU_DATA"])):
						foreach ($arItem["SKU_DATA"] as $propId => $arProp):
							$isImgProperty = false;
							if (array_key_exists('VALUES', $arProp) && is_array($arProp["VALUES"]) && !empty($arProp["VALUES"]))
							{
								foreach ($arProp["VALUES"] as $id => $arVal)
								{
									if (isset($arVal["PICT"]) && !empty($arVal["PICT"]) && is_array($arVal["PICT"])
										&& isset($arVal["PICT"]['SRC']) && !empty($arVal["PICT"]['SRC']))
										{
											$isImgProperty = true;
											break;
										}
								}
							}
							$countValues = count($arProp["VALUES"]);
							$full = ($countValues > 5) ? "full" : "";
							if ($isImgProperty): // iblock element relation property
							?>
							<div class="bx_item_detail_scu_small_noadaptive <?=$full?>">
								<span class="bx_item_section_name_gray">
									<?=$arProp["NAME"]?>:
								</span>
								<div class="bx_scu_scroller_container">
									<div class="bx_scu">
										<ul id="prop_<?=$arProp["CODE"]?>_<?=$arItem["ID"]?>"
											style="width: 200%; margin-left:0%;"
											class="sku_prop_list"
										>
											<?
												foreach ($arProp["VALUES"] as $valueId => $arSkuValue):
													$selected = "";
														foreach ($arItem["PROPS"] as $arItemProp):
															if ($arItemProp["CODE"] == $arItem["SKU_DATA"][$propId]["CODE"])
															{
																if ($arItemProp["VALUE"] == $arSkuValue["NAME"] || $arItemProp["VALUE"] == $arSkuValue["XML_ID"])
																	$selected = "bx_active";
															}
														endforeach;
													?>
													<li style="width:10%;"
														class="sku_prop <?=$selected?>"
														data-value-id="<?=$arSkuValue["XML_ID"]?>"
														data-element="<?=$arItem["ID"]?>"
														data-property="<?=$arProp["CODE"]?>"
														>
														<a href="javascript:void(0);">
															<span style="background-image:url(<?=$arSkuValue["PICT"]["SRC"]?>)"></span>
														</a>
													</li>
													<?
												endforeach;
											?>
										</ul>
									</div>
									<div class="bx_slide_left" onclick="leftScroll('<?=$arProp["CODE"]?>', <?=$arItem["ID"]?>, <?=$countValues?>);"></div>
									<div class="bx_slide_right" onclick="rightScroll('<?=$arProp["CODE"]?>', <?=$arItem["ID"]?>, <?=$countValues?>);"></div>
								</div>
							</div>
							<?
								else:
							?>
								<div class="bx_item_detail_size_small_noadaptive <?=$full?>">
									<span class="bx_item_section_name_gray">
										<?=$arProp["NAME"]?>:
									</span>
									<div class="bx_size_scroller_container">
										<div class="bx_size">
											<ul id="prop_<?=$arProp["CODE"]?>_<?=$arItem["ID"]?>"
												style="width: 200%; margin-left:0%;"
												class="sku_prop_list"
											>
												<?
													foreach ($arProp["VALUES"] as $valueId => $arSkuValue):
														$selected = "";
															foreach ($arItem["PROPS"] as $arItemProp):
																if ($arItemProp["CODE"] == $arItem["SKU_DATA"][$propId]["CODE"])
																{
																	if ($arItemProp["VALUE"] == $arSkuValue["NAME"])
																		$selected = "bx_active";
																}
															endforeach;
															?>
															<li style="width:10%;"
																class="sku_prop <?=$selected?>"
																data-value-id="<?=$arSkuValue["NAME"]?>"
																data-element="<?=$arItem["ID"]?>"
																data-property="<?=$arProp["CODE"]?>"
																>
																<a href="javascript:void(0);"><?=$arSkuValue["NAME"]?></a>
															</li>
															<?
															endforeach;
															?>
											</ul>
										</div>
										<div class="bx_slide_left" onclick="leftScroll('<?=$arProp["CODE"]?>', <?=$arItem["ID"]?>, <?=$countValues?>);"></div>
										<div class="bx_slide_right" onclick="rightScroll('<?=$arProp["CODE"]?>', <?=$arItem["ID"]?>, <?=$countValues?>);"></div>
									</div>
								</div>
								<?
								endif;
						endforeach;
					endif;
				?>
			</div>
		</div>
		<div class="basket_block_cart_discount">
			<div id="discount_value_<?=$arItem["ID"]?>"><?=$arItem["DISCOUNT_PRICE_PERCENT_FORMATED"]?></div>
		</div>
	</div>
	<?
}
*/?>
<div id="basket_items_list">
	<div class="bx_ordercart_order_table_container">
		<table id="basket_items">
			<thead>
				<tr>
					<td class="margin"></td>
					<?
					foreach ($arResult["GRID"]["HEADERS"] as $id => $arHeader){
						$arHeader["name"] = (isset($arHeader["name"]) ? (string)$arHeader["name"] : '');
						if ($arHeader["name"] == '')
							$arHeader["name"] = GetMessage("SALE_".$arHeader["id"]);
						$arHeaders[] = $arHeader["id"];

						// remember which values should be shown not in the separate columns, but inside other columns
						if (in_array($arHeader["id"], array("TYPE")))
						{
							$bPriceType = true;
							continue;
						}
						elseif ($arHeader["id"] == "PROPS")
						{
							$bPropsColumn = true;
							continue;
						}
						elseif ($arHeader["id"] == "DELAY")
						{
							$bDelayColumn = true;
							continue;
						}
						elseif ($arHeader["id"] == "DELETE")
						{
							$bDeleteColumn = true;
							continue;
						}
						elseif ($arHeader["id"] == "WEIGHT")
						{
							$bWeightColumn = true;
						}

						if ($arHeader["id"] == "NAME"):
						?>
							<td class="item" colspan="2" id="col_<?=$arHeader["id"];?>">
						<?
						elseif ($arHeader["id"] == "PRICE"):
						?>
							<td class="price" id="col_<?=$arHeader["id"];?>">
						<?
						else:
						?>
							<td class="custom" id="col_<?=$arHeader["id"];?>">
						<?
						endif;
						?>
							<?=$arHeader["name"]; ?>
							</td>
					<?
					}

					if ($bDeleteColumn || $bDelayColumn):
					?>
						<td class="custom"></td>
					<?
					endif;
					?>
						<td class="margin"></td>
				</tr>
			</thead>

			<tbody>
				<?
				foreach ($arResult["GRID"]["ROWS"] as $k => $arItem):
					// echo '<xmp>'; print_r($arItem); echo '</xmp>';
					if(!empty($arItem['OLD_PRICE'])) $is_Akzii = 1;
					if ($arItem["DELAY"] == "N" && $arItem["CAN_BUY"] == "Y"):
				?>
					<tr id="<?=$arItem["ID"]?>">
						<td class="margin"></td>
						<?
						foreach ($arResult["GRID"]["HEADERS"] as $id => $arHeader):

							if (in_array($arHeader["id"], array("PROPS", "DELAY", "DELETE", "TYPE"))) // some values are not shown in the columns in this template
								continue;

							if ($arHeader["id"] == "NAME"):
							?>
								<td class="itemphoto">
									<div class="bx_ordercart_photo_container">
										<?
										if (strlen($arItem["PREVIEW_PICTURE_SRC"]) > 0):
											$url = $arItem["PREVIEW_PICTURE_SRC"];
										elseif (strlen($arItem["DETAIL_PICTURE_SRC"]) > 0):
											$url = $arItem["DETAIL_PICTURE_SRC"];
										else:
											$url = $templateFolder."/images/no_photo.png";
										endif;
										?>

										<?if (strlen($arItem["DETAIL_PAGE_URL"]) > 0):?><a href="<?=$arItem["DETAIL_PAGE_URL"] ?>"><?endif;?>
											<div class="bx_ordercart_photo" style="background-image:url('<?=$url?>')"></div>
										<?if (strlen($arItem["DETAIL_PAGE_URL"]) > 0):?></a><?endif;?>
									</div>
									<?
									if (!empty($arItem["BRAND"])):
									?>
									<div class="bx_ordercart_brand">
										<img alt="" src="<?=$arItem["BRAND"]?>" />
									</div>
									<?
									endif;
									?>
								</td>
								<td class="item">
									<h2 class="bx_ordercart_itemtitle">
										<?if (strlen($arItem["DETAIL_PAGE_URL"]) > 0):?><a href="<?=$arItem["DETAIL_PAGE_URL"] ?>"><?endif;?>
											<?=$arItem["NAME"]?>
										<?if (strlen($arItem["DETAIL_PAGE_URL"]) > 0):?></a><?endif;?>
									</h2>
									<div class="bx_ordercart_itemart">
										<?
										if ($bPropsColumn):
											foreach ($arItem["PROPS"] as $val):

												if (is_array($arItem["SKU_DATA"]))
												{
													$bSkip = false;
													foreach ($arItem["SKU_DATA"] as $propId => $arProp)
													{
														if ($arProp["CODE"] == $val["CODE"])
														{
															$bSkip = true;
															break;
														}
													}
													if ($bSkip)
														continue;
												}

												echo $val["NAME"].":&nbsp;<span>".$val["VALUE"]."<span><br/>";
											endforeach;
										endif;
										?>
									</div>
									<?
									if (is_array($arItem["SKU_DATA"]) && !empty($arItem["SKU_DATA"])):
										foreach ($arItem["SKU_DATA"] as $propId => $arProp):

											// if property contains images or values
											$isImgProperty = false;
											if (array_key_exists('VALUES', $arProp) && is_array($arProp["VALUES"]) && !empty($arProp["VALUES"]))
											{
												foreach ($arProp["VALUES"] as $id => $arVal)
												{
													if (isset($arVal["PICT"]) && !empty($arVal["PICT"]) && is_array($arVal["PICT"])
														&& isset($arVal["PICT"]['SRC']) && !empty($arVal["PICT"]['SRC']))
													{
														$isImgProperty = true;
														break;
													}
												}
											}
											$countValues = count($arProp["VALUES"]);
											$full = ($countValues > 5) ? "full" : "";

											if ($isImgProperty): // iblock element relation property
											?>
												<div class="bx_item_detail_scu_small_noadaptive <?=$full?>">

													<span class="bx_item_section_name_gray">
														<?=$arProp["NAME"]?>:
													</span>

													<div class="bx_scu_scroller_container">

														<div class="bx_scu">
															<ul id="prop_<?=$arProp["CODE"]?>_<?=$arItem["ID"]?>"
																style="width: 200%; margin-left:0%;"
																class="sku_prop_list"
																>
																<?
																foreach ($arProp["VALUES"] as $valueId => $arSkuValue):

																	$selected = "";
																	foreach ($arItem["PROPS"] as $arItemProp):
																		if ($arItemProp["CODE"] == $arItem["SKU_DATA"][$propId]["CODE"])
																		{
																			if ($arItemProp["VALUE"] == $arSkuValue["NAME"] || $arItemProp["VALUE"] == $arSkuValue["XML_ID"])
																				$selected = "bx_active";
																		}
																	endforeach;
																?>
																	<li style="width:10%;"
																		class="sku_prop <?=$selected?>"
																		data-value-id="<?=$arSkuValue["XML_ID"]?>"
																		data-element="<?=$arItem["ID"]?>"
																		data-property="<?=$arProp["CODE"]?>"
																		>
																		<a href="javascript:void(0);">
																			<span style="background-image:url(<?=$arSkuValue["PICT"]["SRC"]?>)"></span>
																		</a>
																	</li>
																<?
																endforeach;
																?>
															</ul>
														</div>

														<div class="bx_slide_left" onclick="leftScroll('<?=$arProp["CODE"]?>', <?=$arItem["ID"]?>, <?=$countValues?>);"></div>
														<div class="bx_slide_right" onclick="rightScroll('<?=$arProp["CODE"]?>', <?=$arItem["ID"]?>, <?=$countValues?>);"></div>
													</div>

												</div>
											<?
											else:
											?>
												<div class="bx_item_detail_size_small_noadaptive <?=$full?>">

													<span class="bx_item_section_name_gray">
														<?=$arProp["NAME"]?>:
													</span>

													<div class="bx_size_scroller_container">
														<div class="bx_size">
															<ul id="prop_<?=$arProp["CODE"]?>_<?=$arItem["ID"]?>"
																style="width: 200%; margin-left:0%;"
																class="sku_prop_list"
																>
																<?
																foreach ($arProp["VALUES"] as $valueId => $arSkuValue):

																	$selected = "";
																	foreach ($arItem["PROPS"] as $arItemProp):
																		if ($arItemProp["CODE"] == $arItem["SKU_DATA"][$propId]["CODE"])
																		{
																			if ($arItemProp["VALUE"] == $arSkuValue["NAME"])
																				$selected = "bx_active";
																		}
																	endforeach;
																?>
																	<li style="width:10%;"
																		class="sku_prop <?=$selected?>"
																		data-value-id="<?=$arSkuValue["NAME"]?>"
																		data-element="<?=$arItem["ID"]?>"
																		data-property="<?=$arProp["CODE"]?>"
																		>
																		<a href="javascript:void(0);"><?=$arSkuValue["NAME"]?></a>
																	</li>
																<?
																endforeach;
																?>
															</ul>
														</div>
														<div class="bx_slide_left" onclick="leftScroll('<?=$arProp["CODE"]?>', <?=$arItem["ID"]?>, <?=$countValues?>);"></div>
														<div class="bx_slide_right" onclick="rightScroll('<?=$arProp["CODE"]?>', <?=$arItem["ID"]?>, <?=$countValues?>);"></div>
													</div>

												</div>
											<?
											endif;
										endforeach;
									endif;
									?>
								</td>
							<?
							elseif ($arHeader["id"] == "QUANTITY"):
							?>
								<td class="custom">
									<span><?=$arHeader["name"]; ?>:</span>
									<div class="centered">
										<table cellspacing="0" cellpadding="0" class="counter">
											<tr>
												<td>
													<?
													$ratio = isset($arItem["MEASURE_RATIO"]) ? $arItem["MEASURE_RATIO"] : 0;
													$max = isset($arItem["AVAILABLE_QUANTITY"]) ? "max=\"".$arItem["AVAILABLE_QUANTITY"]."\"" : "";
													$useFloatQuantity = ($arParams["QUANTITY_FLOAT"] == "Y") ? true : false;
													$useFloatQuantityJS = ($useFloatQuantity ? "true" : "false");
													?>
													<input
														type="text"
														size="3"
														id="QUANTITY_INPUT_<?=$arItem["ID"]?>"
														name="QUANTITY_INPUT_<?=$arItem["ID"]?>"
														size="2"
														maxlength="18"
														min="0"
														<?=$max?>
														step="<?=$ratio?>"
														style="max-width: 50px"
														value="<?=$arItem["QUANTITY"]?>"
														onchange="updateQuantity('QUANTITY_INPUT_<?=$arItem["ID"]?>', '<?=$arItem["ID"]?>', <?=$ratio?>, <?=$useFloatQuantityJS?>)"
													>
												</td>
												<?
												if (!isset($arItem["MEASURE_RATIO"]))
												{
													$arItem["MEASURE_RATIO"] = 1;
												}
												?>
												<?
												if ($bDeleteColumn):
												?>
													<a href="<?=str_replace("#ID#", $arItem["ID"], $arUrls["delete"])?>"><div class="trash_icon"></div></a>
												<?
												endif;
												?>
											</tr>
										</table>
									</div>
									<input type="hidden" id="QUANTITY_<?=$arItem['ID']?>" name="QUANTITY_<?=$arItem['ID']?>" value="<?=$arItem["QUANTITY"]?>" />
								</td>
							<?
							elseif ($arHeader["id"] == "PRICE"):
							?>
								<td class="price">
										<div class="current_price" id="current_price_<?=$arItem["ID"]?>">
											<? 
												// echo site::convertPrice($arItem["PRICE_FORMATED"]), ' ', site::getCurrency(); 
												echo CCurrencyLang::CurrencyFormat(str_replace(" ", "", $arItem["PRICE_FORMATED"]), site::getCurrency(), true); 
												?>
										</div>
										<div class="old_price" id="old_price_<?=$arItem["ID"]?>">
											<?if (floatval($arItem["DISCOUNT_PRICE_PERCENT"]) > 0):?>
												<? 
												// echo site::convertPrice($arItem["FULL_PRICE_FORMATED"]), ' ', site::getCurrency(); 
												echo CCurrencyLang::CurrencyFormat(str_replace(" ", "", $arItem["FULL_PRICE_FORMATED"]), site::getCurrency(), true); 
												?>
											<?endif;?>
										</div>

									<?if ($bPriceType && strlen($arItem["NOTES"]) > 0):?>
										<div class="type_price"><?=GetMessage("SALE_TYPE")?></div>
										<div class="type_price_value"><?=$arItem["NOTES"]?></div>
									<?endif;?>
								</td>
							<?
							elseif ($arHeader["id"] == "DISCOUNT"):
							?>
								<td class="custom">
									<span><?=$arHeader["name"]; ?>:</span>
									<div id="discount_value_<?=$arItem["ID"]?>"><?=$arItem["DISCOUNT_PRICE_PERCENT_FORMATED"]?></div>
								</td>
							<?
							elseif ($arHeader["id"] == "WEIGHT"):
							?>
								<td class="custom">
									<span><?=$arHeader["name"]; ?>:</span>
									<?=number_format($arItem['WEIGHT'] / 1000, 2, '.', ' ')?> кг
								</td>
							<?
							else:
							?>
								<td class="custom">
									<span><?=$arHeader["name"]; ?>:</span>
									<?
									if ($arHeader["id"] == "SUM"):
									?>
										<div id="sum_<?=$arItem["ID"]?>" class="price_sum">
									<?
									endif;

									echo site::convertPrice($arItem[$arHeader["id"]]), ' ', site::getCurrency();
									// echo CCurrencyLang::CurrencyFormat(site::ConvertPrice($arItem[$arHeader["id"]]), site::getCurrency(), true);

									if ($arHeader["id"] == "SUM"):
									?>
										</div>
									<?
									endif;
									?>
								</td>
							<?
							endif;
						endforeach;

						if ($bDelayColumn || $bDeleteColumn):
						?>
							<td class="control">
								<?
								if ($bDelayColumn):
								?>
									<a href="<?=str_replace("#ID#", $arItem["ID"], $arUrls["delay"])?>" class="delay_link"><div class="basket_block_cart_postponed_button">
				<button>Отложить</button>
			</div></a>
								<?
								endif;
								?>
							</td>
						<?
						endif;
						?>
							<td class="margin"></td>
					</tr>
					<?
					endif;
				endforeach;
				?>
			</tbody>
		</table>
	</div>
	<input type="hidden" id="column_headers" value="<?=CUtil::JSEscape(implode($arHeaders, ","))?>" />
	<input type="hidden" id="offers_props" value="<?=CUtil::JSEscape(implode($arParams["OFFERS_PROPS"], ","))?>" />
	<input type="hidden" id="action_var" value="<?=CUtil::JSEscape($arParams["ACTION_VARIABLE"])?>" />
	<input type="hidden" id="quantity_float" value="<?=$arParams["QUANTITY_FLOAT"]?>" />
	<input type="hidden" id="count_discount_4_all_quantity" value="<?=($arParams["COUNT_DISCOUNT_4_ALL_QUANTITY"] == "Y") ? "Y" : "N"?>" />
	<input type="hidden" id="price_vat_show_value" value="<?=($arParams["PRICE_VAT_SHOW_VALUE"] == "Y") ? "Y" : "N"?>" />
	<input type="hidden" id="hide_coupon" value="<?=($arParams["HIDE_COUPON"] == "Y") ? "Y" : "N"?>" />
	<input type="hidden" id="coupon_approved" value="N" />
	<input type="hidden" id="use_prepayment" value="<?=($arParams["USE_PREPAYMENT"] == "Y") ? "Y" : "N"?>" />

	<div class="bx_ordercart_order_pay">

		<div class="bx_ordercart_order_pay_left">
			<div class="bx_ordercart_coupon">
				<?
				if(strlen($arResult["COUPON"])) {
					$couponval = $arResult["COUPON"];
				} elseif(strlen($_SESSION['COUPON'])) {
					$couponval = $_SESSION['COUPON'];
				} else {
					$couponval = "";
				}
				if ($arParams["HIDE_COUPON"] != "Y"):

					$couponClass = "";
					if (array_key_exists('VALID_COUPON', $arResult))
					{
						$couponClass = ($arResult["VALID_COUPON"] === true) ? "good" : "bad";
					}
					elseif (array_key_exists('COUPON', $arResult) && !empty($arResult["COUPON"]))
					{
						$couponClass = "good";
					}

				if(!$is_Akzii){
				?>
					<p>Промо-код является идентификатором персональной скидки или бонуса, на получение которых имеют право:
						покупатели, имеющие пластиковые дисконтные карточки (введите цифры, указанные на карточке)
						участники рекламных акций в СМИ (введите промо-код, указанный в рекламе)
						победители различных конкурсов, проводимых нашими партнерами (введите индивидуальный промо-код, полученый по электронной почте)
					</p>
					<span><?=GetMessage("STB_COUPON_PROMT")?></span>
					<input type="text" id="coupon" name="COUPON" value="<?=$couponval?>" onchange="enterCoupon();" size="21" class="<?=$couponClass?>">
				<?php } ?>
				<?else:?>
					&nbsp;
				<?endif;?>
			</div>
		</div>

		<div class="bx_ordercart_order_pay_right">
			<table class="bx_ordercart_order_sum">
				<?if ($bWeightColumn):?>
					<tr>
						<td class="custom_t1"><?=GetMessage("SALE_TOTAL_WEIGHT")?></td>
						<td class="custom_t2" id="allWeight_FORMATED"><? 
							// echo site::convertPrice($arResult["allWeight_FORMATED"]), ' ', site::getCurrency(); 
							// echo '<xmp style="text-align: left;">'; print_r($arResult); echo '</xmp>';
							echo number_format($arResult["allWeight"] / 1000, 2, '.', ' '); 
						?> кг</td>
					</tr>
				<?endif;?>
				<?if ($arParams["PRICE_VAT_SHOW_VALUE"] == "Y"):?>
					<tr>
						<td><?echo GetMessage('SALE_VAT_EXCLUDED')?></td>
						<td id="allSum_wVAT_FORMATED"><? 
						// echo site::convertPrice($arResult["allSum_wVAT_FORMATED"]), ' ', site::getCurrency(); 
						echo site::ConvertPrice($arResult["allSum_wVAT_FORMATED"]), ' ', site::getCurrency();
						?></td>
					</tr>
					<?php /* ?>
					<tr>
						<td><?echo GetMessage('SALE_VAT_INCLUDED')?></td>
						<td id="allVATSum_FORMATED"><? 
						// echo site::convertPrice($arResult["allVATSum_FORMATED"]), ' ', site::getCurrency(); 
						echo site::ConvertPrice($arResult["allVATSum_FORMATED"]), ' ', site::getCurrency();
						?></td>
					</tr>
					<?php */ ?>
				<?endif;?>

					<tr>
						<td class="fwb"><?=GetMessage("SALE_TOTAL")?></td>
						<td class="fwb" id="allSum_FORMATED"><? 
						// echo str_replace(" ", "&nbsp;", site::convertPrice($arResult["allSum_FORMATED"])), ' ', site::getCurrency(); 
						echo site::ConvertPrice($arResult["allSum_FORMATED"]), ' ', site::getCurrency();
						?></td>
					</tr>
					<tr>
						<td class="custom_t1"></td>
						<td class="custom_t2" style="text-decoration:line-through; color:#828282;" id="PRICE_WITHOUT_DISCOUNT">
							<?if (floatval($arResult["DISCOUNT_PRICE_ALL"]) > 0):?>
								<?php echo site::ConvertPrice($arResult["PRICE_WITHOUT_DISCOUNT"]), ' ', site::getCurrency(); ?>
							<?endif;?>
						</td>
					</tr>

			</table>
			<div style="clear:both;"></div>
		</div>
		<div style="clear:both;"></div>

		<div class="bx_ordercart_order_pay_center">
				<div class="basket_block_cart_bottom_buttons">
					<a href="/"><div class="basket_block_cart_back"></div></a>
					<a href="javascript:void(0)" onclick="checkOut();"><div class="basket_block_cart_forward"></div></a>
				</div>
			<?if ($arParams["USE_PREPAYMENT"] == "Y" && strlen($arResult["PREPAY_BUTTON"]) > 0):?>
				<?=$arResult["PREPAY_BUTTON"]?>
				<span><?=GetMessage("SALE_OR")?></span>
			<?endif;?>

			<?/*<a href="javascript:void(0)" onclick="checkOut();" class="checkout"><?=GetMessage("SALE_ORDER")?></a>*/?>
		</div>
	</div>
</div>
<?
else:
?>
<div id="basket_items_list">
	<table>
		<tbody>
			<tr>
				<td colspan="<?=$numCells?>" style="text-align:center">
					<div class=""><?=GetMessage("SALE_NO_ITEMS");?></div>
				</td>
			</tr>
		</tbody>
	</table>
</div>
<?
endif;
?>