---
name: ddev-and-search-page-quirks
description: DDEV exec paths need the wp/ prefix; WP body class `search-results` collides with a section class of the same name
metadata:
  type: project
---

Two quirks that cost time on the search-results rewrite (2026-07-29):

- `ddev exec` runs from the esassoc project root; theme paths must be prefixed `wp/` (e.g. `ddev exec php -l wp/wp-content/themes/joshua-tree/search.php`). Bare `wp-content/...` fails.
- WordPress adds `search-results` (or `search-no-results`) to the `<body>` class on search pages, so a bare `.search-results { }` selector styles the body too. Scope search-page styles under `body.search .search-results` (the theme's historical convention was `body.search { ... }`).
- `header.php` already opens `<main class="site-content">` — never emit a second `<main>` in templates; use a `<div>` with the same classes.

**Why:** all three are invisible until they bite; each produced a failed command or would have produced a styling/a11y bug.
**How to apply:** any DDEV verification run, and any new template/SCSS scoped to a WP-generated body class.
