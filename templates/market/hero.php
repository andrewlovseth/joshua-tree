<?php

    $hero = get_field('hero');
    $page_title = $hero['page_title'];
    $photo = $hero['photo'];

?>

<section class="market-hero grid">
    <div class="market-hero__info">
        <h1 class="market-hero__title | page-title"><?php echo $page_title; ?></h1>
    </div>

    <div class="market-hero__photo">
        <?php echo wp_get_attachment_image($photo['ID'], 'full'); ?>
    </div>
</section>