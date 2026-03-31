<?php

declare(strict_types=1);

session_name('backoffice_session');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$hasPage = array_key_exists('page', $_GET);
$hasAction = array_key_exists('action', $_GET);

if (!$hasPage && !$hasAction) {
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], (bool) $params['secure'], (bool) $params['httponly']);
    }
    session_destroy();
    header('Location: /backoffice/index.php?page=auth&action=login');
    exit;
}

$page = $_GET['page'] ?? 'articles';
$action = $_GET['action'] ?? 'list';

if ($page === 'auth') {
    require_once __DIR__ . '/controller/AuthController.php';
    $controller = new AuthController();
    $controller->handle($action);
    exit;
}

if (empty($_SESSION['admin'])) {
    header('Location: /backoffice/index.php?page=auth&action=login');
    exit;
}

switch ($page) {
    case 'articles':
    default:
        require_once __DIR__ . '/controller/ArticleController.php';
        $controller = new ArticleController();
        $controller->handle($action);
        break;
}
