<?php

declare(strict_types=1);

require_once __DIR__ . '/controller/ArticleController.php';

$controller = new ArticleController();
$page = $_GET['page'] ?? 'home';

switch ($page) {
    case 'article':
        $slug = trim((string) ($_GET['slug'] ?? ''));
        if ($slug === '') {
            http_response_code(404);
            require __DIR__ . '/views/pages/not_found.php';
            exit;
        }
        $controller->show($slug);
        break;

    case 'category':
        $slug = trim((string) ($_GET['slug'] ?? ''));
        if ($slug === '') {
            http_response_code(404);
            require __DIR__ . '/views/pages/not_found.php';
            exit;
        }
        $controller->category($slug);
        break;

    case 'home':
    default:
        $controller->home();
        break;
}
