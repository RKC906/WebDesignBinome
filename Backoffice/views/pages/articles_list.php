<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Backoffice - Articles</title>
    <link rel="stylesheet" href="/backoffice/views/css/style.css?v=20260331">
</head>
<body>
<div class="bo-layout">
    <aside class="bo-sidebar">
        <div class="bo-brand">Iran War News</div>
        <nav class="bo-nav">
            <a class="active" href="/backoffice/index.php?page=articles&action=list">Articles</a>
            <a href="/backoffice/index.php?page=articles&action=create">Nouvel article</a>
            <a href="/backoffice/index.php?page=auth&action=logout">Se déconnecter</a>
        </nav>
        <div class="bo-user">
            Connecté : <strong><?= htmlspecialchars((string) ($_SESSION['admin']['username'] ?? '')) ?></strong>
        </div>
    </aside>

    <main class="bo-main">
        <div class="bo-topbar">
            <h1 class="bo-title">Gestion des articles</h1>
            <a class="bo-btn bo-btn-primary" href="/backoffice/index.php?page=articles&action=create">+ Nouvel article</a>
        </div>

        <section class="bo-card">
            <table class="bo-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Titre</th>
                        <th>Slug</th>
                        <th>Auteur</th>
                        <th>Catégorie</th>
                        <th>Publié</th>
                        <th>Créé le</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (empty($articles)): ?>
                    <tr>
                        <td colspan="8">Aucun article.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($articles as $item): ?>
                        <tr>
                            <td><?= (int) $item['id'] ?></td>
                            <td><?= htmlspecialchars($item['titre']) ?></td>
                            <td><?= htmlspecialchars($item['slug']) ?></td>
                            <td><?= htmlspecialchars($item['auteur_nom'] . ' ' . $item['auteur_prenom']) ?></td>
                            <td><?= htmlspecialchars($item['categorie_nom']) ?></td>
                            <td><?= !empty($item['published']) ? 'Oui' : 'Non' ?></td>
                            <td><?= htmlspecialchars((string) $item['created_at']) ?></td>
                            <td>
                                <div class="bo-actions">
                                    <a class="bo-btn bo-btn-secondary" href="/backoffice/index.php?page=articles&action=edit&id=<?= (int) $item['id'] ?>">Modifier</a>
                                    <a class="bo-btn bo-btn-danger" href="/backoffice/index.php?page=articles&action=delete&id=<?= (int) $item['id'] ?>" onclick="return confirm('Supprimer cet article ?');">Supprimer</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </section>
    </main>
</div>
</body>
</html>
