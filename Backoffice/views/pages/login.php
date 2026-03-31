<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Backoffice - Connexion</title>
    <link rel="stylesheet" href="/backoffice/views/css/style.css?v=20260331">
</head>
<body>
<main class="bo-main">
    <section class="bo-login">
        <h1>Connexion administrateur</h1>
        <p>Accès sécurisé au backoffice.</p>

        <form class="bo-form" method="post" action="/backoffice/index.php?page=auth&action=authenticate">
            <div>
                <label for="username">Nom d'utilisateur</label>
                <input id="username" name="username" type="text" required value="cedy">
            </div>

            <div>
                <label for="password">Mot de passe</label>
                <input id="password" name="password" type="password" required value="cedy123">
            </div>

            <button class="bo-btn bo-btn-primary" type="submit">Se connecter</button>
        </form>

        <?php if (!empty($error)): ?>
            <p class="bo-alert"><?= htmlspecialchars((string) $error) ?></p>
        <?php endif; ?>
    </section>
</main>
</body>
</html>
