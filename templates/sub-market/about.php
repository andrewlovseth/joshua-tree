<?php

    $about = get_field('about');
    $title = $about['title'];
    $sub_title = $about['sub_title'];
    $photo = $about['photo'];
    $copy = $about['copy'];

?>

<section class="sub-market-about grid">
    <div class="sub-market-about__breadcrumbs">
        <a href="<?php echo get_permalink($post->post_parent); ?>"><?php echo get_the_title($post->post_parent); ?></a> <span>»</span>  <a href="<?php echo get_permalink($post->id); ?>"><?php echo get_the_title($post->id); ?></a>

    </div>

    <h1 class="sub-market-about__title | page-title"><?php echo $title; ?></h1>

    <h2 class="sub-market-about__sub-title | title-headline small"><?php echo $sub_title; ?></h2>

    <div class="sub-market-about__photo">
        <?php echo wp_get_attachment_image($photo['ID'], 'full'); ?>
    </div>

    <div class="sub-market-about__copy | copy copy-1 extended">
        <?php echo $copy; ?>
    </div>
</section>