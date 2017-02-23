<?
	class ProductResponce {

		const IBLOCK_ID = 15;

		public static function Add($arFields) {
		/*
			добавляет новую подписку на товар

			arFields( 'NAME', 'PHONE', 'EMAIL', 'PRODUCT_ID' )
		*/

			global $USER;
			CModule::IncludeModule('iblock');

			$user_id = $USER->GetID();
			if(empty($user_id)) {
				$user_id = 0;
			}

			$el = new CIBlockElement;

				if( $notify_id = $el->Add(
					array(
						'CREATED_BY' => $user_id,
						'IBLOCK_ID' => 15,
						'NAME' => $arFields['PRODUCT_NAME'],
						'PROPERTY_VALUES' => array(
							'PRODUCT' 			=> $arFields['PRODUCT_ID'],
							'CUSTOMER_PHONE'	=> $arFields['PHONE'],
							'CUSTOMER_EMAIL' 	=> $arFields['EMAIL'],
							'COL' 	=> $arFields['COL'],
							'CUSTOMER_NAME' 	=> $arFields['NAME']
							)
						)
					)
				) {
					return $notify_id;
				} else {
					return "Error: ".$el->LAST_ERROR;
				}
		}

		public static function IsSubscribed( $arFields ) {
		/*
			проверяет, подписан ли пользователь на товар
			arFields( 'EMAIL', 'PRODUCT_ID' )
		*/	
			
			CModule::IncludeModule('iblock');
			CModule::IncludeModule('catalog');

			global $USER;

			$count_subscribes = CIBlockElement::GetList( 
				array(), 
				array('IBLOCK_ID' => self::IBLOCK_ID, 'ACTIVE' => 'Y', 'PROPERTY_CUSTOMER_EMAIL' => $arFields['EMAIL'], 'PROPERTY_PRODUCT' => $arFields['PRODUCT_ID'] ), 
				array() 
			);
			
			
			return (bool) $count_subscribes > 0;
			
		}

		public static function Deactivate($ID) {
			CModule::IncludeModule('iblock');
			$el = new CIBlockElement;
			return $el->Update( $ID, array( 'ACTIVE' => 'N' ) );
		}

		public static function SendAll() {
		/*
			Проверяет все товары из активных подписок на предмет положительного количества на складе,
			каждая подписка, чей товар есть на складе, деактивируется и вызывается событие отправки уведомления (или смс)
		*/
			global $USER;

			CModule::IncludeModule('iblock');
			CModule::IncludeModule('catalog');

			$PRODUCTS_IDS = array();
			$PRODUCTS_SUBSCRIPTION_BY_ID = array();
			$PRODUCTS_AVAILABLE_LIST = array();

			$subscribes_res = CIBlockElement::GetList(
				array('DATE_CREATE' => 'asc'), array('IBLOCK_ID' => 15, 'ACTIVE' => 'Y'),
				false, false,
				array('ID', 'NAME', 'PROPERTY_CUSTOMER_EMAIL', 'PROPERTY_CUSTOMER_PHONE', 'PROPERTY_PRODUCT')
			);
			while( $ar_subscribe = $subscribes_res->GetNext() ) {
				
				$PRODUCTS_SUBSCRIPTION_BY_ID[$ar_subscribe['ID']] = array(
					'ID' => $ar_subscribe['ID'],
					'NAME' => $ar_subscribe['NAME'], 
					'EMAIL' => $ar_subscribe['PROPERTY_CUSTOMER_EMAIL_VALUE'], 
					'PHONE' => $ar_subscribe['PROPERTY_CUSTOMER_PHONE_VALUE'],
					'PRODUCT_ID' => $ar_subscribe['PROPERTY_PRODUCT_VALUE']
				);
				$PRODUCTS_IDS[$ar_subscribe['PROPERTY_PRODUCT_VALUE']] = 1;
			}
			$PRODUCTS_IDS = array_keys($PRODUCTS_IDS); // получаем все уникальные ID интересующих товаров (предложений)
 


			if(!empty($PRODUCTS_IDS)) {

				$product_offers_res = CIBlockElement::GetList( 
					array('ID' => 'asc'), // выбираем доступные для покупки товары, из тех, которыми интересовались
					array('IBLOCK_ID' => 2, 'ID' => $PRODUCTS_IDS, 'ACTIVE' => 'Y', 'CATALOG_AVAILABLE' => 'Y'), 
					false, false, 
					array('ID','NAME','CATALOG_PRICE_1','CATALOG_CURRENCY_1','CATALOG_GROUP_1','DETAIL_PAGE_URL') 
				);

				while( $ar_product_offer = $product_offers_res->GetNext() ) {
					
					
					
					$PRODUCTS_AVAILABLE_LIST[ $ar_product_offer['ID'] ] = $ar_product_offer;
					
					
					
				}
				
				
				
				foreach($PRODUCTS_SUBSCRIPTION_BY_ID as $ar_subscribtion) {
					$ar_product_offer = $PRODUCTS_AVAILABLE_LIST[ $ar_subscribtion['PRODUCT_ID'] ];
					
					//echo "<pre>"; print_r( $ar_product_offer); echo "</pre>";
					
					if( !empty($ar_product_offer) ) {
						// если есть в наличии интересуемый товар
						
						//mail("admin@zoougolok.in.ua", "Cron", var_export($ar_product_offer).' '.var_export($ar_subscribtion));

						if(CEvent::Send("PRODUCT_NOTIFY_SEND", 's1', array(
							'PRODUCT_ID' => $ar_product_offer['ID'],
							'PRODUCT_NAME' => $ar_product_offer['NAME'],
							'PRODUCT_PRICE_VALUE' => $ar_product_offer['CATALOG_PRICE_1'],
							'PRODUCT_CURRENCY_VALUE' => $ar_product_offer['CATALOG_CURRENCY_1'],
							'PRODUCT_PRINT_PRICE' => FormatCurrency( $ar_product_offer['CATALOG_PRICE_1'], $ar_product_offer['CATALOG_CURRENCY_1'] ),
							'PRODUCT_URL' => $ar_product_offer['DETAIL_PAGE_URL'],

							'CUSTOMER_EMAIL' => $ar_subscribtion['EMAIL'],
							'CUSTOMER_PHONE' => $ar_subscribtion['PHONE'],
						))) {
							
							
							$q = array(
							'PRODUCT_ID' => $ar_product_offer['ID'],
							'PRODUCT_NAME' => $ar_product_offer['NAME'],
							'PRODUCT_PRICE_VALUE' => $ar_product_offer['CATALOG_PRICE_1'],
							'PRODUCT_CURRENCY_VALUE' => $ar_product_offer['CATALOG_CURRENCY_1'],
							'PRODUCT_PRINT_PRICE' => FormatCurrency( $ar_product_offer['CATALOG_PRICE_1'], $ar_product_offer['CATALOG_CURRENCY_1'] ),
							'PRODUCT_URL' => $ar_product_offer['DETAIL_PAGE_URL'],

							'CUSTOMER_EMAIL' => $ar_subscribtion['EMAIL'],
							'CUSTOMER_PHONE' => $ar_subscribtion['PHONE'],
						);
							
							
							
							// echo "<pre>"; print_r($q); echo "</pre>";
							
							// если отправили уведомление, деактивируем подписку
							self::Deactivate( $ar_subscribtion['ID'] );
						}

					}

				}

			}

		}

		public static function ProductResponceAgent() {
			global $USER;

			self::SendAll();
			
			return "ProductResponce::ProductResponceAgent();";
		}

		
		
	}
?>