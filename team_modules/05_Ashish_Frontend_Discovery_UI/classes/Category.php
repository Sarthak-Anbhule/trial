<?php
/**
 * CIY - Cook It Yourself
 * Category Manager Class
 */

require_once __DIR__ . '/../config/database.php';

class Category {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    /**
     * Get All Categories with Recipe Counts
     */
    public function getAll(): array {
        $stmt = $this->db->query("
            SELECT c.*, COUNT(r.id) AS recipe_count
            FROM categories c
            LEFT JOIN recipes r ON r.category_id = c.id AND r.is_published = 1
            GROUP BY c.id
            ORDER BY recipe_count DESC, c.name ASC
        ");
        return $stmt->fetchAll();
    }

    /**
     * Get Category by Slug
     */
    public function getBySlug(string $slug): ?array {
        $stmt = $this->db->prepare("SELECT * FROM categories WHERE slug = :slug LIMIT 1");
        $stmt->execute([':slug' => $slug]);
        return $stmt->fetch() ?: null;
    }
}
