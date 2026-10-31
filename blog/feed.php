<?php
/** chelkron.com/blog/feed.xml — the latest 20 posts as RSS. */
require __DIR__ . '/../inc/blog.php';
header('Content-Type: application/rss+xml; charset=UTF-8');
$x = fn(string $s) => htmlspecialchars($s, ENT_XML1 | ENT_QUOTES, 'UTF-8');
echo '<?xml version="1.0" encoding="UTF-8"?>', "\n";
?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
<channel>
<title>Chelkron blog</title>
<link>https://chelkron.com/blog</link>
<atom:link href="https://chelkron.com/blog/feed.xml" rel="self" type="application/rss+xml"/>
<description>News, guides and ideas from Chelkron for growing African businesses.</description>
<language>en</language>
<?php foreach (array_slice(blog_posts(), 0, 20) as $p): $url = 'https://chelkron.com/blog/' . $p['slug']; ?>
<item>
<title><?= $x($p['title']) ?></title>
<link><?= $x($url) ?></link>
<guid isPermaLink="true"><?= $x($url) ?></guid>
<pubDate><?= date(DATE_RSS, strtotime($p['date'] . ' 08:00:00')) ?></pubDate>
<description><?= $x($p['description']) ?></description>
</item>
<?php endforeach; ?>
</channel>
</rss>
