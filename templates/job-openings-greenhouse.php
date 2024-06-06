<?php 

/*

    Template Name: Job Openings (Greenhouse)

*/

get_header(); ?>

    <?php
        $args = [ 'position' => 'top' ];
        get_template_part('templates/join-us/sub-nav', null, $args);
    ?>

    <?php get_template_part('templates/job-openings-greenhouse/page-header'); ?>

    <?php get_template_part('templates/job-openings-greenhouse/info'); ?>
    
    <?php get_template_part('templates/job-openings-greenhouse/greenhouse'); ?>

    <?php
        $args = [ 'position' => 'bottom' ];
        get_template_part('templates/join-us/sub-nav', null, $args);
    ?>

<?php get_footer(); ?>