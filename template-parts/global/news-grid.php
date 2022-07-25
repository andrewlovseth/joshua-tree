<?php
    $cats = get_field('news_category');
	$args = array(
		'post_type' => 'post',
		'posts_per_page' => 6,
        'category__in' => $cats 
	);
	$query = new WP_Query( $args );
	if ( $query->have_posts()): ?>

    <section class="news grid">
        <div class="section-header">
            <h3 class="section-headline small">News & Ideas</h3>
        </div>

        <div class="news-grid">
            <?php while ( $query->have_posts() ) : $query->the_post(); ?>

                <article <?php post_class('news-item'); ?>>

                    <div class="photo">
                        <a href="<?php the_permalink(); ?>">
                            <?php echo get_the_post_thumbnail( $post->ID, 'medium', array( 'alt' => 'Photo for ' . wp_strip_all_tags(get_the_title()) ) ); ?>
                        </a>
                    </div>

                    <div class="info">
                        <div class="info__wrapper">
                            <em class="date"><?php the_time('F j, Y'); ?></em>

                            <div class="headline">
                                <h3 class="title-headline x-small">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h3>
                            </div>

                            <div class="excerpt copy copy-3">
                                <p><?php echo wp_trim_words( get_the_excerpt(), 15, '...' ); ?></p>
                            </div>

                            <div class="cta">
                                <a href="<?php the_permalink(); ?>" class="underline" title="Read the article: <?php the_title(); ?>" aria-label="Read the article: <?php the_title(); ?>">Read the Article</a>
                            </div>
                        </div>
                    </div>                    

                </article>

            <?php endwhile; ?>
        </div>
    </section>

<?php endif; wp_reset_postdata(); ?>