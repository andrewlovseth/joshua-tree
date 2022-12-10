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
                    <h4>Contact Us For</h4>

                    <ul>
                        <?php foreach($services as $service): ?>
                            <li><a href="<?php echo get_permalink($service->ID); ?>"><?php echo get_the_title($service->ID); ?></a></li>
                        <?php endforeach; ?>                        
                    </ul>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <?php $leaders = get_field('leaders'); if( $leaders ): ?>
        <div class="market-leaders">
            <div class="section-header">
                <h3 class="section-headline">Connect with Our Team</h3>
            </div>
            
            <div class="leader-grid">

                <?php foreach( $leaders as $leader ): ?>

                    <?php
                        $args = [ 'leader' => $leader ];
                        get_template_part('templates/single-market/market-leader', null, $args);
                    ?>

                <?php endforeach; ?>
                
            </div>            
        </div>
    <?php endif; ?>

</section>