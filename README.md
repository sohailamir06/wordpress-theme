# Cool Air USA â€” WordPress FSE Theme

A custom Full Site Editing block theme for Cool Air USA HVAC & Plumbing.

## Quick Start

1. **Install the theme**
   - Zip the `cool-air-usa/` folder
   - WP Admin â†’ **Appearance â†’ Themes â†’ Add New â†’ Upload Theme**
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
â”œâ”€â”€ style.css                       Theme header
â”œâ”€â”€ theme.json                      Design tokens (colors, fonts, layout)
â”œâ”€â”€ functions.php                   Setup, asset enqueue, block registration
â”œâ”€â”€ index.php                       Required WP fallback
â”‚
â”œâ”€â”€ templates/                      FSE block templates
â”‚   â”œâ”€â”€ front-page.html             Homepage (renders <!-- wp:cool-air-usa/homepage /-->)
â”‚   â”œâ”€â”€ page-{slug}.html            Per-page templates (one per slug above)
â”‚   â”œâ”€â”€ page.html                   Generic page fallback
â”‚   â”œâ”€â”€ single.html                 Blog post
â”‚   â”œâ”€â”€ index.html                  Blog index
â”‚   â””â”€â”€ 404.html
â”‚
â”œâ”€â”€ parts/                          Template parts referenced by templates
â”‚   â”œâ”€â”€ header.html                 Renders <!-- wp:cool-air-usa/site-header /-->
â”‚   â””â”€â”€ footer.html                 Renders <!-- wp:cool-air-usa/site-footer /-->
â”‚
â”œâ”€â”€ inc/                            All PHP rendering logic
â”‚   â”œâ”€â”€ page-data.php               Brands, reviews, counties data
â”‚   â”œâ”€â”€ render-home.php             Homepage entry â€” calls each section
â”‚   â”œâ”€â”€ render-services.php         Service-page renderer (slug-aware)
â”‚   â”œâ”€â”€ render-pages.php            Loads page renderers + ca_page_hero() helper
â”‚   â”œâ”€â”€ data/
â”‚   â”‚   â””â”€â”€ services.php            All 13 service definitions (title, intro, issues, process, benefits)
â”‚   â””â”€â”€ render/
â”‚       â”œâ”€â”€ site-header.php         Top nav with dropdowns + emergency bar
â”‚       â”œâ”€â”€ site-footer.php         4-column footer
â”‚       â”œâ”€â”€ home-hero.php           Hero with split layout
â”‚       â”œâ”€â”€ home-stats.php          Rotating stats bar + family-owned band
â”‚       â”œâ”€â”€ home-services.php       8 service cards
â”‚       â”œâ”€â”€ home-why.php            6 feature cards with tilt
â”‚       â”œâ”€â”€ home-reviews.php        Google reviews section
â”‚       â”œâ”€â”€ home-process.php        4-step process with animated van
â”‚       â”œâ”€â”€ home-brands.php         Marquee brand list
â”‚       â”œâ”€â”€ home-map.php            County cards (homepage map)
â”‚       â”œâ”€â”€ home-membership.php     Membership CTA band
â”‚       â”œâ”€â”€ home-gallery.php        3D rotating project gallery
â”‚       â”œâ”€â”€ home-emergency.php      Emergency dispatch band
â”‚       â””â”€â”€ page-{slug}.php         Inner-page renderers
â”‚
â””â”€â”€ assets/
    â”œâ”€â”€ css/
    â”‚   â”œâ”€â”€ main.css                Imports all part stylesheets
    â”‚   â””â”€â”€ parts/                  Modular CSS (base, buttons, header, hero, etc.)
    â”œâ”€â”€ js/
    â”‚   â”œâ”€â”€ nav.js                  Dropdowns, mobile menu
    â”‚   â””â”€â”€ main.js                 Reveal, parallax, stats rotator, process van,
    â”‚                               tilt, 3D gallery, contact form
    â””â”€â”€ images/
        â””â”€â”€ logo4t.png
```

## How the Dynamic Block System Works

Templates reference dynamic blocks like `<!-- wp:cool-air-usa/service-page /-->`. These are registered in `functions.php` with PHP `render_callback`s:

| Block                              | Renders                                              |
|------------------------------------|------------------------------------------------------|
| `cool-air-usa/site-header`         | Top nav + emergency info bar                         |
| `cool-air-usa/site-footer`         | 4-column footer + bottom legal bar                   |
| `cool-air-usa/homepage`            | All 11 homepage sections in order                    |
| `cool-air-usa/service-page`        | Service page â€” reads slug from `get_queried_object()`|
| `cool-air-usa/about-page`          | About page                                           |
| `cool-air-usa/contact-page`        | Contact page (with form)                             |
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
- **Brands list**: `ca_brands()` in `inc/page-data.php`
- **Reviews**: `ca_reviews()` in `inc/page-data.php`
- **Cities by county**: `ca_counties()` in `inc/page-data.php`
- **Phone / email / address / portal URL**: defined as constants at the top of `functions.php`
- **Layout**: edit the relevant `inc/render/*.php` file
- **Styles**: edit the relevant `assets/css/parts/*.css` file

## Backend TODO (developer)

The contact form (`/contact/`) currently shows a success message client-side only. To wire up actual submission:

1. Pick a handler â€” recommended: `admin-post.php` action or a REST route
2. In `inc/render/page-contact.php`, change the `<form>` to POST to your endpoint
3. Add a nonce field, CSRF protection, validation, email send (`wp_mail`), and spam protection
4. Update `assets/js/main.js` `initContactForm()` if you want fetch-based AJAX submit instead of full page reload

## Requirements

- WordPress 6.3+ (Full Site Editing)
- PHP 8.0+
- Modern browser (uses CSS custom properties, `color-mix()`, IntersectionObserver)

## License

GPL-2.0-or-later (WordPress theme requirement)
