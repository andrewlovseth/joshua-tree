<?php if(have_rows('details')): ?>

    <section class="details grid">
        <div class="two-col-grid">
   
            <?php while(have_rows('details')): the_row(); ?>

                <div class="col copy copy-2">
                    <?php the_sub_field('copy'); ?>
                </div>

            <?php endwhile; ?>

        </div>
    </section>

<?php endif; ?>