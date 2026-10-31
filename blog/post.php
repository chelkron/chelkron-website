<?php
require __DIR__ . '/../inc/layout.php';
require __DIR__ . '/../inc/blog.php';
$post = blog_post((string)($_GET['slug'] ?? ''));
if (!$post) {
    http_response_code(404);
    site_head('Post not found', 'This blog post doesn’t exist or has moved.', '/blog', ['nav' => '/blog']); ?>
<section class="page-head"><div class="wrap"><p class="eyebrow">Blog</p><h1>We couldn’t find that post.</h1><p>It may have moved. <a href="/blog">See all posts</a>.</p></div></section>
<?php site_foot(false); exit;
}
$more = array_slice(array_filter(blog_posts(), fn($p) => $p['slug'] !== $post['slug']), 0, 2);
site_head($post['title'], $post['description'] ?: $post['title'], '/blog/' . $post['slug'],
          ['nav' => '/blog', 'og_type' => 'article', 'published' => $post['date'], 'feed' => true]); ?>
<script type="application/ld+json"><?= json_encode(['@context' => 'https://schema.org', '@type' => 'BlogPosting', 'headline' => $post['title'],
    'description' => $post['description'], 'datePublished' => $post['date'], 'author' => ['@type' => 'Organization', 'name' => $post['author']],
    'publisher' => ['@type' => 'Organization', 'name' => 'Chelkron Technologies Limited', 'logo' => 'https://chelkron.com/assets/favicon.png'],
    'mainEntityOfPage' => 'https://chelkron.com/blog/' . $post['slug']], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) ?></script>

<header class="post-head">
    <div class="wrap post-narrow">
        <a class="post-back" href="/blog"><span aria-hidden="true">←</span> All posts</a>
        <p class="post-meta"><?php if ($post['tag'] !== ''): ?><span class="post-tag"><?= site_e($post['tag']) ?></span><?php endif; ?><time datetime="<?= site_e($post['date']) ?>"><?= site_e(blog_date($post['date'])) ?></time> · <?= (int)$post['minutes'] ?> min read</p>
        <h1><?= site_e($post['title']) ?></h1>
        <?php if ($post['description'] !== ''): ?><p class="post-lead"><?= site_e($post['description']) ?></p><?php endif; ?>
        <p class="post-by">By <?= site_e($post['author']) ?></p>
    </div>
</header>

<article class="wrap post-narrow post-body">
<?= $post['html'] ?>
</article>

<?php if ($more): ?>
<section class="post-more" aria-labelledby="more-h">
    <div class="wrap post-narrow">
        <h2 id="more-h">More from the blog</h2>
        <div class="posts">
            <?php foreach ($more as $p): ?>
            <article class="post-card">
                <p class="post-meta"><time datetime="<?= site_e($p['date']) ?>"><?= site_e(blog_date($p['date'])) ?></time> · <?= (int)$p['minutes'] ?> min read</p>
                <h3><a href="/blog/<?= site_e($p['slug']) ?>"><?= site_e($p['title']) ?></a></h3>
            </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php site_foot(); ?>
