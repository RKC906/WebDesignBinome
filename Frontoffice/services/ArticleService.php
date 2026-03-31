<?php

declare(strict_types=1);

require_once __DIR__ . '/../config/db.php';

class ArticleService
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = getPDOConnection();
    }

    public function getPublishedArticles(): array
    {
        $sql = "
            SELECT a.id, a.titre, a.slug, a.description, a.image_url, a.created_at,
                   c.nom AS categorie_nom, c.slug AS categorie_slug,
                   au.nom AS auteur_nom, au.prenom AS auteur_prenom
            FROM articles a
            INNER JOIN categories c ON c.id = a.category_id
            INNER JOIN auteurs au ON au.id = a.author_id
            WHERE a.published = TRUE
            ORDER BY a.created_at DESC
        ";

        return $this->pdo->query($sql)->fetchAll();
    }

    public function getPublishedArticleBySlug(string $slug): ?array
    {
        $stmt = $this->pdo->prepare(
            "SELECT a.*, c.nom AS categorie_nom, c.slug AS categorie_slug,
                    au.nom AS auteur_nom, au.prenom AS auteur_prenom
             FROM articles a
             INNER JOIN categories c ON c.id = a.category_id
             INNER JOIN auteurs au ON au.id = a.author_id
             WHERE a.slug = :slug AND a.published = TRUE
             LIMIT 1"
        );

        $stmt->execute(['slug' => $slug]);
        $article = $stmt->fetch();

        return $article ?: null;
    }

    public function getPublishedArticlesByCategorySlug(string $categorySlug): array
    {
        $stmt = $this->pdo->prepare(
            "SELECT a.id, a.titre, a.slug, a.description, a.image_url, a.created_at,
                    c.nom AS categorie_nom, c.slug AS categorie_slug,
                    au.nom AS auteur_nom, au.prenom AS auteur_prenom
             FROM articles a
             INNER JOIN categories c ON c.id = a.category_id
             INNER JOIN auteurs au ON au.id = a.author_id
             WHERE c.slug = :category_slug AND a.published = TRUE
             ORDER BY a.created_at DESC"
        );

        $stmt->execute(['category_slug' => $categorySlug]);
        return $stmt->fetchAll();
    }

    public function getCategories(): array
    {
        $sql = "
            SELECT c.id, c.nom, c.slug,
                   COUNT(a.id) FILTER (WHERE a.published = TRUE) AS articles_count
            FROM categories c
            LEFT JOIN articles a ON a.category_id = c.id
            GROUP BY c.id
            ORDER BY c.nom ASC
        ";

        return $this->pdo->query($sql)->fetchAll();
    }
}
