<?php

declare(strict_types=1);

function getPDOConnection(): PDO
{
    static $pdo = null;

    if ($pdo instanceof PDO) {
        return $pdo;
    }

    $db_host = getenv('POSTGRES_HOST') ?: 'localhost';
    $db_user = getenv('POSTGRES_USER') ?: 'webdesignuser';
    $db_password = getenv('POSTGRES_PASSWORD') ?: 'webdesignmdp';
    $db_name = getenv('POSTGRES_DB') ?: 'webdesigndb';
    $db_port = getenv('POSTGRES_PORT') ?: '5432';

    $dsn = "pgsql:host={$db_host};port={$db_port};dbname={$db_name}";

    $pdo = new PDO($dsn, $db_user, $db_password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);

    return $pdo;
}
