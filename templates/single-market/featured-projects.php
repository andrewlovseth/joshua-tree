<?php

    $featured_projects = get_field('featured_projects');
    if($featured_projects):

?>

    <section class="featured-projects grid">

        <div class="projects-slider-wrapper">
            <div class="projects-slider">

                <?php foreach( $featured_projects as $project ): ?>
                    <div class="project">
                        <a href="<?php echo get_permalink( $project->ID ); ?>">
                            <?php $image = get_field('hero_photo', $project->ID); if( $image ): ?>
                                <div class="photo">
                                    <div class="content">
                                        <?php echo wp_get_attachment_image($image['ID'], 'full'); ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <div class="info">
                                <div class="info__wrapper">
                                    <div class="headline">
                                        <h3><?php echo get_the_title( $project->ID ); ?></h3>
                                    </div>

                                    <?php if(get_field('details_about', $project->ID)): ?>
                                        <div class="copy-3">
                                            <?php the_field('details_about', $project->ID); ?>
                                        </div>
                                    <?php endif; ?>

                                    <?php if(get_field('details_location', $project->ID)): ?>
                                        <div class="location">
                                            <h4><?php the_field('details_location', $project->ID); ?></h4>
                                        </div>
                                    <?php endif; ?>

                                    <?php
                                        $client = get_field('details_client', $project->ID);
                                        if($client): ?>
                                        <div class="client">
                                            <h5><strong>Client:</strong> <?php echo get_the_title( $client->ID ); ?></h5>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>                    
                        </a>
                    </div>
                <?php endforeach; ?>

            </div>
        </div>

    </section>

<?php endif; ?>