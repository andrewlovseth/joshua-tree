<?php

    $featured_projects = get_field('featured_projects');
    $featured_projects_display = get_field('featured_projects_display');
    if($featured_projects):

?>

    <section class="more-projects grid">
        <div class="section-header<?php if($featured_projects_display === 'grid'): ?> section-header__grid<?php endif; ?>">
            <h3 class="section-headline small">Featured Projects</h3>
        </div>

        <?php if($featured_projects_display === 'grid'): ?>

            <?php get_template_part('templates/single-service/grid'); ?>

        <?php else: ?>
            
            <?php get_template_part('templates/single-service/slider'); ?>

        <?php endif; ?>

    </section>

<?php endif; ?>