<?php

    $what_to_expect = get_field('what_to_expect');
    $headline = $what_to_expect['headline'];
    $copy = $what_to_expect['copy'];

?>

<section class="what-to-expect grid">

    <?php if($headline): ?>
        <div class="section-header">
            <h2 class="section-title"><?php echo $headline; ?></h2>
        </div>
    <?php endif; ?>

    <?php if($copy): ?>
        <div class="copy-2 extended">
            <?php echo $copy; ?>
        </div>
    <?php endif; ?>
    
</section>