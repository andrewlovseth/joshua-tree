<?php
/**
 * JSON-LD Schema Functions
 *
 * Helper functions for generating structured data for SEO.
 */

/**
 * Build an ImageObject schema from an attachment ID or ACF image array.
 *
 * @param int|array $image Attachment ID or ACF image array.
 * @return array|null ImageObject schema array or null if invalid.
 */
function esa_schema_image_object($image) {
    if (empty($image)) {
        return null;
    }

    // Handle ACF image array
    if (is_array($image)) {
        if (empty($image['url'])) {
            return null;
        }
        return [
            '@type' => 'ImageObject',
            'url' => $image['url'],
            'width' => $image['width'] ?? null,
            'height' => $image['height'] ?? null,
        ];
    }

    // Handle attachment ID
    if (is_numeric($image)) {
        $url = wp_get_attachment_url($image);
        if (!$url) {
            return null;
        }
        $metadata = wp_get_attachment_metadata($image);
        return [
            '@type' => 'ImageObject',
            'url' => $url,
            'width' => $metadata['width'] ?? null,
            'height' => $metadata['height'] ?? null,
        ];
    }

    return null;
}

/**
 * Clean text by stripping HTML and truncating to max length.
 *
 * @param string $text Text to clean.
 * @param int $max_length Maximum length (default 300).
 * @return string Cleaned text.
 */
function esa_schema_clean_text($text, $max_length = 300) {
    if (empty($text)) {
        return '';
    }

    // Strip HTML tags
    $text = wp_strip_all_tags($text);

    // Decode HTML entities
    $text = html_entity_decode($text, ENT_QUOTES, 'UTF-8');

    // Normalize whitespace
    $text = preg_replace('/\s+/', ' ', $text);
    $text = trim($text);

    // Truncate if needed
    if (strlen($text) > $max_length) {
        $text = substr($text, 0, $max_length - 3) . '...';
    }

    return $text;
}

/**
 * Output JSON-LD script tag for a schema.
 *
 * @param array $schema Schema data array.
 * @return void
 */
function esa_schema_output($schema) {
    if (empty($schema)) {
        return;
    }

    echo '<script type="application/ld+json">';
    echo json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    echo '</script>' . "\n";
}

/**
 * Get Organization schema.
 *
 * @return array Organization schema data.
 */
function esa_schema_organization() {
    $data = [
        '@context' => 'https://schema.org',
        '@type' => 'Organization',
        'name' => 'Environmental Science Associates',
        'url' => home_url('/'),
    ];

    return apply_filters('esa_organization_schema_data', $data);
}

/**
 * Get WebSite schema.
 *
 * @return array WebSite schema data.
 */
function esa_schema_website() {
    return [
        '@context' => 'https://schema.org',
        '@type' => 'WebSite',
        'name' => get_bloginfo('name'),
        'url' => home_url('/'),
    ];
}
