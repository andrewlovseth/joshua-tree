<?php

    $testimonial = get_field('testimonial');
    $photo = $testimonial['photo'];
    $quote = $testimonial['quote'];
    $source = $testimonial['source'];

?>

<section class="testimonial">

    <?php if($photo): ?>
        <div class="testimonial__photo">
            <?php echo wp_get_attachment_image($photo['ID'], 'full'); ?>
        </div>
    <?php endif; ?>

    <div class="testimonial__quote">
        <div class="testimonial__quote-wrapper">
            <div class="testimonial__text">
                <?php echo $quote; ?>
            </div>

            <div class="testimonial__source">
                <span><?php echo $source; ?></span>
            </div>       
        </div>     
    </div>
    
</section>