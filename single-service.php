<?php get_header(); ?>

    <?php get_template_part('templates/single-service/hero'); ?>

    <?php get_template_part('templates/single-service/service-info'); ?>

    <?php get_template_part('templates/single-service/featured-projects'); ?>

    <?php
        /*
            Tools & Resources module — HELD BACK from the front end.

            The module and the Tools CPT shipped ahead of the content being
            ready, so it rendered placeholder mock cards on every service page.
            Restore this line (and drop esa_tools_hide_from_front_end() in
            functions/tools.php) once the real tool inventory is attached.
        */
        // get_template_part('templates/single-service/tools');
    ?>

    <?php get_template_part('template-parts/global/news-grid'); ?>

<?php get_footer(); ?>