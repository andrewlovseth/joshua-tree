<?php

    $about = get_field('about');
    $copy = $about['copy'];
    $sub_services = $about['sub_services'];
    $experts = get_field('experts');

?>

<section class="service-info grid">

    <div class="about">
        <div class="copy-2 extended">
            <?php echo $copy; ?>
        </div>

        <?php if($sub_services): ?>
            <div class="sub-services">
                <div class="header">
                    <h4 class="title-headline small">Learn more about</h4>
                </div>
                <ul>
                    <?php foreach($sub_services as $service): ?>
                        <li>
                            <a href="<?php echo get_permalink($service->ID); ?>">
                                <?php echo get_the_title($service->ID); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
    </div>

    <?php if($experts): ?>
        <div class="experts">
            <div class="section-header">
                <h3 class="section-headline">Connect with our team</h3>
            </div>

            <?php foreach($experts as $expert): ?>

                <?php
                    $args = [ 'expert' => $expert ];
                    get_template_part('template-parts/global/expert', null, $args);
                ?>

            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>