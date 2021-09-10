<article class="market">
    <div class="photo">
        <div class="content">
            <?php $image = get_field('meta_photo'); if( $image ): ?>
                <?php echo wp_get_attachment_image($image['ID'], 'large'); ?>
            <?php endif; ?>
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
			<?php echo wp_trim_words( get_field('intro'), 15, '...' ); ?>
		</div>
    </div>
</article>