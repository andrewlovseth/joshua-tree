<?php

    $args = array(
        'numberposts' => -1,
        'post_type' => 'service',
        'orderby' => 'title',
        'order' => 'ASC'
    );
    $all_services = get_posts($args);
    $services = array();

    foreach($all_services as $s) {
        if($s->post_parent !== 0) {
            array_push($services, $s);
        }        
    }

?>

<section class="additional-services grid">
    <div class="section-header">
        <h3 class="title-headline small">Additional Services</h3>
    </div>

    <?php if($services): ?>
        <div class="services-list">
            <?php foreach($services as $service): ?>
                <div class="link">
                    <a href="<?php echo get_permalink($service->ID); ?>">
                        <?php echo get_the_title($service->ID); ?>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif ; ?>
</section>