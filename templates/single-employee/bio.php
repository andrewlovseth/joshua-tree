<?php

    $info = get_field('info');
    $photo = $info['hero_photo'];

    $bio = get_field('biography');
    $short_bio = $bio['short_bio'];
    $long_bio = $bio['long_bio'];

?>

<article class="biography">

    <?php if( $photo ): ?>
        <div class="photo">
            <?php echo wp_get_attachment_image($photo['ID'], 'full'); ?>
        </div>
    <?php endif; ?>

    <?php if( $short_bio ): ?>
        <div class="short-bio copy-1">
            <?php echo $short_bio; ?>
        </div>
    <?php endif; ?>

    <?php if( $long_bio ): ?>
        <div class="long-bio copy-2 extended">
            <?php echo $long_bio; ?>
        </div>
    <?php endif; ?>

    <div class="back">
        <div class="cta">
            <a href="<?php echo site_url('/about/employee-owner-spotlight/'); ?>" class="btn btn-green">Employee-Owner Spotlight</a>
        </div>
    </div>

</article>