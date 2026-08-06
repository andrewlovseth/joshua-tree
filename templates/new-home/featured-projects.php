<?php

    $posts = get_field('featured_projects');
    if( $posts ):

?>

    <section class="featured-projects grid">

        <div class="slider-wrapper">
            <div class="js-featured-projects-slider">

                <?php foreach( $posts as $p ):
                    $card = esa_featured_work_card( $p->ID );
                ?>
                    <div class="project<?php echo $p->post_type === 'service' ? ' project--service' : ''; ?>">
                        <div class="photo">
                            <?php if( $card['image_id'] ): ?>
                                <a href="<?php echo $card['permalink']; ?>" aria-label="<?php echo $card['title']; ?>" title="<?php echo $card['title']; ?>"><?php echo wp_get_attachment_image($card['image_id'], 'full'); ?></a>
                            <?php endif; ?>
                        </div>

                        <div class="info">
                            <div class="info-wrapper">

                                <?php if( $card['eyebrow'] ):
                                    $label = $card['eyebrow']['url']
                                        ? '<a href="' . esc_url( $card['eyebrow']['url'] ) . '">' . $card['eyebrow']['text'] . '</a>'
                                        : $card['eyebrow']['text'];
                                ?>
                                    <div class="market">
                                        <span class="label"><?php echo $label; ?></span>
                                    </div>
                                <?php endif; ?>


                                <div class="headline">
                                    <h3 class="title-headline"><a href="<?php echo $card['permalink']; ?>"><?php echo $card['title']; ?></a></h3>
                                </div>

                                <?php if( $card['meta'] ): ?>
                                    <div class="location">
                                        <h4><?php echo $card['meta']; ?></h4>
                                    </div>
                                <?php endif; ?>

                                <?php if( $card['copy'] ): ?>
                                    <div class="copy copy-2">
                                        <?php echo $card['copy']; ?>
                                    </div>
                                <?php endif; ?>

                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

            </div>
        </div>
    </section>

<?php endif; ?>
