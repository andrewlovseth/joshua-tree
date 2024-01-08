<?php 

/*

    Template Name: Landing Page

*/

get_header(); ?>

    <div class="page-wrapper grid copy copy-2 extended">

        <?php if ( have_posts() ): while ( have_posts() ): the_post(); ?>
        
            <?php the_content(); ?>

        <?php endwhile; endif; ?>

    </div>

<?php get_footer(); ?>