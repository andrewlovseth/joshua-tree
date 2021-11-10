<?php get_header(); ?>

    <section class="page-header grid">
        <h1 class="page-title">News & Ideas</h1>

        <?php if(is_paged()): ?>
            <?php $paged = (get_query_var('paged')) ? get_query_var('paged') : 1; ?>
            <div class="page-count">
                <h4>Page <?php echo $paged; ?></h4>
            </div>
        <?php endif; ?>
    </section>


    <?php if ( !is_paged() ): ?>
        <?php get_template_part('templates/news/featured-posts'); ?>
    <?php endif; ?>

    <?php get_template_part('templates/news/posts'); ?>

<?php get_footer(); ?>