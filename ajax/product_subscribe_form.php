<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?


CModule::IncludeModule('iblock');


$cpt = new CCaptcha();
$cpt->SetCode();
$captcha_code = $_POST["captcha_code"];
$captcha_word = $_POST["captcha_word"];      

//подключаем капу
if (strlen($captchaPass) <= 0){
	$captchaPass = randString(10);
	COption::SetOptionString("main", "captcha_password", $captchaPass);
}
$cpt->SetCodeCrypt($captchaPass);
$captchaPass = COption::GetOptionString("main", "captcha_password", ""); 



$db_props = CIBlockElement::GetByID($_POST['id']);
$ar_props = $db_props->GetNext();
$URL = CFile::GetPath($ar_props['PREVIEW_PICTURE']); 



?>



<?
	
	$_POST['a'] = ProductResponce::IsSubscribed( array('EMAIL' => $_POST['EMAIL'], 'PRODUCT_ID' => $_POST['id']) );
	
		
		if( !empty($_POST['a'])) {
				
		$success = 'Вы уже подписались на этот товар, мы уведомим вас, как только товар опять появится на складе.';
		
	
	
	} else {
		
		
		
		if(!empty($_POST['sent'])) { 
		$success = false;
	
		$errors = array();
		
		
		if(empty($_POST['captcha_word'])) {
			$errors['CAPTCHA'] = 'Введите символы';
		}
		
		if(empty($_POST['EMAIL'])) {
			$errors['EMAIL'] = 'Укажите email';
		}// else {
//			if( !check_email($_POST['EMAIL']) ) {
//				$errors['EMAIL'] = '– некорректен.';
//			}
//		}

		if(empty($_POST['NAME'])) {
			$errors['NAME'] = 'Укажите имя';
		}
		
		if(empty($_POST['PHONE'])) {
			$errors['PHONE'] = 'Укажите телефон';
		}
		
	
				if(empty($errors)) { 
			
							//проверяем ввод с капчей
							if (!$cpt->CheckCodeCrypt($captcha_word, $captcha_code, $captchaPass)){
							$errors['COMMON'] = 'Ошибка captcha.';
								}else{
									$add = ProductResponce::Add( 
									 array(
											'PRODUCT_NAME' 	=> $ar_props['NAME'],
											'NAME' 			=> $_POST['NAME'],
											'PHONE'      	=> $_POST['PHONE'],
											'EMAIL'      	=> $_POST['EMAIL'],
											'PRODUCT_ID' 	=> $_POST['id'],
											'COL'        	=> $_POST['COL']
										)
									);
									if( $add ) {
										$success = 'Спасибо, мы уведомим вас, как только товар опять появится на складе.';
										
									} else {
										$errors['COMMON'] = 'Ошибка сервера.';
									}
								}
							
						 }
					
					
			}
	
		if( $USER->GetEmail() ) {
			$_POST['EMAIL'] = $USER->GetEmail();
			
		}
		
	}
	
?>

 

<form action="<?=$PHP_SELF?>" method="post" data-sendby="ajax" class="popup-form popup-form-subscribe">
	
	<? if(!empty($URL)){ ?>
    <div class="popup-form-content">
    <?}else{?>
    <div class="popup-form-content_one">
    <?}?>
    		
        <?if($success):?>
		<p class="text_susses"><?=$success?></p>
        
		<?else:?>
      
      
       
        
     
   			<div class="row">
      
           
            
            <? if(!empty($URL)){ ?>
            <div class="col-xs-6">
               <p class="title_request"><?=$ar_props["NAME"]?></p>
               <p class="bl_request_img"><img src="<?=$URL?>" /></p>
            </div>
            <? } ?>
                 
            <? if(!empty($URL)){ ?>
        	<div class="col-xs-6 bl_request">
            <? }else{ ?>
            <div class="col-xs-12">
            <? } ?>
            
            <p class="title_request">Оставьте свои контактные данные, и мы уведомим вас, как только товар появится на складе.</p>
            
            <!--Выводим ошибки в форму-->
            <?if(!empty($errors['COMMON'])) {?>
            <p class="form-errors"><?=$errors['COMMON'];?></p>
            <?}?>
        
            <input type="hidden" name="sent" value="1" />
            <input type="hidden" name="id" value="<?=$_POST['id']?>" />
    		<label>Ваше Имя: <?if(!empty($errors['NAME'])) {?><span class="form-errors"><?=$errors['NAME'];?></span><?}?></label>
            <input type="text" class="form-control" name="NAME" value="<?=$_POST['NAME']?>" />
            <label>E-mail: <?if(!empty($errors['EMAIL'])) {?><span class="form-errors"><?=$errors['EMAIL'];?></span><?}?></label>
            <input type="text" class="form-control" name="EMAIL" value="<?=$_POST['EMAIL']?>" />
            <label>Телефон: <?if(!empty($errors['PHONE'])) {?><span class="form-errors"><?=$errors['PHONE'];?></span><?}?></label>
            <input type="text" class="form-control" name="PHONE" value="<?=$_POST['PHONE']?>" />
            <label>Количество: </label>
            <input type="text" class="form-control" name="COL" value="<?=$_POST['COL']?>" />

            <span class="text_captcha"><p>Введите символы с картинки:</p>
            <?if(!empty($errors['CAPTCHA'])) {?><span class="form-errors"><?=$errors['CAPTCHA'];?></span><?}?></span>
            <div class="col-xs-5 input_captcha">
            <input type="text" size="10" name="captcha_word" class="form-control" >
            </div>

            <div class="col-xs-7 img_block_capcha">
            <input type="hidden" name="captcha_code"  value="<?= htmlspecialchars($cpt->GetCodeCrypt()) ?>">
            <img class="img-responsive img_capcha" src="/bitrix/tools/captcha.php?captcha_code=<?= htmlspecialchars($cpt->GetCodeCrypt()) ?>">
            </div>
			
            <div class="col-xs-12 text-center buttom_form_my">
            <button type="submit" class="btn btn-default">Отправить запрос</button>
            </div>       
        </div>
       
	</div>
  
   <?endif;?>
  </div>
		
</form>


