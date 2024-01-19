<?php

/*
    Template Name: Making Waves
*/

get_header(); ?>

    <div class="making-waves-header">
        <div class="headline">
            <h1 class="page-title"><?php echo get_field('headline'); ?></h1>
            <h2 class="title-headline"><?php echo get_field('sub_headline'); ?></h2>
        </div>

        <div class="copy copy-1">
            <p><?php echo get_field('copy'); ?></p>
        </div>        
    </div>

    <div class="making-waves-body" style="background-image: url(<?php $bg_image = get_field('form_background_image'); echo $bg_image['url']; ?>);">
        <div class="sign-up-form">
            <?php echo get_field('form'); ?>
        </div>
    </div>

<?php get_footer(); ?>