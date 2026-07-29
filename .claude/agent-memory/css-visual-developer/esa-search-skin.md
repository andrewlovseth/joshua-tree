---
name: esa-search-skin
description: Andrew-validated accent mapping and contrast judgments for skinning UI to the ESA (joshua-tree) brand
metadata:
  type: feedback
---

Rules for skinning UI surfaces to the ESA brand, validated through Andrew's review of the search specimens (July 2026):

- **Component surfaces are teal-family only — "fairly standard brand", not polychrome.** My first pass gave each content group its own brand-hue tint (orange tools, green news, blue markets); Andrew rejected it as too varied. All icon tiles/initials circles get ONE light-teal tint (#E0F4F3, dark-teal 12%) with dark-teal #00A69C strokes/text. Resist the urge to color-code categories even when the palette offers the hues.
- **Active chip/tab = colored fill + WHITE text** (explicit Andrew rule). Dark-teal #00A69C fill, white label, white count. He accepts the AA miss (~2.6:1) — his call, don't relitigate.
- **Orange is site chrome only** (nav underline, buttons on the real site). Never on search/app component surfaces — not as active fills, not as `<mark>` tints. Query highlight = teal 40% (#C9EAED).
- Orange #F9A134 fails text contrast on white (~1.9:1) — never text/icons on white regardless. Dark-teal also fails for body text (~2.6:1) but the site uses it for 700-weight links. For accessible colored emphasis text use $medium-blue #00728F (~5.5:1) — approved as the "deepest teal-leaning brand variant".
- Hover/active surface tints: teal on white (8% hover #F4FBFB, 14% keyboard-active, 22% focus ring/pulse).
- Raleway needs one weight up vs. Work Sans at equal size (600 titles, not 500) — it runs lighter.
- `_specimens/` convention: charcoal `.spec-note` bar as scaffolding chrome (from tools.html); site header chrome = white bg, logo left, uppercase 14px 600 letter-spaced nav in dark-gray, orange underline on current section; hotlink production assets from esassoc.com (production-media mu-plugin makes this the norm locally).

**Why:** first-round per-group tints and orange actives were rejected in Andrew's 2026-07-29 review; the teal-only + white-active-text rules came straight from him.
**How to apply:** any ESA/joshua-tree UI or specimen — start from this mapping; single-hue component surfaces, orange reserved for real site chrome.
