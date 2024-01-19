<?php if(have_rows('features')): ?>

<section class="features grid">

    <?php while(have_rows('features')): the_row(); ?>

        <div class="feature">
            <div class="photo">
                <?php $image = get_sub_field('photo'); if( $image ): ?>
                    <?php echo wp_get_attachment_image($image['ID'], 'full'); ?>
                <?php endif; ?>
            </div>
            <div class="info">
                <div class="headline">
                    <h3 class="section-headline small"><?php echo get_sub_field('headline'); ?></h3>
                </div>

                <div class="copy copy-2">
                    <?php echo get_sub_field('copy'); ?>
                </div>

                <?php
                    $link = get_sub_field('cta');
                    if( $link ): 
                    $link_url = $link['url'];
                    $link_title = $link['title'];
                    $link_target = $link['target'] ? $link['target'] : '_self';
                ?>
                    <div class="cta">
                        <a class="btn btn-green" href="<?php echo esc_url($link_url); ?>" target="<?php echo esc_attr($link_target); ?>"><?php echo esc_html($link_title); ?></a>
                    </div>
                <?php endif; ?>
            </div>

        </div>


    <?php endwhile; ?>

    </div>
</section>

<?php endif; ?>