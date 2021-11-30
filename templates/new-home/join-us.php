<?php 
    
    $join_us = get_field('join_us');
    $photo = $join_us['photo'];
    $headline = $join_us['headline'];
    $copy = $join_us['copy'];
    $link = $join_us['link'];

?>

<div class="join-us">
    <div class="wrapper">

        <?php if( $photo ): ?>
            <div class="photo">
                <div class="content">
                    <?php echo wp_get_attachment_image($photo['ID'], 'full'); ?>
                </div>
            </div>
        <?php endif; ?>


        <div class="info">
            <div class="section-header">
                <h2 class="special"><?php echo $headline; ?></h2>
            </div>

            <div class="copy copy-3">
                <?php echo $copy; ?>                
            </div>

            <?php 
                if( $link ): 
                $link_url = $link['url'];
                $link_title = $link['title'];
                $link_target = $link['target'] ? $link['target'] : '_self';
            ?>

                <div class="cta">
                    <a class="underline" href="<?php echo esc_url($link_url); ?>" target="<?php echo esc_attr($link_target); ?>"><?php echo esc_html($link_title); ?></a>
                </div>

            <?php endif; ?>
        </div>

    </div>
</div>