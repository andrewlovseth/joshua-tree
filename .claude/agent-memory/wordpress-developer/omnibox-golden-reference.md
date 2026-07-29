---
name: omnibox-golden-reference
description: The ultimate-hall theme is the approved golden reference for omnibox search behavior; joshua-tree's port lives in js/search.js
metadata:
  type: reference
---

The Ultimate Hall of Fame theme at `/Users/andrewlovseth/Dev/ultimate-hall/wp/wp-content/themes/ultimate-hall/` (js/search.js, template-parts/header/search.php, scss/header/_search.scss) is the approved golden-reference implementation for the omnibox search pattern. The joshua-tree port (2026-07-29) kept its full interaction contract — 250ms debounce, Map cache keyed "query|scope", AbortController + request-sequence guard, ghost completion with Tab-accept, "/" and Cmd/Ctrl+K, localStorage recents, esc()-before-innerHTML with property-assigned URLs — and reskinned it from `_specimens/omnibox.html`. When behavior questions come up (Tab vs scope cycling, ghost-pool clearing during fetches), the ultimate-hall file is the tiebreaker, not the specimen (which is a static demo with simplified matching/highlighting).
