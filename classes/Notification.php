<?php
/**
 * CIY - Cook It Yourself
 * Notifications Manager Class
 */

require_once __DIR__ . '/../config/database.php';

class Notification {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    /**
     * Send Notification
     */
    public function send(int $userId, int $actorId, string $type, ?int $targetId, string $message): bool {
        if ($userId === $actorId) return false;

        $stmt = $this->db->prepare("
            INSERT INTO notifications (user_id, actor_id, type, target_id, message)
            VALUES (:uid, :aid, :type, :tid, :msg)
        ");
        return $stmt->execute([
            ':uid' => $userId,
            ':aid' => $actorId,
            ':type' => $type,
            ':tid' => $targetId,
            ':msg' => $message
        ]);
    }

    /**
     * Get Notifications for User
     */
    public function getUserNotifications(int $userId, int $limit = 20): array {
        $stmt = $this->db->prepare("
            SELECT n.*, u.name AS actor_name, u.avatar AS actor_avatar, u.username AS actor_username
            FROM notifications n
            JOIN users u ON n.actor_id = u.id
            WHERE n.user_id = :uid
            ORDER BY n.created_at DESC
            LIMIT :limit
        ");
        $stmt->bindValue(':uid', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Mark all as read
     */
    public function markAllAsRead(int $userId): void {
        $stmt = $this->db->prepare("UPDATE notifications SET is_read = 1 WHERE user_id = :uid");
        $stmt->execute([':uid' => $userId]);
    }
}
