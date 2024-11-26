<?php

    $gallery = get_field('gallery');
    $headline = $gallery['headline'];
    $copy = $gallery['copy'];
    $photos = $gallery['photos'];

    if($photos || $headline || $copy):
?>

    <section class="gallery">
        <?php if($headline): ?>
            <div class="section-header">
                <h3 class="section-headline small"><?php echo $headline; ?></h3>
            </div>
        <?php endif; ?>

        <?php if($copy): ?>
            <div class="copy copy-2">
                <?php echo $copy; ?>
            </div>
        <?php endif; ?>

        <?php if( $photos ): ?>
            <div class="service-info__gallery">
                <div class="services-gallery-slider">
                    <?php foreach( $photos as $photo ): ?>
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
    </section>

<?php endif; ?>