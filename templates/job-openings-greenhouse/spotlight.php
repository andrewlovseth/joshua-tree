<?php if(have_rows('spotlight')): ?>

    <div class="spotlight">

        <?php while(have_rows('spotlight')): the_row(); ?>

            <?php
                $photo = get_sub_field('photo');
                $link = get_sub_field('link');

                if($link) {
                    $link_url = $link['url'];
                    $link_title = $link['title'];
                    $link_target = $link['target'] ? $link['target'] : '_self';
                }
            ?>

            <div class="spotlight__item">
         		<a class="spotlight__link" href="<?php echo esc_url($link_url); ?>" target="<?php echo esc_attr($link_target); ?>">
                    <div class="spotlight__photo">
                        <?php echo wp_get_attachment_image($photo['ID'], 'full'); ?>
                    </div>

                    <div class="spotlight__caption">
                        <?php echo esc_html($link_title); ?>
                    </div>
                </a>
            </div>

        <?php endwhile; ?>

    </div>
    
<?php endif; ?>