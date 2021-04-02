<?php 
    $about = get_field('about');
    $headline = $about['headline'];
    $photo = $about['photo'];
?>

<section class="about grid">

    <div class="headline">
        <h1><?php echo $headline; ?></h1>
    </div>

    <?php if($photo): ?>
        <div class="photo">
            <?php echo wp_get_attachment_image( $photo['id'], 'full' ); ?>
        </div>
    <?php endif; ?>
    
</section>