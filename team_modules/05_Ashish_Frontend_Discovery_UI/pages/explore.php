<?php
/**
 * CIY - Cook It Yourself
 * Recipe Discovery & Search Hub
 */

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/helpers.php';
require_once __DIR__ . '/../classes/Auth.php';
require_once __DIR__ . '/../classes/Recipe.php';
require_once __DIR__ . '/../classes/Category.php';

$recipeEngine = new Recipe();
$categoryEngine = new Category();

$currentUserId = Auth::id();
$categories = $categoryEngine->getAll();

// Get Search Parameters
$searchParams = [
    'search' => trim($_GET['search'] ?? ''),
    'category' => trim($_GET['category'] ?? ''),
    'difficulty' => trim($_GET['difficulty'] ?? ''),
    'cuisine' => trim($_GET['cuisine'] ?? ''),
    'max_time' => !empty($_GET['max_time']) ? (int)$_GET['max_time'] : null,
    'sort' => trim($_GET['sort'] ?? 'latest')
];

$page = max(1, (int)($_GET['page'] ?? 1));
$results = $recipeEngine->getRecipes($searchParams, $page, 9, $currentUserId);

$activeNav = 'explore';
$pageTitle = 'Explore Recipes - ' . APP_NAME;
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/navbar.php';
?>

<div class="container py-5 my-4">
    <!-- Header Title -->
    <div class="mb-4">
        <h2 class="font-heading fw-bold mb-1">Explore Recipes</h2>
        <p class="text-muted">Discover <?= $results['total'] ?> delicious recipes curated for you</p>
    </div>

    <!-- Search & Filter Controls -->
    <div class="glass-card p-4 mb-4" data-aos="fade-up">
        <form action="" method="GET" class="row g-3 align-items-center">
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text bg-transparent border-end-0 text-muted"><i class="fa-solid fa-magnifying-glass"></i></span>
                    <input type="text" name="search" class="form-control glass-card border-start-0" placeholder="Search recipe or ingredient..." value="<?= e($searchParams['search']) ?>">
                </div>
            </div>

            <div class="col-6 col-md-2">
                <select name="category" class="form-select glass-card">
                    <option value="">All Categories</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= e($cat['slug']) ?>" <?= $searchParams['category'] === $cat['slug'] ? 'selected' : '' ?>><?= e($cat['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-6 col-md-2">
                <select name="difficulty" class="form-select glass-card">
                    <option value="">Any Difficulty</option>
                    <option value="easy" <?= $searchParams['difficulty'] === 'easy' ? 'selected' : '' ?>>Easy</option>
                    <option value="medium" <?= $searchParams['difficulty'] === 'medium' ? 'selected' : '' ?>>Medium</option>
                    <option value="hard" <?= $searchParams['difficulty'] === 'hard' ? 'selected' : '' ?>>Hard</option>
                </select>
            </div>

            <div class="col-6 col-md-2">
                <select name="sort" class="form-select glass-card">
                    <option value="latest" <?= $searchParams['sort'] === 'latest' ? 'selected' : '' ?>>Newest</option>
                    <option value="popular" <?= $searchParams['sort'] === 'popular' ? 'selected' : '' ?>>Most Viewed</option>
                    <option value="likes" <?= $searchParams['sort'] === 'likes' ? 'selected' : '' ?>>Most Liked</option>
                    <option value="fastest" <?= $searchParams['sort'] === 'fastest' ? 'selected' : '' ?>>Fastest Cook Time</option>
                </select>
            </div>

            <div class="col-6 col-md-2">
                <button type="submit" class="btn-ciy-primary w-100 py-2">Filter</button>
            </div>
        </form>
    </div>

    <!-- Recipe Results Grid -->
    <?php if (!empty($results['items'])): ?>
        <div class="row g-4 mb-5">
            <?php foreach ($results['items'] as $recipe): ?>
                <div class="col-md-6 col-lg-4">
                    <?php include __DIR__ . '/../components/recipe_card.php'; ?>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Pagination -->
        <?php if ($results['pages'] > 1): ?>
            <nav class="d-flex justify-content-center">
                <ul class="pagination gap-2">
                    <?php for ($i = 1; $i <= $results['pages']; $i++): ?>
                        <li class="page-item <?= $i === $results['page'] ? 'active' : '' ?>">
                            <a class="page-link rounded-circle glass-card px-3 py-2 <?= $i === $results['page'] ? 'bg-primary text-white border-0' : 'text-dark' ?>" 
                               href="?<?= http_build_query(array_merge($_GET, ['page' => $i])) ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>
                </ul>
            </nav>
        <?php endif; ?>
    <?php else: ?>
        <div class="glass-card text-center py-5 my-4">
            <i class="fa-solid fa-utensils text-muted display-1 mb-3"></i>
            <h4 class="font-heading fw-bold">No Recipes Found</h4>
            <p class="text-muted">Try adjusting your filters or search keywords.</p>
            <a href="<?= BASE_URL ?>/pages/explore.php" class="btn-ciy-outline mt-2">Reset Filters</a>
        </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
