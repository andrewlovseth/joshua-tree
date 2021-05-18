<?php

    $sustainability = get_field('sustainability');
    $headline = $sustainability['headline'];
    $sub_headline = $sustainability['sub_headline'];
    $copy = $sustainability['copy'];
    $photo = $sustainability['photo']

?>

<section class="sustainability grid">

    <?php if($headline): ?>
        <div class="section-header">
            <h2 class="title-headline"><?php echo $headline; ?></h2>
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
    
    <?php if( $photo ): ?>
        <div class="photo">
            <?php echo wp_get_attachment_image($photo['ID'], 'full'); ?>
        </div>
    <?php endif; ?>
    
</section>