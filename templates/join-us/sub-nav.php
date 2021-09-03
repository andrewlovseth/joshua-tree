<?php 
    $args = wp_parse_args($args);

    if(!empty($args)) {
        $position = $args['position'];
    }
    $join_us = get_page_by_path('join-us');
    if(have_rows('sub_nav', $join_us->ID)):

?>
    <nav class="sub-nav grid join-us-sub-nav <?php echo $position; ?>">
        <ul>
            <?php while(have_rows('sub_nav', $join_us->ID)) : the_row(); ?>

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

            <?php endwhile; ?> 
        </ul>
    </nav>
<?php endif; ?>
