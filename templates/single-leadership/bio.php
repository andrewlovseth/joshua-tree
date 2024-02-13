<?php

    $bio = get_field('biography');
    $copy = $bio['copy'];

?>

<div class="biography">
    <div class="copy-2 extended">
        <?php echo $copy; ?>
    </div>

    <div class="back">
        <div class="cta">
            <a href="<?php echo site_url('/about/leadership/'); ?>" class="btn btn-green">Leadership</a>
        </div>
    </div>
</div>