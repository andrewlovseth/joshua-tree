<?php if(have_rows('site_nav', 'options')): ?>
    <nav class="mobile-nav">
        <div class="mobile-nav-wrapper">
            <div class="logo">
                <a href="<?php echo site_url('/'); ?>"><img src="<?php $image = get_field('logo_white', 'options'); echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" /></a>
            </div>
            
            <ul>
                <li class="link">
                    <a href="<?php echo site_url('/'); ?>">Home</a>
                </li>
                
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
        </div>
    </nav>
<?php endif; ?>
