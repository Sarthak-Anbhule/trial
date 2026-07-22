<?php
/**
 * CIY - Cook It Yourself
 * User Manager Class
 */

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/helpers.php';

class User {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    /**
     * Get user by ID or Username
     */
    public function get($identifier): ?array {
        $field = is_numeric($identifier) ? 'id' : 'username';
        $stmt = $this->db->prepare("
            SELECT u.*, 
                   (SELECT COUNT(*) FROM recipes WHERE user_id = u.id AND is_published = 1) AS recipes_count,
                   (SELECT COUNT(*) FROM followers WHERE following_id = u.id) AS followers_count,
                   (SELECT COUNT(*) FROM followers WHERE follower_id = u.id) AS following_count
            FROM users u
            WHERE u.{$field} = :id LIMIT 1
        ");
        $stmt->execute([':id' => $identifier]);
        $user = $stmt->fetch();
        return $user ?: null;
    }

    /**
     * Update User Profile (Name, Bio, Avatar, Cover)
     */
    public function updateProfile(int $userId, array $data, ?array $files = null): array {
        $name = trim($data['name'] ?? '');
        $bio = trim($data['bio'] ?? '');

        if (empty($name)) {
            return ['success' => false, 'message' => 'Name cannot be empty.'];
        }

        $avatarName = null;
        $coverName = null;

        // Handle Avatar File Upload
        if (!empty($files['avatar']['name']) && $files['avatar']['error'] === UPLOAD_ERR_OK) {
            $ext = strtolower(pathinfo($files['avatar']['name'], PATHINFO_EXTENSION));
            if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'svg'])) {
                $avatarName = 'avatar_' . $userId . '_' . time() . '.' . $ext;
                if (!is_dir(PROFILE_UPLOAD_PATH)) {
                    mkdir(PROFILE_UPLOAD_PATH, 0755, true);
                }
                move_uploaded_file($files['avatar']['tmp_name'], PROFILE_UPLOAD_PATH . $avatarName);
            }
        }

        // Handle Cover Image Upload
        if (!empty($files['cover']['name']) && $files['cover']['error'] === UPLOAD_ERR_OK) {
            $ext = strtolower(pathinfo($files['cover']['name'], PATHINFO_EXTENSION));
            if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp'])) {
                $coverName = 'cover_' . $userId . '_' . time() . '.' . $ext;
                if (!is_dir(PROFILE_UPLOAD_PATH)) {
                    mkdir(PROFILE_UPLOAD_PATH, 0755, true);
                }
                move_uploaded_file($files['cover']['tmp_name'], PROFILE_UPLOAD_PATH . $coverName);
            }
        }

        $sql = "UPDATE users SET name = :name, bio = :bio";
        $params = [':name' => $name, ':bio' => $bio, ':id' => $userId];

        if ($avatarName) {
            $sql .= ", avatar = :avatar";
            $params[':avatar'] = $avatarName;
        }

        if ($coverName) {
            $sql .= ", cover_image = :cover";
            $params[':cover'] = $coverName;
        }

        $sql .= " WHERE id = :id";
        $stmt = $this->db->prepare($sql);

        if ($stmt->execute($params)) {
            $_SESSION['user_name'] = $name;
            return ['success' => true, 'message' => 'Profile updated successfully!'];
        }

        return ['success' => false, 'message' => 'Failed to update profile.'];
    }

    /**
     * Get Popular Chefs / Top Creators
     */
    public function getPopularChefs(int $limit = 6): array {
        $stmt = $this->db->prepare("
            SELECT u.id, u.name, u.username, u.avatar, u.role,
                   COUNT(DISTINCT r.id) AS recipe_count,
                   COUNT(DISTINCT f.id) AS followers_count
            FROM users u
            LEFT JOIN recipes r ON r.user_id = u.id AND r.is_published = 1
            LEFT JOIN followers f ON f.following_id = u.id
            WHERE u.status = 'active'
            GROUP BY u.id
            ORDER BY followers_count DESC, recipe_count DESC
            LIMIT :limit
        ");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Toggle Follow/Unfollow User
     */
    public function toggleFollow(int $followerId, int $followingId): array {
        if ($followerId === $followingId) {
            return ['success' => false, 'message' => 'You cannot follow yourself.'];
        }

        $stmt = $this->db->prepare("SELECT id FROM followers WHERE follower_id = :follower AND following_id = :following");
        $stmt->execute([':follower' => $followerId, ':following' => $followingId]);
        $existing = $stmt->fetch();

        if ($existing) {
            // Unfollow
            $del = $this->db->prepare("DELETE FROM followers WHERE id = :id");
            $del->execute([':id' => $existing['id']]);
            return ['success' => true, 'following' => false, 'message' => 'Unfollowed user.'];
        } else {
            // Follow
            $ins = $this->db->prepare("INSERT INTO followers (follower_id, following_id) VALUES (:follower, :following)");
            $ins->execute([':follower' => $followerId, ':following' => $followingId]);
            return ['success' => true, 'following' => true, 'message' => 'Now following user!'];
        }
    }

    /**
     * Check if follower follows following
     */
    public function isFollowing(?int $followerId, int $followingId): bool {
        if (!$followerId) return false;
        $stmt = $this->db->prepare("SELECT id FROM followers WHERE follower_id = :follower AND following_id = :following LIMIT 1");
        $stmt->execute([':follower' => $followerId, ':following' => $followingId]);
        return (bool)$stmt->fetch();
    }
}
