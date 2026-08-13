<?php
/**
 * Global Search API
 *
 * Powers the omnibox typeahead dropdown and the /?s= search results page.
 *
 * Architecture: esa_grouped_search() is the single source of truth for
 * grouped search across services, markets, projects, people (employee +
 * leadership), tools, news, and pages. The REST endpoint below is a thin
 * JSON wrapper around it; search.php calls it directly for server rendering.
 *
 * Matching is self-contained WP_Query (SearchWP is not involved): every
 * group matches post_title OR the _esa_search_index meta — a flattened
 * string of the post's ACF content rebuilt on every save. News and pages
 * additionally match post_content/post_excerpt. Tokens of 1-2 characters
 * ("AI") match on word boundaries so they can't hit "Air Quality" or
 * "Sustainability" as substrings; longer tokens match as substrings.
 *
 * Route: GET /wp-json/esa/v1/search?q=<term>&per_group=<int>&group=<key>
 */

/**
 * Meta key holding a post's flattened ACF-content search index.
 *
 * Underscore-prefixed so WP hides it from the Custom Fields metabox. Holds
 * every human-readable string from the post's ACF fields (titles from
 * related posts included) — and ONLY those; the post title is matched
 * separately in SQL, so a Quick Edit to the title can't desync this index.
 */
const ESA_SEARCH_INDEX_META = '_esa_search_index';

/**
 * Post types covered by search — the seven omnibox groups' sources.
 *
 * @return string[]
 */
function esa_search_post_types() {
    return array( 'service', 'market', 'projects', 'employee', 'leadership', 'tools', 'post', 'page' );
}

/**
 * Recursively collect human-readable strings from an ACF field value tree.
 *
 * Strings are tag-stripped; URLs, fragments, and emails are skipped, as are
 * subkeys that only ever hold plumbing (attachment urls, mime types, CSS
 * classes). Related WP_Post values contribute their titles, so a project
 * indexes its market and service names — searching "water" finds projects
 * related to the Water market even when the copy never says it.
 *
 * @param mixed    $value Field value (array|string|WP_Post|scalar).
 * @param string[] $out   Accumulator, appended in place.
 * @param string[] $deny  Lower-cased array keys to skip descending into.
 * @return void
 */
function esa_search_collect_strings( $value, array &$out, array $deny ) {
    if ( $value instanceof WP_Post ) {
        $out[] = get_the_title( $value );
        return;
    }

    if ( is_array( $value ) ) {
        foreach ( $value as $key => $child ) {
            if ( is_string( $key ) && in_array( strtolower( $key ), $deny, true ) ) {
                continue;
            }
            esa_search_collect_strings( $child, $out, $deny );
        }
        return;
    }

    if ( ! is_string( $value ) ) {
        return;
    }

    $text = trim( wp_strip_all_tags( $value ) );
    if ( '' === $text ) {
        return;
    }
    if ( preg_match( '#^(https?://|/|\#|mailto:|tel:)#i', $text ) || is_email( $text ) ) {
        return;
    }

    $out[] = $text;
}

/**
 * Build (and persist) a post's search index from its ACF fields.
 *
 * Walks get_fields() (formatted values) rather than a per-type field map,
 * so new field groups — like the Emerging Technology template's case
 * studies — are indexed the day they're added, with zero search-side code.
 * Idempotent; safe to call repeatedly (save hook + backfill).
 *
 * @param int $post_id Post ID.
 * @return string The index string saved to meta (may be empty).
 */
function esa_build_search_index( $post_id ) {
    $post_id = (int) $post_id;

    $deny = array( 'id', 'url', 'link', 'target', 'class', 'filename', 'subtype', 'mime_type', 'sizes', 'icon' );
    /**
     * Filters the ACF subkeys excluded from the search index walker.
     *
     * @param string[] $deny    Lower-cased keys to skip.
     * @param int      $post_id Post being indexed.
     */
    $deny = apply_filters( 'esa/search/index_deny_keys', $deny, $post_id );

    $strings = array();
    $fields  = function_exists( 'get_fields' ) ? get_fields( $post_id ) : array();
    if ( is_array( $fields ) ) {
        esa_search_collect_strings( $fields, $strings, $deny );
    }

    $index = trim( preg_replace( '/\s+/u', ' ', implode( ' ', $strings ) ) );

    update_post_meta( $post_id, ESA_SEARCH_INDEX_META, $index );

    return $index;
}

