<?php 

/*

    Template Name: About

*/

get_header(); ?>

    <?php
        $args = [ 'position' => 'top' ];
        get_template_part('templates/about/sub-nav', null, $args);
    ?>

    <?php get_template_part('templates/about/page-header'); ?>

    <?php get_template_part('templates/about/history'); ?>

    <?php get_template_part('templates/about/values'); ?>

    <?php
        $args = [ 'position' => 'bottom' ];
        get_template_part('templates/about/sub-nav', null, $args);
    ?>

<?php get_footer(); ?>