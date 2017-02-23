<?

include_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/urlrewrite.php');
$sapi_type = php_sapi_name();

if ($sapi_type == "cgi") {
    header("Status: 404");
} else {
    header("HTTP/1.1 404 Not Found");
}

@define("ERROR_404","Y");

$matchExpr  = '/(?:jpg|gif|png)/';
$haveMatch  = preg_match($matchExpr, $_SERVER['REQUEST_URI']);

if ($haveMatch) {

    die();

} else {

    global $APPLICATION;

    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

    $APPLICATION->SetTitle("404 - Страница не найдена");
    $APPLICATION->AddChainItem('404 - Страница не найдена');
    
    echo '<div class="col-xs-8 item_content_main">';
	echo '<h1>'. $APPLICATION->GetTitle() .'</h1>';


    $APPLICATION->IncludeComponent(
        "bitrix:main.map",
        "404",
        array(
            "CACHE_TYPE" => "A",
            "CACHE_TIME" => "36000000",
            "SET_TITLE" => "N",
            "LEVEL"	=>	"3",
            "COL_NUM"	=>	"2",
            "SHOW_DESCRIPTION" => "Y"
        ),
        false
    );

	echo '</div>';

    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");

}