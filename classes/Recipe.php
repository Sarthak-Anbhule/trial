<?php
/**
 * CIY - Cook It Yourself
 * Recipe Management & Search Engine Class
 */

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/helpers.php';

class Recipe {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    /**
     * Fetch Single Recipe by Slug or ID with Author, Category, Ingredients, Steps & Nutrition
     */
    public function get($identifier, ?int $currentUserId = null): ?array {
        $field = is_numeric($identifier) ? 'r.id' : 'r.slug';
        
        $sql = "
            SELECT r.*, 
                   c.name AS category_name, c.slug AS category_slug, c.icon AS category_icon,
                   u.id AS author_id, u.name AS author_name, u.username AS author_username, u.avatar AS author_avatar, u.role AS author_role,
                   (SELECT COUNT(*) FROM likes WHERE recipe_id = r.id) AS likes_count,
                   (SELECT COUNT(*) FROM bookmarks WHERE recipe_id = r.id) AS bookmarks_count,
                   (SELECT AVG(rating) FROM comments WHERE recipe_id = r.id AND rating > 0) AS avg_rating,
                   (SELECT COUNT(*) FROM comments WHERE recipe_id = r.id) AS comments_count
            FROM recipes r
            JOIN categories c ON r.category_id = c.id
            JOIN users u ON r.user_id = u.id
            WHERE {$field} = :id AND r.is_published = 1
            LIMIT 1
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $identifier]);
        $recipe = $stmt->fetch();

        if (!$recipe) return null;

        // Increment view count asynchronously
        $this->db->prepare("UPDATE recipes SET views_count = views_count + 1 WHERE id = :id")->execute([':id' => $recipe['id']]);

        // Attach ingredients
        $ingStmt = $this->db->prepare("SELECT * FROM recipe_ingredients WHERE recipe_id = :rid ORDER BY sort_order ASC, id ASC");
        $ingStmt->execute([':rid' => $recipe['id']]);
        $recipe['ingredients'] = $ingStmt->fetchAll();

        // Attach steps
        $stepStmt = $this->db->prepare("SELECT * FROM recipe_steps WHERE recipe_id = :rid ORDER BY step_number ASC");
        $stepStmt->execute([':rid' => $recipe['id']]);
        $recipe['steps'] = $stepStmt->fetchAll();

        // Attach nutrition
        $nutrStmt = $this->db->prepare("SELECT * FROM recipe_nutrition WHERE recipe_id = :rid LIMIT 1");
        $nutrStmt->execute([':rid' => $recipe['id']]);
        $recipe['nutrition'] = $nutrStmt->fetch() ?: [
            'calories' => 450, 'protein' => '24g', 'carbs' => '40g', 'fat' => '18g', 'fiber' => '5g'
        ];

        // Attach User specific interactions
        if ($currentUserId) {
            $likeCheck = $this->db->prepare("SELECT id FROM likes WHERE user_id = :uid AND recipe_id = :rid LIMIT 1");
            $likeCheck->execute([':uid' => $currentUserId, ':rid' => $recipe['id']]);
            $recipe['is_liked'] = (bool)$likeCheck->fetch();

            $bmCheck = $this->db->prepare("SELECT id FROM bookmarks WHERE user_id = :uid AND recipe_id = :rid LIMIT 1");
            $bmCheck->execute([':uid' => $currentUserId, ':rid' => $recipe['id']]);
            $recipe['is_bookmarked'] = (bool)$bmCheck->fetch();
        } else {
            $recipe['is_liked'] = false;
            $recipe['is_bookmarked'] = false;
        }

        return $recipe;
    }

    /**
     * Filter & Search Recipes with Pagination
     */
    public function getRecipes(array $params = [], int $page = 1, int $limit = 9, ?int $currentUserId = null): array {
        $where = ["r.is_published = 1"];
        $bindings = [];

        // Search Query
        if (!empty($params['search'])) {
            $where[] = "(r.title LIKE :search OR r.description LIKE :search OR r.cuisine LIKE :search)";
            $bindings[':search'] = '%' . $params['search'] . '%';
        }

        // Category Filter
        if (!empty($params['category'])) {
            if (is_numeric($params['category'])) {
                $where[] = "r.category_id = :cat_id";
                $bindings[':cat_id'] = (int)$params['category'];
            } else {
                $where[] = "c.slug = :cat_slug";
                $bindings[':cat_slug'] = $params['category'];
            }
        }

        // Difficulty Filter
        if (!empty($params['difficulty'])) {
            $where[] = "r.difficulty = :diff";
            $bindings[':diff'] = ucfirst($params['difficulty']);
        }

        // Cuisine Filter
        if (!empty($params['cuisine'])) {
            $where[] = "r.cuisine = :cuisine";
            $bindings[':cuisine'] = $params['cuisine'];
        }

        // User ID Filter (My Recipes)
        if (!empty($params['user_id'])) {
            $where[] = "r.user_id = :uid";
            $bindings[':uid'] = (int)$params['user_id'];
        }

        // Featured Only
        if (!empty($params['featured'])) {
            $where[] = "r.is_featured = 1";
        }

        // Max Cooking Time Filter
        if (!empty($params['max_time'])) {
            $where[] = "(r.prep_time + r.cook_time) <= :max_time";
            $bindings[':max_time'] = (int)$params['max_time'];
        }

        $whereSql = implode(' AND ', $where);

        // Sorting
        $sortSql = "ORDER BY r.created_at DESC";
        if (!empty($params['sort'])) {
            switch ($params['sort']) {
                case 'popular':
                    $sortSql = "ORDER BY r.views_count DESC, r.created_at DESC";
                    break;
                case 'likes':
                    $sortSql = "ORDER BY likes_count DESC";
                    break;
                case 'fastest':
                    $sortSql = "ORDER BY (r.prep_time + r.cook_time) ASC";
                    break;
            }
        }

        // Calculate offset
        $offset = ($page - 1) * $limit;

        // Count Total
        $countSql = "SELECT COUNT(*) FROM recipes r JOIN categories c ON r.category_id = c.id WHERE {$whereSql}";
        $countStmt = $this->db->prepare($countSql);
        $countStmt->execute($bindings);
        $totalItems = (int)$countStmt->fetchColumn();

        // Main Query
        $sql = "
            SELECT r.*, 
                   c.name AS category_name, c.slug AS category_slug, c.icon AS category_icon,
                   u.name AS author_name, u.username AS author_username, u.avatar AS author_avatar,
                   (SELECT COUNT(*) FROM likes WHERE recipe_id = r.id) AS likes_count,
                   (SELECT COUNT(*) FROM bookmarks WHERE recipe_id = r.id) AS bookmarks_count,
                   (SELECT AVG(rating) FROM comments WHERE recipe_id = r.id AND rating > 0) AS avg_rating
            FROM recipes r
            JOIN categories c ON r.category_id = c.id
            JOIN users u ON r.user_id = u.id
            WHERE {$whereSql}
            {$sortSql}
            LIMIT :limit OFFSET :offset
        ";

        $stmt = $this->db->prepare($sql);
        foreach ($bindings as $key => $val) {
            $stmt->bindValue($key, $val);
        }
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $recipes = $stmt->fetchAll();

        // Attach saved state if logged in
        if ($currentUserId && !empty($recipes)) {
            $recipeIds = array_column($recipes, 'id');
            $inClause = implode(',', array_map('intval', $recipeIds));

            $bms = $this->db->query("SELECT recipe_id FROM bookmarks WHERE user_id = {$currentUserId} AND recipe_id IN ({$inClause})")->fetchAll(PDO::FETCH_COLUMN);
            $lks = $this->db->query("SELECT recipe_id FROM likes WHERE user_id = {$currentUserId} AND recipe_id IN ({$inClause})")->fetchAll(PDO::FETCH_COLUMN);

            foreach ($recipes as &$r) {
                $r['is_bookmarked'] = in_array($r['id'], $bms);
                $r['is_liked'] = in_array($r['id'], $lks);
            }
        }

        return [
            'items' => $recipes,
            'total' => $totalItems,
            'page' => $page,
            'pages' => ceil($totalItems / $limit)
        ];
    }

    /**
     * Create Recipe
     */
    public function create(array $data, array $files, int $userId): array {
        $title = trim($data['title'] ?? '');
        $description = trim($data['description'] ?? '');
        $categoryId = (int)($data['category_id'] ?? 0);
        $prepTime = (int)($data['prep_time'] ?? 15);
        $cookTime = (int)($data['cook_time'] ?? 30);
        $servings = (int)($data['servings'] ?? 4);
        $difficulty = $data['difficulty'] ?? 'Easy';
        $cuisine = trim($data['cuisine'] ?? 'International');
        $videoUrl = trim($data['video_url'] ?? '');

        if (empty($title) || empty($description) || $categoryId <= 0) {
            return ['success' => false, 'message' => 'Title, Category, and Description are required.'];
        }

        // Image Handling
        if (empty($files['cover_image']['name']) || $files['cover_image']['error'] !== UPLOAD_ERR_OK) {
            return ['success' => false, 'message' => 'A valid cover image is required for the recipe.'];
        }

        $ext = strtolower(pathinfo($files['cover_image']['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, ['jpg', 'jpeg', 'png', 'webp'])) {
            return ['success' => false, 'message' => 'Cover image must be a JPG, PNG, or WEBP file.'];
        }

        $coverName = 'recipe_' . time() . '_' . mt_rand(1000, 9999) . '.' . $ext;
        if (!is_dir(RECIPE_UPLOAD_PATH)) {
            mkdir(RECIPE_UPLOAD_PATH, 0755, true);
        }
        move_uploaded_file($files['cover_image']['tmp_name'], RECIPE_UPLOAD_PATH . $coverName);

        $slug = slugify($title) . '-' . mt_rand(100, 999);

        // Insert Recipe
        $stmt = $this->db->prepare("
            INSERT INTO recipes (user_id, category_id, title, slug, description, prep_time, cook_time, servings, difficulty, cuisine, video_url, cover_image)
            VALUES (:uid, :cid, :title, :slug, :desc, :prep, :cook, :servings, :diff, :cuisine, :video, :cover)
        ");

        $stmt->execute([
            ':uid' => $userId,
            ':cid' => $categoryId,
            ':title' => $title,
            ':slug' => $slug,
            ':desc' => $description,
            ':prep' => $prepTime,
            ':cook' => $cookTime,
            ':servings' => $servings,
            ':diff' => $difficulty,
            ':cuisine' => $cuisine,
            ':video' => $videoUrl,
            ':cover' => $coverName
        ]);

        $recipeId = (int)$this->db->lastInsertId();

        // Ingredients Insertion
        if (!empty($data['ingredients']) && is_array($data['ingredients'])) {
            $ingStmt = $this->db->prepare("INSERT INTO recipe_ingredients (recipe_id, amount, unit, name, sort_order) VALUES (:rid, :amt, :unit, :name, :order)");
            foreach ($data['ingredients'] as $index => $ing) {
                if (!empty($ing['name'])) {
                    $ingStmt->execute([
                        ':rid' => $recipeId,
                        ':amt' => $ing['amount'] ?? '1',
                        ':unit' => $ing['unit'] ?? '',
                        ':name' => trim($ing['name']),
                        ':order' => $index + 1
                    ]);
                }
            }
        }

        // Steps Insertion
        if (!empty($data['steps']) && is_array($data['steps'])) {
            $stepStmt = $this->db->prepare("INSERT INTO recipe_steps (recipe_id, step_number, title, instruction, time_minutes) VALUES (:rid, :step, :title, :inst, :time)");
            foreach ($data['steps'] as $index => $st) {
                if (!empty($st['instruction'])) {
                    $stepStmt->execute([
                        ':rid' => $recipeId,
                        ':step' => $index + 1,
                        ':title' => trim($st['title'] ?? 'Step ' . ($index + 1)),
                        ':inst' => trim($st['instruction']),
                        ':time' => (int)($st['time_minutes'] ?? 5)
                    ]);
                }
            }
        }

        // Nutrition Insertion
        $nutrStmt = $this->db->prepare("INSERT INTO recipe_nutrition (recipe_id, calories, protein, carbs, fat, fiber) VALUES (:rid, :cal, :prot, :carbs, :fat, :fiber)");
        $nutrStmt->execute([
            ':rid' => $recipeId,
            ':cal' => (int)($data['calories'] ?? 450),
            ':prot' => trim($data['protein'] ?? '25g'),
            ':carbs' => trim($data['carbs'] ?? '45g'),
            ':fat' => trim($data['fat'] ?? '18g'),
            ':fiber' => trim($data['fiber'] ?? '4g')
        ]);

        return ['success' => true, 'recipe_id' => $recipeId, 'slug' => $slug, 'message' => 'Recipe published successfully!'];
    }

    /**
     * Delete Recipe
     */
    public function delete(int $recipeId, int $userId, bool $isAdmin = false): bool {
        $stmt = $this->db->prepare("SELECT user_id, cover_image FROM recipes WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $recipeId]);
        $recipe = $stmt->fetch();

        if (!$recipe) return false;
        if ($recipe['user_id'] !== $userId && !$isAdmin) return false;

        // Delete cover file
        if (!empty($recipe['cover_image']) && file_exists(RECIPE_UPLOAD_PATH . $recipe['cover_image'])) {
            @unlink(RECIPE_UPLOAD_PATH . $recipe['cover_image']);
        }

        $del = $this->db->prepare("DELETE FROM recipes WHERE id = :id");
        return $del->execute([':id' => $recipeId]);
    }
}
