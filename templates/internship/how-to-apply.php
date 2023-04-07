<?php

$how_to_apply = get_field('how_to_apply');
    $headline = $how_to_apply['headline'];
    $copy = $how_to_apply['copy'];
    $link = $how_to_apply['link'];

    $study_areas = get_field('study_areas');
    $study_areas_headline = $study_areas['headline'];
    $study_areas_copy = $study_areas['copy'];
    
?>

<section class="how-to-apply grid">

    <?php if($headline): ?>
        <div class="section-header">
            <h2 class="section-title"><?php echo $headline; ?></h2>
        </div>
    <?php endif; ?>

    <div class="info">
        <?php if($copy): ?>
            <div class="copy-2 extended">
                <?php echo $copy; ?>
            </div>
        <?php endif; ?>

        <?php 
            if( $link ): 
            $link_url = $link['url'];
            $link_title = $link['title'];
            $link_target = $link['target'] ? $link['target'] : '_self';
        ?>

            <div class="cta">
                <a class="btn btn-teal" href="<?php echo esc_url($link_url); ?>" target="<?php echo esc_attr($link_target); ?>"><?php echo esc_html($link_title); ?></a>
            </div>

        <?php endif; ?>
    </div>

    <div class="study-areas">
        <?php if($study_areas_headline): ?>
            <div class="headline">
                <h3><?php echo $study_areas_headline; ?></h3>
            </div>
        <?php endif; ?>

        <?php if($study_areas_copy): ?>
            <div class="copy-3 extended">
                <?php echo $study_areas_copy; ?>
            </div>
        <?php endif; ?>
    </div>

    
</section>