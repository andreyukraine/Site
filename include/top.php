<?

function getTopProducts($count, $page, $sectionCode)
{

    $arBasketItems = array();
    $dbBasketItems = CSaleBasket::GetList(
        array(
            "ORDER_PAYED" => "desc",
        ),
        array(
            "@CAN_BUY" => "Y",
            "@ORDER_PAYED" => "Y",
            "%DETAIL_PAGE_URL" => $sectionCode // символьный код раздела
        ),
        array(
            "COUNT" => "ORDER_PAYED",
            "PRODUCT_ID",
        ),
        array(
            'iNumPage' => $page, // номер страницы при постраничной навигации
            'nPageSize' => $count // количество элементов на странице при постраничной навигации
        ),
        array(
            "ID", "MODULE_ID", "NAME", "PRODUCT_ID",
            "CAN_BUY", "ORDER_PAYED", "DETAIL_PAGE_URL"
        )
    );

    while ($arItems = $dbBasketItems->Fetch())
    {
        $res = CIBlockElement::GetByID($arItems['PRODUCT_ID']);
        $arBasketItems[] = $res->GetNext();
    }

    return $arBasketItems;

}

?>

<!--<div class="topten_block">-->
    <div class="topten_header">
        <h2>ТОП 10</h2>
        <?$APPLICATION->IncludeComponent(
            "bitrix:catalog.section.list",
            "cat_top_list",
            array(
                "VIEW_MODE" => "LIST",
                "SHOW_PARENT_NAME" => "N",
                "IBLOCK_TYPE" => "catalog",
                "IBLOCK_ID" => "2",
                "SECTION_ID" => "",
                "SECTION_CODE" => "",
                "SECTION_URL" => "",
                "COUNT_ELEMENTS" => "N",
                "TOP_DEPTH" => "1",
                "SECTION_FIELDS" => array(
                    0 => "ID",
                    1 => "CODE",
                    2 => "XML_ID",
                    3 => "NAME",
                    4 => "IBLOCK_CODE",
                    5 => "IBLOCK_EXTERNAL_ID",
                ),
                "SECTION_USER_FIELDS" => array(
                    0 => "",
                    1 => "",
                ),
                "ADD_SECTIONS_CHAIN" => "Y",
                "CACHE_TYPE" => "N",
                "CACHE_TIME" => "36000000",
                "CACHE_NOTES" => "",
                "CACHE_GROUPS" => "N",
                "COMPONENT_TEMPLATE" => "cat_top_list"
            ),
            false
        );?>

    </div><? print_r($top_sections) ?>
    <? foreach ($top_sections as $top_section): ?>

        <div class="top_custom_section" id="top_custom_section_<? echo($top_section['ID']); ?>">
            <div class="slider_real_top_wrap bx_catalog_tile_home_type_2 col5 bx_blue">
                <div class="slider_real_top bx_catalog_tile_slide owl-carousel">
                    <? $section_list = getTopProducts(10, 1, $top_section['CODE']); ?>
                    <? foreach ($section_list as $item): ?>
                        <?
                        $item['PREVIEW_PICTURE'] = CFile::GetPath($item['PREVIEW_PICTURE']);
                        if (!isset($item['PREVIEW_PICTURE'])) {
                            $item['PREVIEW_PICTURE'] = "/images/no_photo.png";
                        }
                        ?>
                        <a href="<?=$item['DETAIL_PAGE_URL']?>">
                            <img src="<?=$item['PREVIEW_PICTURE']?>" alt="<?=$item['NAME']?>">
                            <label><?=$item['NAME']?></label>
                        </a>
                    <? endforeach; ?>
                </div>
            </div>
        </div>
    <? endforeach; ?>
</div>
<?
unset($top_sections);
?>
<!--</div>-->