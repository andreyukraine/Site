<?
$rst = CCatalogDiscountCoupon::GetList();
echo $rst;
echo "sdgfsdg";
/*
if(session_start()) {
	if(isset($_POST['coupon_sb'])) {
		$_SESSION['COUPON'] = $_POST['coupon_sb'];
		echo $_POST['coupon_sb'];
	} else {
		die();
	}
} else {
	echo "Неизвестная ошибка!";
	die();
}
*/
?>