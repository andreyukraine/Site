<?
class Tools{
	
	public static function GetAvtorsLitters(){
			setlocale(LC_ALL, 'uk_UA.utf8');
			CModule::IncludeModule('iblock');
			CModule::IncludeModule('catalog');
			
			$autors = array();
			$result = array();
			$letter = array();
			$two_arrays = array();
			
			global $USER;

			$arFilter = array("IBLOCK_ID" => 7, "ACTIVE" => "Y", "PROPERTY_DISABLED" => 0 );
			$arSelect = array("PROPERTY_SURNAME");
   			$res = CIBlockElement::GetList(array(""), $arFilter, false, array("nPageSize"=>10000), $arSelect);
			  while($ob = $res->GetNextElement())
			  {
				 $arFields = $ob->GetFields(); 
				 	
					$char = preg_replace("#(.*?)\(.*?\)(.*?)#is","\\1\\3",$arFields["PROPERTY_SURNAME_VALUE"]);
					$char1 = preg_replace("/[^а-яёa-z]/iu", '', $char);
					
					 //$chars = array('А','Б','В','Г','Ґ','Д','Е','Є','Ж','З','И','І','Ї','К','Л','М','Н','О','П','Р','С','Т','У','Ф','Х','Ц','Ч','Ш','Щ','Э','Ю','Я','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
					 
					if(!empty($char1)){ 
					 $autors[] = mb_substr(strtoupper ($char1), 0, 1);
					}
					 
					
		}
		$result = array_unique($autors);
		asort($result, SORT_LOCALE_STRING);
		//$two_arrays = array_intersect($result, $chars1);
		
		//инкапсулируем массивы
				  // foreach($result as $key =>$val)
					//  {		
						   
						   /*if($val == $two_arrays[$key]){
							   $letter[$key] = array(
								  "two_arrays" => $two_arrays[$key],
							   );
							   }else{*/
					//			 $letter[$key] = $val;
							/*);    
						   }*/
						   
							  
						   
					//  }
	 
					// asort($letter, SORT_LOCALE_STRING);
	return $result;
	
	}
}

?>