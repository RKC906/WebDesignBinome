<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Backoffice - Articles</title>
    <link rel="stylesheet" href="views/css/style.css">
    <style>
        .actions { margin: 1rem 0; }
        table { width: 100%; border-collapse: collapse; background: #fff; }
        th, td { border: 1px solid #e5e7eb; padding: .6rem; text-align: left; }
        th { background: #f9fafb; }
        .btn { display: inline-block; padding: .45rem .8rem; border-radius: 6px; text-decoration: none; background: #2563eb; color: #fff; }
        .btn-danger { background: #dc2626; }
        .btn-secondary { background: #4b5563; }
    </style>
</head>
<body>
<main class="container">
    <div class="actions" style="display:flex;justify-content:space-between;align-items:center;">
        <p style="margin:0;">Connecté : <strong><?= htmlspecialchars((string) ($_SESSION['admin']['username'] ?? '')) ?></strong></p>
        <a class="btn btn-secondary" href="/backoffice/index.php?page=auth&action=logout">Se déconnecter</a>
    </div>

    <h1>Gestion des articles</h1>

    <div class="actions">
        <a class="btn" href="/backoffice/index.php?page=articles&action=create">+ Nouvel article</a>
    </div>

    <table>
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
                        <a class="btn btn-secondary" href="/backoffice/index.php?page=articles&action=edit&id=<?= (int) $item['id'] ?>">Modifier</a>
                        <a class="btn btn-danger" href="/backoffice/index.php?page=articles&action=delete&id=<?= (int) $item['id'] ?>" onclick="return confirm('Supprimer cet article ?');">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</main>
</body>
</html>
