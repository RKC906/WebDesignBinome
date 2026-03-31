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

    public function home(): void
    {
        $this->render('home', [
            'articles' => $this->service->getPublishedArticles(),
            'categories' => $this->service->getCategories(),
            'pageTitle' => 'Actualités sur la guerre en Iran',
        ]);
    }

    public function show(string $slug): void
    {
        $article = $this->service->getPublishedArticleBySlug($slug);
        if (!$article) {
            http_response_code(404);
            $this->render('not_found', ['message' => 'Article introuvable.']);
            return;
        }

        $this->render('article_show', [
            'article' => $article,
            'categories' => $this->service->getCategories(),
            'pageTitle' => $article['titre'],
        ]);
    }

    public function category(string $slug): void
    {
        $articles = $this->service->getPublishedArticlesByCategorySlug($slug);
        $categories = $this->service->getCategories();

        $currentCategory = null;
        foreach ($categories as $category) {
            if ((string) $category['slug'] === $slug) {
                $currentCategory = $category;
                break;
            }
        }

        if (!$currentCategory) {
            http_response_code(404);
            $this->render('not_found', ['message' => 'Catégorie introuvable.']);
            return;
        }

        $this->render('category', [
            'articles' => $articles,
            'categories' => $categories,
            'currentCategory' => $currentCategory,
            'pageTitle' => 'Catégorie : ' . $currentCategory['nom'],
        ]);
    }
}
