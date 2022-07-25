<?php

    $hero = get_field('hero');
    $photo = $hero['photo'];
    $headline = $hero['headline'];

?>


<section class="hero project-hero grid">
    <?php if( $photo ): ?>
        <div class="photo">
            <?php echo wp_get_attachment_image($photo['ID'], 'full'); ?>
        </div>
    <?php endif; ?>    

    <div class="page-header">
        <h1 class="page-title">
            <?php if($headline): ?>
                <?php echo $headline; ?>
            <?php else: ?>
                <?php the_title(); ?>
            <?php endif; ?>            
        </h1>
    </div>
</section>