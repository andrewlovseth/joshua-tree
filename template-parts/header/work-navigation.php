<nav class="work-nav grid">

    <div class="markets">
        <div class="nav-section-header">
            <h3 class="nav-header">Markets</h3>
        </div>

        <div class="links">
            <?php if(have_rows('markets', 'options')): while(have_rows('markets', 'options')): the_row(); ?>
    
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

            <?php endwhile; endif; ?>
        </div>
    </div>

    <div class="services">
        <div class="nav-section-header">
            <h3 class="nav-header">Services</h3>
        </div>

        <div class="links">
            <?php if(have_rows('services', 'options')): while(have_rows('services', 'options')): the_row(); ?>
    
                <?php 
                    $link = get_sub_field('link');
                    if( $link ): 
                    $link_url = $link['url'];
                    $link_title = $link['title'];
                    $link_target = $link['target'] ? $link['target'] : '_self';

                    $stream_opts = [
                        "ssl" => [
                            "verify_peer"=>false,
                            "verify_peer_name"=>false,
                        ]
                    ];    
                

                    $icon = get_sub_field('icon');
                    if($icon) {
                        $svg = file_get_contents($icon['url'], false, stream_context_create($stream_opts));

                    }
                    
                ?>

                    <div class="link">
                        <a href="<?php echo esc_url($link_url); ?>" target="<?php echo esc_attr($link_target); ?>">
                            <?php if($icon): ?>
                                <span class="icon"><?php echo $svg; ?></span>
                            <?php else: ?>
                                <span class="icon empty"></span>
                            <?php endif; ?>
                            <span class="label"><?php echo esc_html($link_title); ?></span>
                        </a>
                    </div>

                <?php endif; ?>

            <?php endwhile; endif; ?>
        </div>



    </div>

    <div class="projects">
        <?php 
            $link = get_field('projects_link', 'options');
            if( $link ): 
            $link_url = $link['url'];
            $link_title = $link['title'];
            $link_target = $link['target'] ? $link['target'] : '_self';
        ?>

            <div class="cta">
                <a class="btn" href="<?php echo esc_url($link_url); ?>" target="<?php echo esc_attr($link_target); ?>"><?php echo esc_html($link_title); ?></a>
            </div>
                     
        <?php endif; ?>
    </div>

</nav>