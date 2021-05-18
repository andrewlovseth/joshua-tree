<?php

    $whats_an_esop = get_field('whats_an_esop');
    $headline = $whats_an_esop['headline'];
    $copy = $whats_an_esop['copy'];

?>

<section class="whats-an-esop grid">

    <div class="info">
        <?php if($headline): ?>
            <div class="headline">
                <h2 class="section-headline"><?php echo $headline; ?></h2>
            </div>
        <?php endif; ?>

        <?php if($copy): ?>
            <div class="copy-2 deck">
                <?php echo $copy; ?>
            </div>
        <?php endif; ?>
    </div>

</section>