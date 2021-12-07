<?php

    $ongoing_education = get_field('ongoing_education');
    $headline = $ongoing_education['headline'];
    $copy = $ongoing_education['copy'];
    $photo = $ongoing_education['photo'];
?>

<section class="ongoing-education grid left-flow">
    <div class="headline section-header">
        <h2><?php echo $headline; ?></h2>
    </div>

    <div class="photo">
        <?php echo wp_get_attachment_image($photo['ID'], 'full'); ?>
    </div>

    <div class="copy copy-1 extended">
        <?php echo $copy; ?>
    </div>
</section>