<?php

    $approach = get_field('approach');
    if( !$approach ) return;

    $eyebrow = $approach['eyebrow'];
    $headline = $approach['headline'];
    $copy = $approach['copy'];
    $steps = $approach['steps'];
    $callout = $approach['callout'];

?>

<section class="et-approach grid">

    <?php if( $eyebrow || $headline || $copy ): ?>
        <div class="section-header">
            <?php if( $eyebrow || $headline ): ?>
                <div class="section-header-title">
                    <?php if( $eyebrow ): ?>
                        <p class="eyebrow"><?php echo esc_html($eyebrow); ?></p>
                    <?php endif; ?>
                    <?php if( $headline ): ?>
                        <h2 class="section-headline"><?php echo esc_html($headline); ?></h2>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            <?php if( $copy ): ?>
                <div class="section-copy copy-2 extended">
                    <?php echo $copy; ?>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <?php if( $steps ): ?>
        <div class="approach-steps four-col-grid">
            <?php $i = 1; foreach( $steps as $step ): ?>
                <div class="approach-step">
                    <?php if( !empty($step['icon']) ): ?>
                        <div class="step-icon">
                            <?php echo wp_get_attachment_image($step['icon']['ID'], 'medium'); ?>
                        </div>
                    <?php endif; ?>
                    <span class="step-number">Step <?php echo $i; ?></span>
                    <h3 class="step-title"><?php echo esc_html($step['title']); ?></h3>
                    <p class="step-desc"><?php echo esc_html($step['description']); ?></p>
                </div>
            <?php $i++; endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if( $callout && !empty($callout['text']) ): ?>
        <aside class="et-approach-callout">
            <?php if( !empty($callout['eyebrow']) ): ?>
                <p class="eyebrow"><?php echo esc_html($callout['eyebrow']); ?></p>
            <?php endif; ?>
            <p class="callout-text"><?php echo esc_html($callout['text']); ?></p>
        </aside>
    <?php endif; ?>

</section>
