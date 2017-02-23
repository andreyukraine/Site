<?php 



require_once('lib/global.php');

  
		
	  
	  
  
	 function UpdateAmount(){
		  
		  $asd = array();
		  $AMOUNT_FILE_PATH = '/home/bitrix/www/makano/kassa/Sales.xml';
		  
		  $xml = new CDataXML();
		  
		  $xml = simplexml_load_file($AMOUNT_FILE_PATH);
		  
		  $xml_path = $AMOUNT_FILE_PATH;
		  
		  $file = fopen("/home/bitrix/www/makano/kassa/count_sale.txt","a+");
		   
		  $file_path = "/home/bitrix/www/makano/kassa/count_sale.txt";
		  
		  
		  
		if(filesize($xml_path) == 0){
			unlink($file_path);
			echo "<pre> del "; print_r("Пустой xml удаляем файл count_sale"); echo "</pre>";
		}else{
		
		  //открываем файл для чтения
		  $number_chek = fgets($file);
		  echo "<pre> значение файла с какого заказа начинаем парсить "; print_r($number_chek); echo "</pre>";
 		  //смотрим количестко заказов в xml
		  $c_count = count($xml->sales);
		  echo "<pre> всего заказов "; print_r($c_count); echo "</pre>";
		  //проверяем если не пустой тогда записываем первое вхождение
		  if(filesize($file_path) == 0){
			   echo "<pre> filesize "; print_r("Файл пустой"); echo "</pre>";
			  //пробегаемся по файлу ищем заказы
				for($i = 0; $i < $c_count; $i++) { 	
				  $n_chek = (int)$xml->sales[$i]->{'number'};
						  
							  $p_cnt = count($xml->sales[$i]->sales_details);
					
							  for($j = 0; $j < $p_cnt; $j++) { 
							  
							  //получение даты транзакции	
								$param = $xml->sales[$i]->sales_details[$j]; 
								$data_tranzaction = (string) $param->{'reg_time'};
								echo "<pre> data_tranzaction "; print_r($data_tranzaction); echo "</pre>";
								
								$asd[$j] = UpdateAmountProduct((int) $param->{'article'}, (int) $param->{'qty'}, $data_tranzaction);
								print_c($asd[$j]);
							  } 
			
			    }
				$number_chek++;
			//открываем файл и записываем номер последнего заказа
			$file_2 = fopen("/home/bitrix/www/makano/kassa/count_sale.txt","a+");	
			fwrite($file_2, $c_count);
		    fclose($file);
		  }else{
			  echo "<pre> filesize "; print_r("Файл не пустой"); echo "</pre>";
			  
			  
			  //пробегаемся по файлу ищем заказы
				for($z = $number_chek + 1; $z <= $c_count; $z++) { 
					
				  $n_chek_2 = (int)$xml->sales[$z-1]->{'number'}; 
				  
						  if($n_chek_2 == ($number_chek + 1)){
							  $p_cnt = count($xml->sales[$z-1]->sales_details);
							  for($k = 0; $k < $p_cnt; $k++) { 
							  
							  //получение даты транзакции	
								$param = $xml->sales[$z-1]->sales_details[$k]; 
								
								$data_tranzaction = (string) $param->{'reg_time'};
								$asd[$k] = UpdateAmountProduct((int) $param->{'article'}, (int) $param->{'qty'});
								print_c($asd[$j]);
							  } 
						  }
			    }
				$number_chek++;
			//открываем файл и записываем номер последнего заказа
			$file_2 = fopen("/home/bitrix/www/makano/kassa/count_sale.txt","w+");	
			fwrite($file_2, $c_count);
		    fclose($file);
		  }  
		}
		
		
	  print_c("start");
		
	  //конец функции
	  }
	  
	  
	  
	   function UpdateAmountProduct($art, $kol){
	   
		   if(Cmodule::IncludeModule('iblock')){
			   //получаем ID товара по артукулу с-маркета
				$product_offers_res = CIBlockElement::GetList( 
				  array(),
				  array('IBLOCK_ID' => 2, 'PROPERTY_ARTNUMBER' => $art), 
				  false, false, 
				  array() 
				);
					while( $ar_subscribe = $product_offers_res->GetNext() ) {
						//echo "<pre> ar_subscribe "; print_r($ar_subscribe); echo "</pre>";
						$curent_kol = KolCurrentProduct($ar_subscribe['ID'], $kol);
					}			
		   }
	  }
	  
	  
	  
	   //получение текущего остатка с битрикса
	   function KolCurrentProduct($ID, $kol) {
			if(Cmodule::IncludeModule('catalog')){ 
				$db_res = CCatalogProduct::GetList(
					array(),
					array("ID" => $ID),
					false,
					array()
				);
				while ($ar_res = $db_res->Fetch())
					{
						if($ar_res['QUANTITY'] > 0){
							
							echo "<pre> QUANTITY "; print_r($ar_res['QUANTITY']); echo "</pre>";
				  			echo "<pre> kol "; print_r($kol); echo "</pre>";
						  
						  
						  $temp_kol = $ar_res['QUANTITY'] - $kol;
						  //проверка на отрицательное число чтобы не залазили в минуса
							  if($temp_kol < 0){
								  $total_kol = $ar_res['QUANTITY'] - $kol + abs($temp_kol);
							  }else{
								  $total_kol = $temp_kol;
							  }
						  
						  UpdateProduct($ar_res['ID'], $total_kol);
						  return $ar_res['QUANTITY'];
						}
					}
			}
	  }
	  
	  
	  
	  
	  //метод обновления остатка у товара
	   function UpdateProduct($ID, $KOL) {
	   		CModule::IncludeModule('catalog');
			CCatalogProduct::Update($ID, array("QUANTITY" => $KOL));	  
	  }
	  
	  
	 
	 //Запуск агента	
	 // public function KassaOflineAgent() { 
     //  self::UpdateAmount();
     //  return "KassaOfline::KassaOflineAgent();";
     //  }
	 
	 
	 
  
  
  ?>