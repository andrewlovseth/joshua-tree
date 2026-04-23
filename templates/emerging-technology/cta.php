<?php

    $cta = get_field('cta');
    if( !$cta ) return;

    $eyebrow = $cta['eyebrow'];
    $headline_lead = $cta['headline_lead'];
    $headline_accent = $cta['headline_accent'];
    $copy = $cta['copy'];
    $button = $cta['button'];
    $optin_slug = $cta['optin_slug'] ?? '';

?>

<section class="et-cta grid">
    <div class="et-cta__container ">

        <?php if( $eyebrow ): ?>
            <p class="eyebrow"><?php echo esc_html($eyebrow); ?></p>
        <?php endif; ?>

        <?php if( $headline_lead || $headline_accent ): ?>
            <h2 class="et-cta-headline">
                <?php if( $headline_lead ): ?>
                    <span class="headline-lead"><?php echo esc_html($headline_lead); ?></span>
                <?php endif; ?>
                <?php if( $headline_accent ): ?>
                    <span class="headline-accent"><?php echo esc_html($headline_accent); ?></span>
                <?php endif; ?>
            </h2>
        <?php endif; ?>

        <?php if( $copy ): ?>
            <div class="et-cta-copy copy-2">
                <?php echo $copy; ?>
            </div>
        <?php endif; ?>

        <?php
            if( $button ):
                $button_title = $button['title'];
                $is_modal = !empty($optin_slug);
                // The WP OptinMonster plugin auto-detects links with this URL pattern
                // and converts them into modal triggers on page load.
                $modal_url = 'https://app.monstercampaigns.com/c/' . $optin_slug . '/';
        ?>
            <div class="et-cta-actions cta">
                <?php if( $is_modal ): ?>
                    <a class="btn btn-teal" href="<?php echo esc_url($modal_url); ?>"><?php echo esc_html($button_title); ?></a>
                <?php else: ?>
                    <a class="btn btn-teal" href="<?php echo esc_url($button['url']); ?>" target="<?php echo esc_attr($button['target'] ?: '_self'); ?>"><?php echo esc_html($button_title); ?></a>
                <?php endif; ?>
            </div>
        <?php endif; ?>

    </div>
</section>
