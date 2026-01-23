# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Commands

```bash
bun run dev        # Dev server: SCSS watch + live reload proxy (http://localhost:3030)
bun run build      # Production CSS build (no sourcemaps)
bun install        # Install dependencies
```

### Build System

Bun-native TypeScript scripts (no Gulp):

- **`build.ts`** — Compiles SCSS entries (`style.scss`, `gutenberg.scss`) using Dart Sass, then autoprefixes with LightningCSS. Expanded output preserves WordPress theme header comment.
- **`dev.ts`** — Proxy server on port 3030 that forwards to DDEV (`https://esassoc.dev`). Injects WebSocket client for live reload: CSS changes hot-inject without page reload, PHP/JS changes trigger full reload.

## Architecture

### Functions Organization

`functions.php` imports modular files from `functions/`:

| File | Purpose |
|------|---------|
| `theme-support.php` | WP features, SVG upload, "Posts" → "News" relabeling, featured post exclusion |
| `enqueue-styles-scripts.php` | Asset loading with cache-busting |
| `acf.php` | Options pages (Header, Footer, Clients), relationship field ordering |
| `register-blocks.php` | ACF blocks: sidebar, esa-contacts, esa-hero, esa-featured-projects |
| `disable-gutenberg-editor.php` | Gutenberg disabled for 18 page templates and 7 CPTs |
| `svg.php` | `esa_svg($url)` helper for inline SVG |
| `schema.php` | JSON-LD structured data (Organization, WebSite, BreadcrumbList, NewsArticle, Person, Service, CreativeWork) |
| `ajax-load-more.php` | Ajax Load More Pro customization |

### Template Organization

Large pages are split into sub-templates in `templates/`:
- `templates/single-projects/` — hero.php, about.php, gallery.php, etc.
- `templates/archive-projects/` — filters.php, page-header.php, grid.php

Template parts in `template-parts/` are organized by location (header/, footer/, global/, search/).

### SCSS Structure

`scss/style.scss` imports in order:
1. `normalize` → `variables/` → `mixins/`
2. `typography/` → `layout/` → `vendor/` (Slick)
3. `elements/` (buttons, forms, grids)
4. `header/` → `footer/`
5. `templates/` (page-specific styles)
6. `blocks/` (ACF block styles)

### Color Tokens

Defined in `scss/variables/_colors.scss`:
- **Primary**: Orange `#F9A134`, Cool Gray `#ADAFB2`, Blue `#699CC6`, Teal `#72CCD2`, Dark Teal `#00A69C`
- **Grayscale**: off-white, light/medium/dark gray, charcoal

### Grid System

- `.grid` — 12-column responsive (4→8→12 cols at breakpoints)
- `.four-col-grid` — 1→2→4 column progression
- Gap: 2rem horizontal, 4rem vertical

Breakpoint mixins: `tablet-small`, `tablet`, `desktop-small`, `desktop`

## Key Patterns

### Function Naming
- Legacy: `bearsmith_*` prefix
- Current: `esa_*` prefix

### ACF Field Conventions
Common field group patterns: `hero`, `info`, `contact`, `social`, `about`, `details`, `testimonial`

### Block IDs
Pattern: `esa-{block-name}-{id}` (e.g., `esa-hero-123`)

### Schema Implementation
`schema.php` hooks to `wp_head` via `esa_output_schema()`. Yoast's Article schema is disabled for posts in favor of custom NewsArticle schema.

## Custom Post Types

Templates exist for: `projects`, `service`, `employee`, `leadership`, `client`, `market`

CPT registration is handled by plugins, not the theme.

## Deployment

Bitbucket → WP Pusher to production (esassoc.com)
