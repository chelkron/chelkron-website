# chelkron.com

The Chelkron Technologies home page. Plain HTML and CSS, no build step.

- `index.html` — the page
- `assets/site.css` — styles
- `assets/logo.svg`, `assets/favicon.png` — brand
- `contact.php` — sends the "Send us a message" pop-up form to support@chelkron.com (needs PHP, which cPanel has)
- `.htaccess` — HTTPS redirect, security headers, caching (Apache / cPanel)

## Publishing on cPanel (Orangehost)

Upload `index.html`, `contact.php`, `.htaccess` and the `assets` folder into `public_html`, replacing what's there.
Or use cPanel's **Git Version Control** to clone this repo and deploy it to `public_html`.

Check the old site's files first: anything in `public_html` you still need (for example email
verification files or other folders) should stay.

## Contact form

`contact.php` emails each message to `support@chelkron.com` from `noreply@chelkron.com`, with the
visitor's address as Reply-To, so you can answer with Reply. Both addresses are at the top of the file.
For the mail to arrive (and not land in spam), chelkron.com's SPF record must allow this cPanel server
to send for the domain. Send a test message after publishing.

Spam guards: a hidden field people never see, a 3-second minimum on the form, and at most 5 messages
per hour from one IP address.
