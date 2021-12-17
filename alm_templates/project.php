<?php 

    $services = get_field('details_services');
    $market = get_field('details_market'); 
    $client_type = get_field('details_client_type'); 
    $location = get_field('details_location');
    $image = get_field('hero_photo'); 

?>

<div class="project">
    <?php var_dump($market, $services, $client_type); ?>
    <a href="<?php echo get_permalink(); ?>">
        <?php if( $image ): ?>
            <div class="photo">
                <div class="content">
                    <?php echo wp_get_attachment_image($image['ID'], 'medium'); ?>
                </div>
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
                    <h3 class="title-headline small"><?php echo get_the_title(); ?></h3>
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