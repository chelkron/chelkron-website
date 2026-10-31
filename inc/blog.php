<?php
/**
 * chelkron.com/blog — posts are Markdown files in blog/posts/, named <date>-<address>.md, e.g.
 * blog/posts/2026-10-31-chelkron-domains.md → chelkron.com/blog/chelkron-domains
 *
 * Each file starts with a few settings between --- lines, then the post in Markdown:
 *   ---
 *   title: Introducing Chelkron Domains
 *   description: One or two sentences for the list, Google and link previews.
 *   date: 2026-10-31
 *   author: Chelkron Team            (optional)
 *   tag: Product news                (optional)
 *   draft: true                      (optional: hidden until removed)
 *   ---
 * Posts dated in the future stay hidden until that day.
 *
 *   blog_posts()          published posts, newest first
 *   blog_post($slug)      one post with its HTML, or null
 *   blog_md($markdown)    Markdown → safe HTML (raw HTML in a post is shown as text, never run)
 */

const BLOG_DIR = __DIR__ . '/../blog/posts';

function blog_parse(string $file): ?array {
    $raw = (string)@file_get_contents($file);
    if (!preg_match('/\A---\s*\n(.*?)\n---\s*\n(.*)\z/s', str_replace("\r\n", "\n", $raw), $m)) return null;
    $meta = [];
    foreach (explode("\n", $m[1]) as $line) {
        if (preg_match('/^\s*([a-z_]+)\s*:\s*(.*?)\s*$/i', $line, $kv)) $meta[strtolower($kv[1])] = trim($kv[2], " \"'");
    }
    if (!preg_match('/^(\d{4}-\d{2}-\d{2})-([a-z0-9-]+)\.md$/', basename($file), $n)) return null;
    $date = preg_match('/^\d{4}-\d{2}-\d{2}$/', $meta['date'] ?? '') ? $meta['date'] : $n[1];
    $words = str_word_count(strip_tags($m[2]));
    return [
        'slug' => $n[2], 'title' => $meta['title'] ?? $n[2], 'description' => $meta['description'] ?? '',
        'date' => $date, 'author' => $meta['author'] ?? 'Chelkron Team', 'tag' => $meta['tag'] ?? '',
        'draft' => in_array(strtolower($meta['draft'] ?? ''), ['true', 'yes', '1'], true),
        'minutes' => max(1, (int)round($words / 220)), 'body' => $m[2],
    ];
}

function blog_posts(): array {
    $out = [];
    foreach (glob(BLOG_DIR . '/*.md') ?: [] as $f) {
        $p = blog_parse($f);
        if ($p && !$p['draft'] && $p['date'] <= date('Y-m-d')) $out[$p['slug']] = $p;
    }
    uasort($out, fn($a, $b) => strcmp($b['date'], $a['date']) ?: strcmp($a['title'], $b['title']));
    return $out;
}

function blog_post(string $slug): ?array {
    if (!preg_match('/\A[a-z0-9-]{1,100}\z/', $slug)) return null;
    $p = blog_posts()[$slug] ?? null;
    if ($p) $p['html'] = blog_md($p['body']);
    return $p;
}

function blog_date(string $ymd): string { return date('j F Y', strtotime($ymd)); }

/** Links and images only to web addresses, email, or pages on this site. */
function blog_url(string $u): string {
    $u = trim(html_entity_decode($u, ENT_QUOTES, 'UTF-8'));
    return preg_match('#\A(https?://|mailto:|/(?!/)|\#)#i', $u) ? htmlspecialchars($u, ENT_QUOTES, 'UTF-8') : '#';
}

function blog_inline(string $s): string {
    $s = htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
    $code = [];
    $s = preg_replace_callback('/`([^`]+)`/', function ($m) use (&$code) { $code[] = '<code>' . $m[1] . '</code>'; return "\x01" . (count($code) - 1) . "\x01"; }, $s);
    $s = preg_replace_callback('/!\[([^\]]*)\]\(([^)\s]+)\)/', fn($m) => '<img src="' . blog_url($m[2]) . '" alt="' . $m[1] . '" loading="lazy">', $s);
    $s = preg_replace_callback('/\[([^\]]+)\]\(([^)\s]+)\)/', function ($m) {
        $href = blog_url($m[2]); $ext = preg_match('#^https?://(?!chelkron\.com|[a-z0-9-]+\.chelkron\.com)#i', html_entity_decode($href));
        return '<a href="' . $href . '"' . ($ext ? ' target="_blank" rel="noopener"' : '') . '>' . $m[1] . '</a>';
    }, $s);
    $s = preg_replace('/\*\*(.+?)\*\*/', '<strong>$1</strong>', $s);
    $s = preg_replace('/(?<![\w*])\*(?!\s)(.+?)(?<!\s)\*(?![\w*])/', '<em>$1</em>', $s);
    return preg_replace_callback("/\x01(\d+)\x01/", fn($m) => $code[(int)$m[1]], $s);
}

function blog_md(string $md): string {
    $lines = explode("\n", str_replace("\r\n", "\n", $md));
    $html = ''; $para = []; $list = null; $items = []; $quote = [];
    $flush = function () use (&$html, &$para, &$list, &$items, &$quote) {
        if ($para)  { $html .= '<p>' . blog_inline(implode(' ', $para)) . "</p>\n"; $para = []; }
        if ($list)  { $html .= "<$list>" . implode('', array_map(fn($i) => '<li>' . blog_inline($i) . '</li>', $items)) . "</$list>\n"; $list = null; $items = []; }
        if ($quote) { $html .= '<blockquote><p>' . blog_inline(implode(' ', $quote)) . "</p></blockquote>\n"; $quote = []; }
    };
    for ($i = 0, $n = count($lines); $i < $n; $i++) {
        $l = rtrim($lines[$i]);
        if (preg_match('/^```/', $l)) {
            $flush(); $buf = [];
            for ($i++; $i < $n && !preg_match('/^```/', $lines[$i]); $i++) $buf[] = $lines[$i];
            $html .= '<pre><code>' . htmlspecialchars(implode("\n", $buf), ENT_QUOTES, 'UTF-8') . "</code></pre>\n";
            continue;
        }
        if (trim($l) === '') { $flush(); continue; }
        if (preg_match('/^(#{2,4})\s+(.*)$/', $l, $m)) {
            $flush(); $lv = strlen($m[1]);
            $id = trim(preg_replace('/[^a-z0-9]+/', '-', strtolower($m[2])), '-');
            $html .= "<h$lv id=\"" . $id . '">' . blog_inline($m[2]) . "</h$lv>\n"; continue;
        }
        if (preg_match('/^(-{3,}|\*{3,})$/', trim($l))) { $flush(); $html .= "<hr>\n"; continue; }
        if (preg_match('/^>\s?(.*)$/', $l, $m)) { if ($para || $list) $flush(); $quote[] = $m[1]; continue; }
        if (preg_match('/^\s*[-*]\s+(.*)$/', $l, $m)) { if ($list !== 'ul') $flush(); $list = 'ul'; $items[] = $m[1]; continue; }
        if (preg_match('/^\s*\d+[.)]\s+(.*)$/', $l, $m)) { if ($list !== 'ol') $flush(); $list = 'ol'; $items[] = $m[1]; continue; }
        if ($list && preg_match('/^\s{2,}(.*)$/', $l, $m)) { $items[count($items) - 1] .= ' ' . $m[1]; continue; }
        if ($list || $quote) $flush();
        $para[] = trim($l);
    }
    $flush();
    return $html;
}
