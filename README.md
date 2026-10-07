# chelkron.com

The Chelkron Technologies home page. Plain HTML and CSS, no build step.

- `index.html` — the home page
- `terms/index.html` — Terms of Use (served at /terms)
- `privacy-policy/index.html` — Privacy Policy (served at /privacy-policy)
- `assets/site.css` — styles
- `assets/logo.svg`, `assets/favicon.png` — brand
- `contact.php` — sends the "Send us a message" pop-up form to support@chelkron.com (needs PHP, which cPanel has)
- `.htaccess` — HTTPS redirect, security headers, caching (Apache / cPanel)
- `support/` — the support site, served at **support.chelkron.com** (see below)

## Publishing on cPanel (Orangehost)

Upload `index.html`, `contact.php`, `.htaccess` and the `assets`, `terms` and `privacy-policy` folders into `public_html`, replacing what's there.
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

## Support site (support.chelkron.com)

`support/` is its own small site: live chat, WhatsApp, email and a support-request form.
It loads its fonts, logo and main styles from chelkron.com, plus its own `support/support.css`.

- `support/index.html` — the page
- `support/send.php` — emails each request to support@chelkron.com with a reference like `CK-261007-1A2B`
  in the subject (same spam guards as the contact form)
- `support/.htaccess` — always sends visitors to https://support.chelkron.com (also chelkron.com/support)

Publishing on cPanel:
1. **Domains → Create A New Domain** (or Subdomains): `support.chelkron.com`, document root `public_html/support`.
2. Upload the `support` folder into `public_html` (or deploy the repo as usual).
3. **SSL/TLS Status → Run AutoSSL** so the subdomain gets a certificate.

Live chat uses Tawk.to (free). Until its two IDs are set at the top of the script in `support/index.html`
(`TAWK_PROPERTY`, `TAWK_WIDGET`), "Start a chat" opens WhatsApp instead.
