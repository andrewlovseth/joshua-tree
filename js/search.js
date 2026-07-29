/* ==========================================================================
   ESA — Omnibox search (command palette)

   Vanilla JS, no jQuery, no build step. Enqueued in the footer with an
   `esaSearch` config object localized by functions/enqueue-styles-scripts.php:
     esaSearch.endpoint -> GET {endpoint}?q=<term>&per_group=<int>[&group=<key>]
     esaSearch.homeUrl  -> used for the "View all results" link (?s=...&type=...)

   API contract (functions/search-api.php):
     { query, total, groups: [ { key, label, icon, count, items: [ {id, type, title, url, sub, photo} ] } ] }
   All seven groups (pages, news, markets, services, projects, people, tools)
   are always present, in that order, even with count 0. `photo` is a
   thumbnail URL on people items (null when no headshot exists). Queries
   under 2 chars return no groups, so we never fetch below MIN_CHARS.

   Ghost completion: an inline twin element (.ob__ghost) behind the
   transparent-background input paints the typed text invisibly plus a gray
   completion remainder, matched against the currently-loaded result titles
   in group order. Tab accepts when visible; otherwise Tab keeps its role of
   cycling scopes. ArrowRight at the end of the input also accepts. The pool
   clears while a fetch is in flight so the ghost never completes against
   stale results.

   Security note: every API string is escaped via esc() before being placed
   into innerHTML. URLs (row hrefs, people photo srcs) are assigned through
   element properties (never concatenated into HTML), which avoids attribute
   injection entirely.
   ========================================================================== */
