<?php

    $featured_projects = get_field('similar_projects');
    if($featured_projects):

?>

    <section class="more-projects grid">
        <div class="section-header">
            <h3 class="section-headline small">Similar Projects</h3>
        </div>

        <div class="more-projects-slider-wrapper">
            <div class="more-projects-slider">

                <?php foreach( $featured_projects as $project ): ?>
                    <div class="project">
                        <a href="<?php echo get_permalink( $project->ID ); ?>">
                            <?php $image = get_field('hero_photo', $project->ID); if( $image ): ?>
                                <div class="photo">
                                    <?php echo wp_get_attachment_image($image['ID'], 'full'); ?>
                                </div>
                            <?php endif; ?>

                            <div class="info">
                                <div class="info__wrapper">
                                    <?php $market = get_field('details_market', $project->ID); if($market): ?>
                                        <div class="market">
                                            <h4><?php echo get_the_title($market); ?></h4>
                                        </div>
                                    <?php endif; ?>

                                    <div class="headline">
                                        <h3 class="title-headline small"><?php echo get_the_title( $project->ID ); ?></h3>
                                    </div>

                                    <div class="location">
                                        <h4><?php the_field('details_location', $project->ID); ?></h4>
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