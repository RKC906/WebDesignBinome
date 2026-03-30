<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Backoffice - Connexion</title>
    <link rel="stylesheet" href="views/css/style.css">
    <style>
        .login-card { max-width: 420px; margin: 4rem auto; background: #fff; padding: 1.2rem; border-radius: 10px; box-shadow: 0 8px 20px rgba(0,0,0,.08); }
        label { display:block; margin:.8rem 0 .3rem; font-weight:600; }
        input { width:100%; padding:.6rem; border:1px solid #d1d5db; border-radius:6px; }
        .btn { margin-top:1rem; width:100%; padding:.65rem; border:0; border-radius:6px; background:#2563eb; color:#fff; font-weight:600; cursor:pointer; }
        .error { margin-top:.8rem; background:#fee2e2; color:#991b1b; padding:.6rem; border-radius:6px; }
    </style>
</head>
<body>
<main class="container">
    <section class="login-card">
        <h1>Connexion administrateur</h1>

        <form method="post" action="/backoffice/index.php?page=auth&action=authenticate">
            <label for="username">Nom d'utilisateur</label>
            <input id="username" name="username" type="text" required value="admin">

            <label for="password">Mot de passe</label>
            <input id="password" name="password" type="password" required value="admin123">

            <button class="btn" type="submit">Se connecter</button>
        </form>

        <?php if (!empty($error)): ?>
            <p class="error"><?= htmlspecialchars((string) $error) ?></p>
        <?php endif; ?>
    </section>
</main>
</body>
</html>
