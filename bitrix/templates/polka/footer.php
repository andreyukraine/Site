		<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

		</div> <!-- //bx_content_section-->

		<? if($APPLICATION->GetCurPage() == '/'): ?>
			<?$APPLICATION->IncludeComponent("bitrix:catalog.section.list","footer_list", Array(
				"VIEW_MODE" => "LIST",
				"SHOW_PARENT_NAME" => "N",
				"IBLOCK_TYPE" => "catalog",
				"IBLOCK_ID" => "2",
				"SECTION_ID" => "",
				"SECTION_CODE" => "",
				"SECTION_URL" => "",
				"COUNT_ELEMENTS" => "N",
				"TOP_DEPTH" => "2",
				"SECTION_FIELDS" => array("ID", "CODE", "NAME"),
				"SECTION_USER_FIELDS" => "",
				"ADD_SECTIONS_CHAIN" => "Y",
				"CACHE_TYPE" => "A",
				"CACHE_TIME" => "36000000",
				"CACHE_NOTES" => "",
				"CACHE_GROUPS" => "Y"
			));?>
			<script>
				$(function() {
					$.each($('.categories_list'), function(i, v) {
						if($(v).find('ul li').length > 6) {
							$(v).find('ul').html($(v).find('ul li').slice(0, 6));
						}
					});
				});
			</script>
		<?endif;?>


		<div class="footer">
			<div class="top_footer_block">
				<div class="container">
					<div class="row">
						<div class="col-xs-3 top_footer_block_el">
							<div class="time_table">
								<?$APPLICATION->IncludeComponent("bitrix:main.include", "", Array("AREA_FILE_SHOW" => "file", "PATH" => SITE_DIR."include/timetable.php", "EDIT_MODE" => "html"), false, Array());?>
							</div>
						</div>
						<div class="col-xs-3 top_footer_block_el">
							<div class="phone_table">
								<?
								$APPLICATION->IncludeComponent("bitrix:main.include", "", Array(
									"AREA_FILE_SHOW" => "file",
									"PATH" => SITE_DIR.'include/'.(in_array($_COOKIE['currency'], array("USD", "EUR"))?'phonetable_us':'phonetable').'.php',
									"EDIT_MODE" => "html",
								), false, Array());
								?>
							</div>
						</div>
						<div class="col-xs-2 top_footer_block_el">
							<div class="footer_menu">
								<?$APPLICATION->IncludeComponent("bitrix:menu", "footer_menu", array(
									"COMPONENT_TEMPLATE" => "footer_menu",
									"ROOT_MENU_TYPE" => "footer",
									"MENU_CACHE_TYPE" => "Y",
									"MENU_CACHE_TIME" => "86400",
									"MENU_CACHE_USE_GROUPS" => "Y",
									"MENU_CACHE_GET_VARS" => array(
									),
									"MAX_LEVEL" => "1",
									"CHILD_MENU_TYPE" => "left",
									"USE_EXT" => "N",
									"DELAY" => "N",
									"ALLOW_MULTI_SELECT" => "N"
								), false); ?>
							</div>
						</div>
						<div class="col-xs-4 top_footer_block_el">
							<img src="<?= SITE_TEMPLATE_PATH . '/images/footer_logo.png' ?>" alt="Polka" width="100%" />
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
			<div class="footer_info">
				<div class="container">
					<div class="row">
						<div class="col-xs-6">
							<?$APPLICATION->IncludeComponent("bitrix:main.include", "", Array("AREA_FILE_SHOW" => "file", "PATH" => SITE_DIR."include/foot_text.php", "EDIT_MODE" => "html", ), false, Array());?>
						</div>
						<div class="col-xs-3">
							<div id="vk_groups" style="height: 142px; width: 230px; background: none;">
								<iframe name="fXDcc327" frameborder="0" rel="nofollow" src="http://vk.com/widget_community.php?app=0&amp;width=230px&amp;_ver=1&amp;gid=43946548&amp;mode=0&amp;color1=&amp;color2=&amp;color3=&amp;class_name=&amp;height=142&amp;url=http%3A%2F%2Fknigionline.com%2F&amp;14a77d967cd" width="230" height="142" scrolling="no" id="vkwidget1" style="overflow: hidden; height: 142px;"></iframe>
							</div>
						</div>
						<div class="col-xs-3">
							<div class="fb-like-box fb_iframe_widget" data-href="http://www.facebook.com/KnizhnayaPolka" rel="nofollow" data-width="230" data-height="142" data-show-faces="true" data-stream="false" data-header="true" fb-xfbml-state="rendered" fb-iframe-plugin-query="app_id=186132041471000&amp;header=true&amp;height=142&amp;href=http%3A%2F%2Fwww.facebook.com%2FKnizhnayaPolka&amp;locale=ru_RU&amp;sdk=joey&amp;show_faces=true&amp;stream=false&amp;width=230">
										<span style="vertical-align: bottom; width: 230px; height: 142px; background-color: #F2F2F2;">
											<iframe name="f153edcde4" width="230px" height="142px" frameborder="0" allowtransparency="true" scrolling="no" title="fb:like_box Facebook Social Plugin" src="http://www.facebook.com/plugins/like_box.php?app_id=186132041471000&amp;channel=http%3A%2F%2Fstatic.ak.facebook.com%2Fconnect%2Fxd_arbiter%2F7r8gQb8MIqE.js%3Fversion%3D41%23cb%3Df11c2316f8%26domain%3Dknigionline.com%26origin%3Dhttp%253A%252F%252Fknigionline.com%252Ff1bd8f6948%26relation%3Dparent.parent&amp;header=true&amp;height=142&amp;href=http%3A%2F%2Fwww.facebook.com%2FKnizhnayaPolka&amp;locale=ru_RU&amp;sdk=joey&amp;show_faces=true&amp;stream=false&amp;width=230" style="border: none; visibility: visible; width: 230px; height: 142px;  background-color: #F2F2F2;" class=""></iframe>
										</span>
							</div>
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>

		</div>  <!-- //footer_wrap -->

		</div><!-- //wrap -->

		<script type="text/javascript" src="https://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4e60164f0430c255" rel="nofollow"></script>
		<script type="text/javascript">
			window.vkAsyncInit = function() {
				VK.init({
					apiId: 3198636
				});
			};

			setTimeout(function() {
				var el = document.createElement("script");
				el.type = "text/javascript";
				el.src = "//vk.com/js/api/openapi.js";
				el.async = true;
				var vk_like = document.getElementById("vk_like");
				if (vk_like){
					vk_like.appendChild(el)
				}
			}, 0);
		</script>

		<!-- Google Analytics -->
		<script>
			window.ga=window.ga||function(){(ga.q=ga.q||[]).push(arguments)};ga.l=+new Date;
			ga('create', 'UA-649838-23', 'auto');
			ga('send', 'pageview');
		</script>
		<script async src='//www.google-analytics.com/analytics.js'></script>
		<!-- End Google Analytics -->
	</body>
</html>