<?php 

/*

    Template Name: Leadership Sub Group

*/

get_header(); ?>
    <?php
        $args = [ 'position' => 'top' ];
        get_template_part('templates/about/sub-nav', null, $args);
    ?>

    <?php get_template_part('templates/leadership/page-header'); ?>

    <?php get_template_part('templates/leadership/sub-nav'); ?>

    <?php
        $args = ['executives' => false ];
        get_template_part('templates/leadership/leaders', null, $args);    
    ?>
    
    <?php get_template_part('templates/leadership/gallery'); ?>

    <?php
        $args = [ 'position' => 'bottom' ];
        get_template_part('templates/about/sub-nav', null, $args);
    ?>

<?php get_footer(); ?>