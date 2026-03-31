<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars((string) ($pageTitle ?? 'Actualités')) ?></title>
    <meta name="description" content="Dernières actualités sur la guerre en Iran">
    <link rel="stylesheet" href="/views/css/style.css">
</head>
<body>
<header class="header">
    <div class="container">
    <a class="logo" href="/">Iran War News</a>
        <nav class="nav" aria-label="Catégories">
            <?php foreach ($categories as $category): ?>
                <a href="/categorie/<?= htmlspecialchars((string) $category['slug']) ?>">
                    <?= htmlspecialchars((string) $category['nom']) ?> (<?= (int) $category['articles_count'] ?>)
                </a>
            <?php endforeach; ?>
        </nav>
    </div>
</header>

<main class="container">
    <h1>Actualités récentes</h1>

    <section class="grid">
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
                    <span class="badge"><?= htmlspecialchars((string) $article['categorie_nom']) ?></span>
                    <h2>
                        <a href="/article/<?= htmlspecialchars((string) $article['slug']) ?>">
                            <?= htmlspecialchars((string) $article['titre']) ?>
                        </a>
                    </h2>
                    <p><?= htmlspecialchars((string) ($article['description'] ?? '')) ?></p>
                </div>
            </article>
        <?php endforeach; ?>
    </section>
</main>

<script src="/views/js/main.js"></script>
</body>
</html>
