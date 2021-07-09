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

            <div class="profile">
                <div class="photo">
                    <div class="content">
                        <a href="<?php echo get_permalink($lead->ID); ?>">
                            <?php $image = get_field('info_photo', $lead->ID); if( $image ): ?>
                                <?php echo wp_get_attachment_image($image['ID'], 'full'); ?>
                            <?php endif; ?>
                        </a>
                    </div>                    
                </div>

                <div class="info">
                    <div class="name">
                        <h3><?php echo get_the_title($lead->ID); ?></h3>
                    </div>
                    
                    <div class="meet vital">
                        <p>Meet <a href="<?php echo get_permalink($lead->ID); ?>"><?php the_field('info_first_name', $lead->ID); ?></a></p>
                    </div>

                    <div class="office vital">
                        <p>Office: <a href="<?php $office = get_field('info_office', $lead->ID); echo get_permalink($office->ID); ?>"><?php echo get_the_title($office->ID); ?></a></p>
                    </div>

                    <div class="contact vital">
                        <div class="phone">
                            <p><a href="tel:<?php the_field('contact_phone', $lead->ID); ?>"><?php the_field('contact_phone', $lead->ID); ?></a></p>
                        </div>

                        <div class="email">
                            <p><a href="mailto:<?php the_field('contact_email', $lead->ID); ?>">Email</a></p>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    <?php endif; ?>

</section>