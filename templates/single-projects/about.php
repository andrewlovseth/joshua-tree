<?php if(have_rows('about')): ?>

    <section class="about">

        <?php while(have_rows('about')) : the_row(); ?>

            <?php if( get_row_layout() == 'section' ): ?>

                <div class="content-section">
                    <div class="headline">
                        <h3 class="section-headline small"><?php echo get_sub_field('headline'); ?></h3>
                    </div>

                    <div class="copy copy-2 extended">
                        <?php echo get_sub_field('copy'); ?>
                    </div>                    
                </div>

            <?php endif; ?>

        <?php endwhile; ?>

    </section>

<?php endif; ?>