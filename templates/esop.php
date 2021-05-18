<?php 

/*

    Template Name: ESOP

*/

get_header(); ?>

    <?php
        $args = [ 'position' => 'top' ];
        get_template_part('templates/about/sub-nav', null, $args);
    ?>

    <?php get_template_part('templates/esop/page-header'); ?>

    <?php get_template_part('templates/esop/features'); ?>

    <?php get_template_part('templates/esop/whats-an-esop'); ?>

    <?php get_template_part('templates/esop/benefits'); ?>

    <?php
        $args = [ 'position' => 'bottom' ];
        get_template_part('templates/about/sub-nav', null, $args);
    ?>

<?php get_footer(); ?>