<?php

    $photo_band = get_field('photo_band');
    if( !$photo_band ) return;

    $photo_left = $photo_band['photo_left'];
    $photo_right = $photo_band['photo_right'];

    if( !$photo_left && !$photo_right ) return;

?>

<section class="et-photo-band grid">
    <div class="et-photo-band__container">
        <?php if( $photo_left ): ?>
            <div class="et-photo-band-item">
                <?php echo wp_get_attachment_image($photo_left['ID'], 'large'); ?>
            </div>
        <?php endif; ?>
        <?php if( $photo_right ): ?>
            <div class="et-photo-band-item">
                <?php echo wp_get_attachment_image($photo_right['ID'], 'large'); ?>
            </div>
        <?php endif; ?>
    </div>
</section>
