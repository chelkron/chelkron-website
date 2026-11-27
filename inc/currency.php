<?php
/**
 * chelkron.com — prices in the visitor's own currency.
 *
 * Chelkron charges in naira; every price on the site is shown in the visitor's currency instead (naira in Nigeria),
 * converted from the naira price at today's rate, the same way the apps do it.
 *
 *   site_country()        the visitor's country: their choice (?country=GH, kept in a cookie), else Cloudflare's
 *                         CF-IPCountry header, else a look-up of their IP address (kept in a cookie), else Nigeria
 *   site_money($ngn)      "GH₵270" / "KSh 2,300" / "₦27,500" for a naira amount
 *   site_countries()      the countries in the footer picker
 *
 * Rates come from open.er-api.com (free, no key) once a day and are kept in the server's temp folder; if that fails,
 * the built-in rates below are used.
 */
const SITE_CURRENCY_COOKIE = 'ck_country';

/** Country code => [name, currency, symbol]. Others see US dollars. */
function site_countries(): array {
    return [
        'NG' => ['Nigeria', 'NGN', '₦'], 'GH' => ['Ghana', 'GHS', 'GH₵'], 'KE' => ['Kenya', 'KES', 'KSh '], 'ZA' => ['South Africa', 'ZAR', 'R'],
        'CI' => ["Côte d'Ivoire", 'XOF', 'CFA '], 'SN' => ['Senegal', 'XOF', 'CFA '], 'BJ' => ['Benin', 'XOF', 'CFA '], 'TG' => ['Togo', 'XOF', 'CFA '],
        'BF' => ['Burkina Faso', 'XOF', 'CFA '], 'ML' => ['Mali', 'XOF', 'CFA '], 'NE' => ['Niger', 'XOF', 'CFA '],
        'CM' => ['Cameroon', 'XAF', 'FCFA '], 'GA' => ['Gabon', 'XAF', 'FCFA '], 'CG' => ['Republic of the Congo', 'XAF', 'FCFA '],
        'UG' => ['Uganda', 'UGX', 'USh '], 'TZ' => ['Tanzania', 'TZS', 'TSh '], 'RW' => ['Rwanda', 'RWF', 'FRw '], 'ET' => ['Ethiopia', 'ETB', 'Br '],
        'EG' => ['Egypt', 'EGP', 'E£'], 'MA' => ['Morocco', 'MAD', 'DH '], 'ZM' => ['Zambia', 'ZMW', 'K'], 'BW' => ['Botswana', 'BWP', 'P'],
        'GM' => ['Gambia', 'GMD', 'D'], 'SL' => ['Sierra Leone', 'SLE', 'Le '], 'LR' => ['Liberia', 'LRD', 'L$'], 'MW' => ['Malawi', 'MWK', 'MK '],
        'NA' => ['Namibia', 'NAD', 'N$'], 'MZ' => ['Mozambique', 'MZN', 'MT '], 'AO' => ['Angola', 'AOA', 'Kz '], 'CD' => ['DR Congo', 'CDF', 'FC '],
        'MU' => ['Mauritius', 'MUR', 'Rs '], 'ZW' => ['Zimbabwe', 'USD', '$'],
        '__' => ['Other countries (US$)', 'USD', '$'],
    ];
}

