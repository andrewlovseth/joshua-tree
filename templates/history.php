<?php 

/*

    Template Name: History

*/

get_header(); ?>

    <?php
        $args = [ 'position' => 'top' ];
        get_template_part('templates/about/sub-nav', null, $args);
    ?>

    <?php get_template_part('templates/history/page-header'); ?>

    <?php get_template_part('templates/history/timeline'); ?>

    <?php
        $args = [ 'position' => 'bottom' ];
        get_template_part('templates/about/sub-nav', null, $args);
    ?>

<?php get_footer(); ?>