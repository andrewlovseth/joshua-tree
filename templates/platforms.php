<?php 

/*

    Template Name: Platform Index
    Template Post Type: service

*/

get_header(); ?>

    <?php get_template_part('templates/single-service/hero'); ?>
    
    <?php get_template_part('templates/platforms/about'); ?>

    <?php get_template_part('templates/platforms/cta'); ?>

    <?php get_template_part('templates/platforms/platforms'); ?>

    <?php get_template_part('templates/platforms/experts'); ?>

    <?php get_template_part('templates/single-service/featured-projects'); ?>

    <?php get_template_part('template-parts/global/news-grid'); ?>

<?php get_footer(); ?>

