<?php
/**
 * CIY - Cook It Yourself
 * Interaction Manager Class (Likes, Bookmarks, Comments, Ratings)
 */

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/helpers.php';
require_once __DIR__ . '/Notification.php';

class Interaction {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    /**
     * Toggle Like on Recipe
     */
    public function toggleLike(int $userId, int $recipeId): array {
        $stmt = $this->db->prepare("SELECT id FROM likes WHERE user_id = :uid AND recipe_id = :rid LIMIT 1");
        $stmt->execute([':uid' => $userId, ':rid' => $recipeId]);
        $existing = $stmt->fetch();

        if ($existing) {
            $del = $this->db->prepare("DELETE FROM likes WHERE id = :id");
            $del->execute([':id' => $existing['id']]);
            $liked = false;
        } else {
            $ins = $this->db->prepare("INSERT INTO likes (user_id, recipe_id) VALUES (:uid, :rid)");
            $ins->execute([':uid' => $userId, ':rid' => $recipeId]);
            $liked = true;

            // Trigger Notification to Recipe Owner
            $ownerStmt = $this->db->prepare("SELECT user_id, title FROM recipes WHERE id = :rid LIMIT 1");
            $ownerStmt->execute([':rid' => $recipeId]);
            $recipe = $ownerStmt->fetch();
            if ($recipe && $recipe['user_id'] != $userId) {
                $notifier = new Notification();
                $notifier->send($recipe['user_id'], $userId, 'like', $recipeId, "liked your recipe '{$recipe['title']}'");
            }
        }

        // Return updated count
        $cntStmt = $this->db->prepare("SELECT COUNT(*) FROM likes WHERE recipe_id = :rid");
        $cntStmt->execute([':rid' => $recipeId]);
        $count = (int)$cntStmt->fetchColumn();

        return [
            'success' => true,
            'liked' => $liked,
            'count' => $count,
            'message' => $liked ? 'Added to liked recipes' : 'Removed from likes'
        ];
    }

    /**
     * Toggle Bookmark on Recipe
     */
    public function toggleBookmark(int $userId, int $recipeId): array {
        $stmt = $this->db->prepare("SELECT id FROM bookmarks WHERE user_id = :uid AND recipe_id = :rid LIMIT 1");
        $stmt->execute([':uid' => $userId, ':rid' => $recipeId]);
        $existing = $stmt->fetch();

        if ($existing) {
            $del = $this->db->prepare("DELETE FROM bookmarks WHERE id = :id");
            $del->execute([':id' => $existing['id']]);
            $bookmarked = false;
        } else {
            $ins = $this->db->prepare("INSERT INTO bookmarks (user_id, recipe_id) VALUES (:uid, :rid)");
            $ins->execute([':uid' => $userId, ':rid' => $recipeId]);
            $bookmarked = true;
        }

        // Return count
        $cntStmt = $this->db->prepare("SELECT COUNT(*) FROM bookmarks WHERE recipe_id = :rid");
        $cntStmt->execute([':rid' => $recipeId]);
        $count = (int)$cntStmt->fetchColumn();

        return [
            'success' => true,
            'bookmarked' => $bookmarked,
            'count' => $count,
            'message' => $bookmarked ? 'Recipe saved to bookmarks!' : 'Recipe removed from bookmarks'
        ];
    }

    /**
     * Add Comment with Star Rating
     */
    public function addComment(int $userId, int $recipeId, string $comment, int $rating = 5, ?int $parentId = null): array {
        $comment = trim($comment);
        if (empty($comment)) {
            return ['success' => false, 'message' => 'Comment text cannot be empty.'];
        }

        $rating = max(1, min(5, $rating));

        $stmt = $this->db->prepare("INSERT INTO comments (recipe_id, user_id, parent_id, comment, rating) VALUES (:rid, :uid, :pid, :comm, :rat)");
        if ($stmt->execute([
            ':rid' => $recipeId,
            ':uid' => $userId,
            ':pid' => $parentId,
            ':comm' => $comment,
            ':rat' => $rating
        ])) {
            $commentId = (int)$this->db->lastInsertId();

            // Notify owner
            $ownerStmt = $this->db->prepare("SELECT user_id, title FROM recipes WHERE id = :rid LIMIT 1");
            $ownerStmt->execute([':rid' => $recipeId]);
            $recipe = $ownerStmt->fetch();
            if ($recipe && $recipe['user_id'] != $userId) {
                $notifier = new Notification();
                $notifier->send($recipe['user_id'], $userId, 'comment', $recipeId, "commented on '{$recipe['title']}': \"{$comment}\"");
            }

            return ['success' => true, 'comment_id' => $commentId, 'message' => 'Comment posted!'];
        }

        return ['success' => false, 'message' => 'Failed to post comment.'];
    }

    /**
     * Get Comments for Recipe
     */
    public function getComments(int $recipeId): array {
        $stmt = $this->db->prepare("
            SELECT c.*, u.name AS user_name, u.username AS user_username, u.avatar AS user_avatar
            FROM comments c
            JOIN users u ON c.user_id = u.id
            WHERE c.recipe_id = :rid
            ORDER BY c.created_at DESC
        ");
        $stmt->execute([':rid' => $recipeId]);
        return $stmt->fetchAll();
    }
}
