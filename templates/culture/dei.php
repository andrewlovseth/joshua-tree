<?php

    $dei = get_field('dei');
    $headline = $dei['headline'];
    $sub_headline = $dei['sub_headline'];
    $copy = $dei['copy'];
    $photo = $dei['photo']

?>

<section class="dei grid">

    <?php if($headline): ?>
        <div class="section-header">
            <h2 class="title-headline"><?php echo $headline; ?></h2>
        </div>
    <?php endif; ?>

    <?php if( $photo ): ?>
        <div class="photo">
            <?php echo wp_get_attachment_image($photo['ID'], 'full'); ?>

            <?php if($photo['caption']): ?>
                <div class="caption">
                    <p><?php echo $photo['caption']; ?></p>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <?php if($copy): ?>
        <div class="info copy-2 extended">
            <?php if($sub_headline): ?>
                <strong class="copy-headline"><?php echo $sub_headline; ?></strong>
            <?php endif; ?>

            <?php echo $copy; ?>
        </div>
    <?php endif; ?>
    

    
</section>