<section class="article-body grid">
    <div class="copy copy-2 extended">
        <?php the_content(); ?>
    </div>
    
    <div class="sidebar">
        <?php get_template_part('templates/single-post/authors'); ?>

        <?php get_template_part('templates/single-post/date'); ?>

        <?php get_template_part('templates/single-post/categories'); ?>

        <?php get_template_part('templates/single-post/share'); ?>
    </div>
</section>