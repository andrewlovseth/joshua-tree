<?php

    /**
     * Single tool card — shared renderer for the Tools & Resources module.
     * Reuses the .project card chrome; the .photo slot becomes an icon panel.
     * Expects a normalized $args['tool'] array with keys:
     *   type, status, category, title, blurb, href, external (bool), icon_html
     */

    $tool = isset($args['tool']) ? $args['tool'] : null;
    if( ! $tool ) {
        return;
    }

    $type = $tool['type'];
    $status = $tool['status'];
    $external = ! empty($tool['external']);
    $in_dev = ( $status === 'in-development' );

    $modifier = ( $type === 'link' ) ? 'tool-card--link' : 'tool-card--interactive';

    $classes = array('project', 'tool-card', $modifier);
    if( $in_dev ) {
        $classes[] = 'is-in-development';
    }

    // CTA state — a call-to-action, never a badge stripe.
    if( $in_dev ) {
        $cta_class = 'tool-card__cta tool-card__cta--dev';
        $cta_label = 'In development';
    } elseif( $external ) {
        $cta_class = 'tool-card__cta tool-card__cta--ext';
        $cta_label = 'Open tool';
    } else {
        $cta_class = 'tool-card__cta';
        $cta_label = 'Open tool';
    }

    $target = $external ? ' target="_blank" rel="noopener"' : '';

?>

<div class="<?php echo esc_attr(implode(' ', $classes)); ?>">
    <a href="<?php echo esc_url($tool['href']); ?>"<?php echo $target; ?>>
        <div class="photo tool-card__icon">
            <?php echo $tool['icon_html']; ?>
        </div>
        <div class="info">
            <div class="info__wrapper">
                <?php if( $tool['category'] ): ?>
                    <div class="market">
                        <h4><?php echo esc_html($tool['category']); ?></h4>
                    </div>
                <?php endif; ?>

                <div class="headline">
                    <h3 class="title-headline small"><?php echo esc_html($tool['title']); ?></h3>
                </div>

                <?php if( $tool['blurb'] ): ?>
                    <p class="tool-card__blurb"><?php echo esc_html($tool['blurb']); ?></p>
                <?php endif; ?>

                <span class="<?php echo esc_attr($cta_class); ?>"><?php echo esc_html($cta_label); ?></span>
            </div>
        </div>
    </a>
</div>
