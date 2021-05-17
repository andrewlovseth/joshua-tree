<?php

    $page_header = get_field('page_header');
    $headline = $page_header['headline'];
    $deck = $page_header['deck'];

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
    
</section>