<?php

/*
    Template Name: JEDI
*/

get_header(); ?>

        <?php
            $args = [ 'position' => 'top' ];
            get_template_part('templates/about/sub-nav', null, $args);
        ?>

        <?php get_template_part('templates/jedi/intro'); ?>

        <?php get_template_part('templates/jedi/plan'); ?>
        
        <?php get_template_part('templates/jedi/gallery'); ?>

        <?php get_template_part('templates/jedi/looks-like'); ?>

        <?php get_template_part('templates/jedi/quote'); ?>

        <?php get_template_part('templates/jedi/programs'); ?>
        
        <?php
            $args = [ 'position' => 'bottom' ];
            get_template_part('templates/about/sub-nav', null, $args);
        ?>

<?php get_footer(); ?>