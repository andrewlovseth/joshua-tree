<?php

    $posts = get_field('featured_projects');
    if( $posts ):
    
?>

    <section class="featured-projects grid">
        <div class="section-header">
            <h2 class="special">Our Work</h2>
        </div>

        <div class="slider-wrapper">
            <div class="projects-slider">

                <?php foreach( $posts as $p ): ?>
                    <div class="project">
                        <div class="photo">
                            <div class="content">
                                <?php $image = get_field('hero_photo', $p->ID); if( $image ): ?>
                                    <a href="<?php echo get_permalink( $p->ID ); ?>"><?php echo wp_get_attachment_image($image['ID'], 'full'); ?></a>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="info">
                            <div class="info-wrapper">

                                <?php $market = get_field('details_market', $p->ID); if($market): ?>
                                    <div class="market">
                                        <h4><a href="<?php echo get_permalink( $market ); ?>"><?php echo get_the_title($market); ?></a></h4>
                                    </div>
                                <?php endif; ?>


                                <div class="headline">
                                    <h3 class="title-headline"><a href="<?php echo get_permalink( $p->ID ); ?>"><?php echo get_the_title( $p->ID ); ?></a></h3>
                                </div>

                                <?php if(get_field('details_location', $p->ID)): ?>
                                    <div class="location">
                                        <h4><?php the_field('details_location', $p->ID); ?></h4>
                                    </div>
                                <?php endif; ?>

                                <div class="copy copy-2">
                                    <?php the_field('details_about', $p->ID); ?>
                                </div>

                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

            </div>            
        </div>
    </section>

<?php endif; ?>