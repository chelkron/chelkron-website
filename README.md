# chelkron.com

The Chelkron Technologies website. PHP pages that share one header, menu and footer; no build step.

| Address | File | What's on it |
|---|---|---|
| `/` | `index.php` | Home: what we do, both products, free Mail offer |
| `/workforce` | `workforce/index.php` | Chelkron Workforce: features and plans |
| `/mail` | `mail/index.php` | Chelkron Mail: features and plans |
| `/pricing` | `pricing/index.php` | Both price lists, the free Mail offer, questions |
| `/about` | `about/index.php` | The company |
| `/contact` | `contact/index.php` | Contact form (sent by `contact.php`) |
| `/terms`, `/privacy-policy` | `terms/index.php`, `privacy-policy/index.php` | Legal pages |

Shared parts (in `inc/`, never served directly):
- `inc/layout.php` — the header, menu and footer. **The menu items are `SITE_NAV` at the top**; change them there and every page follows.
- `inc/prices.php` — **every plan and price on the site**, in one list. Yearly prices are worked out from the monthly ones (10% off). Change prices here when the apps' prices change.
- `inc/parts/` — the hero arc and the drawn product screenshots.

Also: `assets/site.css` (styles), `assets/site.js` (phone menu, contact form), `.htaccess` (HTTPS, clean addresses, security headers, caching).
Adding a page: make `newpage/index.php` like the others, add it to `SITE_NAV`, and add its name to the `RewriteRule` list in `.htaccess`.

## Publishing on cPanel (Orangehost)

Upload `index.php`, `contact.php`, `.htaccess` and the `assets`, `inc`, `workforce`, `mail`, `pricing`, `about`, `contact`, `terms` and `privacy-policy` folders into `public_html`. **Delete the old `index.html`** (and `terms/index.html`, `privacy-policy/index.html`) so they can't be served instead.
Or use cPanel's **Git Version Control** to clone this repo and deploy it to `public_html`.

Check the old site's files first: anything in `public_html` you still need (for example email
verification files or other folders) should stay.

## Contact form

`contact.php` emails each message from the form on /contact to `support@chelkron.com` from `noreply@chelkron.com`, with the
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

Live chat uses Tawk.to (free), property "Chelkron Support". Its two IDs are at the top of the script in
`support/index.html` (`TAWK_PROPERTY`, `TAWK_WIDGET`); emptied, "Start a chat" opens WhatsApp instead.
Answer chats in the Tawk.to dashboard or its phone app.

## Blog (chelkron.com/blog)

Each post is a Markdown file in `blog/posts/`, named `<date>-<address>.md`. For example, `blog/posts/2026-11-05-payroll-tips.md` appears at **chelkron.com/blog/payroll-tips**.

Start the file with these lines, then write the post:

```
---
title: Five payroll mistakes small businesses make
description: One or two sentences, shown in the list, on Google and in link previews.
date: 2026-11-05
tag: Guides
---

Your first paragraph…

## A heading

- a list item
- **bold**, *italic*, [a link](https://chelkron.com/workforce)
```

- `author:` is optional (default "Chelkron Team"). `draft: true` hides a post until you remove that line.
- A post dated in the future appears on that day by itself.
- HTML inside a post is shown as text, never run.
- To publish: merge into `main`, then in cPanel → Git Version Control, click **Update from Remote** (and **Deploy HEAD Commit** if you use it).
- The list is at `/blog`, and the RSS feed at `/blog/feed.xml`.
