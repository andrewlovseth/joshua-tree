<article class="search-result-item post">

	<div class="photo">
		<div class="content">
			<a href="<?php the_permalink(); ?>">
				<?php the_post_thumbnail(); ?>
			</a>								
		</div>
	</div>

	<div class="info">
		<div class="type">
			<h5>News & Ideas</h5>
		</div>

		<div class="headline">
			<h4 class="title-headline small"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
		</div>

		<div class="copy copy-3">
			<?php echo wp_trim_words( get_the_content(), 15, '...' ); ?>
		</div>
		
	</div>

</article>