<?php get_header(); ?>

    <?php if ( have_posts() ): while ( have_posts() ): the_post(); ?>

        <article <?php post_class('grid'); ?>>

            <section class="article-header">
                <h1 class="title-headline"><?php the_title(); ?></h1>
            </section>

            <section class="article-body copy copy-2 extended">
                <?php the_content(); ?>
            </section>

        </article>

    <?php endwhile; endif; ?>

<?php get_footer(); ?>