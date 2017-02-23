function eshopOpenNativeMenu()
{
	var native_menu = BX("bx_native_menu");
	var is_menu_active = BX.hasClass(native_menu, "active");

	if (is_menu_active)
	{
		BX.removeClass(native_menu, "active");
		BX.removeClass(BX('bx_menu_bg'), "active");
		BX("bx_eshop_wrap").style.position = "";
		BX("bx_eshop_wrap").style.top = "";
		BX("bx_eshop_wrap").style.overflow = "";
	}
	else
	{
		BX.addClass(native_menu, "active");
		BX.addClass(BX('bx_menu_bg'), "active");
		var topHeight = document.body.scrollTop;
		BX("bx_eshop_wrap").style.position = "fixed";
		BX("bx_eshop_wrap").style.top = -topHeight+"px";
		BX("bx_eshop_wrap").style.overflow = "hidden";
	}

	var easing = new BX.easing({
		duration : 300,
		start : { left : (is_menu_active) ? 0 : -100 },
		finish : { left : (is_menu_active) ? -100 : 0 },
		transition : BX.easing.transitions.quart,
		step : function(state){
			native_menu.style.left = state.left + "%";
		}
	});
	easing.animate();
}

window.addEventListener('resize', function() {
	if (window.innerWidth >= 640 && BX.hasClass(BX("bx_native_menu"), "active"))
		eshopOpenNativeMenu();
}, false );

$(function(){
	$(document).on('click', '#goto-top', function(){
		$('html,body').animate({scrollTop:0}, 200); 
	});
	$(window).on('scroll', function(){
		var w = $(window), but = $('#goto-top');
		if(w.scrollTop()>50 && but.css('display')=='none') but.css('display', 'block');
		else if(w.scrollTop()<50 && but.css('display')!='none') but.css('display', '');
	}); 
	$(document).on('click', '.btn_custom_offer', function() {
		$('.block_custom_offer').toggle();
		$('.layer_custom_offer').toggle();
		return false;
	});
	$(document).on('click', '.layer_custom_offer', function() {
		$('.block_custom_offer').hide();
		$('.layer_custom_offer').hide();
	});



	var $slider_real_top = $('.slider_real_top'),
		$slider_real_top_controls = $('.slider_real_top_controls'),
		$owl_slider_real_top = $slider_real_top.data('owlCarousel');

	$(document).on('click', '.top_custom_link', function() {
		$('.top_custom_section').hide().removeClass('active');
		$('.top_custom_link').removeClass('active');
		$(this).addClass('active');
		var id = $(this).data('section');
		$('#top_custom_section_'+id).show().addClass('active');
		
		return false;
	});

	$slider_real_top.owlCarousel({
		navigation: false,
		pagination: false,
		mouseDrag: false,
		touchDrag: false,
		items: 5
	});

	$slider_real_top_controls.find('.s_prev').on('click', function() {
		$slider_real_top.trigger('owl.prev');
	});

	$slider_real_top_controls.find('.s_next').on('click', function() {
		$slider_real_top.trigger('owl.next');
	});




	$('.top_custom_link').first().trigger('click');
	$(document).on('submit', '#cpnform', function(e) {
		var form = $(this);
		e.preventDefault();
		$.post("", form.serialize(), function(data) {
			alert(data);
			$('#coupon').val($("#coupon_sb").val());
		});
	});
	$(document).on('click', '[data-togglenext]', function(){
		$(this).next().slideToggle(200);
	});
	$(document).on('change', '#empty_form [name]', function() {
		$(this.form).trigger('submit');
	});

});

jQuery(document).ready(function($){
	// browser window scroll (in pixels) after which the "back to top" link is shown
	var offset = 300,
		//browser window scroll (in pixels) after which the "back to top" link opacity is reduced
		offset_opacity = 1200,
		//duration of the top scrolling animation (in ms)
		scroll_top_duration = 700,
		//grab the "back to top" link
		$back_to_top = $('.cd-top');

	//hide or show the "back to top" link
	$(window).scroll(function(){
		( $(this).scrollTop() > offset ) ? $back_to_top.addClass('cd-is-visible') : $back_to_top.removeClass('cd-is-visible cd-fade-out');
		if( $(this).scrollTop() > offset_opacity ) {
			$back_to_top.addClass('cd-fade-out');
		}
	});

	//smooth scroll to top
	$back_to_top.on('click', function(event){
		event.preventDefault();
		$('body,html').animate({
				scrollTop: 0 ,
			}, scroll_top_duration
		);
	});




	$('body').on('submit', 'form', function(e) {	
		if($(this).attr('data-sendby') == 'ajax') {
			
			
			
			e.preventDefault();
			$.fancybox.showLoading();
			//console.log( $( this ).serializeArray() );
	    $.ajax({
	      type: 'POST',
	      cache: false,
	      url: '/ajax/product_subscribe_form.php',
		  
	      data: $(this).serializeArray(),
		  
	      success: function (data) {
	      	$.fancybox.hideLoading();
	        $.fancybox(data, {
				
	            fitToView: false,
	            padding: 0,
	            margin: 0,
	            type: 'html'
	        });

	      }
	    });
	  } 
	});



});