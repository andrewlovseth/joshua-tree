<?php 

$experts = get_field('experts');

if($experts): ?>
    <section class="experts">
        <div class="section-header">
            <h3 class="section-headline small">Connect with Our Team</h3>
        </div>

        <?php foreach($experts as $expert): ?>

            <?php
                $args = [ 'expert' => $expert ];
                get_template_part('template-parts/global/expert', null, $args);
            ?>
            
        <?php endforeach; ?>
    </section>
<?php endif; ?>