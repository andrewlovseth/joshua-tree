<?php

    $experts = get_field('experts');

?>


<section class="platform-experts grid">

    <?php if($experts): ?>
        <div class="experts">
            <div class="section-header">
                <h3 class="section-headline">Connect with Our Team</h3>
            </div>

            <?php foreach($experts as $expert): ?>

                <?php
                    $args = [ 'expert' => $expert ];
                    get_template_part('template-parts/global/expert', null, $args);
                ?>

            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</section>