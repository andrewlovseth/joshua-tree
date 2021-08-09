<?php $services = get_field('services', 'options'); if( $services ): ?>
    <?php foreach( $services as $service ): ?>

        <section class="service grid" id="<?php echo $service->post_name; ?>">

            <?php
                $icon = get_field('meta_icon', $service->ID);
                if($icon) {
                    $svg = esa_svg($icon['url']);
                }
            ?>

            <div class="header">
                <h3 class="title-headline small">
                    <?php if($icon): ?>
                        <span class="icon"><?php echo $svg; ?></span>
                    <?php endif; ?>
                    <span class="label"><?php echo get_the_title($service->ID); ?></span>
                </h3>
            </div>

            <div class="sub-services">
                <?php
                $args = array(
                    'post_type' => 'service',
                    'posts_per_page' => 50,
                    'post_parent' => $service->ID,
                    'orderby' => 'title',
                    'order' => 'ASC'
                );
                $query = new WP_Query( $args );
                if ( $query->have_posts() ) : ?>
                    <ul>
                        <?php while ( $query->have_posts() ) : $query->the_post(); ?>
                            <li>
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                <?php endif; wp_reset_postdata(); ?>
                
            </div>

        </section>
    <?php endforeach; ?>

<?php endif; ?>