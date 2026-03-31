<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars((string) ($pageTitle ?? 'Catégorie')) ?></title>
    <meta name="description" content="Actualités de la catégorie <?= htmlspecialchars((string) ($currentCategory['nom'] ?? '')) ?>">
    <link rel="stylesheet" href="/frontoffice/views/css/style.css">
</head>
<body>
<header class="header">
    <div class="container">
        <a class="logo" href="/frontoffice/">Iran War News</a>
        <nav class="nav" aria-label="Catégories">
            <?php foreach ($categories as $category): ?>
                <a href="/frontoffice/categorie/<?= htmlspecialchars((string) $category['slug']) ?>">
                    <?= htmlspecialchars((string) $category['nom']) ?>
                </a>
            <?php endforeach; ?>
        </nav>
    </div>
</header>

<main class="container">
    <h1>Catégorie : <?= htmlspecialchars((string) $currentCategory['nom']) ?></h1>

    <section class="grid">
        <?php if (empty($articles)): ?>
            <p>Aucun article publié dans cette catégorie.</p>
        <?php else: ?>
            <?php foreach ($articles as $article): ?>
                <article class="card">
                    <?php if (!empty($article['image_url'])): ?>
                        <img src="<?= htmlspecialchars((string) $article['image_url']) ?>" alt="<?= htmlspecialchars((string) $article['titre']) ?>">
                    <?php endif; ?>
                    <div class="card-content">
                        <p class="meta">
                            <?= htmlspecialchars((string) $article['auteur_nom']) ?> <?= htmlspecialchars((string) $article['auteur_prenom']) ?> ·
                            <?= htmlspecialchars((string) $article['created_at']) ?>
                        </p>
                        <h2>
                            <a href="/frontoffice/article/<?= htmlspecialchars((string) $article['slug']) ?>">
                                <?= htmlspecialchars((string) $article['titre']) ?>
                            </a>
                        </h2>
                        <p><?= htmlspecialchars((string) ($article['description'] ?? '')) ?></p>
                    </div>
                </article>
            <?php endforeach; ?>
        <?php endif; ?>
    </section>
</main>

<script src="/frontoffice/views/js/main.js"></script>
</body>
</html>
