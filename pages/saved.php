<?php
/**
 * CIY - Cook It Yourself
 * Bookmarked / Saved Recipes Page
 */

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/helpers.php';
require_once __DIR__ . '/../classes/Auth.php';
require_once __DIR__ . '/../classes/Database.php';
require_once __DIR__ . '/../classes/Recipe.php';

if (!Auth::check()) {
    redirect('auth/login.php');
}

$currentUserId = Auth::id();
$db = Database::getInstance();

$stmt = $db->prepare("
    SELECT r.*, 
           c.name AS category_name, c.slug AS category_slug, c.icon AS category_icon,
           u.name AS author_name, u.username AS author_username, u.avatar AS author_avatar,
           (SELECT COUNT(*) FROM likes WHERE recipe_id = r.id) AS likes_count,
           (SELECT AVG(rating) FROM comments WHERE recipe_id = r.id AND rating > 0) AS avg_rating,
           1 AS is_bookmarked
    FROM bookmarks b
    JOIN recipes r ON b.recipe_id = r.id
    JOIN categories c ON r.category_id = c.id
    JOIN users u ON r.user_id = u.id
    WHERE b.user_id = :uid
    ORDER BY b.created_at DESC
");
$stmt->execute([':uid' => $currentUserId]);
$savedRecipes = $stmt->fetchAll();

$pageTitle = 'Saved Recipes - CIY';
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/navbar.php';
?>

<div class="container py-5 my-4">
    <div class="mb-4">
        <h2 class="font-heading fw-bold mb-1"><i class="fa-solid fa-bookmark text-warning me-2"></i> Saved Bookmarks</h2>
        <p class="text-muted">Your personal collection of saved recipes</p>
    </div>

    <?php if (!empty($savedRecipes)): ?>
        <div class="row g-4">
            <?php foreach ($savedRecipes as $recipe): ?>
                <div class="col-md-6 col-lg-4">
                    <?php include __DIR__ . '/../components/recipe_card.php'; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="glass-card text-center py-5">
            <i class="fa-regular fa-bookmark text-muted display-3 mb-3"></i>
            <h5 class="font-heading fw-bold">No Saved Recipes Yet</h5>
            <p class="text-muted small">Explore recipes and click the bookmark icon to save them here.</p>
            <a href="<?= BASE_URL ?>/pages/explore.php" class="btn-ciy-primary btn-sm mt-2">Explore Recipes</a>
        </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
