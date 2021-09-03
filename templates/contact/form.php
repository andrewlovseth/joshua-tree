<?php

    $form = get_field('form');
    $headline = $form['headline'];
    $copy = $form['copy'];
    $code = $form['code'];

?>

<section class="contact-form grid">
    <div class="headline">
        <h3 class="section-headline small"><?php echo $headline; ?></h3>
    </div>

    <div class="copy copy-2">
        <?php echo $copy; ?>
    </div>

    <div class="form-embed">
        <?php echo $code; ?>
    </div>
</section>