<?php
    $image = get_field('logo', 'options'); 
?>

<div class="site-logo">
    <a href="<?php echo site_url('/'); ?>">
        <?php echo wp_get_attachment_image($image['ID'], 'full'); ?>
    </a>
</div>
