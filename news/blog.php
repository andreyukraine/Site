<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "blog");
$APPLICATION->SetTitle("blog");
?>
<?/*
<div class="blog_content">
	<div class="blog_breadcrumbs">
		<span>Главная страница ></span>
		<span> Вход на сайт ></span>
	</div>	
	<h2>Блог</h2>
	<div class="blog_post_item">
		<div class="blog_post_item_header">
			<div class="blog_post_item_header_data">
				Декабрь 4, 2015
			</div>
			<div class="blog_post_item_header_title">
				Новость для сайта Книжная Полка
			</div>
		</div>
		<div class="blog_post_item_content">
			<div class="blog_post_item_author_info">
				<div class="blog_post_item_author_photo">
					<img src="http://lorempixel.com/50/60/" alt="">
				</div>
				<div class="blog_post_item_author_name">
					Автор Janelle Sullivan
				</div>
			</div>
			<div class="blog_post_item_text">
				Главная особенность в том, что христианская литература – Богоцентрична, а все остальное – терминология, сюжетная линия и выбор литературных 
				средств – это детали. О чем бы ни повествовали авторы, такая книга обязательно строится на непреложных
				 истинах Божьей любви, и это определенно чувствуется. Возможно..<a href="">>></a>
			</div>
		</div>
		<div class="blog_post_item_content_photo">
			<img src="http://lorempixel.com/125/185/" alt="">
		</div>
		<div class="blog_post_item_footer">
			<div class="blog_post_item_footer_comments">
				<a href=""><img src="/upload/pics/cloud_review.png" alt=""></a> Комментарии(0)
			</div>
			<div class="blog_post_item_footer_plus">
				<a href=""><img src="/upload/pics/footer_plus.png" alt=""></a> Читать дальше
			</div>
		</div>
	</div>
	<div class="blog_post_item">
		<div class="blog_post_item_header">
			<div class="blog_post_item_header_data">
				Декабрь 4, 2015
			</div>
			<div class="blog_post_item_header_title">
				Новость для сайта Книжная Полка
			</div>
		</div>
		<div class="blog_post_item_content">
			<div class="blog_post_item_author_info">
				<div class="blog_post_item_author_photo">
					<img src="http://lorempixel.com/50/60/" alt="">
				</div>
				<div class="blog_post_item_author_name">
					Автор Janelle Sullivan
				</div>
			</div>
			<div class="blog_post_item_text">
				Главная особенность в том, что христианская литература – Богоцентрична, а все остальное – терминология, сюжетная линия и выбор литературных 
				средств – это детали. О чем бы ни повествовали авторы, такая книга обязательно строится на непреложных
				 истинах Божьей любви, и это определенно чувствуется. Возможно..<a href="">>></a>
			</div>
		</div>
		<div class="blog_post_item_content_photo">
			<img src="http://lorempixel.com/125/185/" alt="">
		</div>
		<div class="blog_post_item_footer">
			<div class="blog_post_item_footer_comments">
				<a href=""><img src="/upload/pics/cloud_review.png" alt=""></a> Комментарии(0)
			</div>
			<div class="blog_post_item_footer_plus">
				<a href=""><img src="/upload/pics/footer_plus.png" alt=""></a> Читать дальше
			</div>
		</div>
	</div>
	<div class="blog_post_item">
		<div class="blog_post_item_header">
			<div class="blog_post_item_header_data">
				Декабрь 4, 2015
			</div>
			<div class="blog_post_item_header_title">
				Новость для сайта Книжная Полка
			</div>
		</div>
		<div class="blog_post_item_content">
			<div class="blog_post_item_author_info">
				<div class="blog_post_item_author_photo">
					<img src="http://lorempixel.com/50/60/" alt="">
				</div>
				<div class="blog_post_item_author_name">
					Автор Janelle Sullivan
				</div>
			</div>
			<div class="blog_post_item_text">
				Главная особенность в том, что христианская литература – Богоцентрична, а все остальное – терминология, сюжетная линия и выбор литературных 
				средств – это детали. О чем бы ни повествовали авторы, такая книга обязательно строится на непреложных
				 истинах Божьей любви, и это определенно чувствуется. Возможно..<a href="">>></a>
			</div>
		</div>
		<div class="blog_post_item_content_photo">
			<img src="http://lorempixel.com/125/185/" alt="">
		</div>
		<div class="blog_post_item_footer">
			<div class="blog_post_item_footer_comments">
				<a href=""><img src="/upload/pics/cloud_review.png" alt=""></a> Комментарии(0)
			</div>
			<div class="blog_post_item_footer_plus">
				<a href=""><img src="/upload/pics/footer_plus.png" alt=""></a> Читать дальше
			</div>
		</div>
	</div>
	<div class="blog_post_item">
		<div class="blog_post_item_header">
			<div class="blog_post_item_header_data">
				Декабрь 4, 2015
			</div>
			<div class="blog_post_item_header_title">
				Новость для сайта Книжная Полка
			</div>
		</div>
		<div class="blog_post_item_content">
			<div class="blog_post_item_author_info">
				<div class="blog_post_item_author_photo">
					<img src="http://lorempixel.com/50/60/" alt="">
				</div>
				<div class="blog_post_item_author_name">
					Автор Janelle Sullivan
				</div>
			</div>
			<div class="blog_post_item_text">
				Главная особенность в том, что христианская литература – Богоцентрична, а все остальное – терминология, сюжетная линия и выбор литературных 
				средств – это детали. О чем бы ни повествовали авторы, такая книга обязательно строится на непреложных
				 истинах Божьей любви, и это определенно чувствуется. Возможно..<a href="">>></a>
			</div>
		</div>
		<div class="blog_post_item_content_photo">
			<img src="http://lorempixel.com/125/185/" alt="">
		</div>
		<div class="blog_post_item_footer">
			<div class="blog_post_item_footer_comments">
				<a href=""><img src="/upload/pics/cloud_review.png" alt=""></a> Комментарии(0)
			</div>
			<div class="blog_post_item_footer_plus">
				<a href=""><img src="/upload/pics/footer_plus.png" alt=""></a> Читать дальше
			</div>
		</div>
	</div>
	
	<div class="athors_page_block_pagination">
			Товары 1 - 2 из 3  Начало | 1 2 3 4 5 | След. | Конец | Все
	</div>	
</div>
</div>
</div>
<div class="new_section_items">
			<div class="container">
	<div class="promocode">
		<div class="promocode_input">
				<h3>Промо-Код</h3>
				<input type="text" placeholder="введите промо-код">
				<button>OK</button>
				<div class="promocode_description">
					Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ea, cumque, soluta. Nihil quisquam beatae ipsam laboriosam vel blanditiis nobis. Non, facilis fugit nisi laudantium Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ea, cumque, soluta. Nihil quisquam beatae ipsam laboriosam vel blanditiis nobis. Non id numquam exercitationem, aspernatur aliquid veniam.
				</div>
			</div>
		</div>
		<div class="promocode_content">
			<h2>Раздел</h2>
				<div class="authors_book_block_list">
				<div class="news_item_block">
				<div class="news_item_block_photo">
					<img src="http://lorempixel.com/100/150/" alt="">
				</div>
				<div class="news_item_info">
					<div class="new_item_name">
						Lorem Ipsum
					</div>
					<div class="news_item_author">
						dolor sit amet
					</div>
					<div class="news_item_price">
						57,00 грн
					</div>
					<div class="bx_big bx_bt_button bx_cart"></div>
					<div class="detail_button sprite_detail_button"></div>
				</div>
				<div class="news_item_desc">
					Lorem ipsum dolor sit amet, consectetur adipisicing elit. Tenetur ullam dicta iusto excepturi optio asperiores,
					 deserunt earum, facilis laudantium Lorem ipsum dolor sit amet, consectetur adipisicing elit. <a href="#">Читать дальше...</a>
				</div>
			</div>
				<div class="news_item_block news_item_block-no-margin">
				<div class="news_item_block_photo">
					<img src="http://lorempixel.com/100/150/" alt="">
				</div>
				<div class="news_item_info">
					<div class="new_item_name">
						Lorem Ipsum
					</div>
					<div class="news_item_author">
						dolor sit amet
					</div>
					<div class="news_item_price">
						57,00 грн
					</div>
					<div class="bx_big bx_bt_button bx_cart"></div>
					<div class="detail_button sprite_detail_button"></div>
				</div>
				<div class="news_item_desc">
					Lorem ipsum dolor sit amet, consectetur adipisicing elit. Tenetur ullam dicta iusto excepturi optio asperiores,
					 deserunt earum, facilis laudantium Lorem ipsum dolor sit amet, consectetur adipisicing elit. <a href="#">Читать дальше...</a>
				</div>
			</div>
			</div>
			</div>
		</div>
		</div>


*/?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>