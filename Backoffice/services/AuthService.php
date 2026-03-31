<?php

declare(strict_types=1);

require_once __DIR__ . '/../config/db.php';

class AuthService
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = getPDOConnection();
    }

    public function authenticate(string $username, string $password): ?array
    {
        $stmt = $this->pdo->prepare('SELECT id, username, email, password FROM admin WHERE username = :username LIMIT 1');
        $stmt->execute(['username' => $username]);
        $admin = $stmt->fetch();

        if (!$admin) {
            return null;
        }

        $isValidPassword = password_verify($password, (string) $admin['password'])
            || hash_equals((string) $admin['password'], $password);

        if (!$isValidPassword) {
            return null;
        }

        unset($admin['password']);
        return $admin;
    }
}
