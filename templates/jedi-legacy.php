<?php

/*
    Template Name: JEDI Legacy
*/

get_header(); ?>

        <?php
            $args = [ 'position' => 'top' ];
            get_template_part('templates/about/sub-nav', null, $args);
        ?>

        <?php get_template_part('templates/jedi-legacy/intro'); ?>

        <?php get_template_part('templates/jedi-legacy/ongoing-education'); ?>

        <?php get_template_part('templates/jedi-legacy/scholarship'); ?>

        <?php get_template_part('templates/jedi-legacy/outreach-and-internship'); ?>

        <?php get_template_part('templates/jedi-legacy/statement'); ?>

        <?php get_template_part('template-parts/global/news-grid'); ?>

        <?php // get_template_part('templates/jedi-legacy/timeline'); ?>


        <?php
            $args = [ 'position' => 'bottom' ];
            get_template_part('templates/about/sub-nav', null, $args);
        ?>

<?php get_footer(); ?>