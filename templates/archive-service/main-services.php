<section class="main-services grid">
    <div class="service-list">

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
                <?php if($icon): ?>
                    <div class="link">
                        <a href="<?php echo esc_url($link_url); ?>" target="<?php echo esc_attr($link_target); ?>">
                            <span class="icon"><?php echo $svg; ?></span>
                            <span class="label"><?php echo esc_html($link_title); ?></span>
                        </a>
                    </div>
                <?php endif; ?>

            <?php endif; ?>

        <?php endwhile; endif; ?>

    </div>
</section>