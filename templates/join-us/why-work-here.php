<?php

    $why = get_field('why_we_work_here');
    $headline = $why['headline'];

if(have_rows('why_we_work_here')): while(have_rows('why_we_work_here')): the_row(); ?>
 
    <section class="why-we-work-here grid">
        <div class="section-header">
            <h3 class="section-headline small"><?php echo $headline; ?></h3>
        </div>

        <?php if(have_rows('items')): ?>
            <div class="three-col-grid">
                <?php while(have_rows('items')): the_row(); ?>

                    <div class="item">
                        <?php $image = get_sub_field('photo'); if( $image ): ?>
                            <div class="photo">
                                <?php echo wp_get_attachment_image($image['ID'], 'full'); ?>
                            </div>
                        <?php endif; ?>

                        <div class="headline copy copy-2">
                            <h4><?php the_sub_field('headline'); ?></h4>
                        </div>

                        <div class="copy copy-2">
                            <?php the_sub_field('copy'); ?>
                        </div>
                    </div>

                <?php endwhile; ?>
            </div>
        <?php endif; ?>

    </section>

<?php endwhile; endif; ?>
