<?php

    /**
     * Tools & Resources module — service-page peer to Featured Projects.
     * Mirrors templates/single-service/featured-projects.php + grid.php.
     *
     * Reads the `tools` relationship on the Service (get_field('tools')) and
     * renders each via templates/single-service/tool-card.php.
     *
     * PLACEHOLDER: until Veronica's real tool inventory lands, the module
     * falls back to a clearly-marked mock set drawn from the 5/18 web-tools
     * session so the design is demonstrable. Delete the $placeholder_tools
     * block (and its branch below) once real Tools are attached to services.
     */

    $related_tools = get_field('tools');
    $cards = array();

    if( $related_tools ) {

        foreach( $related_tools as $tool_post ) {

            $id = $tool_post->ID;
            $type = get_field('tool_type', $id);
            $status = get_field('status', $id);
            $external_url = get_field('external_url', $id);
            $meta = get_field('meta', $id);
            $icon = ( $meta && ! empty($meta['icon']) ) ? $meta['icon'] : null;

            // Link tools route straight out; interactive / gated tools open a detail page.
            if( $type === 'link' ) {
                $href = $external_url ? $external_url : get_permalink($id);
                $external = (bool) $external_url;
            } else {
                $href = get_permalink($id);
                $external = false;
            }

            // Inline the uploaded SVG icon when present, else a default line icon.
            if( $icon && isset($icon['url']) && strpos($icon['mime_type'], 'svg') !== false ) {
                $icon_html = esa_svg($icon['url']);
            } elseif( $icon && isset($icon['ID']) ) {
                $icon_html = wp_get_attachment_image($icon['ID'], 'thumbnail');
            } else {
                $icon_html = esa_tool_icon_svg('default');
            }

            $cards[] = array(
                'type'      => $type,
                'status'    => $status,
                'category'  => get_field('category', $id),
                'title'     => get_the_title($id),
                'blurb'     => get_field('summary', $id),
                'href'      => $href,
                'external'  => $external,
                'icon_html' => $icon_html,
            );
        }

    } else {

        // ── PLACEHOLDER mock tools (5/18 inventory) — remove when real Tools exist ──
        $placeholder_tools = array(
            array( 'type' => 'link',           'status' => 'live',           'category' => 'Federal · NEPA',                     'title' => 'Permitting Policy Tracker',      'blurb' => 'Live tracking of federal permitting and environmental-review policy.', 'href' => 'https://policytracker.esassoc.com/',       'external' => true,  'icon' => 'chart' ),
            array( 'type' => 'link',           'status' => 'live',           'category' => 'Federal · NEPA',                     'title' => 'NEPA Assignment Navigator',      'blurb' => 'See how NEPA assignment applies to your state or project.',            'href' => 'https://esassoc.com/nepa-assignment-navigator/', 'external' => true,  'icon' => 'layers' ),
            array( 'type' => 'link',           'status' => 'live',           'category' => 'Federal · NEPA · Permitting',        'title' => 'CE Virtual Assistant',           'blurb' => 'AI assistant for scoping categorical exclusions under NEPA.',          'href' => 'https://esassoc.com/ce-virtual-assistant/', 'external' => true,  'icon' => 'bulb' ),
            array( 'type' => 'gated-database', 'status' => 'live',           'category' => 'Biological Resources',               'title' => 'Potential-to-Occur Database',    'blurb' => 'Species potential-to-occur lookup (ESA login).',                       'href' => '#',                                        'external' => false, 'icon' => 'pin' ),
            array( 'type' => 'interactive',    'status' => 'in-development',  'category' => 'Biological Resources',               'title' => 'Species Survey Calendar',        'blurb' => 'Interactive wheel of seasonal survey windows for protected species.',  'href' => '#',                                        'external' => false, 'icon' => 'clock' ),
        );

        foreach( $placeholder_tools as $pt ) {
            $pt['icon_html'] = esa_tool_icon_svg($pt['icon']);
            $cards[] = $pt;
        }
    }

    if( ! $cards ) {
        return;
    }

?>

<section class="more-projects tools-module grid">
    <div class="section-header">
        <h3 class="section-headline small">Tools &amp; Resources</h3>
    </div>

    <div class="projects projects-grid">
        <?php foreach( $cards as $card ): ?>
            <?php get_template_part('templates/single-service/tool-card', null, array( 'tool' => $card )); ?>
        <?php endforeach; ?>
    </div>
</section>
