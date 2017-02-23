jQuery(document).ready(function($){

	$("#homepage-slider").owlCarousel({
		navigation : true,
		slideSpeed : 300,
		paginationSpeed : 400,
		singleItem:true,
		navigationText : false,
		autoPlay: 5000,
		mouseDrag: false,
		transitionStyle : "fade"
	});

});