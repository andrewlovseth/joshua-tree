<?php get_header(); ?>

    <?php
        $args = [ 'position' => 'top' ];
        get_template_part('templates/about/sub-nav', null, $args);
    ?>

    <?php get_template_part('templates/single-leadership/hero'); ?>

    <section class="profile grid">
        <?php get_template_part('templates/single-leadership/bio'); ?>

        <?php get_template_part('templates/single-leadership/sidebar'); ?>
    </section>

    <?php
        $args = [ 'position' => 'bottom' ];
        get_template_part('templates/about/sub-nav', null, $args);
    ?>

<?php get_footer(); ?>