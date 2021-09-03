<?php 

/*

    Template Name: Benefits

*/

get_header(); ?>

    <?php
        $args = [ 'position' => 'top' ];
        get_template_part('templates/join-us/sub-nav', null, $args);
    ?>

    <?php get_template_part('templates/about/page-header'); ?>

    <?php get_template_part('templates/benefits/details'); ?>

    <?php get_template_part('templates/benefits/features'); ?>

    <?php
        $args = [ 'position' => 'bottom' ];
        get_template_part('templates/join-us/sub-nav', null, $args);
    ?>

<?php get_footer(); ?>