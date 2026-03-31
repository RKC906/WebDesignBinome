<?php
$featured = $articles[0] ?? null;
$moreArticles = array_slice($articles, 1);
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars((string) ($pageTitle ?? 'Actualités')) ?></title>
    <meta name="description" content="Dernières actualités sur la guerre en Iran, analyses et reportages complets.">
    <meta name="robots" content="index,follow">
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
                    <img src="<?= htmlspecialchars((string) $featured['image_url']) ?>" alt="<?= htmlspecialchars((string) $featured['titre']) ?>" loading="eager" decoding="async">
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
                    <img src="<?= htmlspecialchars((string) $article['image_url']) ?>" alt="<?= htmlspecialchars((string) $article['titre']) ?>" loading="lazy" decoding="async">
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

<script src="/views/js/main.js"></script>
</body>
</html>
