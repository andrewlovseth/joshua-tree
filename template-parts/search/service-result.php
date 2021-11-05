<article class="service">
    <div class="info">
        <div class="type">
            <h5><?php echo get_post_type(); ?></h5>
        </div>

        <div class="headline">
            <h4 class="title-headline small"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
        </div>

		<div class="copy copy-2">
			<p><?php echo wp_trim_words( get_field('about_copy'), 30, '...' ); ?></p>

            <div class="cta">
                <a href="<?php the_permalink(); ?>" class="underline">Learn more</a>
            </div>

		</div>
    </div>
</article>