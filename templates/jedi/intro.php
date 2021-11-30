<?php

    $intro = get_field('intro');
    $headline = $intro['headline'];
    $copy = $intro['copy'];
    $photo = $intro['photo'];
?>

<section class="page-header grid">
    <div class="headline">
        <h1 class="page-title"><?php echo $headline ?></h1>
    </div>

    <?php if( $photo ): ?>
        <div class="photo">
            <?php echo wp_get_attachment_image($photo['ID'], 'full'); ?>
        </div>
    <?php endif; ?>

    <div class="copy copy-1">
        <p><?php echo $copy; ?></p>
    </div>
    
</section>

