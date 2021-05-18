<?php

    $page_header = get_field('page_header');
    $headline = $page_header['headline'];

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
    
</section>