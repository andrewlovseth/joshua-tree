<?php
    $args = wp_parse_args($args);

    if(!empty($args)) {
        $executives = $args['executives'];
    }

    $leaders = get_field('leaders');

    if( $leaders ):

?>

<section class="leaders grid">
    <div class="leaders-grid<?php if($executives): ?> executives<?php endif; ?>">
        
        <?php foreach( $leaders as $leader ): ?>
            <?php
                $link = get_permalink( $leader->ID );
                if(get_field('info_headshot', $leader->ID)) {
                    $photo = get_field('info_headshot', $leader->ID);
                } else {
                    $photo = get_field('info_photo', $leader->ID);
                }
                $name = get_the_title( $leader->ID );
                $position = get_field('info_position', $leader->ID); 
                $executive = get_field('info_executive', $leader->ID); 
            ?>

            <div class="leader<?php if($executive): ?> executive<?php endif; ?>">
                <a href="<?php echo $link; ?>">
                    <div class="photo">
                        <?php echo wp_get_attachment_image($photo['ID'], 'full'); ?>
                    </div>

                    <div class="info">
                        <div class="name">
                            <h3><?php echo $name; ?></h3>
                        </div>

                        <div class="position">
                            <p><?php echo $position; ?></p>
                        </div>
                    </div>
                </a>
            </div>

        <?php endforeach; ?>

    </div>
</section>

                    <?php endif; ?>