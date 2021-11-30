<?php
    $esa = get_field('esa');
    $copy = $esa['copy'];
    $people = $esa['people'];
    $photos = $esa['photos'];
    
    if(have_rows('esa')): while(have_rows('esa')): the_row();
?>

    <section class="esa grid">
        <div class="esa-grid">
            <div class="message copy copy-1">
                <div class="wrapper">
                    <div class="logo">
                        <img src="<?php $image = get_field('logo_white', 'options'); echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
                    </div>
                
                    <p><?php echo $copy; ?></p>
                </div>
            </div>

            <?php if(have_rows('ctas')): $count = 1; while(have_rows('ctas')): the_row(); ?>
                <div class="cta cta-<?php echo $count; ?>">
                    <?php 
                        $link = get_sub_field('link');
                        if( $link ): 
                        $link_url = $link['url'];
                        $link_title = $link['title'];
                        $link_target = $link['target'] ? $link['target'] : '_self';
                    ?>

                        <a href="<?php echo esc_url($link_url); ?>" target="<?php echo esc_attr($link_target); ?>">
                            <div class="wrapper">
                                <h4 class="title-headline x-small"><?php echo esc_html($link_title); ?></h4>

                                <div class="copy copy-3">
                                    <p><?php the_sub_field('copy'); ?></p>
                                </div>

                                <span class="more">Learn More</span>
                            </div>
                        </a>

                    <?php endif; ?>
                </div>
            <?php $count++; endwhile; endif; ?>


            <?php if( $people ): ?>
                <?php $count = 1; foreach( $people as $p ): ?>
                    <div class="people people-<?php echo $count; ?>">
                        <a href="<?php echo get_permalink( $p->ID ); ?>">
                            <div class="photo">
                                <?php echo get_the_post_thumbnail($p->ID); ?>
                            </div>

                            <div class="info">
                                <div class="headline">
                                    <h4><?php echo get_the_title( $p->ID ); ?></h4>
                                </div>
                            </div>
                        
                        </a>
                    </div>
                <?php $count++; endforeach; ?>
            <?php endif; ?>

            <?php if( $photos ): ?>
                <?php $count = 1; foreach( $photos as $photo ): ?>
                    <div class="photo photo-<?php echo $count; ?>">
                        <?php echo wp_get_attachment_image($photo['ID'], 'full'); ?>
                    </div>
                <?php $count++; endforeach; ?>
            <?php endif; ?>
        
        </div>

        <?php get_template_part('templates/new-home/join-us'); ?>
    </section>

<?php endwhile; endif; ?>
