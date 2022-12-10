
<?php
    $args = wp_parse_args($args);

    if(!empty($args)) {
        $leader = $args['leader'];
    }

    if('leadership' == get_post_type($leader->ID)) {
        $image = get_field('info_headshot', $leader->ID);
    } elseif('employee' == get_post_type($leader->ID)) {
        $image = get_field('info_photo', $leader->ID);
    }

    $position = get_field('info_position', $leader->ID);
?>

<div class="leader profile">
    <div class="photo">
        <a href="<?php echo get_permalink($leader->ID); ?>">
            <?php if( $image ): ?>
                <?php echo wp_get_attachment_image($image['ID'], 'full'); ?>
            <?php endif; ?>
        </a>
    </div>

    <div class="info">
        <div class="name">
            <h3><a href="<?php echo get_permalink($leader->ID); ?>"><?php echo get_the_title($leader->ID); ?></a></h3>
        </div>
        
        <?php if($position): ?>
            <div class="position vital">
                <em><?php echo $position; ?></em>
            </div>
        <?php endif; ?>
    </div>
</div>