/**
 * Keep the search index fresh whenever a searchable post is saved.
 *
 * Priority 20 runs after ACF (priority 10) has written field values, so
 * get_fields() inside the builder reads the just-saved values. Title-only
 * edits (Quick Edit) don't need this — titles are matched in SQL directly.
 *
 * @param int|string $post_id Post ID being saved (ACF passes "options" etc. for non-posts).
 * @return void
 */
function esa_refresh_search_index( $post_id ) {
    if ( ! is_numeric( $post_id ) ) {
        return;
    }
    if ( ! in_array( get_post_type( (int) $post_id ), esa_search_post_types(), true ) ) {
        return;
    }

    esa_build_search_index( (int) $post_id );
}
add_action( 'acf/save_post', 'esa_refresh_search_index', 20 );

/**
 * Backfill the search index for every searchable post.
 *
 * One-time (re)build, meant for WP-CLI:
 *   wp eval 'printf( "%d posts indexed\n", esa_search_index_backfill() );'
 *
 * @return int Number of posts indexed.
 */
function esa_search_index_backfill() {
    $ids = get_posts(
        array(
            'post_type'      => esa_search_post_types(),
            'post_status'    => 'any',
            'posts_per_page' => -1,
            'fields'         => 'ids',
        )
    );

    foreach ( $ids as $id ) {
        esa_build_search_index( $id );
    }

    return count( $ids );
}

/**
 * Split a search query into word tokens for AND-of-terms (conjunctive) matching.
 *
 * Every typed word must appear somewhere in the post's title/index (in any
 * order) — "water recycling" finds "Harvest Water Recycled Water Program".
 * Capped at 10 tokens as a cheap guard against pathological queries.
 *
 * @param string $q Search term.
 * @return string[] Word tokens (empty array for an empty query).
 */
function esa_search_tokens( $q ) {
    $q = trim( (string) $q );
    if ( '' === $q ) {
        return array();
    }
    $tokens = array_values( array_filter(
        (array) preg_split( '/\s+/u', $q ),
        function ( $t ) {
            return '' !== $t;
        }
    ) );
    return array_slice( $tokens, 0, 10 );
}

/**
 * SQL boolean expression matching one token against one column.
 *
 * Tokens of 1-2 alphanumeric characters get word-boundary REGEXP matching:
 * "ai" must appear as its own word, so "AI & Emerging Technologies" matches
 * but "Air Quality" and "Sustainability" don't. The LOWER()+lowercased-token
 * pairing keeps the comparison case-insensitive on both MariaDB (local) and
 * MySQL 8 (production) regardless of their differing regex engines. Longer
 * (or non-alphanumeric) tokens use plain substring LIKE.
 *
 * @param string $column_sql Fully-qualified column reference (trusted, never user input).
 * @param string $token      One search token.
 * @return string Prepared SQL fragment.
 */
function esa_search_match_expr( $column_sql, $token ) {
    global $wpdb;

    $lower = mb_strtolower( $token );

    if ( mb_strlen( $lower ) <= 2 && ctype_alnum( $lower ) ) {
        return $wpdb->prepare(
            "LOWER({$column_sql}) REGEXP %s",
            '(^|[^a-z0-9])' . $lower . '([^a-z0-9]|$)'
        );
    }

    return $wpdb->prepare(
        "{$column_sql} LIKE %s",
        '%' . $wpdb->esc_like( $token ) . '%'
    );
}

