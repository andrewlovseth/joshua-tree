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

        <?php $services = get_field('services', 'options'); if( $services ): ?>
            <div class="links">
                <?php foreach( $services as $service ): ?>
                    <?php
                        $icon = get_field('meta_icon', $service->ID);
                        if($icon) {
                            $svg = esa_svg($icon['url']);
                        }
                    ?>
                    <div class="link">
                        <a href="<?php echo get_permalink($service->ID); ?>">
                            <?php if($icon): ?>
                                <span class="icon"><?php echo $svg; ?></span>
                            <?php else: ?>
                                <span class="icon empty"></span>
                            <?php endif; ?>
                            <span class="label"><?php echo get_the_title($service->ID); ?></span>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
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


    <div class="clients">
        <?php 
            $link = get_field('clients_link', 'options');
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