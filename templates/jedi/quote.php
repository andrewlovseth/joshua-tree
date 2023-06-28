<?php

    $quote = get_field('quote');
    $copy = $quote['copy'];
    $photo = $quote['photo'];
    $source_name = $quote['source_name'];
    $source_title = $quote['source_title'];
?>

<section class="quote grid">
    <?php if( $photo ): ?>
        <div class="photo">
            <?php echo wp_get_attachment_image($photo['ID'], 'full'); ?>
        </div>
    <?php endif; ?>

    <div class="info">
        <div class="copy copy-1 extended">
            <?php echo $copy; ?>
        </div>

        <div class="source">
            <h4 class="source__name"><?php echo $source_name; ?></h4>
            <p class="source__title"><?php echo $source_title; ?></p>
        </div>
    </div>
</section>