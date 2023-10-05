<?php

    $featured_projects = get_field('featured_projects');
    
?>

<div class="projects projects-grid">

    <?php foreach( $featured_projects as $project ): ?>

        <?php 
            $services = get_field('details_services', $project->ID);
            $market = get_field('details_market', $project->ID); 
            $client_type = get_field('details_client_type', $project->ID); 
            $location = get_field('details_location', $project->ID);
            $image = get_field('hero_photo', $project->ID); 

        ?>

        <div class="project">
            <a href="<?php echo get_permalink($project->ID); ?>">
                <?php if( $image ): ?>
                    <div class="photo">
                        <?php echo wp_get_attachment_image($image['ID'], 'medium'); ?>
                    </div>
                <?php endif; ?>

                <div class="info">
                    <div class="info__wrapper">

                        <?php if($market): ?>
                            <div class="market">
                                <h4><?php echo get_the_title($market); ?></h4>
                            </div>
                        <?php endif; ?>

                        <div class="headline">
                            <h3 class="title-headline small"><?php echo get_the_title($project->ID); ?></h3>
                        </div>

                        <?php if($location): ?>
                            <div class="location">
                                <h4><?php echo $location; ?></h4>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>                    
            </a>
        </div>
    <?php endforeach; ?>

</div>