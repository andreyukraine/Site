<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
foreach ($arResult['ITEMS']['AnDelCanBuy'] as $i) {
	$el = CIBlockElement::GetProperty(2, $i['ID'], "sort", "asc", array());
	$props = array();
	while($j = $el->Fetch())
		$props[$j['CODE']] = $j['VALUE'];
	// echo '<xmp>'; print_r($props); echo '</xmp>';
}
?>
