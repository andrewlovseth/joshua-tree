<?php

/*
    Register Blocks
*/




add_action('acf/init', 'my_register_blocks');

function my_register_blocks() {
    if( function_exists('acf_register_block_type') ) {

        acf_register_block_type(array(
            'name'              => 'sidebar',
            'title'             => __('Sidebar'),
            'description'       => __('Inset sidebar inline with copy.'),
            'render_template'   => 'blocks/sidebar/sidebar.php',
            'category'          => 'layout',
            'icon'              => 'welcome-widgets-menus',
            'align'             => 'right',
            'mode'			    => 'preview',
            'supports'          => array(
                'align' => array( 'left', 'right', 'full' ),
                'jsx' => true
            ),
        ));

    }
}