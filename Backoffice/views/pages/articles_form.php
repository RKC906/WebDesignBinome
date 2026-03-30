<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Backoffice - Formulaire Article</title>
    <link rel="stylesheet" href="views/css/style.css">
    <style>
        form { background: #fff; padding: 1rem; border-radius: 8px; }
        label { display: block; margin: .75rem 0 .3rem; font-weight: 600; }
        input, textarea, select { width: 100%; padding: .55rem; border: 1px solid #d1d5db; border-radius: 6px; }
        input[type="file"] { padding: .25rem; }
        .row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
        .actions { margin-top: 1rem; display: flex; gap: .5rem; }
        .btn { display: inline-block; padding: .45rem .8rem; border-radius: 6px; border: 0; text-decoration: none; background: #2563eb; color: #fff; cursor: pointer; }
        .btn-secondary { background: #4b5563; }
        .image-preview { margin-top: .5rem; max-width: 200px; }
        .image-preview img { max-width: 100%; border-radius: 6px; }
    </style>
</head>
<body>
<main class="container">
    <h1><?= $article ? 'Modifier un article' : 'Créer un article' ?></h1>

    <form method="post" action="/backoffice/index.php?page=articles&action=<?= htmlspecialchars($formAction) ?>" enctype="multipart/form-data">
        <label for="titre">Titre</label>
        <input id="titre" name="titre" type="text" required value="<?= htmlspecialchars((string) ($article['titre'] ?? '')) ?>">

        <label for="slug">Slug</label>
        <input id="slug" name="slug" type="text" required value="<?= htmlspecialchars((string) ($article['slug'] ?? '')) ?>">

        <label for="contenus">Contenu</label>
        <textarea id="contenus" name="contenus" rows="8" required><?= htmlspecialchars((string) ($article['contenus'] ?? '')) ?></textarea>

        <label for="description">Description</label>
        <textarea id="description" name="description" rows="3"><?= htmlspecialchars((string) ($article['description'] ?? '')) ?></textarea>

        <label for="image">Image</label>
        <input id="image" name="image" type="file" accept="image/*">
        <?php if (!empty($article['image_url'])): ?>
            <div class="image-preview">
                <p>Image actuelle :</p>
                <img src="<?= htmlspecialchars($article['image_url']) ?>" alt="Image article">
            </div>
        <?php endif; ?>

        <div class="row">
            <div>
                <label for="author_id">Auteur</label>
                <select id="author_id" name="author_id" required>
                    <option value="">Choisir un auteur</option>
                    <?php foreach ($auteurs as $auteur): ?>
                        <option value="<?= (int) $auteur['id'] ?>" <?= (int) ($article['author_id'] ?? 0) === (int) $auteur['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($auteur['nom'] . ' ' . $auteur['prenom']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label for="category_id">Catégorie</label>
                <select id="category_id" name="category_id" required>
                    <option value="">Choisir une catégorie</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= (int) $category['id'] ?>" <?= (int) ($article['category_id'] ?? 0) === (int) $category['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($category['nom']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <label>
            <input type="checkbox" name="published" value="1" <?= !empty($article['published']) ? 'checked' : '' ?>>
            Publié
        </label>

        <div class="actions">
            <button class="btn" type="submit">Enregistrer</button>
            <a class="btn btn-secondary" href="/backoffice/index.php?page=articles&action=list">Annuler</a>
        </div>
    </form>
</main>
</body>
</html>
