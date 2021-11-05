<article class="search-result-item post">
	<div class="info">
		<div class="type">
			<h5>News & Ideas</h5>
		</div>

		<div class="headline">
			<h4 class="title-headline small"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
		</div>

		<div class="copy copy-2">
			<?php echo wp_trim_words( get_the_content(), 30, '...' ); ?>
			<em class="date">&mdash; <?php the_time('F j, Y'); ?></em>
		</div>
		
	</div>

</article>