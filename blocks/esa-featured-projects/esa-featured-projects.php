<?php

/*

    Block: ESA Hero

*/

// Create id attribute allowing for custom "anchor" value.
$id = 'esa-featured-projects-' . $block['id'];

if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'esa-featured-projects more-projects grid';

if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}
if( $is_preview ) {
    $className .= ' is-admin';
}

$featured_projects = get_field('featured_projects');
$featured_projects_display = get_field('featured_projects_display');
if($featured_projects):

?>

    <section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?>">
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