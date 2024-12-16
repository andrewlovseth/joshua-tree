<?php get_header(); ?>

    <?php if(is_category('employee-owner-spotlight')): ?>
        <?php
            $args = [ 'position' => 'top' ];
            get_template_part('templates/about/sub-nav', null, $args);
        ?>
    <?php endif; ?>

    <section class="page-header grid">
        <h4 class="sub-head"><a href="<?php echo get_permalink(get_option('page_for_posts')); ?>">News & Ideas</a></h4>
        <h1 class="page-title"><?php single_cat_title(); ?></h1>

        <?php get_template_part('templates/news/cat-nav'); ?>
    </section>

    <?php get_template_part('templates/news/posts'); ?>


    <?php if(is_category('employee-owner-spotlight')): ?>
        <?php
            $args = [ 'position' => 'bottom' ];
            get_template_part('templates/about/sub-nav', null, $args);
        ?>
    <?php endif; ?>

<?php get_footer(); ?>