<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
	
	<header class="site-header grid">
		<div class="nav-wrapper">
			<?php get_template_part('template-parts/header/logo'); ?>
			<?php get_template_part('template-parts/header/navigation'); ?>
			<?php get_template_part('template-parts/header/search'); ?>
			<?php get_template_part('template-parts/header/hamburger'); ?>		
		</div>


		<?php get_template_part('template-parts/header/work-navigation'); ?>
	</header>

	<?php get_template_part('template-parts/header/mobile-navigation'); ?>

	<?php get_template_part('template-parts/header/search-navigation'); ?>


	<main class="site-content">