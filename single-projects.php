<?php get_header(); ?>

    <?php get_template_part('templates/single-projects/hero'); ?>

    <?php get_template_part('templates/single-projects/overview'); ?>

    <section class="main grid">
        <?php get_template_part('templates/single-projects/about'); ?>

        <?php get_template_part('templates/single-projects/experts'); ?>
    </section>

    <?php get_template_part('templates/single-projects/testimonial'); ?>

    <?php get_template_part('templates/single-projects/details'); ?>

    <?php get_template_part('templates/single-projects/similar-projects'); ?>

    <?php get_template_part('template-parts/global/news-grid'); ?>

<?php get_footer(); ?>