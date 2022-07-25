<?php

    $cta = get_field('cta');
    $headline = $cta['headline'];
    $link = $cta['link'];

?>

<section class="platforms-cta grid">

    <div class="cta">
        <?php 
	if( $link ): 
	$link_url = $link['url'];
	$link_title = $link['title'];
	$link_target = $link['target'] ? $link['target'] : '_self';
 ?>

        <h3><?php echo $headline; ?></h3>

 		<a class="btn" href="<?php echo esc_url($link_url); ?>" target="<?php echo esc_attr($link_target); ?>"><?php echo esc_html($link_title); ?></a>
 	</div>

    <?php endif; ?>

</section>