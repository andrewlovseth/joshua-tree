<?php 
    $about = get_field('about');
    $headline = $about['headline'];
    $photo = $about['photo'];
    $link = $about['link'];

?>

<section class="about grid">

    <div class="headline">
        <h1><?php echo $headline; ?></h1>
    </div>

    <?php if($photo): ?>
        <div class="photo">
            <?php echo wp_get_attachment_image( $photo['id'], 'full' ); ?>
            
            <?php 
                if( $link ): 
                $link_url = $link['url'];
                $link_title = $link['title'];
                $link_target = $link['target'] ? $link['target'] : '_self';
            ?>
                <div class="about-link grid">
                    <div class="cta">
                        <a class="btn btn-green" href="<?php echo esc_url($link_url); ?>" target="<?php echo esc_attr($link_target); ?>"><?php echo esc_html($link_title); ?></a>
                    </div>
                </div>
            <?php endif; ?>
            
        </div>
    <?php endif; ?>
    
</section>