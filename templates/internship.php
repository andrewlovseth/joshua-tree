<?php 

/*

    Template Name: Internship

*/

get_header(); ?>

    <?php
        $args = [ 'position' => 'top' ];
        get_template_part('templates/join-us/sub-nav', null, $args);
    ?>

    <?php get_template_part('templates/internship/page-header'); ?>

    <?php get_template_part('templates/internship/what-to-expect'); ?>
    
    <?php get_template_part('templates/internship/how-to-apply'); ?>

    <?php
        $args = [ 'position' => 'bottom' ];
        get_template_part('templates/join-us/sub-nav', null, $args);
    ?>

<?php get_footer(); ?>