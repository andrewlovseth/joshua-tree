<?php if(have_rows('rich_links')): ?>

    <div class="rich-links | grid">
        <div class="rich-links__grid">
            <?php while(have_rows('rich_links')): the_row(); ?>

                <?php
                    $headline = get_sub_field('headline');
                    $copy = get_sub_field('copy');
                    $link = get_sub_field('link');

                    if($link) {
                        $link_url = $link['url'];
                        $link_title = $link['title'];
                        $link_target = $link['target'] ? $link['target'] : '_self';
                    }
                ?>

                <div class="rich-links__item">
                    <a class="rich-links__link" href="<?php echo esc_url($link_url); ?>" target="<?php echo esc_attr($link_target); ?>">
                        <div class="rich-links__headline">
                            <h3 class="rich-links__title"><?php echo $headline; ?></h3>
                        </div>

                        <div class="rich-links__copy | copy copy-3">
                            <?php echo $copy; ?>
                        </div>

                        <div class="rich-links__cta">
                            <?php echo esc_html($link_title); ?>
                        </div>
                    </a>
                </div>

            <?php endwhile; ?>
        </div>



    </div>
    
<?php endif; ?>