<?

class ForgottenBasket {
	 
	//При добавлении в корзину меняет UF_CARTEMAIL = 1 
	 
	function AddPresentToBasket($ID, $arFields) 
	{
		global $USER;
		$user = new CUser;
		$userid = $user->GetID();
			$fields = Array( 
			"UF_CARTEMAIL" => "1",
			"UF_CARTDATE" => date('Y-m-d'), 
			); 
		$user->Update($userid, $fields);
	}
	
	
	public static function ForgottenCartUser(){
		
		global $USER;
		CModule::IncludeModule("catalog");
		CModule::IncludeModule("sale");
		$DISCOUNT_NAME = "";
		$COUPON_NAME = "";
		$Discont = array();							   
									   
									   
		$arFilter = array(
		//Ищем юзеров с UF_CARTEMAIL = 1 2 или 3
		"UF_CARTEMAIL" => array(1,2,3),
		"ACTIVE" => "Y",
	   	);
		$dbUsers = CUser::GetList(($by="UF_CARTEMAIL"),($order="desc"), $arFilter, array("SELECT"=>array("ID","EMAIL","NAME","UF_*")));
		while ($arUser = $dbUsers->Fetch()) 
		{ 
			
			
			
			//Если дата текущаю больше даты добавления + 2 дня 
			
			//значения для почтового шаблона
			if(strtotime(date('Y-m-d')) == strtotime($arUser['UF_CARTDATE']) && $arUser['UF_CARTEMAIL'] == 1 && !empty(self::ProductsCart($arUser['ID'])) && $arUser['UF_SEND_EMAIL'] != "Y"){
				
				
//				$send_to = 'security_ua@mail.ru';
//				$headers = 'From: sale@knigionline.com';
//				if( mail($send_to ,'Тема сообщения',"Проверка функции Mail",$headers) ){
//					echo 'Mail() работает!';
//				}else{
//					echo 'Проблема с функцией Mail()!';
//				}
				
				
				
				if(CEvent::Send("OLD_CART_ONE", 's1', array('USER_ID' => $arUser['ID'],))) {
					$user = new CUser;
					$fields = Array( 
					"UF_SEND_EMAIL" => "Y",
					);
					$user->Update($arUser['ID'], $fields);
				}
			}
			
			
			echo "<pre> UF_CARTEMAIL "; print_r(!empty(self::ProductsCart($USER_ID))); echo "</pre>";
			
			//Если дата текущаю больше даты добавления + 2 дня 
			if(strtotime(date('Y-m-d')) > strtotime($arUser['UF_CARTDATE'] . ' + 2 days') && 
				$arUser['UF_CARTEMAIL'] == 1 && !empty(self::ProductsCart($arUser['ID'])) )
			{
					//Добавляем в +1 к UF_CARTEMAIL меняем дату UF_CARTDATE
					if($arUser['UF_CARTEMAIL'] == 1){$arUser['UF_CARTEMAIL']++;}
					$user = new CUser;
					$fields = Array( 
					"UF_CARTEMAIL" => $arUser['UF_CARTEMAIL'],
					//"UF_CARTDATE" => date('Y-m-d H:i:s'), 
					); 
					$user->Update($arUser['ID'], $fields);
					
					//проверяем есть у пользователя дисконт карта если нет то генерируем купон на скидку
					
					if($arUser['UF_CARTEMAIL'] == 2){
						
						if(empty($arUser['UF_DISCONT'])){
							
							
							$discont_user_id = self::GetListDiscont($arUser["ID"]);
							
							echo "<pre> User_ID "; print_r($discont_user_id); echo "</pre>";
							
							//проверяем есть ли уже скидки для пользователя
							if(empty($discont_user_id)){
																	
									$COUPON = CatalogGenerateCoupon();
									
									$arDiscount = array (
										'SITE_ID' => "s1", //- сайт;
										'ACTIVE' => "Y", //- флаг активности;
										'NAME' => $arUser["ID"], //- название скидки;
										//'COUPON' => '', //- код купона;
										'SORT' => 100, //- индекс сортировки;
										'MAX_DISCOUNT' => 0.0000, //- максимальная величина скидки;
										'VALUE_TYPE' => "P", //- тип скидки (P - в процентах, F - фиксированная величина);
										'VALUE' => 5, //- величина скидки;
										'CURRENCY' => "UAH", //- валюта;
										'RENEWAL' => "N", //- флаг "Скидка на продление";
										'ACTIVE_FROM' => ConvertTimeStamp(time(), "FULL"), //- дата начала действия скидки;
										'ACTIVE_TO' => '', //- дата окончания действия скидки;
										'PRODUCT_IDS' => self::ProductsCart($arUser['ID'])//-
									);
        					
        							$asd = CCatalogDiscount::Add($arDiscount);
									
									$arCouponFields = array(
										"DISCOUNT_ID" => $asd,
										"ACTIVE" => "Y",
										"ONE_TIME" => "O",
										"COUPON" => $COUPON,
										"DATE_APPLY" => false,
										"COUPON_DESCRIPTION" => "777"
									);
									
									$CID = CCatalogDiscountCoupon::Add($arCouponFields);
									
									//вытаскиваем информацию купона
								   $arFilter = array('ID' => $CID); 
								   $dbCoupon = CCatalogDiscountCoupon::GetList (array(), $arFilter); 
								   if($arCoupon = $dbCoupon->Fetch()) 
								   { 
									   $DISCOUNT_NAME = $arCoupon['DISCOUNT_NAME'];
									   $COUPON_NAME = $arCoupon['COUPON'];
								   } 
									
								   $Discont = array(
								   		'USER_ID' => $arUser['ID'],
								   		'SKIDKA_ID' => $asd,
										'COUPON_NAME' => $COUPON_NAME,
										'COUPON_ID' => $CID,
										'SKIDKA_NAME' => $DISCOUNT_NAME,
								   );
								   
								   unset($COUPON);
								   unset($CID);
								   unset($asd);
							
							}
							
							if(CEvent::Send("OLD_CART", 's1', array(
											'USER_ID' => $arUser['ID'],
											'COUPON' => $Discont['COUPON_NAME'],
											'DISCOUNT_NAME' => $DISCOUNT_NAME
										))) 
							{
							echo("Send email ok");	
							}
									
						}
						
					}
					
					
						
					
					
					
}
			
			//забытая корзина больше 6 дней с момента ухода пользователя
			if(strtotime(date('Y-m-d')) > strtotime($arUser['UF_CARTDATE'] . ' + 6 days') 
			&& $arUser['UF_CARTEMAIL'] == 2 && !empty(self::ProductsCart($arUser['ID'])))
			{
						
						//удаляем скидки пользователя 
						$discont_user_id = self::GetListDiscont($arUser["ID"]);
						CCatalogDiscount::Delete($discont_user_id);
						
						//затераем поля у пользователя
						$user = new CUser;
						$fields = Array(
						"UF_CARTEMAIL" => 0,
					    "UF_CARTDATE" => "", 
						"UF_SEND_EMAIL" => "",
						); 
						$user->Update($arUser["ID"], $fields);
					
						echo "<pre> User_ID "; print_r("Скидка и статусы у пользователя затерты"); echo "</pre>";
						
						if ($atFUser = CSaleUser::GetList(array('USER_ID' => $arUser["ID"])));
						//удаляем брошеную корзину из базы
						//$results = $DB->Query("SEL ECT distinct `NAME` FR OM `b_iblock_section` WHERE `IBLOCK_ID`='8'");
         				
			}
					
					
			echo "<pre> 2222 "; print_r($Discont); echo "</pre>";
			
		}
		
	}
	
