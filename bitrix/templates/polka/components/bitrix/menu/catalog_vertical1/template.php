<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if (empty($arResult["ALL_ITEMS"]))
	return;
if (file_exists($_SERVER["DOCUMENT_ROOT"].$this->GetFolder().'/themes/'.$arParams["MENU_THEME"].'/colors.css'))
	$APPLICATION->SetAdditionalCSS($this->GetFolder().'/themes/'.$arParams["MENU_THEME"].'/colors.css');

$menuBlockId = "catalog_menu_".$this->randString();
?>
<div class="left-menu">
	<ul>
		<?foreach($arResult["MENU_STRUCTURE"] as $itemID => $arColumns):?>     <!-- first level-->
		<?$existPictureDescColomn = ($arResult["ALL_ITEMS"][$itemID]["PARAMS"]["picture_src"] || $arResult["ALL_ITEMS"][$itemID]["PARAMS"]["description"]) ? true : false;?>
		<? if(empty($arColumns)) continue; ?>
		<li class="<?if($arResult["ALL_ITEMS"][$itemID]["SELECTED"]){?>current<? } ?><?if (is_array($arColumns) && count($arColumns) > 0):?> dropdown<?endif?>">
			<a href="<?=$arResult["ALL_ITEMS"][$itemID]["LINK"]?>">
				<?=$arResult["ALL_ITEMS"][$itemID]["TEXT"]?>
			</a>
			<?if (is_array($arColumns) && count($arColumns) > 0):?>
			<? 
			$res = array(); foreach($arColumns as $key=>$arRow) foreach($arRow as $k=>$v) $res[$k] = $v; $arColumns = array(0=>$res); 
			// print_r($arColumns); ?>
			<?foreach($arColumns as $key=>$arRow):?>
			<ul>
				<? 
				$done1 = 0; $done_max = count($arRow); $j = 0; 
				$has_active = 0; foreach($arRow as $itemIdLevel_2=>$arLevel_3) if($arResult['ALL_ITEMS'][$itemIdLevel_2]["SELECTED"]) { $has_active = 1; break; }
				foreach($arRow as $itemIdLevel_2=>$arLevel_3) { 

				// if($_SERVER['REMOTE_ADDR']=='46.229.55.66') { echo '<xmp>'; print_r($itemIdLevel_2); echo '</xmp>'; }
				if($j>6 && !$done1 && !$has_active) { $done1 = 1; ?>
				<div class="collapsed" style="display: none;"> 
				<?php } ?>
				<li class="parent<? echo ($arResult['ALL_ITEMS'][$itemIdLevel_2]["SELECTED"])?' active':''; ?>">
					<a href="<?=$arResult["ALL_ITEMS"][$itemIdLevel_2]["LINK"]?>">
						<?=$arResult["ALL_ITEMS"][$itemIdLevel_2]["TEXT"]?>
					</a>
					<?if (is_array($arLevel_3) && count($arLevel_3) > 0) { ?>
					<ul>
						<?foreach($arLevel_3 as $itemIdLevel_3):?>
						<li>
							<a href="<?=$arResult["ALL_ITEMS"][$itemIdLevel_3]["LINK"]?>">
								<?=$arResult["ALL_ITEMS"][$itemIdLevel_3]["TEXT"]?>
							</a>
							<span style="display: none">
								<?=$arResult["ALL_ITEMS"][$itemIdLevel_3]["PARAMS"]["description"]?>
							</span>
							<span class="bx_children_advanced_panel">
								<img src="<?=$arResult["ALL_ITEMS"][$itemIdLevel_3]["PARAMS"]["picture_src"]?>" alt="">
							</span>
						</li>
						<?endforeach;?>
					</ul>
					<? } ?>
				</li>
				<?php if($j>6 && $j == $done_max-1 && !$has_active) { ?>
				</div>
				<?php } ?>
				<? $j++; } ?>
				<?php if($j>6 && !$has_active) { ?>
				<span class="see_all" 
					onclick="jQuery(this).parent().children('.collapsed').slideToggle(250); ">Все <?php echo $arResult["ALL_ITEMS"][$itemID]["TEXT"]; ?></span>
				<?php } ?>
			</ul>
			<?endforeach;?>
		<?endif?>
		</li>
		<?endforeach;?>
	</ul>
</div>

<script>
	$('a[href="/catalog/knigi/"]').parent('li.dropdown').insertAfter($('li.dropdown')[0]);
	$('a[href="/catalog/soputstvuyushchie/"]').parent('li.dropdown').insertAfter($('li.dropdown')[4]);
</script>