<?php

$search_term = get_search_query();
$search = new WP_Query("s=$search_term&showposts=-1"); 
$count = $search->post_count;

get_header(); ?>

	<section class="archived-posts search-results grid">

        <section class="page-header">
            <h1 class="page-title">Search Results: <?php echo $search_term; ?></h1>
        </section>

        <section class="search-form-wrapper grid">
            <form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">
                <label>
                    <input type="search" class="search-field"
                        data-swplive="true"
                        placeholder="<?php echo esc_attr_x( 'Search', 'placeholder' ) ?>"
                        value="<?php echo get_search_query() ?>" name="s"
                        title="<?php echo esc_attr_x( 'Search for:', 'label' ) ?>" />
                </label>
                <input type="submit" class="search-submit"
                    value="<?php echo esc_attr_x( 'Search', 'submit button' ) ?>" />
            </form>
        </section>

        <?php if($count > 0): ?>
            <section class="results-count">
                <p><?php echo $count; ?> Results</p>
            </section>                
        <?php endif; ?>

		<div class="search-results-list">


			<?php if ( have_posts() ): ?>
                <?php while ( have_posts() ): the_post(); ?>

                    <?php if(get_post_type() == 'post' ): ?>

                        <?php get_template_part('template-parts/search/post-result'); ?>

                    <?php elseif(get_post_type() == 'page' ): ?>

                        <?php get_template_part('template-parts/search/page-result'); ?>

                    <?php elseif(get_post_type() == 'market' ): ?>
                        
                        <?php get_template_part('template-parts/search/market-result'); ?>

                    <?php elseif(get_post_type() == 'projects' ): ?>
                       
                        <?php get_template_part('template-parts/search/project-result'); ?>

                    <?php elseif(get_post_type() == 'service' ): ?>
                        
                        <?php get_template_part('template-parts/search/service-result'); ?>

                    <?php else: ?>

                        <?php get_template_part('template-parts/search/generic-result'); ?>

                    <?php endif; ?>           

    			<?php endwhile; ?>

            <?php else: ?>

                <article class="no-results">
                    <div class="info">
                        <div class="headline">
                            <h4 class="title-headline small">No results. Try another search.</h4>
                        </div>
                    </div>
                </article>                

            <?php endif; ?>

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
		</div>

	</section>

<?php get_footer(); ?>