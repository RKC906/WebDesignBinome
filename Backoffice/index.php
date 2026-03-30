<?php

declare(strict_types=1);

$page = $_GET['page'] ?? 'articles';
$action = $_GET['action'] ?? 'list';

switch ($page) {
    case 'articles':
    default:
        require_once __DIR__ . '/controller/ArticleController.php';
        $controller = new ArticleController();
        $controller->handle($action);
        break;
}
