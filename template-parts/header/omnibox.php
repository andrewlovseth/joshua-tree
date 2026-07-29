<?php
/*
    Omnibox Search — command palette overlay.

    Opened by the header search trigger (template-parts/header/search.php,
    .js-search-trigger), "/" or Cmd/Ctrl+K. The overlay is position: fixed,
    so it can be included anywhere without affecting layout (header.php
    includes it once, after the header).

    Markup + class contract follow the approved specimen
    (_specimens/omnibox.html): .ob panel, .ob-scope pills, .ob-group
    sections, .ob-row results. All behavior lives in js/search.js, which
    renders into the .js-ob-* hooks below and reads window.esaSearch
    (endpoint + homeUrl) localized in functions/enqueue-styles-scripts.php.

    Icons are inline Lucide at stroke-width 1.5 — no CDN dependency. The
    .ob__ghost twin sits behind the transparent input and paints the inline
    ghost completion (see js/search.js).
*/
?>

<div class="ob-overlay js-ob" hidden>
    <div class="ob-overlay__scrim js-ob-close"></div>

    <div class="ob" role="dialog" aria-modal="true" aria-label="Search ESA">
        <div class="ob__searchrow">
            <svg class="ob__searchicon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>

            <div class="ob__inputwrap">
                <div class="ob__ghost" aria-hidden="true"><span class="ob__ghost-typed js-ob-ghost-typed"></span><span class="ob__ghost-rest js-ob-ghost-rest"></span></div>
                <input type="text" class="ob__input js-ob-input" placeholder="Search ESA&hellip;" autocomplete="off" autocapitalize="off" autocorrect="off" spellcheck="false" aria-label="Search ESA">
            </div>

            <button type="button" class="ob__clear js-ob-clear" aria-label="Clear search" hidden>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
            </button>
        </div>

        <div class="ob__scopes js-ob-scopes"></div>

        <div class="ob__results js-ob-results"></div>

        <div class="ob__footer">
            <a class="ob__viewall js-ob-viewall" href="<?php echo esc_url( home_url( '/' ) ); ?>" hidden>View all results <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg></a>

            <div class="ob__hints">
                <span><kbd>&uarr;</kbd><kbd>&darr;</kbd> Navigate</span>
                <span><kbd>&crarr;</kbd> Select</span>
                <span><kbd>Tab</kbd> <span class="ob__tabhint js-ob-tabhint">Scope</span></span>
                <span><kbd>Esc</kbd> Close</span>
            </div>
        </div>
    </div>
</div>
