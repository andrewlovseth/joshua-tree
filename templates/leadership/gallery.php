<?php

    $leadership = get_page_by_path('about/leadership');
    $gallery = get_field('gallery', $leadership->ID);

    if($gallery):

?>

    <section class="leadership-gallery grid">
        <div class="js-leadership-gallery">
            <?php foreach( $gallery as $photo ): ?>

                <figure class="leadership-gallery__photo">
                    <?php echo wp_get_attachment_image($photo['ID'], 'full'); ?>

                    <?php if(wp_get_attachment_caption($photo['ID'])): ?>
                        <figcaption class="caption copy-3">
                            <?php echo wp_get_attachment_caption($photo['ID']); ?>
                        </figcaption>
                    <?php endif; ?>
                </figure>

            <?php endforeach; ?>
        </div>    
    </section>

<?php endif; ?>