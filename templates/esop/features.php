<?php

    $features = get_field('features');
    $headline = $features['headline'];
    $deck = $features['deck'];
    $sub_features = $features['sub_features'];

?>

<section class="features grid">

    <?php if($headline): ?>
        <div class="headline">
            <h2 class="section-headline"><?php echo $headline; ?></h2>
        </div>
    <?php endif; ?>

    <?php if($deck): ?>
        <div class="copy-2 deck">
            <?php echo $deck; ?>
        </div>
    <?php endif; ?>
    
    <div class="sub-features">
        <?php foreach($sub_features as $sub_feature): ?>
            <?php
                $headline = $sub_feature['headline'];
                $copy = $sub_feature['copy'];
            ?>

            <div class="sub-feature">
                <div class="headline">
                    <h3><?php echo $headline; ?></h3>
                </div>

                <div class="copy-2">
                    <?php echo $copy; ?>
                </div>
            </div>

        <?php endforeach; ?>
    </div>



</section>