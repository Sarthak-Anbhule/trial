<?php
/**
 * CIY - Cook It Yourself
 * User's Own Uploaded Recipes Manager
 */

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/helpers.php';
require_once __DIR__ . '/../classes/Auth.php';
require_once __DIR__ . '/../classes/Recipe.php';

if (!Auth::check()) {
    redirect('auth/login.php');
}

$currentUserId = Auth::id();
$recipeEngine = new Recipe();
$myRecipes = $recipeEngine->getRecipes(['user_id' => $currentUserId], 1, 50, $currentUserId)['items'];

// Handle Deletion
if (isset($_GET['delete_id'])) {
    $delId = (int)$_GET['delete_id'];
    if ($recipeEngine->delete($delId, $currentUserId)) {
        redirect('pages/my_recipes.php');
    }
}

$pageTitle = 'My Recipes - CIY';
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/navbar.php';
?>

<div class="container py-5 my-4">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="font-heading fw-bold mb-1"><i class="fa-solid fa-utensils text-primary me-2"></i> My Recipes</h2>
            <p class="text-muted small">Manage your uploaded culinary dishes</p>
        </div>
        <a href="<?= BASE_URL ?>/pages/upload.php" class="btn-ciy-primary btn-sm"><i class="fa-solid fa-plus me-1"></i> Upload New</a>
    </div>

    <?php if (!empty($myRecipes)): ?>
        <div class="row g-4">
            <?php foreach ($myRecipes as $recipe): ?>
                <div class="col-md-6 col-lg-4 position-relative">
                    <?php include __DIR__ . '/../components/recipe_card.php'; ?>
                    <div class="mt-2 text-end">
                        <a href="?delete_id=<?= $recipe['id'] ?>" class="btn btn-outline-danger btn-sm rounded-pill" onclick="return confirm('Are you sure you want to delete this recipe?')">
                            <i class="fa-solid fa-trash me-1"></i> Delete
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="glass-card text-center py-5">
            <h5 class="font-heading fw-bold">You haven't uploaded any recipes yet.</h5>
            <a href="<?= BASE_URL ?>/pages/upload.php" class="btn-ciy-primary btn-sm mt-3">Upload Recipe Studio</a>
        </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
