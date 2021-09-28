<section class="offices grid">

    <div class="section-header">
        <h3 class="section-headline small"><?php the_field('offices_headline'); ?></h3>
    </div>

    <div class="four-col-grid">
        <?php if(have_rows('offices')): while(have_rows('offices')) : the_row(); ?>

            <?php if( get_row_layout() == 'office' ): ?>

                <div class="office">
                    <div class="headline">
                        <h4><?php the_sub_field('name'); ?></h4>
                    </div>

                    <div class="copy copy-3">
                        <p>
                            <?php if(get_sub_field('address')): ?>
                                <?php the_sub_field('address'); ?><br/>
                            <?php endif; ?>

                            <?php if(get_sub_field('phone')): ?>
                                <?php the_sub_field('phone'); ?><br/>
                            <?php endif; ?>

                            <?php if(get_sub_field('map_link')): ?>
                                <a href="<?php the_sub_field('map_link'); ?>" rel="external">Map>></a>
                            <?php endif; ?>
                        </p>
                    </div>
                    
                    
                </div>

            <?php endif; ?>

        <?php endwhile; endif; ?>
    </div>

</section>