<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars((string) ($pageTitle ?? 'Article')) ?></title>
    <meta name="description" content="<?= htmlspecialchars((string) ($article['description'] ?? '')) ?>">
    <link rel="stylesheet" href="/views/css/style.css">
</head>
<body>
<header class="header">
    <div class="container">
    <a class="logo" href="/">Iran War News</a>
        <nav class="nav" aria-label="Catégories">
            <?php foreach ($categories as $category): ?>
                <a href="/categorie/<?= htmlspecialchars((string) $category['slug']) ?>">
                    <?= htmlspecialchars((string) $category['nom']) ?>
                </a>
            <?php endforeach; ?>
        </nav>
    </div>
</header>

<main class="container">
    <article class="article">
        <p class="meta">
            <a href="/categorie/<?= htmlspecialchars((string) $article['categorie_slug']) ?>">
                <?= htmlspecialchars((string) $article['categorie_nom']) ?>
            </a>
            · <?= htmlspecialchars((string) $article['auteur_nom']) ?> <?= htmlspecialchars((string) $article['auteur_prenom']) ?>
            · <?= htmlspecialchars((string) $article['created_at']) ?>
        </p>

        <h1><?= htmlspecialchars((string) $article['titre']) ?></h1>

        <?php if (!empty($article['image_url'])): ?>
            <img src="<?= htmlspecialchars((string) $article['image_url']) ?>" alt="<?= htmlspecialchars((string) $article['titre']) ?>">
        <?php endif; ?>

        <p><?= nl2br(htmlspecialchars((string) $article['contenus'])) ?></p>
    </article>
</main>

<script src="/views/js/main.js"></script>
</body>
</html>