/**
 * Build scoped posts_join / posts_where / posts_groupby / posts_orderby
 * filters for one group's query.
 *
 * The index meta is LEFT JOINed (not INNER) so posts that haven't been
 * indexed yet still match on title. One OR-group of column matches is AND'd
 * onto the WHERE per query token — conjunctive matching, so every typed word
 * must appear (in any matched column) but not necessarily contiguously.
 * GROUP BY on the posts table guards against join fan-out (the index has at
 * most one row per post, but the guarantee is cheap).
 *
 * Ordering is relevance-tiered so close matches lead the list: exact title
 * match, then title-prefix, then any full title match, then index/content-only
 * matches. The group's own orderby (title A-Z; date DESC for news) breaks
 * ties within each tier — without this, "water" listed services
 * alphabetically and buried "Water Resources" behind "Adaptive Management".
 *
 * @param string   $q       Raw (already-trimmed) search term.
 * @param string[] $columns Column keys to match: title|content|excerpt.
 * @return array{join:callable,where:callable,groupby:callable,orderby:callable}
 */
function esa_search_clauses( $q, array $columns ) {
    global $wpdb;

    $tokens = esa_search_tokens( $q );
    if ( empty( $tokens ) ) {
        $tokens = array( (string) $q );
    }

    $column_sql = array(
        'title'   => "{$wpdb->posts}.post_title",
        'content' => "{$wpdb->posts}.post_content",
        'excerpt' => "{$wpdb->posts}.post_excerpt",
    );
    $columns    = array_values( array_intersect( $columns, array_keys( $column_sql ) ) );

    $title_col = $column_sql['title'];
    $q_lower   = mb_strtolower( $q );

    $exact  = $wpdb->prepare( "LOWER({$title_col}) = %s", $q_lower );
    $prefix = $wpdb->prepare( "LOWER({$title_col}) LIKE %s", $wpdb->esc_like( $q_lower ) . '%' );

    $title_all = implode(
        ' AND ',
        array_map(
            function ( $token ) use ( $title_col ) {
                return esa_search_match_expr( $title_col, $token );
            },
            $tokens
        )
    );

    $rank = "CASE WHEN {$exact} THEN 0 WHEN {$prefix} THEN 1 WHEN {$title_all} THEN 2 ELSE 3 END";

    return array(
        'join'    => function ( $join ) use ( $wpdb ) {
            // Alias the join so multiple filters can't collide on table name.
            $join .= $wpdb->prepare(
                " LEFT JOIN {$wpdb->postmeta} AS esa_idx"
                . " ON ( esa_idx.post_id = {$wpdb->posts}.ID AND esa_idx.meta_key = %s )",
                ESA_SEARCH_INDEX_META
            );
            return $join;
        },
        'where'   => function ( $where ) use ( $columns, $column_sql, $tokens ) {
            foreach ( $tokens as $token ) {
                $parts = array();
                foreach ( $columns as $column ) {
                    $parts[] = esa_search_match_expr( $column_sql[ $column ], $token );
                }
                $parts[] = esa_search_match_expr( 'esa_idx.meta_value', $token );

                $where .= ' AND ( ' . implode( ' OR ', $parts ) . ' )';
            }
            return $where;
        },
        'groupby' => function ( $groupby ) use ( $wpdb ) {
            $by = "{$wpdb->posts}.ID";
            if ( '' === trim( (string) $groupby ) ) {
                return $by;
            }
            return $groupby . ", {$by}";
        },
        'orderby' => function ( $orderby ) use ( $rank ) {
            // Prepend the relevance tier; WP's own orderby (from the query
            // args) survives as the tiebreaker within each tier.
            $orderby = trim( (string) $orderby );
            return '' === $orderby ? $rank : "{$rank}, {$orderby}";
        },
    );
}

/**
 * Employee post IDs whose person also exists as a leadership post.
 *
 * The People group spans two CPTs, and nine people are published in both —
 * without this, "Leslie" returns the same person twice. Leadership wins:
 * these employee IDs are excluded from the people query. Names are compared
 * with credentials stripped ("Douglas Skurski, MS, PWS" = "Douglas Skurski"),
 * since the two CPTs suffix credentials inconsistently.
 *
 * Cached in a transient; flushed on any employee/leadership save below.
 *
 * @return int[] Employee post IDs to exclude from the people group.
 */
