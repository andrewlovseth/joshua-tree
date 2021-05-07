<?php

    $utilities = get_field('utilities', 'options');
    $copyright = $utilities['copyright'];
    $ownership_statement = $utilities['ownership_statement'];


    if( have_rows('utilities', 'options') ): while ( have_rows('utilities', 'options') ) : the_row(); 
?>

    <div class="utilities sub-grid">

        <div class="copyright">
            <div class="copy">
                <p><?php echo $copyright; ?></p>
            </div>

            <?php if(have_rows('links')): ?>

                <div class="links">                
                    <?php while(have_rows('links')): the_row(); ?>
        
                        <?php 
                            $link = get_sub_field('link');
                            if( $link ): 
                            $link_url = $link['url'];
                            $link_title = $link['title'];
                            $link_target = $link['target'] ? $link['target'] : '_self';
                        ?>

                            <div class="link">
                                <a href="<?php echo esc_url($link_url); ?>" target="<?php echo esc_attr($link_target); ?>"><?php echo esc_html($link_title); ?></a>
                            </div>

                        <?php endif; ?>

                    <?php endwhile; ?>
                </div>

            <?php endif; ?>
        </div>

        <div class="ownership copy">
            <?php echo $ownership_statement; ?>
        </div>
    </div>

<?php endwhile; endif; ?>