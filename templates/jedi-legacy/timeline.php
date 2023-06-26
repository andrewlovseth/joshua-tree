<?php

    $timeline = get_field('timeline');
    $headline = $timeline['headline'];
    $copy = $timeline['copy'];

if(have_rows('timeline')): while(have_rows('timeline')): the_row(); ?>

    <section class="timeline grid">

        <div class="section-header">
            <h3 class="title-headline"><?php echo $headline; ?></h3>

            <div class="copy copy-2">
                <?php echo $copy; ?>
            </div>
        </div>

        <div class="progress-timeline">
            <div class="js-progress-timeline">
                <?php if(have_rows('progress_timeline')): while(have_rows('progress_timeline')): the_row(); ?>
                
                    <div class="entry">
                        <div class="entry-wrapper">

                            <?php $image = get_sub_field('photo'); if( $image ): ?>
                                <div class="photo">
                                    <?php echo wp_get_attachment_image($image['ID'], 'full'); ?>
                                </div>
                            <?php endif; ?>

                            <div class="info">
                                <div class="year">
                                    <h4><?php the_sub_field('year'); ?></h4>
                                </div>

                                <div class="details copy copy-3 extended">
                                    <?php the_sub_field('copy'); ?>
                                </div>  
                            </div>

                        </div>                  
                    </div>

                <?php endwhile; endif; ?>
            </div>
        </div>

    </section>

<?php endwhile; endif; ?>