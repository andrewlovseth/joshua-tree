(function ($, window, document, undefined) {

	$(document).ready(function($) {

		// Nav Trigger
		$('.js-nav-trigger').click(function(){
			$('body').toggleClass('nav-overlay-open');
			return false;
		});

		// Search Trigger
		$('.js-search-trigger').click(function(){
			$('body').toggleClass('search-overlay-open');
			return false;
		});

			
	});


	$(document).mouseup(function(e) {
		var menu = $('.mobile-nav, .js-nav-trigger, .search-nav');
	
		if (!menu.is(e.target) && menu.has(e.target).length === 0) {
			$('body').removeClass('nav-overlay-open search-overlay-open');
		}
	});


	$(document).keyup(function(e) {		
		if (e.keyCode == 27) {
			$('body').toggleClass('nav-overlay-open');
			$('body').removeClass('search-overlay-open');
		}
	});


})(jQuery, window, document);