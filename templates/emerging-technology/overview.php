<?php

    $overview = get_field('overview');
    if( !$overview ) return;

    $graphic = $overview['graphic'];
    $lede = $overview['lede'];
    $callout = $overview['callout'];
    $button = $overview['button'];
    $optin_slug = $overview['optin_slug'] ?? '';

?>

<section class="et-overview grid">

    <div class="et-overview__container">

        <?php if( $graphic ): ?>
            <div class="et-overview-graphic">
                <?php echo wp_get_attachment_image($graphic['ID'], 'medium'); ?>
            </div>
        <?php endif; ?>

        <div class="et-overview-body">

            <?php if( $lede ): ?>
                <div class="et-overview-lede copy-2 extended">
                    <?php echo $lede; ?>
                </div>
            <?php endif; ?>

            <?php
                $has_callout = $callout && !empty($callout['text']);
                $has_button = !empty($button);
                if( $has_callout || $has_button ):
            ?>
                <div class="et-overview-actions-row">

                    <?php if( $has_callout ): ?>
                        <blockquote class="et-overview-callout">
                            <?php echo $callout['text']; ?>
                        </blockquote>
                    <?php endif; ?>

                    <?php
                        if( $has_button ):
                            $button_title = $button['title'];
                            $is_modal = !empty($optin_slug);
                            // The WP OptinMonster plugin auto-detects links with this URL pattern
                            // and converts them into modal triggers on page load.
                            $modal_url = 'https://app.monstercampaigns.com/c/' . $optin_slug . '/';
                    ?>
                        <div class="et-overview-actions cta">
                            <?php if( $is_modal ): ?>
                                <a class="btn btn-sm btn-teal" href="<?php echo esc_url($modal_url); ?>"><?php echo esc_html($button_title); ?></a>
                            <?php else: ?>
                                <a class="btn btn-sm btn-teal" href="<?php echo esc_url($button['url']); ?>" target="<?php echo esc_attr($button['target'] ?: '_self'); ?>"><?php echo esc_html($button_title); ?></a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                </div>
            <?php endif; ?>

        </div>

    </div>

</section>
