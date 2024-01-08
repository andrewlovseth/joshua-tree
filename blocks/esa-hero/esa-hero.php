<?php

/*

    Block: ESA Hero

*/

// Create id attribute allowing for custom "anchor" value.
$id = 'esa-hero-' . $block['id'];

if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'esa-hero grid';

if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}
if( $is_preview ) {
    $className .= ' is-admin';
}

?>

<section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?>">
    <div class="featured-image">
        <?php the_post_thumbnail(); ?>
    </div>

    <div class="info">
        <h1 class="post-title"><?php the_title(); ?></h1>
    </div>
</section>
