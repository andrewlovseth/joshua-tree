<?php

/*
	Enqueue Styles & Scripts
*/


// Enqueue custom styles and scripts
function bearsmith_enqueue_styles_and_scripts() {
    // Register and noConflict jQuery 3.6.0



	$uri = get_stylesheet_directory_uri();
    $dir = get_stylesheet_directory();

    $script_last_updated_at = filemtime($dir . '/js/site.js');
    $style_last_updated_at = filemtime($dir . '/style.css');

    // Add style.css and third-party css
    wp_enqueue_style( 'style', get_stylesheet_directory_uri() . '/style.css', '', $style_last_updated_at );

    // Add plugins.js & site.js (with jQuery dependency)
    wp_enqueue_script( 'custom-plugins', get_stylesheet_directory_uri() . '/js/plugins.js', array( 'jquery' ), $script_last_updated_at, true );
    wp_enqueue_script( 'custom-site', get_stylesheet_directory_uri() . '/js/site.js', array( 'jquery' ), $script_last_updated_at, true );

    // Omnibox search (vanilla JS, no jQuery dependency, loaded in footer)
    $search_script_last_updated_at = filemtime( $dir . '/js/search.js' );

    wp_enqueue_script( 'esa-search', $uri . '/js/search.js', array(), $search_script_last_updated_at, true );

    // Hand the REST endpoint + home URL to the script as window.esaSearch
    wp_localize_script( 'esa-search', 'esaSearch', array(
        'endpoint' => esc_url_raw( rest_url( 'esa/v1/search' ) ),
        'homeUrl'  => esc_url_raw( home_url( '/' ) ),
    ) );
}
add_action( 'wp_enqueue_scripts', 'bearsmith_enqueue_styles_and_scripts' );


// Add backend styles for Gutenberg
function gutenberg_styles() {
    wp_enqueue_style( 'gutenberg-styles', get_theme_file_uri('gutenberg.css'), false );
}
add_action( 'enqueue_block_editor_assets', 'gutenberg_styles' );