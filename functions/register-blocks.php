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


        acf_register_block_type(array(
            'name'              => 'esa-contacts',
            'title'             => __('ESA Contacts'),
            'description'       => __('Customizable grid of ESA contacts.'),
            'render_template'   => 'blocks/esa-contacts/esa-contacts.php',
            'category'          => 'layout',
            'icon'              => 'dashicons-grid-view',
            'align'             => 'full',
            'mode'			    => 'preview',
            'supports'          => array(
                'jsx' => true
            ),
        ));

        acf_register_block_type(array(
            'name'              => 'esa-hero',
            'title'             => __('ESA Hero'),
            'description'       => __('Customizable ESA hero.'),
            'render_template'   => 'blocks/esa-hero/esa-hero.php',
            'category'          => 'layout',
            'icon'              => 'dashicons-grid-view',
            'align'             => 'full',
            'mode'			    => 'preview',
            'supports'          => array(
                'align' => array('full' ),

                'jsx' => true
            ),
        ));

        acf_register_block_type(array(
            'name'              => 'esa-featured-projects',
            'title'             => __('ESA Featured Projects'),
            'description'       => __('ESA Featured Projects block.'),
            'render_template'   => 'blocks/esa-featured-projects/esa-featured-projects.php',
            'category'          => 'layout',
            'icon'              => 'dashicons-grid-view',
            'align'             => 'full',
            'mode'			    => 'preview',
            'supports'          => array(
                'align' => array('full' ),
                'jsx' => true
            ),
        ));

        acf_register_block_type(array(
            'name'              => 'esa-experts',
            'title'             => __('ESA Experts'),
            'description'       => __('Grid of team members with circular photos.'),
            'render_template'   => 'blocks/esa-experts/esa-experts.php',
            'category'          => 'layout',
            'icon'              => 'groups',
            'mode'              => 'preview',
            'supports'          => array(
                'align' => false,
                'jsx' => false
            ),
        ));

        acf_register_block_type(array(
            'name'              => 'landing-sidebar',
            'title'             => __('Landing Sidebar'),
            'description'       => __('Sidebar with contacts, date, and share links for landing pages.'),
            'render_template'   => 'blocks/landing-sidebar/landing-sidebar.php',
            'category'          => 'layout',
            'icon'              => 'sidebar',
            'mode'              => 'preview',
            'supports'          => array(
                'jsx' => false,
            ),
        ));
    }
}