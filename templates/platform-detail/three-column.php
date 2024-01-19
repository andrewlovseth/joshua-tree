<?php

    if( get_row_layout() == 'three_column' ):
        
    $anchor = get_sub_field('anchor');
    $headline = get_sub_field('headline');

?>

    <section class="three-column platform-section grid"<?php if($anchor): ?> id="<?php echo $anchor; ?>"<?php endif; ?>>
        <div class="section-header">
            <h2 class="section-headline small"><?php echo $headline; ?></h2>
        </div>
    
        <?php if(have_rows('columns')): ?>

            <div class="three-column__wrapper">           
                <?php while(have_rows('columns')): the_row(); ?>
    
                    <div class="column copy-2">
                        <p><?php echo get_sub_field('copy'); ?></p>
                    </div>

                <?php endwhile; ?>
            </div>
        
        <?php endif; ?>
    </section>

<?php endif; ?>