<?php

    $about = get_field('about');
    $copy = $about['copy'];

?>

<section class="service-info grid">

    <div class="about">
        <div class="copy-2 extended">
            <?php echo $copy; ?>
        </div>
    </div>

</section>