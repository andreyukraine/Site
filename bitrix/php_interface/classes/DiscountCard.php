
<? 



require_once("/home/bitrix/www/bitrix/modules/main/include/prolog_before.php");?>

<?php 

class DiscountCard {
	public static function CheckCardAndSendActivationCode( $USER_EMAIL, $CARD_NUMBER ) {	
		$id_user = "";	
		if(CModule::IncludeModule("main"))
			{ 
				global $USER;
				$rsUsers = CUser::GetList(($by="ID"),($order="desc"),Array("EMAIL" => $USER_EMAIL));
  					 while ($rsUser = $rsUsers->Fetch()) 
   						{
							$id_user = $rsUser["ID"];
						}
				//print_c($id_user); 
				$USER = new CUser;
				$USER->Update( $id_user, array( 'UF_DISCONT' => $CARD_NUMBER) );
			}
	}
}

?>