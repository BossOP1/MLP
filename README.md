# Coming Keys — The Reserve

Conversion-focused landing page for a Gurugram residential project. PHP for local
development, rendered to static HTML for Netlify.

## Run locally

```bash
php -S localhost:8000
```

Forms POST to `lead-handler.php`, which validates and appends to `leads.csv`
(gitignored — it holds personal data).

## Build for deploy

```bash
php build.php
```

Renders every page into `dist/`, copies `assets/`, and **converts each form to a
Netlify Form** — there is no PHP at request time on Netlify, so without this step
the forms would post into the void. The build fails loudly if a check doesn't pass.

## Deploy

`netlify.toml` sets `command = "php build.php"` and `publish = "dist"`. Connect the
repo and Netlify does the rest. Submissions land under **Forms** in the Netlify
dashboard, in two buckets:

| Form | Fields |
|---|---|
| `coming-keys-enquiry` | name, phone, email, configuration, source |
| `coming-keys-brochure` | name, phone, email |

If a build image ever lacks the PHP CLI, run `php build.php` locally and publish
`dist/` directly instead.

## Editing content

Almost everything lives in **`config.php`** — brand details, prices, plans,
amenities, location advantages, FAQ, gallery captions, SEO copy. Change it there
and the whole page, the JSON-LD structured data and the FAQ schema all follow.

| File | Purpose |
|---|---|
| `config.php` | All editable content |
| `index.php` | The page: markup, styles, behaviour |
| `thank-you.php` | Post-submission page |
| `helpers.php` | Shared view helpers (`e()`, `u()`, `logo()`) |
| `lead-handler.php` | Local form handling |
| `build.php` | Static build for Netlify |

Images live in `assets/img/` — replace a file with the same name and the
cache-busting `?v=<mtime>` updates automatically.

## Before going live

- Replace the **placeholder HARERA number** in `config.php`. Publishing a real
  estate page with an incorrect registration number is a legal problem, not a
  detail.
- Verify prices, areas, distances and possession date.
- Swap the stock photography in `assets/img/` for actual project renders.
- Add the brochure PDF at `assets/coming-keys-the-reserve-brochure.pdf`.
- Compile Tailwind properly — the page currently uses the Play CDN, which ships
  the whole engine and warns in the console.
