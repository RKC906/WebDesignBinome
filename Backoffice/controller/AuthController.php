<?php

declare(strict_types=1);

require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../services/AuthService.php';

class AuthController extends BaseController
{
    private AuthService $service;

    public function __construct()
    {
        $this->service = new AuthService();
    }

    public function handle(string $action): void
    {
        switch ($action) {
            case 'login':
                $this->showLogin();
                return;
            case 'authenticate':
                $this->authenticate();
                return;
            case 'logout':
                $this->logout();
                return;
            default:
                $this->showLogin();
                return;
        }
    }

    private function showLogin(?string $error = null): void
    {
        if (!empty($_SESSION['admin'])) {
            $this->redirect('/backoffice/index.php?page=articles&action=list');
        }

        $this->render('login', ['error' => $error]);
    }

    private function authenticate(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/backoffice/index.php?page=auth&action=login');
        }

        $username = trim((string) ($_POST['username'] ?? ''));
        $password = (string) ($_POST['password'] ?? '');

        if ($username === '' || $password === '') {
            $this->showLogin('Identifiants invalides.');
            return;
        }

        $admin = $this->service->authenticate($username, $password);
        if (!$admin) {
            $this->showLogin('Nom d\'utilisateur ou mot de passe incorrect.');
            return;
        }

        session_regenerate_id(true);
        $_SESSION['admin'] = [
            'id' => (int) $admin['id'],
            'username' => (string) $admin['username'],
            'email' => (string) $admin['email'],
        ];

        $this->redirect('/backoffice/index.php?page=articles&action=list');
    }

    private function logout(): void
    {
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], (bool) $params['secure'], (bool) $params['httponly']);
        }

        session_destroy();
        $this->redirect('/backoffice/index.php?page=auth&action=login');
    }
}
