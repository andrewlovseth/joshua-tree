<?php if(have_rows('site_nav', 'options')): ?>
    <nav class="site-nav">
        <ul>
            <?php while(have_rows('site_nav', 'options')) : the_row(); ?>
                <?php if( get_row_layout() == 'basic_link' ): ?>

                    <?php 
                        $link = get_sub_field('link');
                        if( $link ): 
                        $link_url = $link['url'];
                        $link_title = $link['title'];
                        $link_target = $link['target'] ? $link['target'] : '_self';
                    ?>

                        <li class="link">
                            <a href="<?php echo esc_url($link_url); ?>" target="<?php echo esc_attr($link_target); ?>"><?php echo esc_html($link_title); ?></a>
                        </li>
                    
                    <?php endif; ?>

                <?php endif; ?>
            <?php endwhile; ?> 
        </ul>
    </nav>
<?php endif; ?>
