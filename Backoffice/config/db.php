<?php
/**
 * Configuration de la connexion à la base de données PostgreSQL
 */

// Récupérer les variables d'environnement (depuis Docker)
$db_host = getenv('POSTGRES_HOST') ?: 'localhost';
$db_user = getenv('POSTGRES_USER') ?: 'webdesignuser';
$db_password = getenv('POSTGRES_PASSWORD') ?: 'webdesignmdp';
$db_name = getenv('POSTGRES_DB') ?: 'webdesigndb';
$db_port = getenv('POSTGRES_PORT') ?: '5432';

// DSN (Data Source Name) pour PostgreSQL
$dsn = "pgsql:host=$db_host;port=$db_port;dbname=$db_name";

try {
    // Créer la connexion PDO
    $pdo = new PDO($dsn, $db_user, $db_password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);

    // La connexion est réussie (message optionnel pour le débogage)
    // echo "Connexion à la BDD réussie !";

} catch (PDOException $e) {
    // En cas d'erreur, afficher le message
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
?>
