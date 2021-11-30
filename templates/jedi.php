<?php

/*
    Template Name: JEDI
*/

get_header(); ?>

    <main class="esa-content">

        <?php get_template_part('templates/jedi/intro'); ?>

        <?php get_template_part('templates/jedi/scholarship'); ?>

        <?php get_template_part('templates/jedi/outreach-and-internship'); ?>

        <?php get_template_part('template-parts/global/news-grid'); ?>

        <?php get_template_part('templates/jedi/timeline'); ?>

    </main>

<?php get_footer(); ?>