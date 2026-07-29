<?php

    /**
     * Tool detail hero — mirrors templates/single-service/hero.php.
     * Reuses .hero.service-hero styling (available via the `single-service`
     * body class added in functions/tools.php).
     */

    $hero = get_field('hero');
    $photo = $hero ? $hero['photo'] : null;

?>

<section class="hero service-hero grid">
    <?php if( $photo ): ?>
        <div class="photo">
            <?php echo wp_get_attachment_image($photo['ID'], 'full'); ?>
        </div>
    <?php endif; ?>

    <div class="page-header">
        <h1 class="page-title"><?php the_title(); ?></h1>
    </div>
</section>
