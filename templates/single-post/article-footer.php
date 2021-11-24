<?php

$searchwp_related = new SearchWP_Related();

// Use the keywords as defined in the SearchWP Related meta box
$keywords = get_post_meta( get_the_ID(), $searchwp_related->meta_key, true );

$args = array(
  's'              => $keywords,  // The stored keywords to use
  'engine'         => 'default',  // the SearchWP engine to use
  'posts_per_page' => 6,
  'post_type'      => 'post'

);

// Retrieve Related content for the current post
$related_content = $searchwp_related->get( $args );

// Returns an array of Post objects for you to loop through
//print_r( $related_content );
if($related_content): ?>

    <section class="news grid">
        <div class="section-header">
            <h3 class="section-headline small">Related News & Ideas</h3>
        </div>
    
        <div class="news-grid">
            <?php foreach ( $related_content as $post ) : setup_postdata( $post ); ?>

                <article <?php post_class('news-item'); ?>>
                    <div class="photo">
                        <div class="content">
                            <a href="<?php the_permalink(); ?>">
                                <?php echo get_the_post_thumbnail( $post->ID, 'large' ); ?>
                            </a>
                        </div>
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
                                <a href="<?php the_permalink(); ?>" class="underline">Read More</a>
                            </div>
                        </div>
                    </div>
                </article>
        
            <?php endforeach; ?>
        </div>
    </section>

<?php endif; wp_reset_postdata(); ?>

<section class="article-footer grid back">
    <div class="cta">
        <a class="btn btn-green" href="<?php echo site_url('/news-and-ideas/'); ?>">News & Ideas</a>
    </div>
</section>