<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Отзывы");
?><div class="review_page">
	<div class="blog_breadcrumbs">
 <a href="/">Главная страница &gt;</a> <a href="/comments/"> Отзывы </a>
	</div>
	<h2>Отзывы</h2>
	 <?$APPLICATION->IncludeComponent(
	"bitrix:catalog.comments",
	"site_reviews",
	Array(
		"ELEMENT_ID" => "42228",
		"IBLOCK_ID" => "11",
		"ELEMENT_CODE" => "",
		"URL_TO_COMMENT" => "/comments",
		"WIDTH" => "",
		"COMMENTS_COUNT" => "10",
		"BLOG_USE" => "Y",
		"FB_USE" => "N",
		"FB_APP_ID" => $arParams["FB_APP_ID"],
		"VK_USE" => "N",
		"VK_API_ID" => $arParams["VK_API_ID"],
		"CACHE_TYPE" => "N",
		"CACHE_TIME" => "0",
		"BLOG_TITLE" => "",
		"BLOG_URL" => "comments",
		"PATH_TO_SMILE" => "",
		"EMAIL_NOTIFY" => "N",
		"AJAX_POST" => "N",
		"SHOW_SPAM" => "Y",
		"SHOW_RATING" => "Y",
		"FB_TITLE" => "",
		"FB_USER_ADMIN_ID" => "",
		"FB_COLORSCHEME" => "light",
		"FB_ORDER_BY" => "reverse_time",
		"VK_TITLE" => "",
		"TEMPLATE_THEME" => "blue",
		"COMPONENT_TEMPLATE" => "site_reviews",
		"IBLOCK_TYPE" => "catalog",
		"RATING_TYPE" => ""
	),
$component
);?>
</div>
<div class="clearfix">
</div>
 <?/*
<div class="review_page">
	<div class="blog_breadcrumbs">
		<span>Главная страница ></span>
		<span> Отзывы ></span>
	</div>
	<h2>Отзывы</h2>
	<div class="review_page_top_pagination">
		Товары 1 - 2 из 3  Начало | 1 2 3 4 5 | След. | Конец | Все
	</div>	
	<div class="review_page_main_block">
		<div class="author_page_inputs">
				<h3>Написать отзыв</h3>
				<input type="text" class="author_page_input_name" placeholder="Имя:">
				<input type="text" class="author_page_input_review" placeholder="Ваш отзыв:">
				<div class="author_page_capcha">
					<div class="author_page_capcha_info">
						Введите число, изображенное на рисунке:
					</div>
					<div class="author_page_capcha_img">
					
					</div>
					<input type="text" class="author_page_capcha_input">
				</div>
				<div class="author_page_input_capcha_send_block">
					<span class="author_page_facebook_plugin"><a href="#"><img src="/bitrix/templates/polka/images/facebook-icon.png" alt="">Facebooks comments plugin</a> </span>
					<a href="#" class="author_page_button sprite_review_active"></a>
				</div>
			</div>
	</div>
	<div class="tab-body-container-review">
			<div class="tab-body-container-review-content">
				<div class="review_photo">
				
				</div>
				<div class="review_info">
					<div class="review_name">
						John Dou
					</div>
					<div class="review_data">
						(06.08.2015 21:04:22)
					</div>
					<div class="main_review">
						Lorem ipsum dolor sit amet, consectetur adipisicing elit. Esse qui nulla vel
						aspernatur repellat libero deleniti tempora 
					</div>
				</div>
				<div class="review_buttons_wrap">
					<span><a href="">Нравиться</a></span>
					<span><a href="">Ответить</a></span>
				</div>
			</div>
			</div>
			<div class="tab-body-container-review">
				<div class="tab-body-container-review-content">
					<div class="review_photo">
					
					</div>
					<div class="review_info">
						<div class="review_name">
							John Dou
						</div>
						<div class="review_data">
							(06.08.2015 21:04:22)
						</div>
						<div class="main_review">
							Lorem ipsum dolor sit amet, consectetur adipisicing elit. Esse qui nulla vel
							aspernatur repellat libero deleniti tempora 
						</div>
					</div>
					<div class="review_buttons_wrap">
						<span><a href="">Нравиться</a></span>
						<span><a href="">Ответить</a></span>
					</div>
				</div>
			</div>
			<div class="tab-body-container-review">
				<div class="tab-body-container-review-content">
					<div class="review_photo">
					
					</div>
					<div class="review_info">
						<div class="review_name">
							John Dou
						</div>
						<div class="review_data">
							(06.08.2015 21:04:22)
						</div>
						<div class="main_review">
							Lorem ipsum dolor sit amet, consectetur adipisicing elit. Esse qui nulla vel
							aspernatur repellat libero deleniti tempora 
						</div>
					</div>
					<div class="review_buttons_wrap">
						<span><a href="">Нравиться</a></span>
						<span><a href="">Ответить</a></span>
					</div>
				</div>
			</div>
			<div class="tab-body-container-review">
				<div class="tab-body-container-review-content">
					<div class="review_photo">
					
					</div>
					<div class="review_info">
						<div class="review_name">
							John Dou
						</div>
						<div class="review_data">
							(06.08.2015 21:04:22)
						</div>
						<div class="main_review">
							Lorem ipsum dolor sit amet, consectetur adipisicing elit. Esse qui nulla vel
							aspernatur repellat libero deleniti tempora 
						</div>
					</div>
					<div class="review_buttons_wrap">
						<span><a href="">Нравиться</a></span>
						<span><a href="">Ответить</a></span>
					</div>
				</div>
			</div>
			<div class="tab-body-container-review">
				<div class="tab-body-container-review-content">
					<div class="review_photo">
					
					</div>
					<div class="review_info">
						<div class="review_name">
							John Dou
						</div>
						<div class="review_data">
							(06.08.2015 21:04:22)
						</div>
						<div class="main_review">
							Lorem ipsum dolor sit amet, consectetur adipisicing elit. Esse qui nulla vel
							aspernatur repellat libero deleniti tempora 
						</div>
					</div>
					<div class="review_buttons_wrap">
						<span><a href="">Нравиться</a></span>
						<span><a href="">Ответить</a></span>
					</div>
				</div>
			</div>
			<div class="tab-body-container-review">
				<div class="tab-body-container-review-content">
					<div class="review_photo">
					
					</div>
					<div class="review_info">
						<div class="review_name">
							John Dou
						</div>
						<div class="review_data">
							(06.08.2015 21:04:22)
						</div>
						<div class="main_review">
							Lorem ipsum dolor sit amet, consectetur adipisicing elit. Esse qui nulla vel
							aspernatur repellat libero deleniti tempora 
						</div>
					</div>
					<div class="review_buttons_wrap">
						<span><a href="">Нравиться</a></span>
						<span><a href="">Ответить</a></span>
					</div>
				</div>
			</div>
			<div class="review_page_bottom_pagination">
				Товары 1 - 2 из 3  Начало | 1 2 3 4 5 | След. | Конец | Все
			</div>	
		</div>
	</div>
</div>
*/?> <?/*$APPLICATION->IncludeComponent(
	"newmark:forum.topic.reviews", 
	"new_reviews", 
	array(
		"SHOW_LINK_TO_FORUM" => "N",
		"FILES_COUNT" => "0",
		"FORUM_ID" => "",
		"IBLOCK_TYPE" => "news",
		"ELEMENT_ID" => 42228,
		"IBLOCK_ID" => 11,
		"AJAX_POST" => "N",
		"POST_FIRST_MESSAGE" => "Y",
		"POST_FIRST_MESSAGE_TEMPLATE" => "#IMAGE#[url=#LINK#]#TITLE#[/url]#BODY#",
		"URL_TEMPLATES_READ" => "read.php?FID=#FID#&TID=#TID#",
		"URL_TEMPLATES_DETAIL" => "photo_detail.php?ID=#ELEMENT_ID#",
		"URL_TEMPLATES_PROFILE_VIEW" => "",
		"MESSAGES_PER_PAGE" => "50",
		"PAGE_NAVIGATION_TEMPLATE" => "",
		"DATE_TIME_FORMAT" => "d.m.Y H:i:s",
		"PATH_TO_SMILE" => "/bitrix/images/forum/smile/",
		"EDITOR_CODE_DEFAULT" => "N",
		"SHOW_AVATAR" => "Y",
		"SHOW_RATING" => "Y",
		"RATING_TYPE" => "like",
		"SHOW_MINIMIZED" => "N",
		"USE_CAPTCHA" => "Y",
		"PREORDER" => "Y",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "0",
		"NAME_TEMPLATE" => "",
		"COMPONENT_TEMPLATE" => "new_reviews"
	),
	false
);?>
<div class="new_section_items">
	<div class="container">
		<div class="promocode">
			 <?$APPLICATION->IncludeComponent(
	"bitrix:main.include",
	"",
	Array(
		"AREA_FILE_SHOW" => "file",
		"PATH" => SITE_DIR."include/promocode.php"
	)
);?>
		</div>
		<div class="promocode_content">
			 <?	
				//Receiving last products from section
				function findLast($curSection, $curElement = array(), $limit = 2, $complete = array()) {
					$arrFilter = array(
						"SECTION_ID" => $curSection,
						"!ID" => $curElement,
						"!PREVIEW_PICTURE" => FALSE,
						"ACTIVE" => 'Y',
						"INCLUDE_SUBSECTIONS" => 'Y'
						);
					$result = CIBlockElement::GetList(
						array(
							"created" => "DESC",
							"ID" => "DESC"
							),
						$arrFilter,
						false,
						array(
							"nTopCount" => $limit
							),
						array(
							"PROPERTY_AUTOR",
							"NAME",
							"ID",
							"DETAIL_PAGE_URL",
							"BUY_URL",
							"CATALOG_GROUP_1",
							"PREVIEW_PICTURE",
							"PREVIEW_TEXT",
							"DETAIL_TEXT"
							)
						);
					if($result->SelectedRowsCount() > 0) {
						while($row = $result->GetNext()) {
							if(count($complete) >= $limit) {
								return $complete;
							}
							$complete[] = $row;
							$curElement[] = $row['ID'];
						}
					}
					if(count($complete) >= $limit) {
						return $complete;
					}
					$nextSection = CIBlockSection::GetByID($curSection)->GetNext();
					if(!empty($nextSection['IBLOCK_SECTION_ID'])) {
						$complete = findLast($nextSection['IBLOCK_SECTION_ID'], $curElement, $limit, $complete);
						return $complete;
					} else {
						return $complete;
					}
				}
				$curSection = 433;
				$curElement = array();
				$limit = 2;
				$last = findLast($curSection, $curElement, $limit);
			?> <?
			if(count($last) == 2) { 
				$last[0]['ADD_URL'] = $APPLICATION->GetCurUri().'&action=ADD2BASKET&id='.$last[0]['ID'];
				$last[0]['PICTURE'] = CFile::GetPath($last[0]['PREVIEW_PICTURE']);
				$last[1]['ADD_URL'] = $APPLICATION->GetCurUri().'&action=ADD2BASKET&id='.$last[1]['ID'];
				$last[1]['PICTURE'] = CFile::GetPath($last[1]['PREVIEW_PICTURE']);
				?>
			<h2>Новинки</h2>
			<div class="authors_book_block_list">
				<div class="news_item_block">
					<div class="news_item_block_photo">
 <img width="120px" src="<?=$last[0]['PICTURE']?>" alt="">
					</div>
					<div class="news_item_info">
						<div class="new_item_name">
							 <?=$last[0]['NAME']?>
						</div>
						<div class="news_item_author">
							 <?=$last[0]['PROPERTY_AUTOR_VALUE']?>
						</div>
						<div class="news_item_price">
							 <?=$last[0]['CATALOG_PRICE_1']?>
						</div>
 <a href="<?=$last[0]['ADD_URL']?>">
						<div class="bx_big bx_bt_button bx_cart">
						</div>
 </a> <a href="<?=$last[0]['DETAIL_PAGE_URL']?>">
						<div class="detail_button sprite_detail_button">
						</div>
 </a>
					</div>
					<div class="news_item_desc">
						 <? if(!empty($last[0]['PREVIEW_TEXT'])) {
						if(strlen($last[0]['PREVIEW_TEXT']) > 250) {
							echo substr($last[0]['PREVIEW_TEXT'], 0, 250);
							echo "<br><a href='".$last[0]['DETAIL_PAGE_URL']."'>Читать дальше...</a>";
						} else {
							echo $last[0]['PREVIEW_TEXT'];
						}
					} else {
						if(strlen($last[0]['DETAIL_TEXT']) > 250) {
							echo substr($last[0]['DETAIL_TEXT'], 0, 250);
							echo "<br><a href='".$last[0]['DETAIL_PAGE_URL']."'>Читать дальше...</a>";
						} else {
							echo $last[0]['DETAIL_TEXT'];
						}
					}
					?>
					</div>
				</div>
				<div class="news_item_block news_item_block-no-margin">
					<div class="news_item_block_photo">
 <img width="120px" src="<?=$last[1]['PICTURE']?>" alt="">
					</div>
					<div class="news_item_info">
						<div class="new_item_name">
							 <?=$last[1]['NAME']?>
						</div>
						<div class="news_item_author">
							 <?=$last[1]['PROPERTY_AUTOR_VALUE']?>
						</div>
						<div class="news_item_price">
							 <?=$last[1]['CATALOG_PRICE_1']?>
						</div>
 <a href="<?=$last[1]['ADD_URL']?>">
						<div class="bx_big bx_bt_button bx_cart">
						</div>
 </a> <a href="<?=$last[1]['DETAIL_PAGE_URL']?>">
						<div class="detail_button sprite_detail_button">
						</div>
 </a>
					</div>
					<div class="news_item_desc">
						 <? if(!empty($last[1]['PREVIEW_TEXT'])) {
						if(strlen($last[1]['PREVIEW_TEXT']) > 250) {
							echo substr($last[1]['PREVIEW_TEXT'], 0, 250);
							echo "<br><a href='".$last[1]['DETAIL_PAGE_URL']."'>Читать дальше...</a>";
						} else {
							echo $last[1]['PREVIEW_TEXT'];
						}
					} else {
						if(strlen($last[1]['DETAIL_TEXT']) > 250) {
							echo substr($last[1]['DETAIL_TEXT'], 0, 250);
							echo "<br><a href='".$last[1]['DETAIL_PAGE_URL']."'>Читать дальше...</a>";
						} else {
							echo $last[1]['DETAIL_TEXT'];
						}
					}
					?>
					</div>
				</div>
			</div>
			 <? } ?>
		</div>
	</div>
</div>
 <?php */ ?>&nbsp;&nbsp;<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>