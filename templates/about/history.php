<?php

    $history = get_field('history');
    $headline = $history['headline'];
    $deck = $history['deck'];
    $photo = $history['photo'];
    $caption = $history['caption'];

?>

<section class="history grid">

    <?php if($headline): ?>
        <div class="headline">
            <h2 class="section-headline"><?php echo $headline; ?></h2>
        </div>
    <?php endif; ?>

    <?php if($deck): ?>
        <div class="copy-2 deck">
            <?php echo $deck; ?>
        </div>
    <?php endif; ?>
    
    <?php if( $photo ): ?>
        <div class="photo">
            <?php echo wp_get_attachment_image($photo['ID'], 'full'); ?>
        </div>
    <?php endif; ?>

    <?php if($caption): ?>
        <div class="copy-2 caption">
            <?php echo $caption; ?>
        </div>
    <?php endif; ?>
</section>