<?php

    $leadership = get_page_by_path('about/leadership');

    $page_header = get_field('page_header', $leadership->ID);
    $photo = $page_header['photo'];

    if($page_header['headline']) {
        $headline = $page_header['headline'];
    } else {
        $headline = get_the_title();
    }
    
    $deck = $page_header['deck'];

?>

<section class="page-header grid">

    <?php if($headline): ?>
        <div class="headline">
            <h1 class="page-title"><?php echo $headline; ?></h1>
        </div>
    <?php endif; ?>

    <?php if($photo): ?>
        <div class="photo">
            <?php echo wp_get_attachment_image($photo['ID'], 'full'); ?>
        </div>
    <?php endif; ?>

    <?php if($deck): ?>
        <div class="copy copy-1 extended">
            <?php echo $deck; ?>
        </div>
    <?php endif; ?>
    
</section>