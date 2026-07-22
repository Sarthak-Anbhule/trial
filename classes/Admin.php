<?php
/**
 * CIY - Cook It Yourself
 * Admin Panel & Analytics Manager Class
 */

require_once __DIR__ . '/../config/database.php';

class Admin {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    /**
     * Dashboard Overview Metrics
     */
    public function getDashboardStats(): array {
        $usersCount = (int)$this->db->query("SELECT COUNT(*) FROM users")->fetchColumn();
        $recipesCount = (int)$this->db->query("SELECT COUNT(*) FROM recipes WHERE is_published = 1")->fetchColumn();
        $commentsCount = (int)$this->db->query("SELECT COUNT(*) FROM comments")->fetchColumn();
        $likesCount = (int)$this->db->query("SELECT COUNT(*) FROM likes")->fetchColumn();
        $reportsPending = (int)$this->db->query("SELECT COUNT(*) FROM reports WHERE status = 'pending'")->fetchColumn();

        return [
            'users' => $usersCount,
            'recipes' => $recipesCount,
            'comments' => $commentsCount,
            'likes' => $likesCount,
            'pending_reports' => $reportsPending
        ];
    }

    /**
     * Get Analytics Chart Data (Monthly Recipe Uploads)
     */
    public function getMonthlyUploadStats(): array {
        $stmt = $this->db->query("
            SELECT DATE_FORMAT(created_at, '%b %Y') AS month_label, COUNT(*) AS total
            FROM recipes
            GROUP BY YEAR(created_at), MONTH(created_at)
            ORDER BY created_at ASC
            LIMIT 12
        ");
        return $stmt->fetchAll();
    }

    /**
     * List all Users with Pagination
     */
    public function getUsers(int $page = 1, int $limit = 15): array {
        $offset = ($page - 1) * $limit;
        $stmt = $this->db->prepare("
            SELECT u.*, 
                   (SELECT COUNT(*) FROM recipes WHERE user_id = u.id) AS recipe_count
            FROM users u
            ORDER BY u.created_at DESC
            LIMIT :limit OFFSET :offset
        ");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Toggle User Status (active / suspended / banned)
     */
    public function updateUserStatus(int $userId, string $status): bool {
        if (!in_array($status, ['active', 'suspended', 'banned'])) return false;
        $stmt = $this->db->prepare("UPDATE users SET status = :status WHERE id = :id AND role != 'admin'");
        return $stmt->execute([':status' => $status, ':id' => $userId]);
    }

    /**
     * Toggle Featured Recipe Status
     */
    public function toggleFeaturedRecipe(int $recipeId): bool {
        $stmt = $this->db->prepare("UPDATE recipes SET is_featured = NOT is_featured WHERE id = :id");
        return $stmt->execute([':id' => $recipeId]);
    }
}
