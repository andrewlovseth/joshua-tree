<?php 

/*

    Template Name: Culture

*/

get_header(); ?>

    <?php
        $args = [ 'position' => 'top' ];
        get_template_part('templates/about/sub-nav', null, $args);
    ?>

    <?php get_template_part('templates/culture/page-header'); ?>

    <?php get_template_part('templates/culture/dei'); ?>

    <?php get_template_part('templates/culture/sustainability'); ?>

    <?php get_template_part('templates/culture/fun-traditions'); ?>

    <?php
        $args = [ 'position' => 'bottom' ];
        get_template_part('templates/about/sub-nav', null, $args);
    ?>

<?php get_footer(); ?>