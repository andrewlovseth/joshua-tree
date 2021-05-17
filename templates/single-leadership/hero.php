<section class="leadership-hero grid">
    <div class="photo">
        <?php $image = get_field('info_hero_photo'); if( $image ): ?>
            <?php echo wp_get_attachment_image($image['ID'], 'full'); ?>
        <?php endif; ?>    
    </div>

    <div class="page-header">
        <h1 class="page-title"><?php the_title(); ?></h1>
    </div>
</section>