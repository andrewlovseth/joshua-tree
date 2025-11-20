<?php

    if( get_row_layout() == 'gray_text' ):

    $anchor = get_sub_field('anchor');
    $headline = get_sub_field('headline');
    $copy = get_sub_field('copy');
    $video_id = get_sub_field('video_id');

?>
    
    <section class="gray-text platform-section grid"<?php if($anchor): ?> id="<?php echo $anchor; ?>"<?php endif; ?>>
        <div class="gray-text__info">
            <?php if($headline): ?>
                <div class="section-header">
                    <h2 class="section-headline small"><?php echo $headline; ?></h2>
                </div>
            <?php endif; ?>

            <?php if($copy): ?>
                <div class="copy-2 extended">
                    <?php echo $copy; ?>
                </div>
            <?php endif; ?>
        </div>

        
        <?php if($video_id): ?>
            <div class="video gray-text__video">
                <iframe src="https://www.youtube.com/embed/<?php echo $video_id; ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
        <?php endif; ?>
    </section>

<?php endif; ?>