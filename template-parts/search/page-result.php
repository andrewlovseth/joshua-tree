<?php
if ($post->post_parent)	{
	$ancestors=get_post_ancestors($post->ID);
	$root=count($ancestors)-1;
	$parent = $ancestors[$root];
} else {
	$parent = $post->ID;
}
?>

<article class="search-result-item page">
	<div class="info">
		<div class="type">
			<h5><?php echo get_the_title($parent); ?></h5>
		</div>

		<div class="headline">
			<h4 class="title-headline small"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
		</div>
		

		<?php 
			if ( function_exists( 'get_field' ) ) {
				$pid = get_post();
				if ( has_blocks( $pid ) ) {
					$blocks = parse_blocks( $pid->post_content );

					foreach ( $blocks as $block ) {
						if ( $block['blockName'] === 'acf/page-header' ) {
							$deck = $block['attrs']['data']['deck'];
							echo '<div class="copy copy-2">' . wp_trim_words($deck, 30, '...') . '</div>';
						}
					}
				}
			}
		?>

	</div>

</article>