<?php 

/*

    Template Name: Join Us

*/

get_header(); ?>

    <?php
        $args = [ 'position' => 'top' ];
        get_template_part('templates/join-us/sub-nav', null, $args);
    ?>

    <?php get_template_part('templates/about/page-header'); ?>

    <?php get_template_part('templates/join-us/why-work-here'); ?>

    <?php get_template_part('templates/join-us/features'); ?>

    <?php get_template_part('templates/home/featured-project'); ?>

    <?php get_template_part('templates/home/employee-owner-spotlight'); ?>

    <?php
        $args = [ 'position' => 'bottom' ];
        get_template_part('templates/join-us/sub-nav', null, $args);
    ?>

<?php get_footer(); ?>