<?php get_header(); ?>

    <section class="page-header grid">
        <h1 class="page-title">Clients</h1>
    </section>

    <?php if(have_rows('client_sections', 'options')): ?>

        <section class="client-tabs grid">
            <nav class="clients-nav">
                <?php $tab_count = 1; while(have_rows('client_sections', 'options')) : the_row(); ?>

                    <div class="link">
                        <a <?php if($tab_count == 1): ?>class="active"<?php endif; ?> href="#<?php echo sanitize_title_with_dashes(get_sub_field('label')); ?>" class="smooth"><?php echo get_sub_field('label'); ?></a>
                    </div>

                <?php $tab_count++; endwhile; ?>
            </nav>
        </section>
        
        <?php $section_count = 1; while(have_rows('client_sections', 'options')) : the_row(); ?>

            <?php if( get_row_layout() == 'section' ): ?>

                <section class="client-type grid<?php if($section_count == 1): ?> active<?php endif; ?>" id="<?php echo sanitize_title_with_dashes(get_sub_field('label')); ?>">
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

                            <?php
                                $client_ID = $post->ID;
                                $projects_args = array(
                                    'post_type'  => 'projects',
                                    'meta_query' => array(
                                        array(
                                            'key'   => 'details_client',
                                            'value' => $client_ID,
                                        )
                                    )
                                );
                                $projects = get_posts( $projects_args );
                                
                                if($projects):
                            ?>

                            <div class="client has-projects">
                                <span class="name"><?php the_title(); ?></span>
                                
                                <ul class="projects">
                                    <?php foreach($projects as $project): ?>
                                        <li class="project">
                                            <a href="<?php echo get_permalink($project->ID); ?>"><?php echo get_the_title($project->ID); ?></a>                                        

                                        </li>

                                    <?php endforeach; ?>
                                </ul>
                            </div>

                            <?php else: ?>
                                <div class="client">
                                    <span class="name"><?php the_title(); ?></span>                                
                                </div>
                            <?php endif; ?>

                        <?php endwhile; endif; wp_reset_postdata(); ?>
                    </div>			
                </section>

            <?php endif; ?>
        
        <?php $section_count++; endwhile; ?>

    <?php endif; ?>

<?php get_footer(); ?>