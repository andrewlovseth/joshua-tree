<section class="employee-hero grid">
    <div class="photo">
        <?php $image = get_field('info_hero_photo'); if( $image ): ?>
            <?php echo wp_get_attachment_image($image['ID'], 'full'); ?>
        <?php else: ?>
            <img src="<?php bloginfo('template_directory'); ?>/images/placeholder-hero.jpeg" alt="Forest and stream" />
        <?php endif; ?>    
    </div>

    <div class="page-header">
        <h1 class="page-title"><?php the_title(); ?></h1>
    </div>
</section>