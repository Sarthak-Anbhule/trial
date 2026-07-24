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

$pageTitle = t('my_recipes') . ' - CIY';
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/navbar.php';
?>

<div class="container py-5 my-4">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="font-heading fw-bold mb-1"><i class="fa-solid fa-utensils text-primary me-2"></i> <?= t('my_recipes') ?></h2>
            <p class="text-muted small"><?= t('my_recipes_subtitle', 'Manage your uploaded culinary dishes') ?></p>
        </div>
        <a href="<?= BASE_URL ?>/pages/upload.php" class="btn-ciy-primary btn-sm"><i class="fa-solid fa-plus me-1"></i> <?= t('create_recipe') ?></a>
    </div>

    <?php if (!empty($myRecipes)): ?>
        <div class="row g-4">
            <?php foreach ($myRecipes as $recipe): ?>
                <div class="col-md-6 col-lg-4 position-relative">
                    <?php include __DIR__ . '/../components/recipe_card.php'; ?>
                    <div class="mt-2 text-end">
                        <a href="?delete_id=<?= $recipe['id'] ?>" class="btn btn-outline-danger btn-sm rounded-pill" onclick="return confirm('<?= t('confirm_delete', 'Are you sure you want to delete this recipe?') ?>')">
                            <i class="fa-solid fa-trash me-1"></i> <?= t('delete', 'Delete') ?>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="glass-card text-center py-5">
            <h5 class="font-heading fw-bold"><?= t('no_my_recipes') ?></h5>
            <a href="<?= BASE_URL ?>/pages/upload.php" class="btn-ciy-primary btn-sm mt-3"><?= t('create_recipe') ?></a>
        </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
