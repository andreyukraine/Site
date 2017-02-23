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

$arViewModeList = $arResult['VIEW_MODE_LIST'];

$arViewStyles = array(
	'LIST' => array(
		'CONT' => 'bx_sitemap',
		'TITLE' => 'bx_sitemap_title',
		'LIST' => 'bx_sitemap_ul',
	)
);
$arCurView = $arViewStyles[$arParams['VIEW_MODE']];

$strSectionEdit = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_EDIT");
$strSectionDelete = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_DELETE");
$arSectionDeleteParams = array("CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM'));
?>
<div class="categories">
	<div class="container">
		<div class="row">
			<?
				$current_depth = 1;
				$last_depth = 1;
				$last_link = '';
				$last_cat = '';
				foreach($arResult['SECTIONS'] as &$arSection) {
					if($arSection['DEPTH_LEVEL'] == 1 && ($arSection['RIGHT_MARGIN'] - $arSection['LEFT_MARGIN']) == 1) continue;
					$current_depth = $arSection['DEPTH_LEVEL'];
					if($current_depth == 1 && $last_depth == 1) {
						$last_link = $arSection['SECTION_PAGE_URL'];
						$last_cat = $arSection['NAME'];
					}
					if($last_depth == 2 && $current_depth == 1) {
						?>
						</ul><div class="categories_button"><button><a href="<?=$last_link?>">Все <?=$last_cat?></a></button></div></div></div></div>
						<?
						$last_link = $arSection['SECTION_PAGE_URL'];
						$last_cat = $arSection['NAME'];
					}
					if($current_depth == 1) {
						$this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], $strSectionEdit);
						$this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], $strSectionDelete, $arSectionDeleteParams);
						?>
						<div class="col-md-2" id="<?=$this->GetEditAreaId($arSection['ID']);?>"><div class="categories_row"><div class="categories_header"><h3><?=$arSection['NAME']?></h3></div><div class="categories_list"><ul>
						<?
					} else {
						?>
						<li><a href="<?=$arSection['SECTION_PAGE_URL']?>"><?=$arSection['NAME']?></a></li>
						<?
					}
					$last_depth = $current_depth;
				}
			?>
			</ul><div class="categories_button"><button><a href="<?=$last_link?>">Все <?=$last_cat?></a></button></div></div></div></div>
		</div>
	</div>
</div>