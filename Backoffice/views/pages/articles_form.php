<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Backoffice - Formulaire Article</title>
    <link rel="stylesheet" href="/backoffice/views/css/style.css?v=20260331">
    <script src="https://cdn.tiny.cloud/1/bitzncd6crhouki0ovjymhc92ek3j7dat772rgp6hrnezs4e/tinymce/8/tinymce.min.js" referrerpolicy="origin" crossorigin="anonymous"></script>
</head>
<body>
<div class="bo-layout">
    <aside class="bo-sidebar">
        <div class="bo-brand">Iran War News</div>
        <nav class="bo-nav">
            <a href="/backoffice/index.php?page=articles&action=list">Articles</a>
            <a class="active" href="/backoffice/index.php?page=articles&action=<?= htmlspecialchars($formAction) ?>">
                <?= $article ? 'Modifier' : 'Créer' ?>
            </a>
            <a href="/backoffice/index.php?page=auth&action=logout">Se déconnecter</a>
        </nav>
        <div class="bo-user">
            Connecté : <strong><?= htmlspecialchars((string) ($_SESSION['admin']['username'] ?? '')) ?></strong>
        </div>
    </aside>

    <main class="bo-main">
        <div class="bo-topbar">
            <h1 class="bo-title"><?= $article ? 'Modifier un article' : 'Créer un article' ?></h1>
            <a class="bo-btn bo-btn-secondary" href="/backoffice/index.php?page=articles&action=list">Retour</a>
        </div>

        <section class="bo-card">
            <form class="bo-form" method="post" action="/backoffice/index.php?page=articles&action=<?= htmlspecialchars($formAction) ?>" enctype="multipart/form-data">
                <div>
                    <label for="titre">Titre</label>
                    <input id="titre" name="titre" type="text" required value="<?= htmlspecialchars((string) ($article['titre'] ?? '')) ?>">
                </div>

                <div>
                    <label for="slug">Slug</label>
                    <input id="slug" name="slug" type="text" required value="<?= htmlspecialchars((string) ($article['slug'] ?? '')) ?>">
                </div>

                <div>
                    <label for="contenus">Contenu</label>
                    <textarea id="contenus" name="contenus" rows="8" required><?= htmlspecialchars((string) ($article['contenus'] ?? '')) ?></textarea>
                </div>

                <div>
                    <label for="description">Description</label>
                    <textarea id="description" name="description" rows="3"><?= htmlspecialchars((string) ($article['description'] ?? '')) ?></textarea>
                </div>

                <div>
                    <label for="image">Image</label>
                    <input id="image" name="image" type="file" accept="image/*">
                    <?php if (!empty($article['image_url'])): ?>
                        <div class="image-preview">
                            <p>Image actuelle :</p>
                            <img src="<?= htmlspecialchars($article['image_url']) ?>" alt="Image article">
                        </div>
                    <?php endif; ?>
                </div>

                <div class="bo-grid">
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

                <div class="bo-actions">
                    <button class="bo-btn bo-btn-primary" type="submit">Enregistrer</button>
                    <a class="bo-btn bo-btn-secondary" href="/backoffice/index.php?page=articles&action=list">Annuler</a>
                </div>
            </form>
        </section>
    </main>
</div>
<script>
    tinymce.init({
        selector: '#contenus',
        plugins: [
            'anchor', 'autolink', 'charmap', 'codesample', 'emoticons', 'link', 'lists', 'media', 'searchreplace', 'table', 'visualblocks', 'wordcount',
            'checklist', 'mediaembed', 'casechange', 'formatpainter', 'pageembed', 'a11ychecker', 'tinymcespellchecker', 'permanentpen', 'powerpaste', 'advtable', 'advcode', 'advtemplate', 'ai', 'uploadcare', 'mentions', 'tinycomments', 'tableofcontents', 'footnotes', 'mergetags', 'autocorrect', 'typography', 'inlinecss', 'markdown', 'importword', 'exportword', 'exportpdf'
        ],
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography uploadcare | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
        tinycomments_mode: 'embedded',
        tinycomments_author: 'Author name',
        mergetags_list: [
            { value: 'First.Name', title: 'First Name' },
            { value: 'Email', title: 'Email' }
        ],
        ai_request: (request, respondWith) => respondWith.string(() => Promise.reject('See docs to implement AI Assistant')),
        uploadcare_public_key: '5d82f0d11e1ddcbba5df'
    });
</script>
</body>
</html>
