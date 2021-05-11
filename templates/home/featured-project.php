<?php 

    $featured_project = get_field('featured_project');
    $photo = $featured_project['photo'];
    $headline = $featured_project['headline'];
    $dek = $featured_project['dek'];
    $link = $featured_project['link'];

?>

<section class="featured-project">
   
    <?php if( $photo ): ?>
        <div class="photo">
            <div class="content">
                <?php echo wp_get_attachment_image($photo['ID'], 'full'); ?>
            </div>
        </div>
    <?php endif; ?>

    <div class="grid overlay">

        <div class="info">
            <div class="section-header">
                <h2><?php echo $headline; ?></h2>
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

    </div>
    
</section>