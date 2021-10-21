<?php get_header(); ?>

    <?php if ( have_posts() ): while ( have_posts() ): the_post(); ?>

        <article <?php post_class(); ?>>

            <?php get_template_part('templates/single-post/article-header'); ?>

            <?php get_template_part('templates/single-post/article-body'); ?>

            <?php get_template_part('templates/single-post/article-footer'); ?>

        </article>

    <?php endwhile; endif; ?>

<?php get_footer(); ?>