function esa_search_people_dupe_ids() {
    $ids = get_transient( 'esa_search_people_dupes' );
    if ( false !== $ids ) {
        return array_map( 'intval', (array) $ids );
    }

    // "Jane Doe, JD, PMP" → "jane doe"; the name before the first comma.
    $normalize = function ( $title ) {
        return mb_strtolower( trim( preg_replace( '/,.*$/u', '', (string) $title ) ) );
    };

    $leader_names = array();
    foreach ( get_posts( array( 'post_type' => 'leadership', 'post_status' => 'publish', 'posts_per_page' => -1 ) ) as $post ) {
        $leader_names[ $normalize( $post->post_title ) ] = true;
    }

    $ids = array();
    foreach ( get_posts( array( 'post_type' => 'employee', 'post_status' => 'publish', 'posts_per_page' => -1 ) ) as $post ) {
        if ( isset( $leader_names[ $normalize( $post->post_title ) ] ) ) {
            $ids[] = $post->ID;
        }
    }

    set_transient( 'esa_search_people_dupes', $ids, DAY_IN_SECONDS );

    return $ids;
}

/**
 * Flush the people-dedupe cache when either people CPT changes.
 *
 * @param int $post_id Post being saved.
 * @return void
 */
function esa_search_flush_people_dupes( $post_id ) {
    if ( in_array( get_post_type( $post_id ), array( 'employee', 'leadership' ), true ) ) {
        delete_transient( 'esa_search_people_dupes' );
    }
}
add_action( 'save_post', 'esa_search_flush_people_dupes' );

/**
 * Run a grouped search across the site's main content types.
 *
 * Entity groups (services, markets, projects, people, tools) match against
 * post_title + the ACF index only — typeahead against names shouldn't get
 * noisy body-text hits. News and pages also match content/excerpt, because
 * finding an article by a phrase in its body is expected there.
 *
 * @param string      $q          Search term. Trimmed here; sanitize before calling.
 * @param int         $per_group  Max items per group, clamped 1-50. Counts always reflect totals.
 * @param string|null $only_group Optional. Restrict ITEMS to one group key.
 *                                All seven group COUNTS are always returned
 *                                regardless, so the scope pills stay stable
 *                                when tabbing between scopes. Invalid values
 *                                are ignored.
 * @return array[] Ordered list of groups: { key, label, count, items[] }.
 *                 Returns an empty array when $q is shorter than 2 characters.
 */
function esa_grouped_search( $q, $per_group = 5, $only_group = null ) {
    $q         = trim( (string) $q );
    $per_group = max( 1, min( 50, (int) $per_group ) );

    // Sub-2-character terms would match nearly everything; treat as "no search".
    if ( mb_strlen( $q ) < 2 ) {
        return array();
    }

    // Insertion order here defines response order.
    $group_defs = array(
        'services' => array(
            'label'     => 'Services',
            'post_type' => 'service',
            'columns'   => array( 'title' ),
            'icon'      => 'leaf',
        ),
        'projects' => array(
            'label'     => 'Projects',
            'post_type' => 'projects',
            'columns'   => array( 'title' ),
            'icon'      => 'map-pin',
        ),
        'markets'  => array(
            'label'     => 'Markets',
            'post_type' => 'market',
            'columns'   => array( 'title' ),
            'icon'      => 'building-2',
        ),
        'people'   => array(
            'label'     => 'People',
            'post_type' => array( 'employee', 'leadership' ),
            'columns'   => array( 'title' ),
            'icon'      => 'user-round',
        ),
        'pages'    => array(
            'label'     => 'Pages',
            'post_type' => 'page',
            'columns'   => array( 'title', 'content', 'excerpt' ),
            'icon'      => 'file-text',
        ),
        'news'     => array(
            'label'     => 'News & Ideas',
            'post_type' => 'post',
            'columns'   => array( 'title', 'content', 'excerpt' ),
            'orderby'   => 'date',
            'order'     => 'DESC',
            'icon'      => 'newspaper',
        ),
        // Tools is indexed and formatted but not exposed as a group until its
        // content is ready — restore it here to re-enable.
    );

    // A valid $only_group restricts which group returns ITEMS, but every group
    // still runs so its count is reported — otherwise the scope pills would
    // lose their counts the moment you tab into a single scope.
    $active_group = ( null !== $only_group && isset( $group_defs[ $only_group ] ) ) ? $only_group : null;

    $groups = array();

    foreach ( $group_defs as $key => $def ) {
        $is_active = ( null === $active_group ) || ( $key === $active_group );

        $clauses = esa_search_clauses( $q, $def['columns'] );
        add_filter( 'posts_join', $clauses['join'] );
        add_filter( 'posts_where', $clauses['where'] );
        add_filter( 'posts_groupby', $clauses['groupby'] );
        add_filter( 'posts_orderby', $clauses['orderby'] );

        // Inactive groups fetch a single ID just for the count (found_posts
        // still reflects the total).
        $args = array(
            'post_type'           => $def['post_type'],
            'post_status'         => 'publish',
            'posts_per_page'      => $is_active ? $per_group : 1,
            'orderby'             => isset( $def['orderby'] ) ? $def['orderby'] : 'title',
            'order'               => isset( $def['order'] ) ? $def['order'] : 'ASC',
            'ignore_sticky_posts' => true,
        );
        if ( ! $is_active ) {
            $args['fields'] = 'ids';
        }

        // One row per person: leadership wins when someone exists in both CPTs.
        if ( 'people' === $key ) {
            $dupes = esa_search_people_dupe_ids();
            if ( ! empty( $dupes ) ) {
                $args['post__not_in'] = $dupes;
            }
        }

        $query = new WP_Query( $args );

        remove_filter( 'posts_join', $clauses['join'] );
        remove_filter( 'posts_where', $clauses['where'] );
        remove_filter( 'posts_groupby', $clauses['groupby'] );
        remove_filter( 'posts_orderby', $clauses['orderby'] );

        $items = array();
        if ( $is_active ) {
            foreach ( $query->posts as $post ) {
                $items[] = esa_search_format_item( $post );
            }
        }

        $groups[] = array(
            'key'   => $key,
            'label' => $def['label'],
            'icon'  => $def['icon'],
            'count' => (int) $query->found_posts,
            'items' => $items,
        );
    }

    return $groups;
}

