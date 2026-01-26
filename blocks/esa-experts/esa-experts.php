<?php

/*
 * ESA Experts — simple team grid with circular photos
 */

$id = 'esa-experts-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

$className = 'esa-experts';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}
if( $is_preview ) {
    $className .= ' is-admin';
}

$header = get_field('header');
$experts = get_field('experts');

if($experts): ?>

    <section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?>">

        <?php if($header): ?>
            <div class="section-header">
                <h3 class="section-headline"><?php echo esc_html($header); ?></h3>
            </div>
        <?php endif; ?>

        <div class="esa-experts__grid">
            <?php foreach($experts as $expert): ?>
                <?php
                    $args = [ 'expert' => $expert ];
                    get_template_part('template-parts/global/expert', null, $args);
                ?>
            <?php endforeach; ?>
        </div>

    </section>

<?php endif; ?>
