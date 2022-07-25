<section class="post-list grid">
    <div class="news-grid">

        <?php if ( have_posts() ): while ( have_posts() ): the_post(); ?>

            <article <?php post_class('news-item'); ?>>

                <div class="photo">
                    <a href="<?php the_permalink(); ?>">
                        <?php echo get_the_post_thumbnail( $post->ID, 'large' ); ?>
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
                            <a href="<?php the_permalink(); ?>" class="underline">Read More</a>
                        </div>
                    </div>
                </div>                    
            
            </article>

        <?php endwhile; endif; ?>

    </div>

    <div class="pagination">
				<?php
					global $wp_query;
						
					$big = 999999999; // need an unlikely integer
						
					echo paginate_links( array(
						'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
						'format' => '?paged=%#%',
						'current' => max( 1, get_query_var('paged') ),
						'total' => $wp_query->max_num_pages
					) );
				?>
			</div>

</section>