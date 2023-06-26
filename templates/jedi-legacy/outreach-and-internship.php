<?php

    $outreach = get_field('outreach_and_internship');
    $headline = $outreach['headline'];
    $copy = $outreach['copy'];
    $photo = $outreach['photo'];
?>

<section class="outreach-and-internship grid left-flow">

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