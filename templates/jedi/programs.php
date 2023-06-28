<?php

    $headline = get_field('programs_headline');
?>

<section class="programs grid">
    <div class="headline programs__headline">
        <h3 class="section-headline"><?php echo $headline; ?></h3>
    </div>

    <div class="programs__grid">
        <?php if(have_rows('programs')): while(have_rows('programs')): the_row(); ?>
            <?php
                $photo = get_sub_field('graphic');
                $link = get_sub_field('link');

                if( $link ) {
                    $link_url = $link['url'];
                    $link_title = $link['title'];
                    $link_target = $link['target'] ? $link['target'] : '_self';
                }
            ?>

            <div class="programs__item">
                <div class="programs__photo">
                    <a href="<?php echo esc_url($link_url); ?>" target="<?php echo esc_attr($link_target); ?>">
                        <?php echo wp_get_attachment_image($photo['ID'], 'full'); ?>
                    </a>
                </div>

                <div class="programs__info">
                    <h4 class="programs__link">
                        <a href="<?php echo esc_url($link_url); ?>" target="<?php echo esc_attr($link_target); ?>"><?php echo esc_html($link_title); ?></a>
                    </h4>
                </div>
            </div>
        <?php endwhile; endif; ?>
    </div>




</section>