/**
 * Format a single post into the shared search-result item shape.
 *
 * Sub-line pieces are joined with " · " (interpunct), skipping empties, and
 * never repeat the group's own name. The `photo` key is always present: a
 * thumbnail URL for people and projects, null for everything else (those
 * render icons or initials client-side).
 *
 * @param WP_Post $post The matched post.
 * @return array { id, type, title, url, sub, photo }.
 */
function esa_search_format_item( $post ) {
    $title     = get_the_title( $post );
    $sub_parts = array();
    $photo     = null;

    switch ( $post->post_type ) {
        case 'projects':
            // e.g. "Water · Elk Grove, California"
            $sub_parts[] = esa_search_related_title( get_field( 'details_market', $post->ID ) );
            $sub_parts[] = get_field( 'details_location', $post->ID );
            $photo       = esa_search_image_url( get_field( 'hero_photo', $post->ID ) );
            break;

        case 'employee':
            $sub_parts[] = get_field( 'info_position', $post->ID );
            $photo       = esa_search_image_url( get_field( 'info_photo', $post->ID ) );
            break;

        case 'leadership':
            $position    = get_field( 'info_position', $post->ID );
            $sub_parts[] = $position ? $position : 'Leadership';
            $photo       = esa_search_image_url( get_field( 'info_headshot', $post->ID ) );
            break;

        case 'tools':
            // e.g. "Interactive · Live"
            $sub_parts[] = esa_search_choice_label( get_field( 'tool_type', $post->ID ) );
            $sub_parts[] = esa_search_choice_label( get_field( 'status', $post->ID ) );
            break;

        case 'post':
            $sub_parts[] = get_the_date( '', $post );
            break;

        case 'page':
            // The section a page lives in: its root ancestor's title.
            $ancestors = get_post_ancestors( $post );
            if ( ! empty( $ancestors ) ) {
                $sub_parts[] = get_the_title( end( $ancestors ) );
            }
            break;

        // 'service' and 'market' rows are self-explanatory under their group
        // headers; no sub-line.
    }

    $sub_parts = array_filter(
        $sub_parts,
        function ( $part ) {
            return is_string( $part ) && '' !== trim( $part );
        }
    );

    // get_the_title() runs wptexturize, which turns straight quotes into
    // smart-quote HTML entities. Decode to real UTF-8 characters here so
    // every consumer escapes exactly once for its own context.
    $title = html_entity_decode( $title, ENT_QUOTES, 'UTF-8' );
    $sub   = html_entity_decode( implode( ' · ', $sub_parts ), ENT_QUOTES, 'UTF-8' );

    return array(
        'id'    => $post->ID,
        'type'  => $post->post_type,
        'title' => $title,
        'url'   => get_permalink( $post ),
        'sub'   => $sub,
        'photo' => $photo,
    );
}

