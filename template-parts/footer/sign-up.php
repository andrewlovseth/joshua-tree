<?php

    $stay_in_touch = get_field('stay_in_touch', 'options');
    $headline = $stay_in_touch['headline'];
    $link = $stay_in_touch['cta'];

    if( have_rows('stay_in_touch', 'options') ): while ( have_rows('stay_in_touch', 'options') ) : the_row(); 
?>

    <section class="sign-up grid">
        <div class="sub-grid">

            <div class="headline">
                <h3><?php echo $headline; ?></h3>
            </div>

            <?php 
                if( $link ): 
                $link_url = $link['url'];
                $link_title = $link['title'];
                $link_target = $link['target'] ? $link['target'] : '_self';
            ?>

                <div class="cta">
                    <a href="<?php echo esc_url($link_url); ?>" target="<?php echo esc_attr($link_target); ?>"><?php echo esc_html($link_title); ?></a>
                </div>

            <?php endif; ?>

            <?php if(have_rows('social_links')): ?>
                <div class="social-links">

                    <?php while(have_rows('social_links')): the_row(); ?>    
                        <?php 
                            $link = get_sub_field('link');
                            $icon = get_sub_field('icon');
                            if( $link ): 
                            $link_url = $link['url'];
                            $link_title = $link['title'];
                            $link_target = $link['target'] ? $link['target'] : '_self';
                        ?>

                            <div class="link">
                                <a href="<?php echo esc_url($link_url); ?>" target="<?php echo esc_attr($link_target); ?>">
                                    <img src="<?php echo $icon['url']; ?>" alt="<?php echo esc_html($link_title); ?>" />
                                </a>
                            </div>

                        <?php endif; ?>
                    <?php endwhile; ?>
                </div>            

            <?php endif; ?>

        </div>
    </section>

<?php endwhile; endif; ?>