<?php

    $sub_market = get_field('sub_market');
    $parent_market = $sub_market['parent_market'];

?>

<section class="page-header grid">
    <?php if(get_field('is_sub_market') == TRUE): ?>
        <?php if($parent_market): ?>
            <div class="parent-market copy-3">
                <a href="<?php echo get_permalink($parent_market->ID); ?>"><?php echo get_the_title($parent_market->ID); ?></a>
            </div>
        <?php endif; ?>
    <?php endif; ?>
    <h1 class="page-title"><?php the_title(); ?></h1>

    <div class="copy-1">
        <?php the_field('intro'); ?>
    </div>
</section>