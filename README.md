# john-maccallum.com

John MacCallum's website. Jekyll 3.10, published to GitHub Pages by
`.github/workflows/pages.yml` on every push to `master`.

## Build and preview

    bundle install
    rm -rf _site && bundle exec jekyll serve

Then open http://localhost:4000. Clear `_site` before building: an
interrupted build can leave it inconsistent on macOS.

## Where things live

| What | Where |
|---|---|
| Works: facts, tags, recordings, videos, materials, performances | `_data/works.yml` |
| Program and performance notes | `_works/<slug>.md` (one per notated or electroacoustic work) |
| Tags and their definitions | `_data/tags.yml` |
| Albums | `_data/recordings.yml` |
| Publications | `_data/writing.yml`; PDFs in `assets/papers/` |
| Scores, parts, sketches, electronics | `compositions/<folder>/`, the old site's paths, so old links keep working |
| Old paper PDFs | `writings/<folder>/`, kept at their old paths for the same reason |
| Pages | `index.html`, `works/`, `software/`, `writing/`, `teaching/`, `facilitation/`, `about/`, `contact/` |
| Outbound links, navigation, photo | `_config.yml` |
| Old `index.php?page=` URLs | `legacy/index.html`, reached through a Cloudflare redirect rule on `/index.php` |

Facts come from the CV and works list in `professional_docs`. The CV is
the source; the site follows it. A project's own website is the source
for that project's dates.

## Common changes

- **New performance:** add it to the work's `performances` in `_data/works.yml`, most recent first.
- **New video:** add `{label, embed, url}` to the work's `videos`. For Vimeo, `embed` is `https://player.vimeo.com/video/<id>?dnt=1`.
- **Photo:** put it in `assets/` and set `photo:` in `_config.yml`.
- **New tag:** define it in `_data/tags.yml`, then add it to the works it applies to.