/**
 * Resolve an ACF image field value to a thumbnail URL (or null).
 *
 * Handles all three ACF image return formats — array, attachment ID, or URL
 * string — so callers don't care how the field is configured. Prefers the
 * generated 'thumbnail' size, falling back to the full URL when an image is
 * smaller than the thumbnail size.
 *
 * @param mixed $image ACF image value (array|int|string|false).
 * @return string|null Thumbnail URL, or null when absent/unresolvable.
 */
function esa_search_image_url( $image ) {
    if ( is_array( $image ) ) {
        if ( ! empty( $image['sizes']['thumbnail'] ) ) {
            return (string) $image['sizes']['thumbnail'];
        }
        return ! empty( $image['url'] ) ? (string) $image['url'] : null;
    }

    if ( is_numeric( $image ) ) {
        $url = wp_get_attachment_image_url( (int) $image, 'thumbnail' );
        return $url ? $url : null;
    }

    if ( is_string( $image ) && '' !== $image ) {
        return $image;
    }

    return null;
}

/**
 * Extract the human label from an ACF choice field (button_group / select).
 *
 * These fields return array{value,label} when "Both" return format is set,
 * but a plain string when the format is "Value" or "Label" — handle both.
 *
 * @param mixed $value Raw get_field() return.
 * @return string|null Label string, or null when unset.
 */
function esa_search_choice_label( $value ) {
    if ( is_array( $value ) && isset( $value['label'] ) && '' !== $value['label'] ) {
        return (string) $value['label'];
    }
    if ( is_string( $value ) && '' !== $value ) {
        // Values are stored slug-style ("in-development"); present them readably.
        return ucwords( str_replace( array( '-', '_' ), ' ', $value ) );
    }
    return null;
}

/**
 * Resolve an ACF post_object value (WP_Post or ID) to its post title.
 *
 * @param mixed $value Raw get_field() return for a post_object field.
 * @return string|null Post title, or null when unset/unresolvable.
 */
function esa_search_related_title( $value ) {
    if ( $value instanceof WP_Post ) {
        return $value->post_title;
    }
    if ( is_numeric( $value ) ) {
        $title = get_the_title( (int) $value );
        return '' !== $title ? $title : null;
    }
    return null;
}

/**
 * Initials for results without a photo (people missing a headshot).
 *
 * First letter of each of the first two words, uppercased. Leading
 * punctuation is stripped per word so quoted or parenthesized words still
 * contribute their letter.
 *
 * @param string $title Result title.
 * @return string 1-2 uppercase characters, or "?" when nothing usable.
 */
function esa_search_initials( $title ) {
    $words   = preg_split( '/\s+/u', trim( (string) $title ) );
    $letters = array();

    foreach ( $words as $word ) {
        $word = preg_replace( '/^[^\p{L}\p{N}]+/u', '', $word );
        if ( '' === $word ) {
            continue;
        }
        $letters[] = mb_strtoupper( mb_substr( $word, 0, 1 ) );
        if ( 2 === count( $letters ) ) {
            break;
        }
    }

    return empty( $letters ) ? '?' : implode( '', $letters );
}

/**
 * Inline SVG for the search UI's icon set (Lucide, ISC license), rendered
 * at stroke 1.5 — the set approved in the omnibox/search-results specimens.
 *
 * Safe to echo without further escaping: the markup is assembled entirely
 * from this static, hardcoded map — no user input or post data is ever
 * interpolated. Unknown names return an empty string.
 *
 * @param string $name  Icon name (see the map below).
 * @param string $class Optional class attribute for the <svg>.
 * @return string SVG markup, or '' for unknown names.
 */
