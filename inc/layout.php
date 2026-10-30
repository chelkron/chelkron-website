<?php
/**
 * chelkron.com — the header, menu and footer every page shares.
 *
 *   <?php require __DIR__ . '/../inc/layout.php';
 *   site_head('Pricing', 'Plans and prices for Chelkron Workforce and Chelkron Mail.', '/pricing'); ?>
 *   …the page…
 *   <?php site_foot(); ?>
 *
 * To add or rename a menu item, change SITE_NAV below; every page picks it up.
 */
const SITE_NAV = [
    '/workforce' => 'Workforce',
    '/mail'      => 'Mail',
    '/pricing'   => 'Pricing',
    '/about'     => 'About',
    '/contact'   => 'Contact',
];
const SITE_CSS_VERSION = 7;

function site_e(string $s): string { return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); }

/**
 * A marketing partner's code from their link (chelkron.com/workforce?ref=ADA), remembered here for 60 days.
 * site.js adds it to every link to the Workforce and Mail sites, which check the code, count the visit and
 * remember the partner themselves (their shared/partners.php). '' when there is none.
 */
function site_ref(): string {
    static $ref = null;
    if ($ref !== null) return $ref;
    $clean = function ($v): string { $v = strtoupper(trim((string)$v)); return preg_match('/\A[A-Z0-9][A-Z0-9_-]{2,29}\z/', $v) ? $v : ''; };
    $ref = $clean($_GET['ref'] ?? '');
    if ($ref !== '' && !headers_sent()) {
        setcookie('site_ref', $ref, ['expires' => time() + 60 * 86400, 'path' => '/', 'httponly' => true, 'samesite' => 'Lax',
                                     'secure' => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off']);
    }
    if ($ref === '') $ref = $clean($_COOKIE['site_ref'] ?? '');
    return $ref;
}

/** Everything from <!DOCTYPE> to the opening <main>. $title '' = the home page. */
function site_head(string $title, string $desc, string $path, array $opt = []): void {
    $full = $title === '' ? 'Chelkron Technologies — software for African businesses' : $title . ' · Chelkron';
    $url  = 'https://chelkron.com' . ($path === '/' ? '/' : $path);
    $here = fn(string $href) => $href === $path ? ' aria-current="page"' : '';
    $links = '';
    foreach (SITE_NAV as $href => $label) $links .= '<a href="' . $href . '"' . $here($href) . '>' . site_e($label) . '</a>';
    $body = !empty($opt['body_class']) ? ' class="' . site_e($opt['body_class']) . '"' : '';
    if (($ref = site_ref()) !== '') $body .= ' data-ref="' . site_e($ref) . '"';   // a partner's link: passed on to the product sites
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= site_e($full) ?></title>
<meta name="description" content="<?= site_e($desc) ?>">
<link rel="canonical" href="<?= site_e($url) ?>">
<meta property="og:title" content="<?= site_e($title === '' ? 'Chelkron Technologies' : $title . ' · Chelkron') ?>">
<meta property="og:description" content="<?= site_e($desc) ?>">
<meta property="og:type" content="website">
<meta property="og:url" content="<?= site_e($url) ?>">
<meta name="theme-color" content="#0F2A5C">
<link rel="icon" type="image/png" href="/assets/favicon.png">
<link rel="icon" type="image/svg+xml" href="/assets/logo.svg">
<link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,500;12..96,700&family=Geist:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="/assets/site.css?v=<?= SITE_CSS_VERSION ?>">
</head>
<body<?= $body ?>>

<header class="top">
    <div class="wrap top-in">
        <a class="brand" href="/" aria-label="Chelkron Technologies home">
            <img src="/assets/logo.svg" alt="" width="30" height="33">
            <span>Chelkron</span>
        </a>
        <nav class="nav" aria-label="Main"><?= $links ?></nav>
        <a class="btn btn-blue btn-sm top-cta" href="/pricing">Start free</a>
        <button type="button" class="menu-btn" aria-label="Open menu" aria-expanded="false" aria-controls="menu" onclick="menu(true)">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M4 7h16M4 12h16M4 17h16"/></svg>
        </button>
    </div>
</header>

<div class="menu" id="menu" role="dialog" aria-modal="true" aria-label="Menu" hidden>
    <div class="wrap menu-top">
        <a class="brand" href="/"><img src="/assets/logo.svg" alt="" width="30" height="33"><span>Chelkron</span></a>
        <button type="button" class="menu-x" aria-label="Close menu" onclick="menu(false)">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M6 6l12 12M18 6L6 18"/></svg>
        </button>
    </div>
    <nav class="wrap menu-links" aria-label="Menu"><a href="/"<?= $here('/') ?>>Home</a><?= $links ?></nav>
    <div class="wrap menu-foot">
        <a class="btn btn-blue" href="https://workforce.chelkron.com/signup">Try Chelkron Workforce free</a>
        <a class="btn btn-ghost" href="https://mail.chelkron.com/signup">Try Chelkron Mail free</a>
    </div>
</div>

<main>
<?php
}

/** A "Talk to us" band, then the footer and the shared script. */
function site_foot(bool $talk = true): void {
    if ($talk) { ?>
<section class="contact" aria-labelledby="talk-h">
    <div class="wrap contact-in">
        <div>
            <h2 id="talk-h">Your 14 days start now.</h2>
            <p>Sign up, invite your team and connect your domain. See the difference before you pay a kobo. Questions first? We're happy to help.</p>
        </div>
        <div class="contact-list">
            <a class="btn btn-light" href="/pricing">Start free</a>
            <a class="btn btn-line" href="/contact">Talk to us</a>
        </div>
    </div>
</section>
<?php } ?>
</main>

<footer class="foot">
    <div class="wrap">
        <div class="foot-grid">
            <div class="foot-brand">
                <a class="brand brand-sm" href="/"><img src="/assets/logo.svg" alt="" width="22" height="24"><span>Chelkron</span></a>
                <p>Built in Africa, for business in Africa.</p>
            </div>
            <nav aria-label="Products"><b>Products</b><a href="/workforce">Chelkron Workforce</a><a href="/mail">Chelkron Mail</a><a href="https://domains.chelkron.com/">Domains</a><a href="/pricing">Pricing</a></nav>
            <nav aria-label="Company"><b>Company</b><a href="/about">About us</a><a href="/contact">Contact</a><a href="https://support.chelkron.com/">Support</a></nav>
            <nav aria-label="Sign in"><b>Sign in</b><a href="https://workforce.chelkron.com/signin">Workforce</a><a href="https://mail.chelkron.com/signin">Mail</a><a href="https://mailbox.chelkron.com/">Mailbox</a></nav>
        </div>
        <div class="foot-base">
            <p>&copy; <span id="yr">2026</span> Chelkron Technologies Limited</p>
            <nav class="foot-legal" aria-label="Legal"><a href="/terms">Terms of Use</a><a href="/privacy-policy">Privacy Policy</a></nav>
        </div>
    </div>
</footer>
<script src="/assets/site.js?v=<?= SITE_CSS_VERSION ?>"></script>
</body>
</html>
<?php
}
