<?php 

    $join_us = get_field('join_us');
    $headline = $join_us['headline'];
    $photo = $join_us['photo'];
    $sub_headline = $join_us['sub_headline'];
    $dek = $join_us['dek'];
    $link = $join_us['link'];

?>

<section class="join-us grid">
    <div class="section-header">
        <h2><?php echo $headline; ?></h2>
    </div>

    <?php if( $photo ): ?>
        <div class="photo">
            <?php echo wp_get_attachment_image($photo['ID'], 'full'); ?>
        </div>
    <?php endif; ?>

    <div class="info sub-grid">
        <div class="sub-headline">
            <h3 class="title-headline"><?php echo $sub_headline; ?></h3>
        </div>

        <div class="copy p1">
            <?php echo $dek; ?>

            <?php 
                if( $link ): 
                $link_url = $link['url'];
                $link_title = $link['title'];
                $link_target = $link['target'] ? $link['target'] : '_self';
            ?>

                <div class="cta">
                    <a class="btn btn-green" href="<?php echo esc_url($link_url); ?>" target="<?php echo esc_attr($link_target); ?>"><?php echo esc_html($link_title); ?></a>
                </div>

            <?php endif; ?>
        </div>
    </div>
    
</section>