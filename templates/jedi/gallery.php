<?php

    $gallery = get_field('gallery');
    if($gallery):

?>

    <section class="gallery grid">
        <div class="gallery__wrapper">
            <div class="js-jedi-gallery">
                <?php foreach( $gallery as $photo ): ?>

                    <figure class="gallery__photo">
                        <?php echo wp_get_attachment_image($photo['ID'], 'full'); ?>
                    </figure>

                <?php endforeach; ?>
            </div>    
        </div>
    </section>

<?php endif; ?>