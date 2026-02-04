<?php

/*
    Advanced Custom Fields
*/


// Add options pages
function bearsmith_acf_options_pages() {
    acf_add_options_page();
    acf_add_options_sub_page('Header');
    acf_add_options_sub_page('Footer');
    acf_add_options_sub_page('Clients');
    acf_add_options_sub_page('API Keys');
}
add_action('acf/init', 'bearsmith_acf_options_pages');


// Order Relationship fields
function bearsmith_relationship_order_by_date($args, $field, $post_id) {
    $args['orderby'] = 'date';
    $args['order'] = 'DESC';
    return $args;
}
add_filter('acf/fields/relationship/query', 'bearsmith_relationship_order_by_date', 10, 3);


// Custom back-end styles
function bearsmith_acf_styles() {
    ?>

        <style type="text/css">
            .acf-relationship .list {
                height: 400px;
            }
        </style>

    <?php
}
add_action('acf/input/admin_head', 'bearsmith_acf_styles');

// Set Google Maps API key from ACF option (stored in Options > API Keys)
function esa_acf_google_maps_api_key() {
    $api_key = get_field('google_maps_api_key', 'option');
    if ($api_key) {
        acf_update_setting('google_api_key', $api_key);
    }
}
add_action('acf/init', 'esa_acf_google_maps_api_key');