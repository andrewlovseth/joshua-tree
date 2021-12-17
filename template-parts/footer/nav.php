<nav class="footer-nav">

    <?php if(have_rows('footer_nav', 'options')): while(have_rows('footer_nav', 'options')) : the_row(); ?>

        <?php if( get_row_layout() == 'column' ): ?>

            <div class="column">

                <?php if(have_rows('content')): while(have_rows('content')) : the_row(); ?>

                    <?php if( get_row_layout() == 'logo' ): ?>
                        <?php 
                            $image = get_sub_field('image');
                        ?>

                        <div class="footer-logo">
                            <a href="<?php echo site_url('/'); ?>">
                                <?php echo wp_get_attachment_image($image['ID'], 'full'); ?>
                            </a>
                        </div>

                    <?php endif; ?>

                    <?php if( get_row_layout() == 'link_group' ): ?>

                        <div class="link-group">
                            <div class="header-link">
                                <?php 
                                    $link = get_sub_field('header_link');
                                    if( $link ): 
                                    $link_url = $link['url'];
                                    $link_title = $link['title'];
                                    $link_target = $link['target'] ? $link['target'] : '_self';
                                ?>

                                    <div class="link">
                                        <a href="<?php echo esc_url($link_url); ?>" target="<?php echo esc_attr($link_target); ?>"><?php echo esc_html($link_title); ?></a>
                                    </div>

                                <?php endif; ?>
                            </div>

                            <div class="sub-links">
                                <?php if(have_rows('sub_links')): while(have_rows('sub_links')): the_row(); ?>
    
                                    <div class="link">
                                        <?php 
                                            $link = get_sub_field('link');
                                            if( $link ): 
                                            $link_url = $link['url'];
                                            $link_title = $link['title'];
                                            $link_target = $link['target'] ? $link['target'] : '_self';
                                        ?>

                                            <div class="sub-link">
                                                <a href="<?php echo esc_url($link_url); ?>" target="<?php echo esc_attr($link_target); ?>"><?php echo esc_html($link_title); ?></a>
                                            </div>

                                        <?php endif; ?>
                                    </div>

                                <?php endwhile; endif; ?>
                            </div>
                        </div>

                    <?php endif; ?> 

                <?php endwhile; endif; ?>

            </div>

        <?php endif; ?>

    <?php endwhile; endif; ?>

</nav>