/** Units per US dollar: today's from the cache or the API, else these (late 2026). */
function site_rates(): array {
    static $rates = null;
    if ($rates !== null) return $rates;
    $rates = ['USD' => 1, 'NGN' => 1620, 'GHS' => 15.5, 'KES' => 129.5, 'ZAR' => 18.6, 'XOF' => 610, 'XAF' => 610, 'UGX' => 3700, 'TZS' => 2600,
              'RWF' => 1420, 'ETB' => 125, 'EGP' => 49, 'MAD' => 10, 'ZMW' => 27, 'BWP' => 13.8, 'GMD' => 72, 'SLE' => 23, 'LRD' => 190,
              'MWK' => 1740, 'NAD' => 18.6, 'MZN' => 64, 'AOA' => 920, 'CDF' => 2850, 'MUR' => 46];
    $file = rtrim(sys_get_temp_dir(), '/') . '/chelkron-web-rates.json';
    $cached = is_readable($file) ? json_decode((string)@file_get_contents($file), true) : null;
    if (is_array($cached) && filemtime($file) > time() - 86400) return $rates = array_merge($rates, $cached);
    $ctx = stream_context_create(['http' => ['timeout' => 4], 'https' => ['timeout' => 4]]);
    $d = json_decode((string)@file_get_contents('https://open.er-api.com/v6/latest/USD', false, $ctx), true);
    if (($d['result'] ?? '') === 'success' && is_array($d['rates'] ?? null)) {
        $keep = array_intersect_key($d['rates'], $rates);
        @file_put_contents($file, json_encode($keep), LOCK_EX);
        return $rates = array_merge($rates, $keep);
    }
    if (is_array($cached)) { @touch($file, time() - 86400 + 3600); return $rates = array_merge($rates, $cached); }   // try again in an hour
    return $rates;
}

function site_country(): string {
    static $cc = null;
    if ($cc !== null) return $cc;
    $list = site_countries();
    $ok = fn($c) => is_string($c) && isset($list[strtoupper($c)]) ? strtoupper($c) : null;
    if ($c = $ok($_COOKIE[SITE_CURRENCY_COOKIE] ?? null)) return $cc = $c;
    $cf = strtoupper((string)($_SERVER['HTTP_CF_IPCOUNTRY'] ?? ''));
    if (preg_match('/^[A-Z]{2}$/', $cf) && $cf !== 'XX') return $cc = ($ok($cf) ?? '__');
    // No Cloudflare: look the address up once, and remember it
    $ip = (string)($_SERVER['REMOTE_ADDR'] ?? '');
    $found = '';
    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
        $ctx = stream_context_create(['http' => ['timeout' => 2], 'https' => ['timeout' => 2]]);
        $found = strtoupper(trim((string)@file_get_contents('https://ipapi.co/' . rawurlencode($ip) . '/country/', false, $ctx)));
    }
    $cc = preg_match('/^[A-Z]{2}$/', $found) ? ($ok($found) ?? '__') : 'NG';
    if ($found !== '' && !headers_sent()) site_country_cookie($cc);
    return $cc;
}

function site_country_cookie(string $cc): void {
    setcookie(SITE_CURRENCY_COOKIE, $cc, ['expires' => time() + 90 * 86400, 'path' => '/', 'samesite' => 'Lax', 'secure' => !empty($_SERVER['HTTPS'])]);
    $_COOKIE[SITE_CURRENCY_COOKIE] = $cc;
}

/** ?country=GH from the footer picker: remember it and reload the page without the parameter. */
function site_country_pick(): void {
    if (!isset($_GET['country']) || headers_sent()) return;
    $cc = strtoupper((string)$_GET['country']);
    if (isset(site_countries()[$cc])) site_country_cookie($cc);
    $path = strtok((string)($_SERVER['REQUEST_URI'] ?? '/'), '?') ?: '/';
    header('Location: ' . $path, true, 303);
    exit;
}

/** A naira amount in the visitor's currency, rounded like the apps ("GH₵270", "KSh 2,300", "$17"). */
function site_money(float $ngn): string {
    [, $cur, $sym] = site_countries()[site_country()];
    if ($cur === 'NGN') return '₦' . number_format($ngn);
    $r = site_rates();
    $v = $ngn / $r['NGN'] * ($r[$cur] ?? 0);
    if ($v <= 0) { $v = $ngn / $r['NGN']; $sym = '$'; }
    $v = $v >= 1000 ? round($v / 100) * 100 : ($v >= 100 ? round($v / 10) * 10 : ($v >= 1 ? round($v) : round($v, 2)));
    return $sym . number_format($v, $v >= 1 ? 0 : 2);
}
