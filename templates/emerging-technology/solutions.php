<?php

    $solutions = get_field('solutions');
    if( !$solutions ) return;

    $eyebrow = $solutions['eyebrow'];
    $headline = $solutions['headline'];
    $copy = $solutions['copy'];
    $items = $solutions['items'];

?>

<section class="et-solutions grid">

    <?php if( $eyebrow || $headline || $copy ): ?>
        <div class="section-header">
            <?php if( $eyebrow ): ?>
                <p class="eyebrow"><?php echo esc_html($eyebrow); ?></p>
            <?php endif; ?>
            <?php if( $headline ): ?>
                <h2 class="section-headline"><?php echo esc_html($headline); ?></h2>
            <?php endif; ?>
            <?php if( $copy ): ?>
                <div class="section-copy copy-2 extended">
                    <?php echo $copy; ?>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <?php if( $items ): ?>
        <div class="solutions-grid three-col-grid">
            <?php foreach( $items as $item ): ?>
                <article class="solution-item">
                    <?php if( !empty($item['icon']) ): ?>
                        <div class="solution-header">
                            <div class="solution-icon">
                                <?php echo esa_svg($item['icon']['url']); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="solution-body">
                        <h3 class="solution-title"><?php echo esc_html($item['title']); ?></h3>
                        <p class="solution-desc"><?php echo wp_kses_post($item['description']); ?></p>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</section>
