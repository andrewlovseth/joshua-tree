<?php

    $plan = get_field('plan');
    $headline = $plan['headline'];
    $copy = $plan['copy'];
    $photo = $plan['photo'];
?>

<section class="plan">

    <div class="grid plan__content">
        <?php if( $photo ): ?>
            <div class="photo">
                <?php echo wp_get_attachment_image($photo['ID'], 'full'); ?>
            </div>
        <?php endif; ?>

        <div class="info">
            <div class="headline">
                <h2 class="section-headline"><?php echo $headline ?></h2>
            </div>

            <div class="copy copy-1 extended">
                <?php echo $copy; ?>
            </div>
        </div>
    </div>
</section>