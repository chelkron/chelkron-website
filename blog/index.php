<?php
require __DIR__ . '/../inc/layout.php';
require __DIR__ . '/../inc/blog.php';
$posts = blog_posts();
site_head('Blog', 'News, guides and ideas from Chelkron for growing African businesses: running your team, professional email and your name online.', '/blog', ['feed' => true]); ?>

<section class="page-head">
    <div class="wrap">
        <p class="eyebrow">Blog</p>
        <h1>Ideas for growing businesses.</h1>
        <p>Practical guides on running your team, professional email and getting your business online, plus news from Chelkron.</p>
    </div>
</section>

<section class="blog-list" aria-label="Posts">
    <div class="wrap">
        <?php if (!$posts): ?>
        <p class="blog-empty">The first posts are on their way.</p>
        <?php else: ?>
        <div class="posts">
            <?php foreach ($posts as $p): ?>
            <article class="post-card">
                <p class="post-meta"><?php if ($p['tag'] !== ''): ?><span class="post-tag"><?= site_e($p['tag']) ?></span><?php endif; ?><time datetime="<?= site_e($p['date']) ?>"><?= site_e(blog_date($p['date'])) ?></time> · <?= (int)$p['minutes'] ?> min read</p>
                <h2><a href="/blog/<?= site_e($p['slug']) ?>"><?= site_e($p['title']) ?></a></h2>
                <?php if ($p['description'] !== ''): ?><p><?= site_e($p['description']) ?></p><?php endif; ?>
                <a class="more" href="/blog/<?= site_e($p['slug']) ?>" aria-label="Read: <?= site_e($p['title']) ?>">Read more <span aria-hidden="true">→</span></a>
            </article>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
        <p class="blog-feed"><a href="/blog/feed.xml">RSS feed</a></p>
    </div>
</section>

<?php site_foot(); ?>
