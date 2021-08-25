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
                                $icon = get_sub_field('icon');
                                echo esa_svg($icon['url']);       
                            ?>
                        </span>
                    </div>

                    <div class="label">
                        <h3><?php the_sub_field('label'); ?></h3>
                    </div>
                </div>

                <div class="client-list">
                    <?php
                        $type = get_sub_field('label');
                        $args = array(
                            'post_type' => 'client',
                            'posts_per_page' => 100,
                            'orderby' => 'title',
                            'order' => 'ASC',
                            'meta_query' => array(
                                array(
                                    'key' => 'meta_type',
                                    'value' => $type
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