<?php

    $mission = get_field('mission');
    $logo = $mission['logo'];
    $copy = $mission['copy'];
    $link = $mission['link'];

?>

<div class="mission">
    <a class="mission__link" href="<?php echo $link; ?>">
        <div class="mission__logo">
            <?php echo esa_svg($logo['url']); ?>
        </div>

        <div class="mission__copy | copy copy-1">
            <?php echo $copy; ?>
        </div>
    </a>
</div>