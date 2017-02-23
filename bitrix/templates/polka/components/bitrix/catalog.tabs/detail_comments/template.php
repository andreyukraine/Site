<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);

if (isset($arParams["DATA"]) && !empty($arParams["DATA"]) && is_array($arParams["DATA"]))
{
	$content = "";
	$activeTabId = "";
	$jsObjName = "catalogTabs_".$arResult["ID"];
	$tabIDList = array();
?>
<div id="<? echo $arResult["ID"]; ?>" class="bx-catalog-tab-section-container"<?=isset($arResult["WIDTH"]) ? ' style="width: '.$arResult["WIDTH"].'px;"' : ''?>>
	<ul class="bx-catalog-tab-list" style="left: 0px;">
		<?
		foreach ($arParams["DATA"] as $tabId => $arTab)
		{
			if (isset($arTab["NAME"]) && isset($arTab["CONTENT"]))
			{
				$id = $arResult["ID"].$tabId;
				$tabActive = (isset($arTab["ACTIVE"]) && $arTab["ACTIVE"] == "Y");
				?><li id="<?=$id?>"><span><?=$arTab["NAME"]?></span></li><?
				if($tabActive || $activeTabId == "")
					$activeTabId = $tabId;

				$content .= '<div id="'.$id.'_cont" class="tab-off">'.$arTab["CONTENT"].'</div>';
				$tabIDList[] = $tabId;
			}
		}
		?>
	</ul>
	<div class="bx-catalog-tab-body-container">
		<div class="container">
			<div class="tab-body-container-review">
				<div class="tab-body-container-review-content">
					<div class="review_photo">
					
					</div>
					<div class="review_info">
						<div class="review_name">
							John Dou
						</div>
						<div class="review_data">
							(06.08.2015 21:04:22)
						</div>
						<div class="main_review">
							Lorem ipsum dolor sit amet, consectetur adipisicing elit. Esse qui nulla vel
							aspernatur repellat libero deleniti tempora 
						</div>
					</div>
					<div class="review_buttons_wrap">
						<span><a href="">Нравиться</a></span>
						<span><a href="">Ответить</a></span>
					</div>
				</div>
			</div>
			<div class="tab-body-container-review-review">
				<div class="tab-body-container-review-content">
					<div class="review_photo">
					
					</div>
					<div class="review_info">
						<div class="review_name">
							John Dou
						</div>
						<div class="review_data">
							(06.08.2015 21:04:22)
						</div>
						<div class="main_review">
							Lorem ipsum dolor sit amet, consectetur adipisicing elit. Esse qui nulla vel
							aspernatur repellat libero deleniti tempora 
						</div>
					</div>
					<div class="review_buttons_wrap">
						<span><a href="">Нравиться</a></span>
						<span><a href="">Ответить</a></span>
					</div>
				</div>
			</div>
			</div>
			<div class="review_input">
				<h2>Написать отзыв</h2>
			
				<input type="text" class="review_input_name" placeholder="Имя:">
				<input type="text" class="review_input_text" placeholder="Ваш отзыв:">
				<div class="review_capcha">
					<div class="review_capcha_info">
						Введите число, изображенное на рисунке:
					</div>
					<div class="review_capcha_img">
					
					</div>
					<input type="text" class="review_capcha_input">
				</div>
				<div class="input_capcha_send_block">
					<span class="facebook_plugin"><a href="#"><img src="/bitrix/templates/polka/images/facebook-icon.png" alt="">Facebooks comments plugin</a> </span>
					<a href="#" class="review_button sprite_review_active"></a>
				</div>
			</div>	
			<!--<?=$content?>-->
		</div>
	</div>
</div>
<?
$arJSParams = array(
	'activeTabId' =>  $activeTabId,
	'tabsContId' => $arResult["ID"],
	'tabList' => $tabIDList
);
?>
<script type="text/javascript">
var <?=$jsObjName?> = new JCCatalogTabs(<? echo CUtil::PhpToJSObject($arJSParams, false, true); ?>);
</script>
<?
}
?>