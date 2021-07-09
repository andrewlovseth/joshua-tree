<?php

    $hero = get_field('hero');
    $photo = $hero['photo'];

?>

<section class="hero service-hero grid">
    <div class="photo">
        <div class="content">
            <?php echo wp_get_attachment_image($photo['ID'], 'full'); ?>
        </div>
    </div>

    <div class="page-header">
        <h1 class="page-title"><?php the_title(); ?></h1>
    </div>
</section>