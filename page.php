<?php get_header(); ?>

    <section class="page-header grid">
        <div class="headline">
            <h1 class="page-title"><?php the_title(); ?></h1>
        </div>
    </section>

    <?php if ( have_posts() ): while ( have_posts() ): the_post(); ?>

        <article class="default-page grid">
            <div class="copy copy-2 extended">
                <?php the_content(); ?>
            </div>
        </article>

    <?php endwhile; endif; ?>

<?php get_footer(); ?>