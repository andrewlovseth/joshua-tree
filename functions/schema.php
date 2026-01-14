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

/**
 * Get BreadcrumbList schema based on post type.
 *
 * @return array|null BreadcrumbList schema or null on front page.
 */
function esa_schema_breadcrumb() {
    // No breadcrumb on front page
    if (is_front_page()) {
        return null;
    }

    $items = [];
    $position = 1;

    // Home is always first
    $items[] = [
        '@type' => 'ListItem',
        'position' => $position++,
        'name' => 'Home',
        'item' => home_url('/'),
    ];

    // Build path based on post type
    $post_type = get_post_type();

    switch ($post_type) {
        case 'post':
            $items[] = [
                '@type' => 'ListItem',
                'position' => $position++,
                'name' => 'News',
                'item' => home_url('/news/'),
            ];
            break;

        case 'employee':
            $items[] = [
                '@type' => 'ListItem',
                'position' => $position++,
                'name' => 'About',
                'item' => home_url('/about/'),
            ];
            $items[] = [
                '@type' => 'ListItem',
                'position' => $position++,
                'name' => 'Our Team',
                'item' => home_url('/about/our-team/'),
            ];
            break;

        case 'leadership':
            $items[] = [
                '@type' => 'ListItem',
                'position' => $position++,
                'name' => 'About',
                'item' => home_url('/about/'),
            ];
            $items[] = [
                '@type' => 'ListItem',
                'position' => $position++,
                'name' => 'Leadership',
                'item' => home_url('/about/leadership/'),
            ];
            break;

        case 'service':
            $items[] = [
                '@type' => 'ListItem',
                'position' => $position++,
                'name' => 'Services',
                'item' => home_url('/services/'),
            ];
            break;

        case 'projects':
            $items[] = [
                '@type' => 'ListItem',
                'position' => $position++,
                'name' => 'Projects',
                'item' => home_url('/projects/'),
            ];
            break;
    }

    // Add current page as last item (no 'item' property per schema.org spec)
    if (is_singular()) {
        $items[] = [
            '@type' => 'ListItem',
            'position' => $position,
            'name' => get_the_title(),
        ];
    }

    return [
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => $items,
    ];
}

/**
 * Get NewsArticle schema for blog posts.
 *
 * @param int $post_id Post ID.
 * @return array NewsArticle schema data.
 */
function esa_schema_news_article($post_id) {
    $post = get_post($post_id);
    if (!$post) {
        return null;
    }

    $schema = [
        '@context' => 'https://schema.org',
        '@type' => 'NewsArticle',
        'headline' => get_the_title($post_id),
        'mainEntityOfPage' => [
            '@type' => 'WebPage',
            '@id' => get_permalink($post_id),
        ],
        'url' => get_permalink($post_id),
        'datePublished' => get_the_date('c', $post_id),
        'dateModified' => get_the_modified_date('c', $post_id),
    ];

    // Add image if post has thumbnail
    if (has_post_thumbnail($post_id)) {
        $thumbnail_id = get_post_thumbnail_id($post_id);
        $image = esa_schema_image_object($thumbnail_id);
        if ($image) {
            $schema['image'] = $image;
        }
    }

    // Get authors from ACF relationship field
    $authors = get_field('authors', $post_id);
    if ($authors && is_array($authors)) {
        $author_schemas = [];
        foreach ($authors as $author) {
            $author_schemas[] = [
                '@type' => 'Person',
                'name' => get_the_title($author->ID),
                'url' => get_permalink($author->ID),
            ];
        }
        $schema['author'] = $author_schemas;
    } else {
        // Fall back to Organization as author
        $schema['author'] = [
            '@type' => 'Organization',
            'name' => 'Environmental Science Associates',
        ];
    }

    // Publisher is always the Organization
    $schema['publisher'] = [
        '@type' => 'Organization',
        'name' => 'Environmental Science Associates',
    ];

    return $schema;
}
