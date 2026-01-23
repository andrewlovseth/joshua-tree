<?php
/**
 * Block Patterns
 *
 * Registers pattern categories and pre-configured block patterns
 * for use in the block editor.
 */

/**
 * Register ESA pattern category.
 */
function esa_register_pattern_category() {
    register_block_pattern_category( 'esa', array(
        'label' => __( 'ESA', 'joshua-tree' ),
    ) );
}
add_action( 'init', 'esa_register_pattern_category' );

/**
 * Register ESA Hero pattern using the Cover block.
 */
function esa_register_hero_pattern() {
    register_block_pattern( 'esa/landing-hero', array(
        'title'       => __( 'Landing Hero', 'joshua-tree' ),
        'description' => __( 'Full-width hero with background image and overlaid title for landing pages.', 'joshua-tree' ),
        'categories'  => array( 'esa' ),
        'content'     => '<!-- wp:cover {"dimRatio":30,"minHeight":50,"minHeightUnit":"vh","align":"full","className":"esa-hero-pattern"} -->
<div class="wp-block-cover alignfull esa-hero-pattern" style="min-height:50vh"><span aria-hidden="true" class="wp-block-cover__background has-background-dim-30 has-background-dim"></span><div class="wp-block-cover__inner-container"><!-- wp:heading {"level":1,"style":{"typography":{"fontWeight":"700"}},"textColor":"white"} -->
<h1 class="wp-block-heading has-white-color has-text-color" style="font-weight:700">Page Title</h1>
<!-- /wp:heading --></div></div>
<!-- /wp:cover -->',
    ) );
}
add_action( 'init', 'esa_register_hero_pattern' );

/**
 * Register Landing Article pattern: two-column layout with sidebar.
 *
 * Left column (66.66%) for native blocks (content).
 * Right column (33.33%) with the Landing Sidebar ACF block pre-placed.
 */
function esa_register_landing_article_pattern() {
    register_block_pattern( 'esa/landing-article', array(
        'title'       => __( 'Landing Article', 'joshua-tree' ),
        'description' => __( 'Two-column layout with content on the left and a contacts/date/share sidebar on the right.', 'joshua-tree' ),
        'categories'  => array( 'esa' ),
        'content'     => '<!-- wp:columns {"className":"landing-article-columns"} -->
<div class="wp-block-columns landing-article-columns"><!-- wp:column {"width":"66.66%"} -->
<div class="wp-block-column" style="flex-basis:66.66%"><!-- wp:paragraph -->
<p>Add your content here...</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"33.33%"} -->
<div class="wp-block-column" style="flex-basis:33.33%"><!-- wp:acf/landing-sidebar /--></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->',
    ) );
}
add_action( 'init', 'esa_register_landing_article_pattern' );
