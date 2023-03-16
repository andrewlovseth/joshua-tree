<?php

    if( get_row_layout() == 'experts' ):

    $anchor = get_sub_field('anchor');
    $headline = get_sub_field('section_header');
    $experts = get_sub_field('experts_gallery');

?>

    <section class="experts-section platform-section grid"<?php if($anchor): ?> id="<?php echo $anchor; ?>"<?php endif; ?>>
        <?php if($headline): ?>
            <div class="section-header">
                <h3 class="section-headline small"><?php echo $headline; ?></h3>
            </div>
        <?php endif; ?>

        <div class="experts">
            <?php foreach($experts as $expert): ?>

                <?php
                    $args = [ 'expert' => $expert ];
                    get_template_part('template-parts/global/expert', null, $args);
                ?>
                
            <?php endforeach; ?>
        </div>
    </section>

<?php endif; ?>