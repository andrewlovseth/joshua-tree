<?php

    if( get_row_layout() == 'gallery' ):

    $headline = get_sub_field('section_title');
?>
    
    <section class="gallery platform-section grid">
        
        <?php if($headline): ?>
            <div class="section-header">
                <h2 class="section-headline small"><?php echo $headline; ?></h2>
            </div>
        <?php endif; ?>

        <?php if(have_rows('gallery_items')): ?>
            <div class="gallery__items">

                <?php while(have_rows('gallery_items')): the_row(); ?>
                    <?php
                        $image = get_sub_field('image');
                        $copy = get_sub_field('copy');
                    ?>
 
                    <div class="gallery__item">
                        <div class="gallery__item-image">
                            <?php echo wp_get_attachment_image($image['ID'], 'full'); ?>
                        </div>

                        <div class="gallery__item-copy copy-3">
                            <?php echo $copy; ?>
                        </div>
                    </div>
                
                <?php endwhile; ?>
            </div>
        <?php endif; ?>        
    </section>

<?php endif; ?>

