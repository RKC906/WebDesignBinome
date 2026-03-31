<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars((string) ($pageTitle ?? 'Article')) ?></title>
    <meta name="description" content="<?= htmlspecialchars((string) ($article['description'] ?? '')) ?>">
    <meta name="robots" content="index,follow">
    <link rel="stylesheet" href="/views/css/style.css">
</head>
<body>
<?php
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

<main class="article-wrap">
    <article class="article-body">
        <p class="article-meta">
            <a href="/categorie/<?= htmlspecialchars((string) $article['categorie_slug']) ?>" class="badge">
                <?= htmlspecialchars((string) $article['categorie_nom']) ?>
            </a>
            · <?= htmlspecialchars((string) $article['auteur_nom']) ?> <?= htmlspecialchars((string) $article['auteur_prenom']) ?>
            · <time datetime="<?= htmlspecialchars((string) date('c', strtotime((string) $article['created_at']))) ?>">
                <?= htmlspecialchars((string) $article['created_at']) ?>
            </time>
        </p>

        <h1 class="article-title"><?= htmlspecialchars((string) $article['titre']) ?></h1>

        <?php if (!empty($article['image_url'])): ?>
            <?php $articleWebp = webp_url((string) $article['image_url']); ?>
            <?php $articleSrcset = webp_srcset((string) $article['image_url']); ?>
            <div class="article-hero">
                <picture>
                    <?php if ($articleWebp): ?>
                        <source type="image/webp" srcset="<?= htmlspecialchars($articleSrcset ?: $articleWebp) ?>" sizes="(max-width: 900px) 100vw, 820px">
                    <?php endif; ?>
                    <img src="<?= htmlspecialchars((string) $article['image_url']) ?>" alt="<?= htmlspecialchars((string) $article['titre']) ?>" loading="lazy" decoding="async" sizes="(max-width: 900px) 100vw, 820px">
                </picture>
            </div>
        <?php endif; ?>

        <p><?= nl2br(htmlspecialchars((string) $article['contenus'])) ?></p>
    </article>
</main>

<footer class="footer">
    <div class="container">
        <p>Iran War News · Article</p>
    </div>
</footer>

<script src="/views/js/main.js" defer></script>
</body>
</html>
