<?php

    /**
     * Tool detail intro — mirrors templates/single-service/service-info.php.
     * Tool-type line reads as a plain sentence-case line (type · category),
     * followed by the about copy from the post editor (the_content).
     */

    $type = get_field('tool_type');
    $category = get_field('category');

    $type_labels = array(
        'link'           => 'Link',
        'interactive'    => 'Interactive tool',
        'gated-database' => 'Gated database',
    );
    $type_label = isset($type_labels[$type]) ? $type_labels[$type] : '';

    $type_line = $type_label;
    if( $category ) {
        $type_line = $type_line ? $type_label . ' &middot; ' . esc_html($category) : esc_html($category);
    }

?>

<section class="service-info grid">
    <div class="about">
        <div class="copy-2 extended about__main">
            <?php if( $type_line ): ?>
                <p class="tool-type-line"><?php echo $type_line; ?></p>
            <?php endif; ?>

            <?php the_content(); ?>
        </div>
    </div>
</section>
