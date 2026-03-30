<?php

declare(strict_types=1);

session_name('backoffice_session');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
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
