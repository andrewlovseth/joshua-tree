<?php if(have_rows('mobile_nav', 'options')): ?>
    <nav class="mobile-nav">
        <div class="mobile-nav-wrapper">
            <div class="logo">
                <a href="<?php echo site_url('/'); ?>"><img src="<?php $image = get_field('logo', 'options'); echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" /></a>
            </div>
            
            <ul class="main-links">
                <?php while(have_rows('mobile_nav', 'options')) : the_row(); ?>
                    <?php if( get_row_layout() == 'basic_link' ): ?>

                        <?php 
                            $link = get_sub_field('link');
                            if( $link ): 
                            $link_url = $link['url'];
                            $link_title = $link['title'];
                            $link_target = $link['target'] ? $link['target'] : '_self';
                        ?>

                            <li class="link main-link">
                                <a href="<?php echo esc_url($link_url); ?>" target="<?php echo esc_attr($link_target); ?>"><?php echo esc_html($link_title); ?></a>
                            </li>
                        
                        <?php endif; ?>

                    <?php endif; ?>

                    <?php if( get_row_layout() == 'dropdown' ): ?>

                        <?php 
                            $section_header = get_sub_field('section_header');
                        ?>

                        <li class="link main-link dropdown">
                            <a href="#<?php echo sanitize_title_with_dashes($section_header); ?>-subnav" class="section-header">
                                <?php echo $section_header; ?>
                                <span class="arrow"><img src="<?php bloginfo('template_directory'); ?>/images/down-arrow.svg" alt="Down Arrow" /></span>
                            </a>

                            <ul id="<?php echo sanitize_title_with_dashes($section_header); ?>-subnav" class="sub-links">
                                <?php if(have_rows('links')): while(have_rows('links')) : the_row(); ?>

                                    <?php if( get_row_layout() == 'basic_link' ): ?>

                                        <?php 
                                            $link = get_sub_field('link');
                                            if( $link ): 
                                            $link_url = $link['url'];
                                            $link_title = $link['title'];
                                            $link_target = $link['target'] ? $link['target'] : '_self';
                                        ?>

                                            <li class="link sub-link">
                                                <a href="<?php echo esc_url($link_url); ?>" target="<?php echo esc_attr($link_target); ?>"><?php echo esc_html($link_title); ?></a>
                                            </li>

                                        <?php endif; ?>

                                    <?php endif; ?>

                                    <?php if( get_row_layout() == 'divider' ): ?>
                                        <div class="divider">
                                            <div class="divider-object"></div>                                    
                                        </div>
                                    <?php endif; ?>

                                <?php endwhile; endif; ?>
                            </ul>
                        </li>                       

                    <?php endif; ?>

                <?php endwhile; ?> 
            </ul>
        </div>
    </nav>
<?php endif; ?>
