<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page introuvable</title>
    <link rel="stylesheet" href="/views/css/style.css">
</head>
<body>
<main class="not-found">
    <h1>404</h1>
    <p><?= htmlspecialchars((string) ($message ?? 'Ressource introuvable.')) ?></p>
    <a href="/">Retour à l'accueil</a>
</main>
</body>
</html>
