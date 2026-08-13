<?php
/**
 * Search results template (/?s=term)
 *
 * Server-rendered counterpart to the omnibox dropdown. Calls the same
 * esa_grouped_search() backend as the REST endpoint, so both surfaces
 * always return identical groups, sub-lines, and photos.
 *
 * Layout is the approved "sidebar rail" design (_specimens/search-results
 * .html): scope filters with live counts in a left rail (chips at mobile
 * widths), grouped results in the main column. People rows lead with
 * headshot thumbnails (initials fallback); other groups with their Lucide
 * icon tile via esa_search_icon().
 *
 * Optional ?type=services|projects|markets|pages|news filters the page to
 * one group; invalid values fall back to all groups. Filtered views go
 * deeper per group (50 vs 20) since they only render one section.
 */

if ( ! function_exists( 'esa_search_highlight' ) ) {
    /**
     * Escape text for HTML while wrapping case-insensitive matches of the
     * query in <mark>. Splits the RAW string on the matches (captured), then
     * escapes each piece — matches can't straddle escape boundaries and
     * nothing is double-escaped.
     *
     * Highlights per token (matching the API's conjunctive matcher), and
     * short alphanumeric tokens ("ai") only mark whole words — mirroring
     * esa_search_match_expr(), so "Training" never gets a mid-word mark.
     *
     * @param string $text Raw (unescaped) text.
     * @param string $q    Raw search query.
     * @return string HTML-safe string with <mark> highlights.
     */
    function esa_search_highlight( $text, $q ) {
        $text = (string) $text;
        $q    = trim( (string) $q );

        if ( '' === $q ) {
            return esc_html( $text );
        }

        $tokens = esa_search_tokens( $q );
        if ( empty( $tokens ) ) {
            $tokens = array( $q );
        }

        // Longest first so overlapping tokens prefer the longer match.
        usort(
            $tokens,
            function ( $a, $b ) {
                return mb_strlen( $b ) - mb_strlen( $a );
            }
        );

        $branches = array_map(
            function ( $token ) {
                $branch = preg_quote( $token, '/' );
                if ( mb_strlen( $token ) <= 2 && ctype_alnum( $token ) ) {
                    $branch = '\b' . $branch . '\b';
                }
                return $branch;
            },
            $tokens
        );

        $pieces = preg_split( '/(' . implode( '|', $branches ) . ')/iu', $text, -1, PREG_SPLIT_DELIM_CAPTURE );
        if ( false === $pieces ) {
            return esc_html( $text );
        }

        $out = '';
        foreach ( $pieces as $i => $piece ) {
            // Odd indexes are the captured query matches.
            $out .= ( $i % 2 ) ? '<mark>' . esc_html( $piece ) . '</mark>' : esc_html( $piece );
        }

        return $out;
    }
}

// Raw (unescaped) query so the backend sees the real term; escape at output.
$search_query = trim( sanitize_text_field( get_search_query( false ) ) );

// Whitelist-validate the optional type filter. Anything else → null → all groups.
$valid_types = array( 'services', 'projects', 'markets', 'people', 'pages', 'news' );
$type        = null;
if ( isset( $_GET['type'] ) ) {
    $requested_type = sanitize_key( wp_unslash( $_GET['type'] ) );
    if ( in_array( $requested_type, $valid_types, true ) ) {
        $type = $requested_type;
    }
}

$has_query = mb_strlen( $search_query ) >= 2;

// All view caps each group at 20; a filtered view shows one group, so go to 50.
$per_group = $type ? 50 : 20;
$groups    = $has_query ? esa_grouped_search( $search_query, $per_group, $type ) : array();

/*
 * esa_grouped_search() always reports all seven group counts, even when
 * scoped to one group (only ITEMS are restricted) — so a single call covers
 * both the rail counts and the visible sections.
 */
$total       = 0;
$shown_total = 0;
foreach ( $groups as $group ) {
    $total += $group['count'];
    if ( null === $type || $group['key'] === $type ) {
        $shown_total += $group['count'];
    }
}

// Filter/more-link URL builder. urlencode() because add_query_arg() expects encoded values.
$base_url = home_url( '/' );
$all_url  = add_query_arg( 's', urlencode( $search_query ), $base_url );

