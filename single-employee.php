<?php get_header(); ?>

    <?php
        $args = [ 'position' => 'top' ];
        get_template_part('templates/about/sub-nav', null, $args);
    ?>

    <?php get_template_part('templates/single-employee/hero'); ?>

    <section class="profile grid">
        <?php get_template_part('templates/single-employee/bio'); ?>

        <?php get_template_part('templates/single-employee/sidebar'); ?>
    </section>

    <?php get_template_part('template-parts/global/news-grid-employee'); ?>

    <?php
        $args = [ 'position' => 'bottom' ];
        get_template_part('templates/about/sub-nav', null, $args);
    ?>

<?php get_footer(); ?>