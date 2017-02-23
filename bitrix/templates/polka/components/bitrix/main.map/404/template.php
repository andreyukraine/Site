<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if (!is_array($arResult["arMap"]) || count($arResult["arMap"]) < 1)
	return;

$arRootNode = Array();
foreach($arResult["arMap"] as $index => $arItem)
{
	if ($arItem["LEVEL"] == 0)
		$arRootNode[] = $index;
}

$allNum = count($arRootNode);
$colNum = ceil($allNum / $arParams["COL_NUM"]);

?>




	<?foreach ($arResult["arMap"] as $index => $arItem):?>

		<ul>
			<li><a href="<?=$arItem["FULL_PATH"]?>"><?=$arItem["NAME"]?></a></li>
		</ul>

	<?endforeach;?>
