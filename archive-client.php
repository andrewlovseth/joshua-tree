<?php get_header(); ?>

<section class="page-header grid">
    <h1 class="page-title">Clients</h1>
</section>




<?php if(have_rows('client_sections', 'options')): ?>

    <section class="jump-links grid">

        <nav class="clients-nav">

            <span class="header">Jump to:</span>

            <?php while(have_rows('client_sections', 'options')) : the_row(); ?>

                <div class="link">
                    <a href="#<?php echo sanitize_title_with_dashes(get_sub_field('label')); ?>" class="smooth"><?php the_sub_field('label'); ?></a>
                </div>

            <?php endwhile; ?>

        </nav>


    </section>




    
    
    <?php while(have_rows('client_sections', 'options')) : the_row(); ?>

        <?php if( get_row_layout() == 'section' ): ?>

            <section class="region grid" id="<?php echo sanitize_title_with_dashes(get_sub_field('label')); ?>">
                <div class="section-header">
                    <div class="icon">
                        <span class="svg">
                            <?php 
                                $stream_opts = [
                                    "ssl" => [
                                        "verify_peer"=>false,
                                        "verify_peer_name"=>false,
                                    ]
                                ];
                                $icon = get_sub_field('icon');
                                if($icon) {
                                    $svg = file_get_contents($icon['url'], false, stream_context_create($stream_opts));
                                    echo $svg;
                                }
                            ?>
                        </span>
                    </div>

                    <div class="label">
                        <h3><?php the_sub_field('label'); ?></h3>
                    </div>
                </div>

                <div class="client-list">
                    <?php
                        $region = get_sub_field('region');
                        $args = array(
                            'post_type' => 'client',
                            'posts_per_page' => 100,
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'region',
                                    'field'    => 'slug',
                                    'terms'    => $region->slug,
                                ),
                            ),
                        );
                        $query = new WP_Query( $args );
                        if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post(); ?>

                        <div class="link">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </div>

                    <?php endwhile; endif; wp_reset_postdata(); ?>
                </div>			
            </section>

        <?php endif; ?>
    
    <?php endwhile; ?>

<?php endif; ?>

<?php get_footer(); ?>