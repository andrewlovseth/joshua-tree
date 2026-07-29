<?php

    /**
     * Tool detail CTA — lead-capture / gated-access button.
     * Shown for in-development tools (get notified) and gated-database tools
     * (email gate). The email-gate FORM itself is a later phase — this stages
     * the button + a placeholder note only.
     */

    $type = get_field('tool_type');
    $status = get_field('status');
    $cta = get_field('cta');

    $show = ( $status === 'in-development' ) || ( $type === 'gated-database' );
    if( ! $show ) {
        return;
    }

    // Sensible defaults per the specimen when the CTA group is left blank.
    if( $status === 'in-development' ) {
        $heading = 'Get notified when it launches';
        $copy = 'Be the first to use this tool. We&rsquo;ll let you know the moment it goes live.';
        $default_label = 'Get early access';
    } else {
        $heading = 'Access the database';
        $copy = 'This resource is available to ESA clients and partners.';
        $default_label = 'Request access';
    }

    $label = ( $cta && $cta['label'] ) ? $cta['label'] : $default_label;
    $url = ( $cta && $cta['url'] ) ? $cta['url'] : '#';

?>

<section class="tool-cta grid">
    <div class="tool-cta__inner">
        <div class="tool-cta__copy">
            <h2 class="section-headline small"><?php echo esc_html($heading); ?></h2>
            <p class="copy-1"><?php echo $copy; ?></p>
        </div>
        <div class="cta">
            <a href="<?php echo esc_url($url); ?>" class="btn btn-teal"><?php echo esc_html($label); ?></a>
        </div>
        <p class="tool-cta__note">An email-gate form wraps this button in a later phase.</p>
    </div>
</section>
