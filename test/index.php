<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Тест");?>


<? $APPLICATION->IncludeComponent("bitrix:form","order_absent",Array(
                                                   "AJAX_MODE" => "Y",
                                                   "SEF_MODE" => "N",
                                                   "WEB_FORM_ID" => '1',
                                                   "RESULT_ID" => $_REQUEST["RESULT_ID"],
                                                   "START_PAGE" => "new",
                                                   "SHOW_LIST_PAGE" => "N",
                                                   "SHOW_EDIT_PAGE" => "N",
                                                   "SHOW_VIEW_PAGE" => "Y",
                                                   "SUCCESS_URL" => "",
                                                   "SHOW_ANSWER_VALUE" => "Y",
                                                   "SHOW_ADDITIONAL" => "N",
                                                   "SHOW_STATUS" => "Y",
                                                   "EDIT_ADDITIONAL" => "N",
                                                   "EDIT_STATUS" => "N",
                                                   "NOT_SHOW_FILTER" => Array(),
                                                   "NOT_SHOW_TABLE" => Array(),
                                                   "CHAIN_ITEM_TEXT" => "",
                                                   "CHAIN_ITEM_LINK" => "",
                                                   "IGNORE_CUSTOM_TEMPLATE" => "Y",
                                                   "USE_EXTENDED_ERRORS" => "Y",
                                                   "CACHE_TYPE" => "A",
                                                   "CACHE_TIME" => "3600",
                                                   "AJAX_OPTION_JUMP" => "N",
                                                   "AJAX_OPTION_STYLE" => "N",
                                                   "AJAX_OPTION_HISTORY" => "N",
                                                   "SEF_FOLDER" => "/",
                                                   "SEF_URL_TEMPLATES" => Array(
                                                       "new" => "#WEB_FORM_ID#/",
                                                       "list" => "#WEB_FORM_ID#/list/",
                                                       "edit" => "#WEB_FORM_ID#/edit/#RESULT_ID#/",
                                                       "view" => "#WEB_FORM_ID#/view/#RESULT_ID#/"
                                                   ),
                                                   "VARIABLE_ALIASES" => Array(
                                                       "new" => Array(),
                                                       "list" => Array(),
                                                       "edit" => Array(),
                                                       "view" => Array(),
                                                   ),
                                                   'custom_params'=>array(
                                                       'product_id'=>50130,
                                                       'product_name'=>'Есть Идея!',
                                                       //'product_url'=>'http://'.$_SERVER['HTTP_HOST'].$arItem['DETAIL_PAGE_URL'],
                                                       //'product_articul'=>$arItem['XML_ID'],
                                                       'customer_ip'=>$_SERVER['REMOTE_ADDR'],
                                                   ),
                                               )
);
?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>