<?php 

/*

    Template Name: Employee Owner Spotlight

*/

get_header(); ?>

    <?php
        $args = [ 'position' => 'top' ];
        get_template_part('templates/about/sub-nav', null, $args);
    ?>

    <?php get_template_part('templates/employee-owner-spotlight/page-header'); ?>

    <?php get_template_part('templates/employee-owner-spotlight/featured-owners'); ?>

    <?php get_template_part('templates/employee-owner-spotlight/more-owners'); ?>

    <?php
        $args = [ 'position' => 'bottom' ];
        get_template_part('templates/about/sub-nav', null, $args);
    ?>

<?php get_footer(); ?>