get_header(); ?>

    <section class="search-results grid">

        <?php if ( $has_query ) : ?>
            <header class="phead">
                <h1 class="phead__title">Search results for &ldquo;<em><?php echo esc_html( $search_query ); ?></em>&rdquo;</h1>
                <p class="phead__sub"><?php echo esc_html( number_format_i18n( $total ) ); ?> <?php echo 1 === $total ? 'result' : 'results'; ?></p>
            </header>
        <?php else : ?>
            <header class="phead">
                <h1 class="phead__title">Search</h1>
            </header>
        <?php endif; ?>

        <?php if ( $has_query && $total > 0 ) : ?>

            <div class="b-layout">

                <aside class="b-rail">
                    <h2 class="b-rail__title">Filter results</h2>

                    <div class="rail-list">
                        <a class="rail-item<?php echo null === $type ? ' is-active' : ''; ?>" href="<?php echo esc_url( $all_url ); ?>">
                            <span class="rail-item__label"><span class="rail-item__icon" aria-hidden="true"><?php echo esa_search_icon( 'search' ); // Static trusted SVG. ?></span><span>All</span></span>
                            <span class="rail-count"><?php echo esc_html( number_format_i18n( $total ) ); ?></span>
                        </a>

                        <?php foreach ( $groups as $group ) : ?>
                            <?php $rail_class = 'rail-item' . ( $type === $group['key'] ? ' is-active' : '' ); ?>
                            <?php if ( 0 === $group['count'] ) : ?>
                                <?php // Empty groups are inert: same inner structure, but a span, no link. ?>
                                <span class="<?php echo esc_attr( $rail_class . ' is-disabled' ); ?>">
                                    <span class="rail-item__label"><span class="rail-item__icon" aria-hidden="true"><?php echo esa_search_icon( $group['icon'] ); // Static trusted SVG. ?></span><span><?php echo esc_html( $group['label'] ); ?></span></span>
                                    <span class="rail-count">0</span>
                                </span>
                            <?php else : ?>
                                <?php $filter_url = add_query_arg( array( 's' => urlencode( $search_query ), 'type' => $group['key'] ), $base_url ); ?>
                                <a class="<?php echo esc_attr( $rail_class ); ?>" href="<?php echo esc_url( $filter_url ); ?>">
                                    <span class="rail-item__label"><span class="rail-item__icon" aria-hidden="true"><?php echo esa_search_icon( $group['icon'] ); // Static trusted SVG. ?></span><span><?php echo esc_html( $group['label'] ); ?></span></span>
                                    <span class="rail-count"><?php echo esc_html( number_format_i18n( $group['count'] ) ); ?></span>
                                </a>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </aside>

                <div class="b-results">

                    <form class="rform" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                        <div class="rform__wrap">
                            <span class="rform__icon" aria-hidden="true"><?php echo esa_search_icon( 'search' ); // Static trusted SVG. ?></span>
                            <input type="search" class="rform__input" name="s" value="<?php echo esc_attr( $search_query ); ?>" placeholder="Search services, projects, people, tools&hellip;" aria-label="Search ESA" />
                        </div>
                    </form>

                    <?php // Mobile stand-in for the rail (rail hides, chips show, at narrow widths). ?>
                    <nav class="chips b-chips">
                        <a class="chip<?php echo null === $type ? ' is-active' : ''; ?>" href="<?php echo esc_url( $all_url ); ?>">All <span class="chip__count"><?php echo esc_html( number_format_i18n( $total ) ); ?></span></a>

                        <?php foreach ( $groups as $group ) : ?>
                            <?php $chip_class = 'chip' . ( $type === $group['key'] ? ' is-active' : '' ); ?>
                            <?php if ( 0 === $group['count'] ) : ?>
                                <span class="<?php echo esc_attr( $chip_class . ' is-disabled' ); ?>"><?php echo esc_html( $group['label'] ); ?> <span class="chip__count">0</span></span>
                            <?php else : ?>
                                <?php $filter_url = add_query_arg( array( 's' => urlencode( $search_query ), 'type' => $group['key'] ), $base_url ); ?>
                                <a class="<?php echo esc_attr( $chip_class ); ?>" href="<?php echo esc_url( $filter_url ); ?>"><?php echo esc_html( $group['label'] ); ?> <span class="chip__count"><?php echo esc_html( number_format_i18n( $group['count'] ) ); ?></span></a>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </nav>

                    <?php if ( $shown_total > 0 ) : ?>

                        <div class="groups">

                            <?php foreach ( $groups as $group ) : ?>
                                <?php
                                // The page hides empty groups; a scoped view renders only its group.
                                if ( 0 === $group['count'] || ( null !== $type && $group['key'] !== $type ) ) {
                                    continue;
                                }
                                ?>
                                <section class="group">
                                    <header class="ghead">
                                        <span class="ghead__icon" aria-hidden="true"><?php echo esa_search_icon( $group['icon'] ); // Static trusted SVG. ?></span><h2><?php echo esc_html( $group['label'] ); ?></h2><span class="gcount"><?php echo esc_html( number_format_i18n( $group['count'] ) ); ?></span>
                                    </header>

                                    <div class="grows">
                                        <?php foreach ( $group['items'] as $item ) : ?>
                                            <?php
                                            /*
                                             * Lead visual: people get a headshot thumbnail when one
                                             * exists (alt="" — the adjacent title already names the
                                             * person), initials otherwise; every other group gets
                                             * its icon tile.
                                             */
                                            if ( 'people' === $group['key'] ) {
                                                $lead_html = ! empty( $item['photo'] )
                                                    ? '<span class="lead lead--people"><img src="' . esc_url( $item['photo'] ) . '" loading="lazy" alt="" /></span>'
                                                    : '<span class="lead lead--people" aria-hidden="true">' . esc_html( esa_search_initials( $item['title'] ) ) . '</span>';
                                            } else {
                                                $lead_html = '<span class="lead" aria-hidden="true">' . esa_search_icon( $group['icon'] ) . '</span>';
                                            }
                                            ?>
                                            <a class="rrow" href="<?php echo esc_url( $item['url'] ); ?>">
                                                <?php echo $lead_html; // Escaped piecewise above. ?>
                                                <span class="rrow__body">
                                                    <span class="rrow__title"><?php echo esa_search_highlight( $item['title'], $search_query ); // Escapes internally. ?></span>
                                                    <?php if ( '' !== $item['sub'] ) : ?>
                                                        <span class="rrow__sub"><?php echo esa_search_highlight( $item['sub'], $search_query ); // Escapes internally. ?></span>
                                                    <?php endif; ?>
                                                </span>
                                            </a>
                                        <?php endforeach; ?>
                                    </div>

                                    <?php
                                    // The "Show all" link targets the type-filtered view, so it is
                                    // suppressed when that filter is already active (it would link
                                    // to the current URL and show nothing new).
                                    if ( $group['count'] > count( $group['items'] ) && $type !== $group['key'] ) :
                                        ?>
                                        <?php $more_url = add_query_arg( array( 's' => urlencode( $search_query ), 'type' => $group['key'] ), $base_url ); ?>
                                        <a class="more" href="<?php echo esc_url( $more_url ); ?>">Show all <?php echo esc_html( number_format_i18n( $group['count'] ) ); ?> <?php echo esc_html( strtolower( $group['label'] ) ); ?> <?php echo esa_search_icon( 'chevron-right' ); // Static trusted SVG. ?></a>
                                    <?php endif; ?>
                                </section>
                            <?php endforeach; ?>

                        </div>

                    <?php else : ?>

                        <?php // Hand-typed ?type= for a group with no matches; rail stays for navigation. ?>
                        <p class="rempty">No matches for &ldquo;<?php echo esc_html( $search_query ); ?>&rdquo;. Try a different keyword.</p>

                    <?php endif; ?>

                </div>

            </div>

        <?php else : ?>

            <?php // No query / no matches at all: headline + form + message, no rail (specimen parity). ?>
            <form class="rform" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                <div class="rform__wrap">
                    <span class="rform__icon" aria-hidden="true"><?php echo esa_search_icon( 'search' ); // Static trusted SVG. ?></span>
                    <input type="search" class="rform__input" name="s" value="<?php echo esc_attr( $search_query ); ?>" placeholder="Search services, projects, people, tools&hellip;" aria-label="Search ESA" />
                </div>
            </form>

            <?php if ( $has_query ) : ?>
                <p class="rempty">No matches for &ldquo;<?php echo esc_html( $search_query ); ?>&rdquo;. Try a different keyword.</p>
            <?php else : ?>
                <p class="rempty">Start typing to search services, markets, projects, people, tools, and ideas.</p>
            <?php endif; ?>

        <?php endif; ?>

    </section>

<?php get_footer(); ?>