function esa_search_icon( $name, $class = '' ) {
    static $paths = array(
        'search'        => '<circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/>',
        // Group icons — keep in sync with $group_defs in esa_grouped_search().
        'file-text'     => '<path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/><path d="M10 9H8"/><path d="M16 13H8"/><path d="M16 17H8"/>',
        'newspaper'     => '<path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 1-2 2Zm0 0a2 2 0 0 1-2-2v-9c0-1.1.9-2 2-2h2"/><path d="M18 14h-8"/><path d="M15 18h-5"/><path d="M10 6h8v4h-8V6Z"/>',
        'building-2'    => '<path d="M6 22V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v18Z"/><path d="M6 12H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2"/><path d="M18 9h2a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-2"/><path d="M10 6h4"/><path d="M10 10h4"/><path d="M10 14h4"/><path d="M10 18h4"/>',
        'leaf'          => '<path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z"/><path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12"/>',
        'map-pin'       => '<path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"/><circle cx="12" cy="10" r="3"/>',
        'user-round'    => '<circle cx="12" cy="8" r="5"/><path d="M20 21a8 8 0 0 0-16 0"/>',
        'wrench'        => '<path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/>',
        // UI affordances.
        'history'       => '<path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><path d="M3 3v5h5"/><path d="M12 7v5l4 2"/>',
        'x'             => '<path d="M18 6 6 18"/><path d="m6 6 12 12"/>',
        'chevron-right' => '<path d="m9 18 6-6-6-6"/>',
        'arrow-right'   => '<path d="M5 12h14"/><path d="m12 5 7 7-7 7"/>',
    );

    if ( ! isset( $paths[ $name ] ) ) {
        return '';
    }

    return '<svg' . ( $class ? ' class="' . esc_attr( $class ) . '"' : '' )
        . ' viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"'
        . ' stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">'
        . $paths[ $name ]
        . '</svg>';
}

/**
 * Register the public search REST route.
 *
 * permission_callback is __return_true because every result is public,
 * published content — the same data anyone can reach by browsing the site.
 */
function esa_register_search_route() {
    register_rest_route(
        'esa/v1',
        '/search',
        array(
            'methods'             => WP_REST_Server::READABLE,
            'callback'            => 'esa_search_rest_callback',
            'permission_callback' => '__return_true',
            'args'                => array(
                'q'         => array(
                    'required'          => true,
                    'type'              => 'string',
                    'description'       => 'Search term (minimum 2 characters for results).',
                    'sanitize_callback' => 'sanitize_text_field',
                ),
                'per_group' => array(
                    'type'              => 'integer',
                    'default'           => 5,
                    'description'       => 'Max items per group, clamped 1-50.',
                    'sanitize_callback' => 'absint',
                ),
                'group'     => array(
                    'type'        => 'string',
                    'description' => 'Restrict results to a single group.',
                    'enum'        => array( 'services', 'projects', 'markets', 'people', 'pages', 'news' ),
                ),
            ),
        )
    );
}
add_action( 'rest_api_init', 'esa_register_search_route' );

/**
 * REST callback: wraps esa_grouped_search() in the response envelope.
 *
 * @param WP_REST_Request $request Incoming request.
 * @return WP_REST_Response { query, total, groups }.
 */
function esa_search_rest_callback( WP_REST_Request $request ) {
    $q         = trim( (string) $request->get_param( 'q' ) );
    $per_group = (int) $request->get_param( 'per_group' );
    $group     = $request->get_param( 'group' );

    // Short query: valid request, empty result set (contract: 200, groups []).
    if ( mb_strlen( $q ) < 2 ) {
        return rest_ensure_response(
            array(
                'query'  => $q,
                'total'  => 0,
                'groups' => array(),
            )
        );
    }

    $groups = esa_grouped_search( $q, $per_group, $group ? $group : null );

    $total = 0;
    foreach ( $groups as $group_data ) {
        $total += $group_data['count'];
    }

    return rest_ensure_response(
        array(
            'query'  => $q,
            'total'  => $total,
            'groups' => $groups,
        )
    );
}
