<?php
/**
 * CIY - Cook It Yourself
 * Categories Grid Page
 */

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/helpers.php';
require_once __DIR__ . '/../classes/Category.php';

$categoryEngine = new Category();
$categories = $categoryEngine->getAll();

$activeNav = 'categories';
$pageTitle = 'Recipe Categories - ' . APP_NAME;
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/navbar.php';
?>

<div class="container py-5 my-4">
    <div class="text-center mb-5">
        <h2 class="font-heading fw-bold display-5 mb-2">Recipe Categories</h2>
        <p class="text-muted">Browse world cuisines and culinary categories</p>
    </div>

    <div class="row g-4">
        <?php foreach ($categories as $cat): ?>
            <div class="col-md-4 col-lg-3">
                <a href="<?= BASE_URL ?>/pages/explore.php?category=<?= e($cat['slug']) ?>" class="glass-card text-center p-4 d-block text-reset h-100" data-aos="fade-up">
                    <div class="icon-box bg-light rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width:70px; height:70px;">
                        <i class="fa-solid <?= e($cat['icon']) ?> display-6 text-primary"></i>
                    </div>
                    <h5 class="font-heading fw-bold mb-1"><?= e($cat['name']) ?></h5>
                    <p class="text-muted small mb-2"><?= e($cat['description']) ?></p>
                    <span class="badge bg-primary rounded-pill px-3 py-2"><?= $cat['recipe_count'] ?> Recipes</span>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
