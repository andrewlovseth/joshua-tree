<?php 

/*

    Template Name: Platform Detail
    Template Post Type: service

*/

get_header(); ?>

    <?php get_template_part('templates/single-service/hero'); ?>
    
    <?php get_template_part('templates/platforms/about'); ?>

    <?php if(have_rows('sections')): while(have_rows('sections')) : the_row(); ?>
    
        <?php get_template_part('templates/platform-detail/three-column'); ?>

        <?php get_template_part('templates/platform-detail/graphic'); ?>

        <?php get_template_part('templates/platform-detail/gray-text'); ?>

        <?php get_template_part('templates/platform-detail/tabbed-features'); ?>

        <?php get_template_part('templates/platform-detail/cta'); ?>

        <?php get_template_part('templates/platform-detail/quote'); ?>

        <?php get_template_part('templates/platform-detail/gallery'); ?>

        <?php get_template_part('templates/platform-detail/experts'); ?>

    <?php endwhile; endif; ?>

<?php get_footer(); ?>

