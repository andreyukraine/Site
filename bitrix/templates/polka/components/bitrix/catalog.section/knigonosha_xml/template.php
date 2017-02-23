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
if(!function_exists('str_limit')) {
	function str_limit($str='', $words=0, $sym=0){
		$str = preg_replace("~(<.*?>|\r\n|\s{2,})~iu", ' ', $str);
		if($words) $str = implode(" ", array_slice(explode(" ", $str), 0, $words));
		if($sym) $str = preg_replace('~^(.{1,'.$sym.'}).*~us', '$1', $str);
		return $str;
	}
}
$this->setFrameMode(true);
header('Content-type: text/xml');
echo '<?xml version="1.0"?>'.PHP_EOL;
if (empty($arResult['ITEMS'])) return; ?>
<AmazonEnvelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="amzn-envelope.xsd">
	<Header>
		<DocumentVersion>1.01</DocumentVersion>
		<MerchantIdentifier>My_Merch_ID</MerchantIdentifier>
	</Header>
	<MessageType>Product</MessageType>
	<PurgeAndReplace>false</PurgeAndReplace>
	<? 
		$c = 1; foreach ($arResult['ITEMS'] as &$arItem) { 
			$catalog_vars = CCatalogProduct::GetByID($arItem['ID']);
			$time = date("Y-m-d\TH:i:s");
	?>
	<Message>
		<MessageID><?php echo $c++; ?></MessageID>
		<OperationType>Update</OperationType>
		<Product>
			<SKU><?php echo $arItem['XML_ID']; ?></SKU>
			<StandardProductID>
				<Type>ISBN</Type>
				<Value><?php echo $arItem['PROPERTIES']['ISBN']['VALUE']; ?></Value>
			</StandardProductID>
			<ProductTaxCode>A_GEN_TAX</ProductTaxCode>
			<LaunchDate><?php echo $time; ?></LaunchDate>
			<ReleaseDate><?php echo $time; ?></ReleaseDate>
			<NumberOfItems>1</NumberOfItems>
			<DescriptionData>
				<Title><?php echo $arItem['NAME']; ?></Title>
				<Brand><?php echo $arItem['PROPERTIES']['IZDATELSTVO']['VALUE']; ?></Brand>
				<Description><?php echo preg_replace('~<.*?>~us', '', $arItem['DETAIL_TEXT']); ?></Description>
				<BulletPoint>Product Weight: <?php echo number_format($catalog_vars['WEIGHT'] / 1000, 2, '.', ' '); ?> kg.</BulletPoint>
				<PackageWeight unitOfMeasure="KG"><?php echo number_format($catalog_vars['WEIGHT'] / 1000, 2, '.', ' '); ?></PackageWeight>
				<MSRP currency="UAH"><?php echo $arItem['PRICES']['BASE']['VALUE']; ?></MSRP>
				<Manufacturer><?php echo $arItem['PROPERTIES']['AUTOR']['VALUE']; ?></Manufacturer>
				<MfrPartNumber><?php echo $arItem['PROPERTIES']['ARTNUMBER']['VALUE']; ?></MfrPartNumber>
				<SearchTerms>Books</SearchTerms>
				<ItemType></ItemType>
				<IsGiftWrapAvailable>false</IsGiftWrapAvailable>
				<IsGiftMessageAvailable>false</IsGiftMessageAvailable>
			</DescriptionData>
			<ProductData>
				<Sports>
					<ProductType>Product_Type_Enum</ProductType>
				</Sports>
			</ProductData>
		</Product>
	</Message>
	<? } unset($arItem); ?>
</AmazonEnvelope>