(function () {
    'use strict';

    var cfg = window.esaSearch || {};

    var palette = document.querySelector('.js-ob');
    var openButtons = document.querySelectorAll('.js-search-trigger');
    if (!palette || !openButtons.length) return;

    var panel = palette.querySelector('.ob');
    var input = palette.querySelector('.js-ob-input');
    var clearBtn = palette.querySelector('.js-ob-clear');
    var closeEls = palette.querySelectorAll('.js-ob-close');
    var scopesEl = palette.querySelector('.js-ob-scopes');
    var resultsEl = palette.querySelector('.js-ob-results');
    var viewAllEl = palette.querySelector('.js-ob-viewall');
    var ghostTypedEl = palette.querySelector('.js-ob-ghost-typed');
    var ghostRestEl = palette.querySelector('.js-ob-ghost-rest');
    var tabHintEl = palette.querySelector('.js-ob-tabhint');
    if (!panel || !input || !scopesEl || !resultsEl) return;

    var MIN_CHARS = 2;
    var DEBOUNCE_MS = 250;
    var PER_GROUP_ALL = 5;
    var PER_GROUP_SCOPED = 20;
    var RECENTS_KEY = 'esa_omni_recents';
    var RECENTS_CAP = 5;

    /* ---- inline icon set ----
       Lucide paths inlined (no CDN dependency), drawn at stroke-width 1.5.
       Same set as the approved specimen (_specimens/omnibox.html). */
    var ICONS = {
        'search': '<circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/>',
        'leaf': '<path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z"/><path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12"/>',
        'building-2': '<path d="M6 22V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v18Z"/><path d="M6 12H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2"/><path d="M18 9h2a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-2"/><path d="M10 6h4"/><path d="M10 10h4"/><path d="M10 14h4"/><path d="M10 18h4"/>',
        'map-pin': '<path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"/><circle cx="12" cy="10" r="3"/>',
        'user-round': '<circle cx="12" cy="8" r="5"/><path d="M20 21a8 8 0 0 0-16 0"/>',
        'wrench': '<path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/>',
        'newspaper': '<path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 1-2 2Zm0 0a2 2 0 0 1-2-2v-9c0-1.1.9-2 2-2h2"/><path d="M18 14h-8"/><path d="M15 18h-5"/><path d="M10 6h8v4h-8V6Z"/>',
        'file-text': '<path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/><path d="M10 9H8"/><path d="M16 13H8"/><path d="M16 17H8"/>',
        'history': '<path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><path d="M3 3v5h5"/><path d="M12 7v5l4 2"/>',
        'x': '<path d="M18 6 6 18"/><path d="m6 6 12 12"/>',
        'chevron-right': '<path d="m9 18 6-6-6-6"/>',
        'arrow-right': '<path d="M5 12h14"/><path d="m12 5 7 7-7 7"/>'
    };

    function icon(name, cls) {
        return '<svg' + (cls ? ' class="' + cls + '"' : '') +
            ' viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"' +
            ' stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">' +
            (ICONS[name] || '') + '</svg>';
    }

    var SCOPES = [
        { key: 'all', label: 'All' },
        { key: 'services', label: 'Services', icon: 'leaf' },
        { key: 'projects', label: 'Projects', icon: 'map-pin' },
        { key: 'markets', label: 'Markets', icon: 'building-2' },
        { key: 'pages', label: 'Pages', icon: 'file-text' },
        { key: 'news', label: 'News & Ideas', icon: 'newspaper' }
    ];

    /* Lead icons by item type (the API returns post-type slugs; group keys are
       accepted too so recents saved from either shape render the same). */
    var TYPE_ICONS = {
        'page': 'file-text', 'pages': 'file-text',
        'post': 'newspaper', 'news': 'newspaper',
        'market': 'building-2', 'markets': 'building-2',
        'service': 'leaf', 'services': 'leaf',
        'project': 'map-pin', 'projects': 'map-pin',
        'tool': 'wrench', 'tools': 'wrench'
    };

    /* ---- state ---- */
    var state = {
        scope: 'all',
        rows: [],       // flat list of row <a> elements, for keyboard nav
        active: -1, // no implicit row selection — Enter goes to the results page

        counts: null,   // { all, pages, news, ... } from latest response
        ghostPool: [],  // titles from the currently-loaded results, in group order
        ghostRest: '',  // visible completion remainder ('' = no ghost showing)
        lastFocus: null // element to restore focus to on close
    };
    var cache = new Map();    // "<query>|<scope>" -> parsed response
    var inflight = null;      // AbortController for the in-flight fetch
    var requestSeq = 0;       // discards out-of-order responses (belt + suspenders)
    var debounceTimer = null;

    /* ---- escaping / highlight ---- */
    function esc(value) {
        return String(value == null ? '' : value).replace(/[&<>"']/g, function (c) {
            return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' }[c];
        });
    }

    // Highlight every query word (conjunctive search matches per-word, so a
    // multi-word query like "offshore wind" highlights "offshore" and "wind"
    // separately rather than looking for the whole phrase contiguously).
    function highlight(text, q) {
        text = String(text == null ? '' : text);
        var tokens = String(q == null ? '' : q).trim().split(/\s+/).filter(Boolean);
        if (!tokens.length) return esc(text);
        // Longest first so overlapping tokens prefer the longer match.
        tokens.sort(function (a, b) { return b.length - a.length; });
        var pattern = tokens.map(function (t) {
            var branch = t.replace(/[.*+?^${}()|[\]\\]/g, '\\$&'); // escape regex metachars
            // Short alphanumeric tokens ("ai") only mark whole words —
            // mirrors the API matcher, so "Training" never highlights mid-word.
            if (t.length <= 2 && /^[a-z0-9]+$/i.test(t)) branch = '\\b' + branch + '\\b';
            return branch;
        }).join('|');
        var re = new RegExp('(' + pattern + ')', 'gi');
        var out = '';
        var last = 0;
        var m;
        while ((m = re.exec(text)) !== null) {
            out += esc(text.slice(last, m.index)) + '<mark>' + esc(m[0]) + '</mark>';
            last = m.index + m[0].length;
            if (re.lastIndex === m.index) re.lastIndex++; // guard against zero-width matches
        }
        return out + esc(text.slice(last));
    }

    /* ---- recents (localStorage, best-effort: private mode may throw) ---- */
    function getRecents() {
        try {
            var parsed = JSON.parse(localStorage.getItem(RECENTS_KEY) || '[]');
            if (!Array.isArray(parsed)) return [];
            return parsed.filter(function (r) {
                return r && typeof r === 'object' && typeof r.url === 'string';
            }).slice(0, RECENTS_CAP);
        } catch (e) {
            return [];
        }
    }

    function pushRecent(item) {
        if (!item || !item.url) return;
        try {
            var next = getRecents().filter(function (r) {
                return r && r.url !== item.url;
            });
            next.unshift({
                type: item.type || '',
                title: item.title || '',
                url: item.url,
                sub: item.sub || '',
                photo: typeof item.photo === 'string' ? item.photo : ''
            });
            localStorage.setItem(RECENTS_KEY, JSON.stringify(next.slice(0, RECENTS_CAP)));
        } catch (e) {
            /* storage unavailable — recents are a nicety, not a requirement */
        }
    }

    /* ---- row leads ----
       People: 40px circle — headshot when the item has a photo, initials
       otherwise (first letters of the first two words). Everything else:
       40px rounded icon tile on the shared teal tint. */
    function initials(title) {
        var words = String(title == null ? '' : title).split(/\s+/);
        var out = '';
        for (var i = 0; i < words.length && out.length < 2; i++) {
            // Skip leading punctuation so credentials/quotes don't steal a slot.
            var ch = words[i].replace(/^[^0-9A-Za-z]+/, '').charAt(0);
            if (ch) out += ch.toUpperCase();
        }
        return out || '?';
    }

    function makeLead(item) {
        var lead = document.createElement('span');
        var type = item.type || '';

        if (type === 'employee' || type === 'people' || type === 'leadership') {
            lead.className = 'ob-row__lead ob-row__lead--people';
            if (item.photo && typeof item.photo === 'string') {
                var img = document.createElement('img');
                img.src = item.photo; // property assignment — never templated HTML
                img.alt = '';
                img.loading = 'lazy';
                lead.appendChild(img);
            } else {
                lead.textContent = initials(item.title);
            }
        } else {
            lead.className = 'ob-row__lead';
            lead.innerHTML = icon(TYPE_ICONS[type] || 'file-text');
        }
        return lead;
    }

    /* ---- rendering ---- */
    function groupHead(label, count, iconName) {
        return '<header class="ob-group__head">' +
            '<span class="ob-group__title">' + (iconName ? icon(iconName) : '') + esc(label) + '</span>' +
            (count == null ? '' : '<span class="ob-group__count">' + esc(count) + '</span>') +
            '</header>';
    }

    function makeRow(item, q) {
        var row = document.createElement('a');
        row.className = 'ob-row';
        row.href = item.url || '#';

        row.appendChild(makeLead(item));

        var body = document.createElement('span');
        body.className = 'ob-row__body';
        body.innerHTML =
            '<span class="ob-row__title">' + highlight(item.title, q) + '</span>' +
            (item.sub ? '<span class="ob-row__sub">' + esc(item.sub) + '</span>' : '');
        row.appendChild(body);

        // icon() output is a static literal (no API data); parse it detached
        // and append the resulting <svg> node directly.
        var chevWrap = document.createElement('span');
        chevWrap.innerHTML = icon('chevron-right', 'ob-row__chevron');
        if (chevWrap.firstChild) row.appendChild(chevWrap.firstChild);

        row._obItem = item;

        row.addEventListener('mousemove', function () {
            var i = state.rows.indexOf(row);
            if (i !== -1 && i !== state.active) setActive(i);
        });

        row.addEventListener('click', function (e) {
            pushRecent(item);
            // Plain left click navigates via the anchor itself; modified clicks
            // (cmd/ctrl/shift/middle) open elsewhere, so keep the palette open.
            if (!e.metaKey && !e.ctrlKey && !e.shiftKey && !e.altKey) close();
        });

        state.rows.push(row);
        return row;
    }

    function setActive(idx) {
        state.active = idx;
        state.rows.forEach(function (row, i) {
            row.classList.toggle('is-active', i === idx);
        });
        if (state.rows[idx]) state.rows[idx].scrollIntoView({ block: 'nearest' });
    }

    function renderGroups(data, q) {
        resultsEl.innerHTML = '';
        resultsEl.scrollTop = 0;
        state.rows = [];

        var groups = (data && data.groups) || [];
        var visible = groups.filter(function (g) {
            if (state.scope !== 'all' && g.key !== state.scope) return false;
            return g.items && g.items.length > 0;
        });

        if (!visible.length) {
            resultsEl.innerHTML = '<div class="ob__empty">' +
                '<p class="ob__empty-title">No matches for &ldquo;' + esc(q) + '&rdquo;</p>' +
                '<p class="ob__empty-note">Try a different keyword or scope.</p></div>';
            return;
        }

        var scopeIcons = {};
        SCOPES.forEach(function (s) { scopeIcons[s.key] = s.icon; });

        visible.forEach(function (g) {
            var section = document.createElement('section');
            section.className = 'ob-group';
            section.innerHTML = groupHead(g.label, g.count, scopeIcons[g.key]);
            g.items.forEach(function (item) {
                section.appendChild(makeRow(item, q));
            });
            resultsEl.appendChild(section);
        });

        // No implicit selection: rows activate via arrows/hover only, so a
        // bare Enter submits to the results page instead of the first row.
        setActive(-1);
    }

    /* Empty-query home: Recent group (keyboard-navigable) + centered intro */
    function renderEmptyState() {
        resultsEl.innerHTML = '';
        resultsEl.scrollTop = 0;
        state.rows = [];

        var recents = getRecents();
        if (recents.length) {
            var section = document.createElement('section');
            section.className = 'ob-group';
            section.innerHTML = groupHead('Recent', null, 'history');
            recents.forEach(function (item) {
                section.appendChild(makeRow(item, ''));
            });
            resultsEl.appendChild(section);
        }

        var wrap = document.createElement('div');
        wrap.className = 'ob__hero';
        wrap.innerHTML =
            '<p class="ob__hero-title">Search ESA</p>' +
            '<p class="ob__hero-note">Find services, markets, projects, people, tools, and ideas. ' +
            'Start typing &mdash; completions appear as ghost text, <kbd>Tab</kbd> accepts them.</p>';
        resultsEl.appendChild(wrap);

        setActive(-1);
    }

    function renderError() {
        state.rows = [];
        resultsEl.innerHTML = '<div class="ob__empty">' +
            '<p class="ob__empty-title">Search is having trouble right now.</p>' +
            '<p class="ob__empty-note">Check your connection and try again in a moment.</p></div>';
    }

    function renderScopes() {
        scopesEl.innerHTML = '';
        SCOPES.forEach(function (s) {
            var btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'ob-scope' + (s.key === state.scope ? ' is-active' : '');
            btn.setAttribute('aria-pressed', s.key === state.scope ? 'true' : 'false');
            var count = state.counts ? state.counts[s.key] : null;
            btn.innerHTML = esc(s.label) +
                (count == null ? '' : ' <span class="ob-scope__count">' + esc(count) + '</span>');
            btn.addEventListener('click', function () {
                setScope(s.key);
            });
            scopesEl.appendChild(btn);
        });
    }

    /* Counts come back on every response (all seven groups are always present),
       so the pills stay consistent whether the last fetch was "all" or scoped. */
    function updateCounts(data) {
        var counts = { all: 0 };
        ((data && data.groups) || []).forEach(function (g) {
            counts[g.key] = g.count || 0;
            counts.all += g.count || 0;
        });
        state.counts = counts;
    }

    /* ---- ghost completion ----
       Candidates are the titles currently on screen, in group order (the API
       always returns groups in pages, news, markets, services, projects,
       people, tools order). No ghost when: query empty, exact match (no
       remainder), the match isn't a prefix, or a fetch is in flight (the pool
       is cleared until the response lands). Matching runs on the raw
       (untrimmed) input so the invisible twin always mirrors the real text
       glyph-for-glyph. */
    function ghostPoolFrom(data) {
        var pool = [];
        ((data && data.groups) || []).forEach(function (g) {
            (g.items || []).forEach(function (item) {
                if (item && item.title) pool.push(String(item.title));
            });
        });
        return pool;
    }

    function updateGhost() {
        var raw = input.value;
        var rest = '';
        if (raw.length && state.ghostPool.length) {
            var low = raw.toLowerCase();
            for (var i = 0; i < state.ghostPool.length; i++) {
                var cand = state.ghostPool[i];
                var candLow = cand.toLowerCase();
                if (candLow.indexOf(low) === 0 && candLow.length > low.length) {
                    rest = cand.slice(raw.length);
                    break;
                }
            }
        }
        state.ghostRest = rest;
        if (ghostTypedEl) ghostTypedEl.textContent = rest ? raw : '';
        if (ghostRestEl) ghostRestEl.textContent = rest;
        if (tabHintEl) tabHintEl.textContent = rest ? 'Complete' : 'Scope';
    }

    function clearGhostPool() {
        state.ghostPool = [];
        updateGhost();
    }

    function acceptGhost() {
        if (!state.ghostRest) return false;
        input.value = input.value + state.ghostRest;
        var end = input.value.length;
        input.setSelectionRange(end, end);
        refresh({ immediate: true });
        return true;
    }

    /* ---- view all (search results page) ---- */
    function viewAllUrl(q) {
        var url = (cfg.homeUrl || '/') + '?s=' + encodeURIComponent(q);
        if (state.scope !== 'all') url += '&type=' + encodeURIComponent(state.scope);
        return url;
    }

    function updateViewAll(q) {
        if (!viewAllEl) return;
        if (q.length >= MIN_CHARS) {
            viewAllEl.href = viewAllUrl(q);
            viewAllEl.hidden = false;
        } else {
            viewAllEl.hidden = true;
        }
    }

    /* ---- fetching ---- */
    function buildUrl(q, scope) {
        var url = new URL(cfg.endpoint);
        url.searchParams.set('q', q);
        if (scope === 'all') {
            url.searchParams.set('per_group', String(PER_GROUP_ALL));
        } else {
            url.searchParams.set('group', scope);
            url.searchParams.set('per_group', String(PER_GROUP_SCOPED));
        }
        return url.toString();
    }

    function applyResponse(data, q) {
        updateCounts(data);
        renderScopes();
        renderGroups(data, q);
        updateViewAll(q);
        state.ghostPool = ghostPoolFrom(data);
        updateGhost();
    }

    function search(q, scope) {
        var key = q + '|' + scope;

        if (cache.has(key)) {
            applyResponse(cache.get(key), q);
            return;
        }

        if (!cfg.endpoint || typeof window.fetch !== 'function') {
            renderError();
            return;
        }

        var requestUrl;
        try {
            requestUrl = buildUrl(q, scope); // new URL() throws on a malformed endpoint
        } catch (e) {
            renderError();
            return;
        }

        if (inflight) inflight.abort();
        inflight = new AbortController();
        var seq = ++requestSeq;

        // Fetch in flight: never complete against the now-stale results.
        clearGhostPool();

        fetch(requestUrl, {
            signal: inflight.signal,
            headers: { Accept: 'application/json' }
        })
            .then(function (res) {
                if (!res.ok) throw new Error('Search request failed: ' + res.status);
                return res.json();
            })
            .then(function (data) {
                if (seq !== requestSeq) return; // superseded by a newer request
                cache.set(key, data);
                if (palette.hidden) return;
                // Only paint if the UI still wants this exact query + scope.
                if (q !== input.value.trim() || scope !== state.scope) return;
                applyResponse(data, q);
            })
            .catch(function (err) {
                if (err && err.name === 'AbortError') return;
                if (seq !== requestSeq) return;
                renderError();
            });
    }

    /* ---- refresh: single entry point after any input/scope change ---- */
    function refresh(opts) {
        var immediate = opts && opts.immediate;
        var q = input.value.trim();

        if (clearBtn) clearBtn.hidden = input.value.length === 0;
        clearTimeout(debounceTimer);

        if (q.length < MIN_CHARS) {
            if (inflight) inflight.abort();
            state.counts = null;
            clearGhostPool();
            renderScopes();
            renderEmptyState();
            updateViewAll(q);
            return;
        }

        renderScopes();
        updateViewAll(q);
        // Re-match the (possibly longer) raw text against the currently-loaded
        // results so the ghost tracks every keystroke during the debounce gap.
        updateGhost();

        if (immediate) {
            search(q, state.scope);
        } else {
            debounceTimer = setTimeout(function () {
                search(q, state.scope);
            }, DEBOUNCE_MS);
        }
    }

    function setScope(key) {
        state.scope = key;
        refresh({ immediate: true });
        input.focus();
    }

    /* ---- open / close ---- */
    function open() {
        if (!palette.hidden) return;
        state.lastFocus = document.activeElement;
        // Never stack on top of the mobile nav overlay (site.js owns that class).
        document.body.classList.remove('nav-overlay-open');
        document.body.classList.add('omnibox-open');
        palette.hidden = false;
        input.value = '';
        state.scope = 'all';
        refresh({ immediate: true });
        window.requestAnimationFrame(function () {
            input.focus();
        });
    }

    function close() {
        if (palette.hidden) return;
        palette.hidden = true;
        document.body.classList.remove('omnibox-open');
        clearTimeout(debounceTimer);
        if (inflight) inflight.abort();
        if (state.lastFocus && typeof state.lastFocus.focus === 'function') {
            state.lastFocus.focus();
        }
        state.lastFocus = null;
    }

    /* ---- events ---- */
    Array.prototype.forEach.call(openButtons, function (btn) {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            open();
        });
    });

    Array.prototype.forEach.call(closeEls, function (el) {
        el.addEventListener('click', close);
    });

    input.addEventListener('input', function () {
        refresh();
    });

    if (clearBtn) {
        clearBtn.addEventListener('click', function () {
            input.value = '';
            refresh({ immediate: true });
            input.focus();
        });
    }

    /* Keyboard, scoped to the panel. Tab conflict resolution: when ghost text
       is visible, Tab accepts the completion; otherwise Tab keeps its shipped
       role of cycling scopes (Shift+Tab always cycles). ArrowRight with the
       caret at the end of the input also accepts. Arrows move the active row,
       Enter goes to the full results page unless a row was explicitly
       activated (arrows/hover) — then it opens that row. Cmd/Ctrl+Enter
       always goes to the results page. */
    panel.addEventListener('keydown', function (e) {
        if (e.key === 'Tab') {
            e.preventDefault();
            if (!e.shiftKey && state.ghostRest && acceptGhost()) return;
            var i = SCOPES.findIndex(function (s) { return s.key === state.scope; });
            var next = (i + (e.shiftKey ? SCOPES.length - 1 : 1)) % SCOPES.length;
            setScope(SCOPES[next].key);
            return;
        }

        if (e.key === 'ArrowRight' && e.target === input && state.ghostRest &&
            input.selectionStart === input.value.length &&
            input.selectionEnd === input.value.length) {
            e.preventDefault();
            acceptGhost();
            return;
        }

        if (e.key === 'ArrowDown') {
            e.preventDefault();
            if (state.rows.length) setActive(Math.min(state.active + 1, state.rows.length - 1));
            return;
        }

        if (e.key === 'ArrowUp') {
            e.preventDefault();
            if (state.rows.length) setActive(Math.max(state.active - 1, 0));
            return;
        }

        if (e.key === 'Enter' && e.target === input) {
            e.preventDefault();

            var row = state.rows[state.active];
            if (!e.metaKey && !e.ctrlKey && row && row.href) {
                pushRecent(row._obItem);
                window.location.assign(row.href);
                return;
            }

            var q = input.value.trim();
            if (q.length >= MIN_CHARS) window.location.assign(viewAllUrl(q));
        }
    });

    /* Global shortcuts. "/" and Cmd/Ctrl+K open (never while typing elsewhere);
       Esc closes. While the palette is open we return early so "/" can be
       typed into the search input, and nothing leaks to other handlers. */
    document.addEventListener('keydown', function (e) {
        if (!palette.hidden) {
            if (e.key === 'Escape') {
                e.preventDefault();
                close();
            }
            return;
        }

        var t = e.target;
        var typing = t && (/^(INPUT|TEXTAREA|SELECT)$/.test(t.tagName) || t.isContentEditable);
        if (typing) return;

        if (e.key === '/' && !e.metaKey && !e.ctrlKey && !e.altKey) {
            e.preventDefault();
            open();
        } else if ((e.metaKey || e.ctrlKey) && (e.key === 'k' || e.key === 'K')) {
            e.preventDefault();
            open();
        }
    });
})();
