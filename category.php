<?php get_header(); ?>

    <section class="page-header grid">
        <h4 class="sub-head">News & Ideas</h4>
        <h1 class="page-title"><?php single_cat_title(); ?></h1>
    </section>

    <?php get_template_part('templates/news/posts'); ?>

<?php get_footer(); ?>