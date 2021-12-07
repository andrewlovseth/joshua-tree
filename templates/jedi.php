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

        <?php get_template_part('templates/jedi/ongoing-education'); ?>

        <?php get_template_part('templates/jedi/scholarship'); ?>

        <?php get_template_part('templates/jedi/outreach-and-internship'); ?>

        <?php get_template_part('templates/jedi/statement'); ?>

        <?php get_template_part('template-parts/global/news-grid'); ?>

        <?php // get_template_part('templates/jedi/timeline'); ?>


        <?php
            $args = [ 'position' => 'bottom' ];
            get_template_part('templates/about/sub-nav', null, $args);
        ?>

<?php get_footer(); ?>