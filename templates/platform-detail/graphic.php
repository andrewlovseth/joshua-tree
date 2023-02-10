<?php

    if( get_row_layout() == 'graphic' ):

    $caption = get_sub_field('caption');
    $image = get_sub_field('image');

?>
    
    <section class="graphic platform-section grid">

        <?php if($caption): ?>
            <div class="caption copy-2">
                <p><?php echo $caption; ?></p>
            </div>
        <?php endif; ?>
        
        <?php if($image): ?>
            <div class="image">
                <?php echo wp_get_attachment_image($image['ID'], 'full'); ?>
            </div>
        <?php endif; ?>

    </section>

<?php endif; ?>