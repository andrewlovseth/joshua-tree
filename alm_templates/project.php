<div class="project">
    <a href="<?php echo get_permalink(); ?>">
        <?php $image = get_field('hero_photo'); if( $image ): ?>
            <div class="photo">
                <div class="content">
                    <?php echo wp_get_attachment_image($image['ID'], 'full'); ?>
                </div>
            </div>
        <?php endif; ?>

        <div class="info">
            <div class="info__wrapper">
                <div class="market">
                    <?php $market = get_field('details_market'); ?>
                    <h4><?php echo get_the_title($market->ID); ?></h4>
                </div>

                <div class="headline">
                    <h3 class="title-headline small"><?php echo get_the_title(); ?></h3>
                </div>

                <div class="location">
                    <h4><?php the_field('details_location'); ?></h4>
                </div>
            </div>
        </div>                    
    </a>
</div>