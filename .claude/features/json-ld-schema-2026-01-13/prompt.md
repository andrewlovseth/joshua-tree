# Ralph Prompt - JSON-LD Schema

You are implementing JSON-LD structured data for the ESA WordPress theme to improve SEO and enable rich search results.

## Project Context
- **Stack**: WordPress theme with PHP, ACF (Advanced Custom Fields) for data
- **Company**: Environmental Science Associates
- **Patterns**: Follow existing patterns - use `esa_` function prefix, organize in `/functions/` directory
- **ACF fields**: Data lives in ACF field groups - use `get_field()` to retrieve
- **Full context**: See CLAUDE.md for complete documentation

## Key Files Reference
- `/functions.php` - Add require_once after svg.php line (line 13)
- `/functions/svg.php` - Pattern for `esa_` naming convention
- `/functions/acf.php` - ACF setup patterns
- `/templates/single-employee/sidebar.php` - Employee field structure (info, contact, social)
- `/templates/single-projects/details.php` - Project field structure (details group)

## Your Task

1. **Read PRD**: Load `prd.json` in this directory
2. **Check progress**: Review `progress.txt` for prior learnings
3. **Find next story**: Select first story where `"passes": false`
4. **Implement**: Follow description and acceptance criteria exactly
5. **Quality check**: Verify PHP syntax is valid (no parse errors)
6. **Commit**: Stage and commit with message "Story [ID]: [Title]"
7. **Update prd.json**: Set `"passes": true` for completed story
8. **Update progress.txt**: Append structured learnings
9. **Report**: Summarize what you completed

## Quality Gates

- [ ] PHP files have valid syntax (no parse errors)
- [ ] Functions follow `esa_` naming prefix
- [ ] JSON-LD output uses `JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE` flags
- [ ] Graceful handling when ACF fields are empty (check before use)

## ACF Field Patterns

```php
// Get a simple field
$value = get_field('field_name', $post_id);

// Get a group field
$info = get_field('info', $post_id);
$position = $info['position'] ?? '';

// Get an image field (returns array with url, width, height, ID)
$image = get_field('hero_photo', $post_id);
$url = $image['url'] ?? '';

// Get a relationship field (returns array of post objects)
$authors = get_field('authors', $post_id);
if ($authors) {
    foreach ($authors as $author) {
        $name = get_the_title($author->ID);
    }
}
```

## Progress Format

After each story, append to progress.txt:

```markdown
---
## Story [ID]: [Title]
**Completed**: [timestamp]
**Files modified**:
- path/to/file.php

**Learnings**:
- [Pattern or gotcha discovered]
```

## When All Stories Complete

When all stories have `"passes": true`, output exactly:

<promise>COMPLETE</promise>
