<?php

    $statement = get_field('statement');
    $headline = $statement['headline'];
    $copy = $statement['copy'];
    $photo = $statement['photo'];
?>

<section class="statement grid left-flow">
    <div class="headline section-header">
        <h2><?php echo $headline; ?></h2>
    </div>

    <div class="photo">
        <?php echo wp_get_attachment_image($photo['ID'], 'full'); ?>
    </div>

    <div class="copy copy-2 extended">
        <?php echo $copy; ?>
    </div>
</section>