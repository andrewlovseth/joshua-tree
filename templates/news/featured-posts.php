<?php

    $news_id = get_option('page_for_posts'); 
    $featured_posts = get_field('featured_posts', $news_id);

if( $featured_posts ): ?>

    <section class="featured-posts grid">
        <div class="featured-grid">
            <?php $count =1; foreach( $featured_posts as $p ): ?>
                <?php
                    $article_class = 'news-item featured-' . $count;
                ?>

                <article <?php post_class($article_class, $p->ID); ?>>
                    <div class="photo">
                        <div class="content">
                            <a href="<?php echo get_permalink( $p->ID ); ?>">
                                <?php echo get_the_post_thumbnail( $p->ID, 'large' ); ?>
                            </a>
                        </div>
                    </div>

                    <div class="info">
                        <div class="info__wrapper">
                            <em class="date"><?php the_time('F j, Y'); ?></em>
    
                            <div class="headline">
                                <h3 class="title-headline small">
                                    <a href="<?php echo get_permalink( $p->ID ); ?>">
                                        <?php echo get_the_title( $p->ID ); ?>
                                    </a>
                                </h3>
                            </div>

                            <div class="excerpt copy copy-2">
                                <?php echo get_the_excerpt($p->ID); ?>
                            </div>

                            <div class="cta">
                                <a href="<?php echo get_permalink( $p->ID ); ?>" class="btn btn-teal">Read More</a>
                            </div>
                        </div>
                    </div>                    
                </article>
            <?php $count++; endforeach; ?>
        </div>
    </section>

<?php endif; ?>