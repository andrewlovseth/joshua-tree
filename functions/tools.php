<?php

/*
    Tools CPT

    The `tools` post type and its field group are registered via ACF local JSON
    (acf-json/post_type_tools.json + acf-json/group_tools.json). This file holds
    the theme-side glue: body-class reuse and the card icon library.
*/


/*
    HELD BACK — the Tools CPT and its service-page module shipped before the
    content was ready, so service pages rendered placeholder mock cards. Until
    the real inventory lands, the post type is registered admin-only: no public
    URLs, no REST, invisible to WP search and nav menus. Authoring in wp-admin
    still works.

    To bring Tools back: delete this filter and restore the module include in
    single-service.php.
*/
function esa_tools_hide_from_front_end( $args, $post_type ) {

    if ( 'tools' !== $post_type ) {
        return $args;
    }

    $args['public']              = false;
    $args['publicly_queryable']  = false;
    $args['exclude_from_search'] = true;
    $args['show_in_nav_menus']   = false;
    $args['show_in_rest']        = false;
    $args['has_archive']         = false;

    // Keep the admin UI so tools stay authorable while the front end is dark.
    $args['show_ui']             = true;
    $args['show_in_menu']        = true;

    return $args;
}
add_filter( 'register_post_type_args', 'esa_tools_hide_from_front_end', 10, 2 );


// The tool detail page (single-tools.php) reuses the service page's hero,
// intro and section styling. Mirror the specimen's dual body class by adding
// `single-service` alongside `single-tools`; tool-specific sections layer on
// top via body.single-tools rules.
function esa_tools_body_class( $classes ) {
    if ( is_singular( 'tools' ) ) {
        $classes[] = 'single-service';
    }
    return $classes;
}
add_filter( 'body_class', 'esa_tools_body_class' );


// Line-style inline SVG icons for the tool cards' gradient tiles. Used for the
// placeholder inventory and as the fallback when a tool has no uploaded icon.
// 24-unit viewBox, currentColor stroke — matches the specimen's icon direction.
function esa_tool_icon_svg( $key ) {

    $icons = array(

        // trend / tracker
        'chart'  => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 17l5-5 4 4 8-8M21 8v5M21 8h-5" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"/></svg>',

        // layered navigator
        'layers' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2l9 4-9 4-9-4 9-4zM3 11l9 4 9-4M3 16l9 4 9-4" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"/></svg>',

        // assistant / idea
        'bulb'   => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 3a7 7 0 0 1 7 7c0 2.5-1.3 4-2.5 5.2-.8.8-1.5 1.5-1.5 2.8H9c0-1.3-.7-2-1.5-2.8C6.3 14 5 12.5 5 10a7 7 0 0 1 7-7zM9.5 21h5" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"/></svg>',

        // location / species map
        'pin'    => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 21s-7-4.5-7-10a7 7 0 0 1 14 0c0 5.5-7 10-7 10z" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linejoin="round"/><circle cx="12" cy="11" r="2.5" fill="none" stroke="currentColor" stroke-width="1.75"/></svg>',

        // seasonal calendar / clock
        'clock'  => '<svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="9" fill="none" stroke="currentColor" stroke-width="1.75"/><path d="M12 7v5l3.5 2" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"/></svg>',

        // default tool
        'default' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M14.7 6.3a4 4 0 0 0-5.2 5.2l-6 6a1.5 1.5 0 0 0 2.1 2.1l6-6a4 4 0 0 0 5.2-5.2l-2.4 2.4-2.1-2.1 2.4-2.4z" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"/></svg>',
    );

    return isset( $icons[ $key ] ) ? $icons[ $key ] : $icons['default'];
}
