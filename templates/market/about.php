<?php

    $about = get_field('about');
    $headline = $about['headline'];
    $copy = $about['copy'];

?>

<section class="market-about grid">
    <h2 class="market-about__title | title-headline x-small"><?php echo $headline; ?></h2>

    <div class="market-about__copy | copy copy-2 extended">
        <?php echo $copy; ?>
    </div>
</section>