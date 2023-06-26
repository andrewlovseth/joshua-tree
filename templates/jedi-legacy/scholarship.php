<?php

    $scholarship = get_field('scholarship');
    $headline = $scholarship['headline'];
    $copy = $scholarship['copy'];
    $photo = $scholarship['photo'];
?>

<section class="scholarship grid">

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