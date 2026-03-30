<?php

declare(strict_types=1);

require_once __DIR__ . '/../config/db.php';

class ArticleService
{
    private PDO $pdo;
    private string $uploadsDir = __DIR__ . '/../../uploads/articles/';
    private array $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    private int $maxFileSize = 5242880; // 5MB

    public function __construct()
    {
        $this->pdo = getPDOConnection();
    }

    public function getAll(): array
    {
        $sql = "
            SELECT a.id,
                   a.titre,
                   a.slug,
                   a.published,
                   a.created_at,
                   au.nom AS auteur_nom,
                   au.prenom AS auteur_prenom,
                   c.nom AS categorie_nom
            FROM articles a
            INNER JOIN auteurs au ON au.id = a.author_id
            INNER JOIN categories c ON c.id = a.category_id
            ORDER BY a.created_at DESC
        ";

        return $this->pdo->query($sql)->fetchAll();
    }

    public function getById(int $id): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM articles WHERE id = :id LIMIT 1');
        $stmt->execute(['id' => $id]);
        $article = $stmt->fetch();

        return $article ?: null;
    }

    public function create(array $data): int
    {
        $imageUrl = $this->handleImageUpload($_FILES['image'] ?? null);

        $stmt = $this->pdo->prepare(
            'INSERT INTO articles (titre, slug, contenus, description, image_url, author_id, category_id, published)
             VALUES (:titre, :slug, :contenus, :description, :image_url, :author_id, :category_id, :published)
             RETURNING id'
        );

        $stmt->execute([
            'titre' => $data['titre'],
            'slug' => $data['slug'],
            'contenus' => $data['contenus'],
            'description' => $data['description'] ?: null,
            'image_url' => $imageUrl,
            'author_id' => (int) $data['author_id'],
            'category_id' => (int) $data['category_id'],
            'published' => !empty($data['published']),
        ]);

        return (int) $stmt->fetchColumn();
    }

    public function update(int $id, array $data): void
    {
        $article = $this->getById($id);
        $imageUrl = $article['image_url'];

        // Si une nouvelle image est uploadée
        if (!empty($_FILES['image']['name'])) {
            $newImageUrl = $this->handleImageUpload($_FILES['image']);
            if ($newImageUrl) {
                // Supprimer l'ancienne image
                if ($article['image_url'] && strpos($article['image_url'], '/uploads/') !== false) {
                    $this->deleteImage($article['image_url']);
                }
                $imageUrl = $newImageUrl;
            }
        }

        $stmt = $this->pdo->prepare(
            'UPDATE articles
             SET titre = :titre,
                 slug = :slug,
                 contenus = :contenus,
                 description = :description,
                 image_url = :image_url,
                 author_id = :author_id,
                 category_id = :category_id,
                 published = :published,
                 updated_at = CURRENT_TIMESTAMP
             WHERE id = :id'
        );

        $stmt->execute([
            'id' => $id,
            'titre' => $data['titre'],
            'slug' => $data['slug'],
            'contenus' => $data['contenus'],
            'description' => $data['description'] ?: null,
            'image_url' => $imageUrl,
            'author_id' => (int) $data['author_id'],
            'category_id' => (int) $data['category_id'],
            'published' => !empty($data['published']),
        ]);
    }

    public function delete(int $id): void
    {
        $article = $this->getById($id);
        if ($article && $article['image_url'] && strpos($article['image_url'], '/uploads/') !== false) {
            $this->deleteImage($article['image_url']);
        }

        $stmt = $this->pdo->prepare('DELETE FROM articles WHERE id = :id');
        $stmt->execute(['id' => $id]);
    }

    public function getAuteurs(): array
    {
        return $this->pdo
            ->query('SELECT id, nom, prenom FROM auteurs ORDER BY nom ASC, prenom ASC')
            ->fetchAll();
    }

    public function getCategories(): array
    {
        return $this->pdo
            ->query('SELECT id, nom FROM categories ORDER BY nom ASC')
            ->fetchAll();
    }

    private function handleImageUpload(?array $file): ?string
    {
        if (!$file || empty($file['name'])) {
            return null;
        }

        // Validation
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return null;
        }

        if ($file['size'] > $this->maxFileSize) {
            return null;
        }

        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, $this->allowedExtensions, true)) {
            return null;
        }

        // Générer un nom unique
        $filename = uniqid('article_', true) . '.' . $ext;
        $filepath = $this->uploadsDir . $filename;

        // Créer le dossier s'il n'existe pas
        if (!is_dir($this->uploadsDir)) {
            mkdir($this->uploadsDir, 0755, true);
        }

        // Déplacer le fichier
        if (move_uploaded_file($file['tmp_name'], $filepath)) {
            return '/uploads/articles/' . $filename;
        }

        return null;
    }

    private function deleteImage(string $imageUrl): void
    {
        if (strpos($imageUrl, '/uploads/') !== false) {
            $filepath = __DIR__ . '/../..' . $imageUrl;
            if (file_exists($filepath)) {
                unlink($filepath);
            }
        }
    }
}
