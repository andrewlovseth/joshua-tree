<?php

    $details = get_field('details');
    $photo = $details['photo'];
    $client = $details['client'];
    $location = $details['location'];
    $market = $details['market'];
    $services = $details['services'];
    $notable = $details['notable'];

?>

<section class="details grid">
    <div class="info">
        <div class="section-header">
            <h3 class="section-headline small">Details</h3>
        </div>

        <?php if($client): ?>
            <div class="vital client copy copy-2">
                <p>
                    <strong>Client</strong>
                    <a href="<?php echo get_permalink($client->ID); ?>"><?php echo get_the_title($client->ID); ?></a>
                </p>
            </div>
        <?php endif; ?>

        <?php if($location): ?>
            <div class="vital location copy copy-2">
                <p>
                    <strong>Location</strong>
                    <?php echo $location; ?>
                </p>
            </div>
        <?php endif; ?>

        <?php if($market): ?>
            <div class="vital market copy copy-2">
                <p>
                    <strong>Market</strong>
                    <a href="<?php echo get_permalink($market->ID); ?>"><?php echo get_the_title($market->ID); ?></a>
                </p>
            </div>
        <?php endif; ?>

        <?php if($services): ?>
            <div class="vital services copy copy-2">
                <p>
                    <strong>Services</strong>
                    <?php foreach( $services as $service ): ?>
                        <a href="<?php echo get_permalink( $service->ID ); ?>"><?php echo get_the_title( $service->ID ); ?></a><br/>
                    <?php endforeach; ?>
                </p>
            </div>
        <?php endif; ?>

        <?php if($notable): ?>
            <div class="vital notable copy copy-2">
                <p>
                    <strong>Notable</strong>
                    <?php echo $notable; ?>
                </p>
            </div>
        <?php endif; ?>

    </div>

    <?php if( $photo ): ?>
        <div class="photo">
            <?php echo wp_get_attachment_image($photo['ID'], 'full'); ?>
        </div>
    <?php endif; ?>

</section>