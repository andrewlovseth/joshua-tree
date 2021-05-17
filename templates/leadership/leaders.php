<section class="leaders grid">

    <div class="leaders-grid">
        <?php $leaders = get_field('leaders'); if( $leaders ): ?>
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

</section>