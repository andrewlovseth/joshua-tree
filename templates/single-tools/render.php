<?php

    /**
     * Interactive render slot — the custom component mounts here at runtime.
     * Only interactive tools carry this section. In-development tools show an
     * "In development" status inside the slot (a CTA state, not a badge stripe).
     */

    $type = get_field('tool_type');
    if( $type !== 'interactive' ) {
        return;
    }

    $slug = get_field('interactive_slug');
    $status = get_field('status');

?>

<section class="tool-render grid">
    <div class="tool-render-slot" data-tool-type="interactive" data-interactive-slug="<?php echo esc_attr($slug); ?>">
        <div class="tool-render-slot__ring" aria-hidden="true">
            <span class="tool-render-slot__hub"></span>
        </div>
        <div class="tool-render-slot__meta">
            <h3 class="title-headline x-small">Interactive tool mounts here</h3>
            <p class="copy-2">The interactive component renders into this slot at runtime.<?php if( $slug ): ?> Mount point: <code>tool_type=interactive</code> &middot; <code>interactive_slug=<?php echo esc_html($slug); ?></code>.<?php endif; ?></p>

            <?php if( $status === 'in-development' ): ?>
                <p class="tool-render-slot__status">In development</p>
            <?php endif; ?>
        </div>
    </div>
</section>
