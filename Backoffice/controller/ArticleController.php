<?php

declare(strict_types=1);

require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../services/ArticleService.php';

class ArticleController extends BaseController
{
    private ArticleService $service;

    public function __construct()
    {
        $this->service = new ArticleService();
    }

    public function handle(string $action): void
    {
        switch ($action) {
            case 'create':
                $this->create();
                return;
            case 'store':
                $this->store();
                return;
            case 'edit':
                $this->edit();
                return;
            case 'update':
                $this->update();
                return;
            case 'delete':
                $this->delete();
                return;
            case 'list':
            default:
                $this->index();
                return;
        }
    }

    private function index(): void
    {
        $articles = $this->service->getAll();
        $this->render('articles_list', ['articles' => $articles]);
    }

    private function create(): void
    {
        $this->render('articles_form', [
            'article' => null,
            'auteurs' => $this->service->getAuteurs(),
            'categories' => $this->service->getCategories(),
            'formAction' => 'store',
        ]);
    }

    private function store(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirectToList();
        }

        $this->service->create($_POST);
        $this->redirectToList();
    }

    private function edit(): void
    {
        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        $article = $this->service->getById($id);

        if (!$article) {
            $this->redirectToList();
        }

        $this->render('articles_form', [
            'article' => $article,
            'auteurs' => $this->service->getAuteurs(),
            'categories' => $this->service->getCategories(),
            'formAction' => 'update&id=' . $id,
        ]);
    }

    private function update(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirectToList();
        }

        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        if ($id <= 0) {
            $this->redirectToList();
        }

        $this->service->update($id, $_POST);
        $this->redirectToList();
    }

    private function delete(): void
    {
        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        if ($id > 0) {
            $this->service->delete($id);
        }

        $this->redirectToList();
    }

    private function redirectToList(): void
    {
        header('Location: /backoffice/index.php?page=articles&action=list');
        exit;
    }
}
