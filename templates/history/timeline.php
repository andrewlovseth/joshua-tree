<?php if(have_rows('timeline')): ?>
    <section class="timeline grid">

        <?php while(have_rows('timeline')) : the_row(); ?>

            <?php if( get_row_layout() == 'event' ): ?>

                <div class="event">
                    <div class="date copy-1 ">
                        <h5><?php the_sub_field('date'); ?></h5>
                    </div>

                    <div class="copy-2 description">
                        <?php the_sub_field('description'); ?>
                    </div>
                </div>
            <?php endif; ?>

        <?php endwhile; ?>

    </section> 
<?php endif; ?>