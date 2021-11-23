<?php

    $bio = get_field('biography');
    $long_bio = $bio['long_bio'];

?>

<article class="biography">

    <?php if( $long_bio ): ?>
        <div class="long-bio copy-2 extended">
            <?php echo $long_bio; ?>
        </div>
    <?php endif; ?>

</article>