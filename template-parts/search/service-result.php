<article class="service">
    <div class="photo icon">
        <div class="content">
            <div class="svg">
                <?php 
                    $icon = get_field('meta_icon');
                    echo esa_svg($icon['url']);       
                ?>
            </div>
        </div>
    </div>

    <div class="info">
        <div class="type">
            <h5><?php echo get_post_type(); ?></h5>
        </div>

        <div class="headline">
            <h4 class="title-headline small"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
        </div>

		<div class="copy copy-3">
			<p><?php echo wp_trim_words( get_field('about_copy'), 30, '...' ); ?></p>

            <div class="cta">
                <a href="<?php the_permalink(); ?>" class="underline">Learn more</a>
            </div>

		</div>
    </div>
</article>