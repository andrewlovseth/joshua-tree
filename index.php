<?php get_header(); ?>

    <section class="page-header grid">
        <div class="headline">
            <h1 class="page-title">News & Ideas</h1>
        </div>
    </section>

    <section class="post-list grid">

        <?php if ( have_posts() ): while ( have_posts() ): the_post(); ?>

            <article <?php post_class(); ?>>

                <section class="article-header">
                    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                </section>
                
            </article>

        <?php endwhile; endif; ?>

    </section>


<?php get_footer(); ?>