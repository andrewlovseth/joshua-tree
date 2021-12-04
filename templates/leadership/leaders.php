<section class="leaders grid">

    <?php if(have_rows('leadership_group')): while(have_rows('leadership_group')) : the_row(); ?>

        <?php if( get_row_layout() == 'group' ): ?>
            <div class="leadership-group">
                <div class="section-header">
                    <h3 class="section-headline small"><?php the_sub_field('header'); ?></h3>
                </div>

                <div class="leaders-grid">
                    <?php $leaders = get_sub_field('leaders'); if( $leaders ): ?>
                        <?php foreach( $leaders as $leader ): ?>
                            <div class="leader">
                                <a href="<?php echo get_permalink( $leader->ID ); ?>">
                                    <div class="photo">
                                        <img src="<?php $image = get_field('info_headshot', $leader->ID); echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
                                    </div>

                                    <div class="info">
                                        <div class="name">
                                            <h3><?php echo get_the_title( $leader->ID ); ?></h3>
                                        </div>
                                        <div class="position">
                                            <p><?php the_field('info_position', $leader->ID); ?></p>
                                        </div>
                                    </div>
                            
                            
                                </a>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>



        <?php endif; ?>

    <?php endwhile; endif; ?>

</section>