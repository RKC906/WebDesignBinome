<?php
$featured = $articles[0] ?? null;
$moreArticles = array_slice($articles, 1);

function webp_url(?string $url): ?string
{
    if (empty($url) || strpos($url, '/uploads/') !== 0) {
        return null;
    }

    $webp = preg_replace('/\.(jpe?g|png)$/i', '.webp', $url);
    if (!$webp || $webp === $url) {
        return null;
    }

    $path = '/var/www/html' . $webp;
    return file_exists($path) ? $webp : null;
}

function webp_srcset(?string $url): ?string
{
    if (empty($url) || strpos($url, '/uploads/') !== 0) {
        return null;
    }

    $base = preg_replace('/\.(jpe?g|png)$/i', '', $url);
    if (!$base) {
        return null;
    }

    $candidates = [];
    foreach ([600, 1200] as $size) {
        $variant = sprintf('%s@%d.webp', $base, $size);
        $path = '/var/www/html' . $variant;
        if (file_exists($path)) {
            $candidates[] = sprintf('%s %dw', $variant, $size);
        }
    }

    $full = webp_url($url);
    if ($full) {
        $candidates[] = sprintf('%s 1600w', $full);
    }

    return $candidates ? implode(', ', $candidates) : null;
}
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars((string) ($pageTitle ?? 'Actualités')) ?></title>
    <meta name="description" content="Dernières actualités sur la guerre en Iran, analyses et reportages complets.">
    <meta name="robots" content="index,follow">
    <link rel="preload" href="/views/css/style.css" as="style">
    <link rel="stylesheet" href="/views/css/style.css">
</head>
<body>
<header class="site-header">
    <div class="container">
        <div class="topbar">
            <a class="logo" href="/">Iran War News</a>
            <div class="meta-bar">
                <span>Frontoffice</span>
                <span><?= date('d/m/Y') ?></span>
            </div>
        </div>
        <nav aria-label="Catégories">
            <div class="nav-primary">
                <?php foreach ($categories as $category): ?>
                    <a href="/categorie/<?= htmlspecialchars((string) $category['slug']) ?>">
                        <?= htmlspecialchars((string) $category['nom']) ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </nav>
    </div>
</header>

<main class="container">
    <?php if ($featured): ?>
        <section class="hero">
            <article class="hero-card">
                <?php if (!empty($featured['image_url'])): ?>
                    <?php $featuredWebp = webp_url((string) $featured['image_url']); ?>
                    <?php $featuredSrcset = webp_srcset((string) $featured['image_url']); ?>
                    <?php $featuredSrc = $featuredWebp ?: (string) $featured['image_url']; ?>
                    <link rel="preload" as="image" href="<?= htmlspecialchars($featuredSrc) ?>" fetchpriority="high">
                    <picture>
                        <?php if ($featuredWebp): ?>
                            <source type="image/webp" srcset="<?= htmlspecialchars($featuredSrcset ?: $featuredWebp) ?>" sizes="(max-width: 900px) 100vw, 820px">
                        <?php endif; ?>
                        <img src="<?= htmlspecialchars((string) $featured['image_url']) ?>" alt="<?= htmlspecialchars((string) $featured['titre']) ?>" loading="eager" decoding="async" fetchpriority="high" sizes="(max-width: 900px) 100vw, 820px">
                    </picture>
                <?php endif; ?>
                <div class="hero-body">
                    <span class="kicker">À la une</span>
                    <h1 class="headline">
                        <a href="/article/<?= htmlspecialchars((string) $featured['slug']) ?>">
                            <?= htmlspecialchars((string) $featured['titre']) ?>
                        </a>
                    </h1>
                    <p class="summary"><?= htmlspecialchars((string) ($featured['description'] ?? '')) ?></p>
                    <p class="story-meta">
                        <?= htmlspecialchars((string) $featured['auteur_nom']) ?> <?= htmlspecialchars((string) $featured['auteur_prenom']) ?> ·
                        <time datetime="<?= htmlspecialchars((string) date('c', strtotime((string) $featured['created_at']))) ?>">
                            <?= htmlspecialchars((string) $featured['created_at']) ?>
                        </time>
                    </p>
                </div>
            </article>
        </section>
    <?php endif; ?>

    <section class="story-grid" aria-label="Actualités récentes">
        <?php foreach ($moreArticles as $article): ?>
            <article class="story-card">
                <?php if (!empty($article['image_url'])): ?>
                    <?php $articleWebp = webp_url((string) $article['image_url']); ?>
                    <?php $articleSrcset = webp_srcset((string) $article['image_url']); ?>
                    <picture>
                        <?php if ($articleWebp): ?>
                            <source type="image/webp" srcset="<?= htmlspecialchars($articleSrcset ?: $articleWebp) ?>" sizes="(max-width: 768px) 100vw, 292px">
                        <?php endif; ?>
                        <img src="<?= htmlspecialchars((string) $article['image_url']) ?>" alt="<?= htmlspecialchars((string) $article['titre']) ?>" loading="lazy" decoding="async" sizes="(max-width: 768px) 100vw, 292px">
                    </picture>
                <?php endif; ?>
                <div class="story-body">
                    <span class="badge"><?= htmlspecialchars((string) $article['categorie_nom']) ?></span>
                    <h2 class="story-title">
                        <a href="/article/<?= htmlspecialchars((string) $article['slug']) ?>">
                            <?= htmlspecialchars((string) $article['titre']) ?>
                        </a>
                    </h2>
                    <p class="summary"><?= htmlspecialchars((string) ($article['description'] ?? '')) ?></p>
                    <p class="story-meta">
                        <?= htmlspecialchars((string) $article['auteur_nom']) ?> <?= htmlspecialchars((string) $article['auteur_prenom']) ?> ·
                        <time datetime="<?= htmlspecialchars((string) date('c', strtotime((string) $article['created_at']))) ?>">
                            <?= htmlspecialchars((string) $article['created_at']) ?>
                        </time>
                    </p>
                </div>
            </article>
        <?php endforeach; ?>
    </section>
</main>

<footer class="footer">
    <div class="container">
        <p>Iran War News · Projet Web Design · Frontoffice</p>
    </div>
</footer>

<script src="/views/js/main.js" defer></script>
</body>
</html>
