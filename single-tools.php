<?php get_header(); ?>

    <?php while ( have_posts() ) : the_post(); ?>

        <?php get_template_part('templates/single-tools/hero'); ?>

        <?php get_template_part('templates/single-tools/tool-info'); ?>

        <?php get_template_part('templates/single-tools/render'); ?>

        <?php get_template_part('templates/single-tools/cta'); ?>

        <?php get_template_part('templates/single-tools/related'); ?>

    <?php endwhile; ?>

<?php get_footer(); ?>
