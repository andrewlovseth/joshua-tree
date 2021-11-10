(function ($, window, document, undefined) {

	$(document).ready(function($) {

		// rel="external"
		$('a[rel="external"]').click( function() {
			window.open( $(this).attr('href') );
			return false;
		});

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
		
		// Smooth Scroll Links
		$('.smooth').smoothScroll();


		// Mobile Nav Dropdown Toggle
		$('.mobile-nav .dropdown .section-header').on('click', function() {

			let subnav = $(this).attr('href');
			let dropdown = $(this).closest('.dropdown');

			$(subnav).slideToggle(400).toggleClass('active');;
			$(dropdown).toggleClass('active');

			return false;
		});



		// Tab Links
		$('.tab-links a').on('click', function() {
			$('.tab-links a').removeClass('active');
			$(this).addClass('active');

			var tab_target = $(this).attr('href');
			$('.tab').removeClass('active');
			$(tab_target).addClass('active');
			
			return false;
		});


		// Our Work Nav
		$('.link-our-work').on('click', function() {

			$('.work-nav').toggleClass('active');
			
			return false;
		});


		// Markets / Featured Projects Slider
		$('.projects-slider').slick({
			dots: true,
			arrows: false,
			infinite: true,
			autoplay: true,
			autoplaySpeed: 6000,
		});


		$('.news-slider').slick({
			dots: true,
			arrows: false,
			infinite: true,
			autoplay: true,
			autoplaySpeed: 6000,
		});


		// Markets / More Projects Slider
		$('.more-projects-slider').slick({
			dots: false,
			arrows: true,
			infinite: true,
			slidesToShow: 1,
			slidesToScroll: 1,
			adaptiveHeight: false,
			mobileFirst: true,
			responsive: [
				{
				  breakpoint: 768,
				  settings: {
					slidesToShow: 2,
					slidesToScroll: 1,
				  }
				}
			]
		});


		//Clients: Tabs
		$('.client-tabs a').on('click', function(){
			let section = $(this).attr('href');
			console.log(section);

			$('.client-type').removeClass('active');
			$(section).addClass('active');

			$('.client-tabs a').removeClass('active');
			$(this).addClass('active');

			return false;
		});

		// Clients: Projects Toggle
		$('.client.has-projects .name').on('click', function(){
			let projects = $(this).siblings('.projects');
			$(projects).toggle();

			$(this).toggleClass('active');

		});

		let clearBtn = document.getElementById('alm-filters-reset-button');
		$(clearBtn).on('click', function(e){
		   almfilters.reset();
		   $('.alm-filter--select select option').prop('selected', function() {
			   return this.defaultSelected;
			});
		});



	});


	$(window).scroll(function() {    
		var scroll = $(window).scrollTop();    
		if (scroll >= 0.4 * $(window).height()) {
			$('body').addClass('show-top-btn');
		} else {
			$('body').removeClass('show-top-btn');
		}
	});


	$(document).mouseup(function(e) {
		var menu = $('.mobile-nav, .js-nav-trigger, .search-nav');
	
		if (!menu.is(e.target) && menu.has(e.target).length === 0) {
			$('body').removeClass('nav-overlay-open search-overlay-open');
		}


		var work_nav = $('.work-nav, .link-our-work');
		if (!work_nav.is(e.target) && work_nav.has(e.target).length === 0) {
			$('.work-nav').removeClass('active');
		}

	});


	$(document).keyup(function(e) {		
		if (e.keyCode == 27) {
			$('body').removeClass('nav-overlay-open search-overlay-open');
			$('.work-nav').removeClass('active');
		}
	});


})(jQuery, window, document);