<?php

/*

    Template Name: Market (Legacy)
    Template Post Type: market

*/


get_header(); ?>

    <?php get_template_part('templates/single-market/page-header'); ?>

    <?php get_template_part('templates/single-market/featured-projects'); ?>
    
    <?php get_template_part('templates/single-market/market-info'); ?>

    <?php get_template_part('templates/single-market/more-projects'); ?>

    <?php get_template_part('template-parts/global/news-grid'); ?>

<?php get_footer(); ?>