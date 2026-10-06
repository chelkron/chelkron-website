# chelkron.com

The Chelkron Technologies home page. Plain HTML and CSS, no build step.

- `index.html` — the page
- `assets/site.css` — styles
- `assets/logo.svg`, `assets/favicon.png` — brand
- `.htaccess` — HTTPS redirect, security headers, caching (Apache / cPanel)

## Publishing on cPanel (Orangehost)

Upload `index.html`, `.htaccess` and the `assets` folder into `public_html`, replacing what's there.
Or use cPanel's **Git Version Control** to clone this repo and deploy it to `public_html`.

Check the old site's files first: anything in `public_html` you still need (for example email
verification files or other folders) should stay.
