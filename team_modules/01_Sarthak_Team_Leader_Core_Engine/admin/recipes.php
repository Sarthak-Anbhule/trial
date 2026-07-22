<?php
/**
 * CIY - Cook It Yourself
 * Admin Recipe Moderation Panel
 */

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/helpers.php';
require_once __DIR__ . '/../classes/Auth.php';
require_once __DIR__ . '/../classes/Recipe.php';
require_once __DIR__ . '/../classes/Admin.php';

if (!Auth::isAdmin()) {
    redirect('index.php');
}

$adminEngine = new Admin();
$recipeEngine = new Recipe();

if (isset($_GET['toggle_featured'])) {
    $adminEngine->toggleFeaturedRecipe((int)$_GET['toggle_featured']);
    redirect('admin/recipes.php');
}

if (isset($_GET['delete_id'])) {
    $recipeEngine->delete((int)$_GET['delete_id'], 0, true);
    redirect('admin/recipes.php');
}

$recipes = $recipeEngine->getRecipes([], 1, 30)['items'];

$pageTitle = 'Manage Recipes - CIY Admin';
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/navbar.php';
?>

<div class="container py-5 my-4">
    <div class="glass-card p-4 p-md-5" data-aos="fade-up">
        <h3 class="font-heading fw-bold mb-4"><i class="fa-solid fa-utensils text-primary me-2"></i> Recipe Moderation</h3>
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Category</th>
                        <th>Featured</th>
                        <th>Views</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recipes as $r): ?>
                        <tr>
                            <td>
                                <a href="<?= BASE_URL ?>/pages/detail.php?id=<?= $r['id'] ?>" class="fw-bold text-dark text-decoration-none" target="_blank"><?= e($r['title']) ?></a>
                            </td>
                            <td><?= e($r['author_name']) ?></td>
                            <td><span class="badge bg-light text-dark border"><?= e($r['category_name']) ?></span></td>
                            <td>
                                <a href="?toggle_featured=<?= $r['id'] ?>" class="btn btn-sm <?= !empty($r['is_featured']) ? 'btn-warning text-dark' : 'btn-outline-secondary' ?> rounded-pill">
                                    <i class="fa-solid fa-star"></i> <?= !empty($r['is_featured']) ? 'Featured' : 'Feature' ?>
                                </a>
                            </td>
                            <td><?= format_number($r['views_count']) ?></td>
                            <td>
                                <a href="?delete_id=<?= $r['id'] ?>" class="btn btn-outline-danger btn-sm rounded-pill" onclick="return confirm('Delete this recipe?')">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
