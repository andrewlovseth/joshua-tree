<?php

    $about = get_field('about');
    $copy = $about['copy'];
    $gallery = $about['gallery'];
    $related = $about['related'];

 
    $experts = get_field('experts');

?>

<section class="service-info grid">

    <div class="about">
        <?php if($copy): ?>
            <div class="copy-2 extended about__main">
                <?php echo $copy; ?>
            </div>
        <?php endif; ?>

        <?php if( $gallery ): ?>
            <div class="service-info__gallery">
                <div class="services-gallery-slider">
                    <?php foreach( $gallery as $photo ): ?>
                        <div class="service-info__gallery-photo">
                            <?php echo wp_get_attachment_image($photo['ID'], 'full'); ?>

                            <?php if(wp_get_attachment_caption($photo['ID'])): ?>
                                <div class="service-info__gallery-caption">
                                    <p><?php echo wp_get_attachment_caption($photo['ID']); ?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if($related): ?>
            <div class="copy-2 extended about__related">
                <?php echo $related; ?>
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