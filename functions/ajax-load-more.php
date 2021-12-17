<?php

add_filter('alm_no_results_text', function(){
	return '<div class="no-results"><p>No results found.</p></div>';
});


add_filter('alm_display_results', function(){
	return '';
});