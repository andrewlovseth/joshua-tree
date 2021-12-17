<?php

    $form = get_field('form');
    $headline = $form['headline'];
    $copy = $form['copy'];
    $code = $form['code'];

?>

<section class="contact-form grid">
    <?php if($headline): ?>
        <div class="headline">
            <h3 class="section-headline small"><?php echo $headline; ?></h3>
        </div>
    <?php endif; ?>

    <?php if($copy): ?>
        <div class="copy copy-2">
            <?php echo $copy; ?>
        </div>
    <?php endif; ?>
    
    <?php if($code): ?>
        <div class="form-embed">
            <?php echo $code; ?>
        </div>
    <?php endif; ?>
</section>