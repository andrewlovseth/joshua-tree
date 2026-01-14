<section class="services-list-alphabetical grid">

    <div class="services-search">
        <input
            type="text"
            id="services-filter"
            placeholder="Search services..."
            aria-label="Filter services"
        >
    </div>

    <?php
    // Get all services (both parent and child) in one flat list
    $args = array(
        'post_type' => 'service',
        'posts_per_page' => -1,
        'orderby' => 'title',
        'order' => 'ASC'
    );
    $query = new WP_Query( $args );

    if ( $query->have_posts() ) : ?>
        <div class="services-columns" id="services-list">
            <p class="no-results" id="services-no-results" hidden>
                No services found matching your search.
            </p>
            <ul class="services-list-items">
                <?php while ( $query->have_posts() ) : $query->the_post(); ?>
                    <li class="service-item" data-title="<?php echo esc_attr( strtolower( get_the_title() ) ); ?>">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </li>
                <?php endwhile; ?>
            </ul>
        </div>
    <?php endif;
    wp_reset_postdata(); ?>

</section>