<?php

    $news = get_field('news');
    if($news):

?>

    <section class="news grid">
        <div class="section-header">
            <h3 class="section-headline small">News & Ideas</h3>
        </div>

        <div class="news-slider-wrapper">
            <div class="news-slider">

                <?php foreach( $news as $news_item ): ?>
                    <div class="news-item">
                        <div class="photo">
                            <div class="content">
                                <a href="<?php echo get_permalink( $news_item->ID ); ?>">
                                    <?php echo get_the_post_thumbnail( $news_item->ID, 'large' ); ?>
                                </a>
                            </div>
                        </div>

                        <div class="info">
                            <div class="info__wrapper">
                                <div class="headline">
                                    <h3 class="title-headline small">
                                        <a href="<?php echo get_permalink( $news_item->ID ); ?>">
                                            <?php echo get_the_title( $news_item->ID ); ?>
                                        </a>
                                    </h3>
                                </div>

                                <div class="excerpt copy copy-2">
                                    <?php echo get_the_excerpt($news_item->ID); ?>
                                </div>

                                <div class="cta">
                                    <a href="<?php echo get_permalink( $news_item->ID ); ?>" class="btn btn-teal">Read More</a>
                                </div>
                            </div>
                        </div>                    
                    </div>
                <?php endforeach; ?>

            </div>
        </div>



    </section>

<?php endif; ?>