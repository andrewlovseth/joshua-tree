<section class="featured-owners grid">

    <?php $owners = get_field('featured_owners'); if( $owners ): ?>
        <?php foreach( $owners as $owner ): ?>
            <div class="owner">
                <div class="photo">
                    <a href="<?php echo get_permalink($owner->ID); ?>" class="photo-link">
                        <?php $image = get_field('info_photo', $owner->ID); if( $image ): ?>
                            <?php echo wp_get_attachment_image($image['ID'], 'large'); ?>
                        <?php endif; ?>
                    </a>

                    <div class="headline name">
                        <h3 class="title-headline"><a href="<?php echo get_permalink($owner->ID); ?>"><?php echo get_the_title($owner->ID); ?></a></h3>
                    </div>
                </div>

                <div class="info">
                    <?php if(get_field('biography_short_bio', $owner->ID)): ?>
                        <div class="copy-2">
                            <?php the_field('biography_short_bio', $owner->ID); ?>
                        </div>
                    <?php endif; ?>

                    <div class="cta">
                        <a href="<?php echo get_permalink($owner->ID); ?>" class="btn btn-white-green">More</a>
                    </div>
                
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
    
</section>