<?php

$alt_hero = get_field('alt_hero');
$show = $alt_hero['show'];
$headline_color = $alt_hero['headline_color'];
$remove_drop_shadow = $alt_hero['remove_drop_shadow'];

$className = 'post-title';
if($show == TRUE && $remove_drop_shadow ) {
    $className .= ' no-shadow';
}

?>



<section class="article-header grid">
    <div class="featured-image">
        <?php the_post_thumbnail(); ?>
    </div>

    <div class="info">
        <h1 class="<?php echo esc_attr($className); ?>"<?php if($show == TRUE): ?> style="color: <?php echo $headline_color; ?>"<?php endif; ?>><?php the_title(); ?></h1>
    </div>
</section>