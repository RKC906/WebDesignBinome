<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars((string) ($pageTitle ?? 'Catégorie')) ?></title>
    <meta name="description" content="Actualités de la catégorie <?= htmlspecialchars((string) ($currentCategory['nom'] ?? '')) ?>">
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
    <section class="hero">
        <div>
            <span class="kicker">Catégorie</span>
            <h1 class="headline"><?= htmlspecialchars((string) $currentCategory['nom']) ?></h1>
            <p class="summary"><?= htmlspecialchars((string) ($currentCategory['description'] ?? '')) ?></p>
        </div>
    </section>

    <section class="story-grid">
        <?php if (empty($articles)): ?>
            <p>Aucun article publié dans cette catégorie.</p>
        <?php else: ?>
            <?php foreach ($articles as $article): ?>
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
        <?php endif; ?>
    </section>
</main>

<footer class="footer">
    <div class="container">
        <p>Iran War News · Catégories</p>
    </div>
</footer>

<script src="/views/js/main.js"></script>
</body>
</html>
