<?php 

    $about = get_field('about');
    $copy = $about['copy'];
    $sub_markets = $about['sub_markets'];
    $services = $about['services'];
    $lead = get_field('lead');

?>


<section class="market-info grid">

    <div class="about">
        <div class="copy-2 extended">
            <?php echo $copy; ?>
        </div>

        <?php if($sub_markets): ?>
            <div class="sub-markets">
                <div class="copy-3 extended">
                    <h4>Submarkets</h4>

                    <ul>
                        <?php foreach($sub_markets as $market): ?>
                            <li><a href="<?php echo get_permalink($market->ID); ?>"><?php echo get_the_title($market->ID); ?></a></li>
                        <?php endforeach; ?>                        
                    </ul>
                </div>
            </div>
        <?php endif; ?>

        <?php if($services): ?>
            <div class="services">
                <div class="copy-3 extended">
                    <h4>Service</h4>

                    <ul>
                        <?php foreach($services as $service): ?>
                            <li><a href="<?php echo get_permalink($service->ID); ?>"><?php echo get_the_title($service->ID); ?></a></li>
                        <?php endforeach; ?>                        
                    </ul>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <?php if($lead): ?>
        <div class="market-lead">
            <div class="section-header">
                <h3 class="section-headline">Market<br/>Lead</h3>
            </div>

            <?php
                $args = [ 'expert' => $lead ];
                get_template_part('template-parts/global/expert', null, $args);
            ?>



        </div>
    <?php endif; ?>

</section>