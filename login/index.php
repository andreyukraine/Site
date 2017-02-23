<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");?>
<div class="col-xs-8">
	<? if($USER->IsAuthorized()) {
		$APPLICATION->SetTitle("Вы авторизировались!");
		?>
		<p class="notetext">Вы зарегистрированы и успешно авторизовались.</p>
		<p><a href="/">Вернуться на главную страницу</a></p>
		<?
	} elseif($_GET['register'] == 'yes') {
		$APPLICATION->SetTitle("Регистрация");
		?>
		<div class="registration_page">
			<div class="registration_page_breadcrumbs">
				<a href="/"><span>Главная страница</span></a>
				<a href="/login"><span>Вход на сайт</span></a>
			</div>
			<h2>Pегистрация</h2>
			<div class="registration_page_inputs">
				<h2>Информация о покупателе</h2>
				<?
					$APPLICATION->IncludeComponent("bitrix:main.register","new_register",Array(
					    "USER_PROPERTY_NAME" => "", 
					    "SEF_MODE" => "Y", 
					    "SHOW_FIELDS" => Array("NAME", "LAST_NAME"), 
					    "REQUIRED_FIELDS" => Array("NAME", "LAST_NAME"), 
					    "AUTH" => "Y", 
					    "USE_BACKURL" => "Y", 
					    "SUCCESS_PAGE" => "/", 
					    "SET_TITLE" => "N", 
					    "USER_PROPERTY" => Array(), 
					    "SEF_FOLDER" => "/", 
					    "VARIABLE_ALIASES" => Array()
					    )
					);
				?>
			</div>
		</div>
		<?
	} else {
		$APPLICATION->SetTitle("Вход на сайт");
		?>
		<div class="registration_page_breadcrumbs">
			<a href="/"><span>Главная страница</span></a>
			<span>Вход на сайт</span>
		</div>
		<div class="col-xs-12 text-center">
		<?
			$APPLICATION->IncludeComponent("bitrix:system.auth.form","new_auth",Array(
			    "REGISTER_URL" => "",
			    "FORGOT_PASSWORD_URL" => "/auth",
			    "PROFILE_URL" => "/personal",
			    "SHOW_ERRORS" => "Y" 
			    )
			);
		?>
		</div>
		<?
	}
	?>	
</div>
<? /*
<div class="registration_page">
	<div class="registration_page_breadcrumbs">
		<span>Главная страница</span>
		<span>Вход на сайт</span>
	</div>
	<h2>Pегистрация</h2>
	<div class="registration_page_inputs">
		<div class="registration_page_inputs_block">
			<div class="order_page_inputs">
		<h2>Информация о покупателе</h2>
		<div class="order_page_input_name">
			Имя <span class="order_page_star">*</span> 
			<input type="text">
		</div>
		<div class="order_page_input_surname">
			Фамиля <span class="order_page_star">*</span> 
			<input type="text">
		</div>
		<div class="order_page_input_state">
			Логин <span class="order_page_star">*</span> 
			<input type="text">
		</div>
		<div class="order_page_input_email">
			Пароль <span class="order_page_star">*</span> 
			<input type="text">
		</div>
		<div class="order_page_input_phone">
			<span>
			<p>Подтверждение</p>
			<p>пароля</p> </span><span class="order_page_star">*</span> 
			<input type="text">
		</div>
		<div class="order_page_input_index">
			Email <span class="order_page_star">*</span> 
			<input type="text">
		</div>
		<div class="order_page_capcha">
					<div class="author_page_capcha_info">
						Введите число, изображенное на рисунке:
					</div>
					<div class="author_page_capcha_img">
					
					</div>
					<input type="text" class="author_page_capcha_input">
				</div>
		</div>
		</div>
	</div>
	<div class="registration_page_buttons">
		<div class="registration_page_registration_button">
			
		</div>
		<div class="registration_page_autorization_button">
			
		</div>
	</div>
	
</div>
*/?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>