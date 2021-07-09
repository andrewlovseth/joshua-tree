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

                                    <div class="copy-3">
                                        <p>In preparation for a multibillion-dollar expansion, the City of Chicago developed a master plan to consider future development scenarios at the Chicago O’Hare International Airport—the world’s busiest in terms of aircraft operations.</p>
                                    </div>

                                    <div class="location">
                                        <h4>Chicago, Illinois</h4>
                                    </div>

                                    <div class="client">
                                        <h5><strong>Client:</strong> City of Chicago, Department of Aviation</h5>

                                    </div>
                                </div>
                            </div>                    
                        </a>
                    </div>
                <?php endforeach; ?>

            </div>
        </div>

    </section>

<?php endif; ?>