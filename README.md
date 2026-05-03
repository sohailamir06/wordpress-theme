# Cool Air USA — WordPress FSE Theme

A custom Full Site Editing block theme for Cool Air USA HVAC & Plumbing.

## Quick Start

1. **Install the theme**
   - Zip the `cool-air-usa/` folder
   - WP Admin → **Appearance → Themes → Add New → Upload Theme**
   - Activate it

2. **Auto-provisioning (no manual page setup required)**
   On theme activation and admin load, the theme automatically creates and syncs:
   - `home` (set as static front page)
   - `about`, `contact`, `membership`, `financing`, `careers`
   - `specials`, `brands`, `service-areas`
   - `privacy-policy`, `terms-of-service`
   - `services` + all `/services/{slug}` child pages from `inc/data/services.php`

3. **Automatic synchronization**
   - Required pages are auto-created if missing.
   - Canonical templates are assigned automatically by slug/path.
   - Empty pages are seeded with default design content.
   - When pages are updated in WP Admin, frontend updates automatically via normal WordPress rendering.

4. **Permalinks**: Settings -> Permalinks -> "Post name" (`/%postname%/`)
## Architecture

```
cool-air-usa/
|-- style.css                       Theme header
|-- theme.json                      Design tokens (colors, fonts, layout)
|-- functions.php                   Constants plus inc/bootstrap.php loader
|-- index.php                       Required WP fallback
|
|-- templates/                      FSE block templates
|   |-- front-page.html             Static front page shell
|   |-- page-{slug}.html            Per-page shells for required pages
|   |-- page.html                   Generic page fallback
|   |-- single.html                 Blog post
|   |-- index.html                  Blog index
|   `-- 404.html
|
|-- parts/                          Template parts referenced by templates
|   |-- header.html                 Renders <!-- wp:cool-air-usa/site-header /-->
|   `-- footer.html                 Renders <!-- wp:cool-air-usa/site-footer /-->
|
|-- inc/
|   |-- bootstrap.php               Module loader in dependency order
|   |-- setup.php                   Theme supports and menu locations
|   |-- assets.php                  Frontend/editor assets
|   |-- blocks.php                  Dynamic block and pattern registration
|   |-- menus.php                   Default menu provisioning
|   |-- editor.php                  Gutenberg editor restrictions/defaults
|   |-- helpers.php                 Shared callback and date helpers
|   |-- content/
|   |   |-- pages.php               Required page blueprint and sync logic
|   |   |-- builders.php            Seeded editable block content builders
|   |   `-- migrations.php          Legacy editable-content upgrades
|   |-- data/
|   |   |-- site.php                Brands, reviews, counties data
|   |   `-- services.php            Service definitions
|   |-- forms/
|   |   `-- contact.php             Contact form submission handler
|   `-- render/
|       |-- site-header.php         Top nav with dropdowns + emergency bar
|       |-- site-footer.php         4-column footer
|       |-- home.php                Homepage entry - calls each section
|       |-- service.php             Service-page renderer (slug-aware)
|       |-- pages.php               Loads page renderers + ca_page_hero() helper
|       |-- home-*.php              Homepage section renderers
|       `-- page-{slug}.php         Inner-page renderers
|
|-- patterns/                       Editable reusable homepage sections
`-- assets/
    |-- css/
    |   |-- main.css                Imports all part stylesheets
    |   `-- parts/                  Modular CSS
    |-- js/
    |   |-- nav.js                  Dropdowns, mobile menu
    |   `-- main.js                 Reveal, stats, gallery, form UX
    `-- images/
        `-- logo4t.png
```

## How the Dynamic Block System Works

Global template parts use theme dynamic blocks, and legacy/page-builder blocks remain available in the inserter for controlled layouts. These blocks are registered in `inc/blocks.php` with PHP `render_callback`s:

| Block                              | Renders                                              |
|------------------------------------|------------------------------------------------------|
| `cool-air-usa/site-header`         | Top nav + emergency info bar                         |
| `cool-air-usa/site-footer`         | 4-column footer + bottom legal bar                   |
| `cool-air-usa/homepage`            | All 12 homepage sections in order                    |
| `cool-air-usa/service-page`        | Service page — reads slug from `get_queried_object()`|
| `cool-air-usa/about-page`          | About page                                           |
| `cool-air-usa/contact-page`        | Contact page with server-side form handler           |
| `cool-air-usa/membership-page`     | Membership plans                                     |
| `cool-air-usa/financing-page`      | Financing options                                    |
| `cool-air-usa/careers-page`        | Open jobs + benefits                                 |
| `cool-air-usa/specials-page`       | Current specials grid                                |
| `cool-air-usa/brands-page`         | All 24 brand cards                                   |
| `cool-air-usa/service-areas-page`  | Counties + city directory                            |
| `cool-air-usa/legal-page`          | Privacy or Terms (`kind` attribute)                  |

## Customization

- **Colors / typography**: edit `theme.json` (no PHP needed)
- **Service-page content**: edit `inc/data/services.php` (one entry per slug)
- **Brands list**: `ca_brands()` in `inc/data/site.php`
- **Reviews**: `ca_reviews()` in `inc/data/site.php`
- **Cities by county**: `ca_counties()` in `inc/data/site.php`
- **Phone / email / address / portal URL**: defined as constants at the top of `functions.php`
- **Layout**: edit the relevant `inc/render/*.php` file
- **Styles**: edit the relevant `assets/css/parts/*.css` file

## Contact Form

The contact form (`/contact/`) posts to WordPress through `admin-post.php` using the `ca_contact_request` action.
Submissions are nonce-protected, sanitized, screened with a honeypot field, and sent with `wp_mail()` to the site admin email.

## Requirements

- WordPress 6.3+ (Full Site Editing)
- PHP 8.0+
- Modern browser (uses CSS custom properties, `color-mix()`, IntersectionObserver)

## License

GPL-2.0-or-later (WordPress theme requirement)
