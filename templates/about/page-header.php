<?php

    $page_header = get_field('page_header');
    $headline = $page_header['headline'];
    $deck = $page_header['deck'];
    $copy = $page_header['copy'];
    $photo = $page_header['photo'];

?>

<section class="page-header grid">

    <?php if($headline): ?>
        <div class="headline">
            <h1 class="page-title"><?php echo $headline; ?></h1>
        </div>
    <?php else: ?>
        <div class="headline">
            <h1 class="page-title"><?php the_title(); ?></h1>
        </div>
    <?php endif; ?>

    <?php if($deck): ?>
        <div class="copy-1">
            <?php echo $deck; ?>
        </div>
    <?php endif; ?>

    <?php if($copy): ?>
        <div class="copy-2">
            <?php echo $copy; ?>
        </div>
    <?php endif; ?>
    
    <?php if( $photo ): ?>
        <div class="photo">
            <?php echo wp_get_attachment_image($photo['ID'], 'full'); ?>
        </div>
    <?php endif; ?>

</section>