
<?php
    $args = wp_parse_args($args);

    if(!empty($args)) {
        $expert = $args['expert'];
    }

    if('leadership' == get_post_type($expert->ID)) {
        $image = get_field('info_headshot', $expert->ID);
    } elseif('employee' == get_post_type($expert->ID)) {
        $image = get_field('info_photo', $expert->ID);
    }

    $terms = get_the_terms($expert->ID, 'region');
    if($terms) {
        $region = '';
        foreach($terms as $term) {
            $region .= $term->name . ', ';
        }
        $region = rtrim($region, ', ');
    }

    $social = get_field('social', $expert->ID);
    $linkedin = $social['linkedin'];

?>

<div class="expert profile">
    <div class="photo">
        <div class="content">
            <a href="<?php echo get_permalink($expert->ID); ?>">
                <?php if( $image ): ?>
                    <?php echo wp_get_attachment_image($image['ID'], 'full'); ?>
                <?php endif; ?>
            </a>
        </div>                    
    </div>

    <div class="info">
        <div class="name">
            <h3><a href="<?php echo get_permalink($expert->ID); ?>"><?php echo get_the_title($expert->ID); ?></a></h3>
        </div>
        
        <?php if($region): ?>
            <div class="region vital">
                <em><?php echo $region; ?></em>
            </div>
        <?php endif; ?>
        
        <?php if($linkedin): ?>
            <div class="vital social">
                <div class="social-links">
                    <div class="link linkedin">
                        <a href="<?php echo $linkedin; ?>" rel="external"><img src="<?php bloginfo('template_directory'); ?>/images/icon-linkedin.svg" alt="LinkedIn" /></a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>