	public function GetListDiscont($USER_ID){
	$dbProductDiscounts = CCatalogDiscount::GetList(
		array("SORT" => "ASC"),
		array("NAME" => $USER_ID, "ACTIVE" => "Y"),
		false,
		false,
		array(
				"ID", "SITE_ID", "ACTIVE", "ACTIVE_FROM", "ACTIVE_TO", 
				"RENEWAL", "NAME", "SORT", "MAX_DISCOUNT", "VALUE_TYPE", 
				"VALUE", "CURRENCY", "PRODUCT_ID"
			)
		);
		while ($arProductDiscounts = $dbProductDiscounts->Fetch())
		{
			
			return $arProductDiscounts['ID'];
		
		}
	}
	
	//Количество товаров в забытой корзине
	public function ProductsCart($USER_ID){
		
		$arID = array();
		$arBasketItems = array();
		if (!CModule::IncludeModule("sale")) return;
				$dbBasketItems = CSaleBasket::GetList(
					 array("NAME" => "ASC",	"ID" => "ASC"),
					 array("USER_ID" => $USER_ID, "LID" => "s1", "ORDER_ID" => "NULL"),
					 false,
					 false,
					 array("ID", "CALLBACK_FUNC", "MODULE", "PRODUCT_ID", "QUANTITY", "PRODUCT_PROVIDER_CLASS")
				);
				while ($arItems = $dbBasketItems->Fetch())
					{
						$arID[] = $arItems["ID"];	 
					}
		return $arID;
	}
	
	
	
	
	
	
	//Запуск агента	
	public function ForgottenBasketAgent() {
			
			self::ForgottenCartUser();
						
	return "ForgottenBasket::ForgottenBasketAgent();";
	}
		
}
 

?>