<?php
/**
 * CIY - Cook It Yourself
 * Home Page (Landing & Discovery Hub)
 */

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/helpers.php';
require_once __DIR__ . '/../classes/Auth.php';
require_once __DIR__ . '/../classes/Recipe.php';
require_once __DIR__ . '/../classes/Category.php';
require_once __DIR__ . '/../classes/User.php';

$recipeEngine = new Recipe();
$categoryEngine = new Category();
$userEngine = new User();

$currentUserId = Auth::id();

// Fetch Data
$categories = $categoryEngine->getAll();
$featuredRecipes = $recipeEngine->getRecipes(['featured' => 1], 1, 3, $currentUserId)['items'];
$trendingRecipes = $recipeEngine->getRecipes(['sort' => 'popular'], 1, 6, $currentUserId)['items'];
$latestRecipes = $recipeEngine->getRecipes([], 1, 6, $currentUserId)['items'];
$popularChefs = $userEngine->getPopularChefs(4);
$todaysPick = !empty($featuredRecipes) ? $featuredRecipes[0] : (!empty($latestRecipes) ? $latestRecipes[0] : null);

$activeNav = 'home';
$pageTitle = APP_NAME . ' - Discover. Cook. Share.';
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/navbar.php';
?>

<!-- HERO SECTION -->
<section class="hero-wrapper">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <span class="badge rounded-pill bg-light text-primary border border-primary px-3 py-2 mb-3 fw-semibold animate__animated animate__fadeInDown">
                    <i class="fa-solid fa-sparkles me-1 text-warning"></i> Premium Culinary Experience
                </span>
                <h1 class="hero-title display-3 fw-extrabold mb-3">
                    Discover, Cook & Share <br>Your Culinary Masterpieces
                </h1>
                <p class="hero-subtitle text-muted lead mb-4 px-md-5">
                    Explore thousands of handcrafted glass-tinted recipes from world-renowned chefs and home passionates.
                </p>

                <!-- Search Input Bar -->
                <div class="col-md-10 col-lg-8 mx-auto mb-4">
                    <form action="<?= BASE_URL ?>/pages/explore.php" method="GET" class="glass-card p-2 rounded-pill d-flex align-items-center shadow-lg border">
                        <i class="fa-solid fa-magnifying-glass text-muted fs-5 ms-3 me-2"></i>
                        <input type="text" name="search" class="form-control border-0 bg-transparent shadow-none fs-6" placeholder="Search pasta, ramen, desserts, ingredients..." required>
                        <button type="submit" class="btn-ciy-primary py-2 px-4">Search</button>
                    </form>
                </div>

                <!-- Quick Category Badges -->
                <div class="d-flex flex-wrap justify-content-center gap-2 mt-3">
                    <?php foreach (array_slice($categories, 0, 5) as $cat): ?>
                        <a href="<?= BASE_URL ?>/pages/explore.php?category=<?= e($cat['slug']) ?>" class="btn btn-sm btn-ciy-outline rounded-pill border py-2 px-3 small">
                            <i class="fa-solid <?= e($cat['icon']) ?> me-1 text-primary"></i> <?= e($cat['name']) ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- TODAY'S PICK / FEATURED BANNER -->
<?php if ($todaysPick): ?>
<section class="py-4">
    <div class="container">
        <div class="glass-card p-4 p-md-5 position-relative overflow-hidden" data-aos="fade-up">
            <div class="row align-items-center g-4">
                <div class="col-md-6 order-2 order-md-1">
                    <span class="badge bg-danger rounded-pill px-3 py-2 mb-2 font-heading">
                        <i class="fa-solid fa-fire me-1"></i> Today's Pick
                    </span>
                    <h2 class="display-6 font-heading fw-bold mb-3"><?= e($todaysPick['title']) ?></h2>
                    <p class="text-muted mb-4"><?= e(mb_strimwidth($todaysPick['description'], 0, 140, '...')) ?></p>
                    
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <div class="d-flex align-items-center gap-2">
                            <img src="<?= !empty($todaysPick['author_avatar']) && $todaysPick['author_avatar'] !== 'default_avatar.jpg' ? PROFILE_UPLOAD_URL . e($todaysPick['author_avatar']) : DEFAULT_AVATAR ?>" class="rounded-circle" style="width:36px; height:36px; object-fit:cover;">
                            <span class="fw-semibold small"><?= e($todaysPick['author_name']) ?></span>
                        </div>
                        <span class="text-muted">•</span>
                        <span class="small fw-semibold"><i class="fa-regular fa-clock text-warning me-1"></i> <?= ($todaysPick['prep_time'] + $todaysPick['cook_time']) ?> mins</span>
                        <span class="text-muted">•</span>
                        <span class="small fw-semibold"><i class="fa-solid fa-star text-warning me-1"></i> <?= number_format((float)($todaysPick['avg_rating'] ?? 4.8), 1) ?></span>
                    </div>

                    <a href="<?= BASE_URL ?>/pages/detail.php?id=<?= $todaysPick['id'] ?>" class="btn-ciy-primary">
                        View Recipe <i class="fa-solid fa-arrow-right ms-1"></i>
                    </a>
                </div>
                <div class="col-md-6 order-1 order-md-2">
                    <img src="<?= !empty($todaysPick['cover_image']) ? RECIPE_UPLOAD_URL . e($todaysPick['cover_image']) : DEFAULT_RECIPE_COVER ?>" 
                         alt="<?= e($todaysPick['title']) ?>" 
                         class="img-fluid rounded-4 shadow-lg w-100" style="max-height:360px; object-fit:cover;">
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- POPULAR CATEGORIES CAROUSEL -->
<section class="py-5">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h3 class="font-heading fw-bold mb-1">Explore Categories</h3>
                <p class="text-muted small mb-0">Browse recipes by cuisine and course</p>
            </div>
            <a href="<?= BASE_URL ?>/pages/categories.php" class="btn-ciy-outline btn-sm">View All <i class="fa-solid fa-chevron-right ms-1"></i></a>
        </div>

        <div class="row g-3">
            <?php foreach ($categories as $cat): ?>
                <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                    <a href="<?= BASE_URL ?>/pages/explore.php?category=<?= e($cat['slug']) ?>" class="glass-card text-center p-3 d-block text-reset h-100">
                        <div class="icon-box bg-light rounded-circle mx-auto mb-2 d-flex align-items-center justify-content-center" style="width:54px; height:54px;">
                            <i class="fa-solid <?= e($cat['icon']) ?> fs-4 text-primary"></i>
                        </div>
                        <h6 class="font-heading fw-bold mb-0 text-truncate fs-6"><?= e($cat['name']) ?></h6>
                        <small class="text-muted"><?= $cat['recipe_count'] ?> recipes</small>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- TRENDING RECIPES GRID -->
<section class="py-5">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h3 class="font-heading fw-bold mb-1">Trending Recipes</h3>
                <p class="text-muted small mb-0">Most loved recipes this week</p>
            </div>
            <a href="<?= BASE_URL ?>/pages/explore.php?sort=popular" class="btn-ciy-outline btn-sm">See More <i class="fa-solid fa-chevron-right ms-1"></i></a>
        </div>

        <div class="row g-4">
            <?php foreach ($trendingRecipes as $recipe): ?>
                <div class="col-md-6 col-lg-4">
                    <?php include __DIR__ . '/../components/recipe_card.php'; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- POPULAR CHEFS SHOWCASE -->
<section class="py-5">
    <div class="container">
        <div class="mb-4">
            <h3 class="font-heading fw-bold mb-1">Popular Chefs</h3>
            <p class="text-muted small mb-0">Follow top culinary creators</p>
        </div>

        <div class="row g-4">
            <?php foreach ($popularChefs as $chef): ?>
                <div class="col-6 col-md-3">
                    <div class="glass-card p-4 text-center h-100" data-aos="fade-up">
                        <img src="<?= !empty($chef['avatar']) && $chef['avatar'] !== 'default_avatar.jpg' ? PROFILE_UPLOAD_URL . e($chef['avatar']) : DEFAULT_AVATAR ?>" 
                             class="rounded-circle mb-3 border border-3 border-warning" style="width:80px; height:80px; object-fit:cover;">
                        <h6 class="font-heading fw-bold mb-1 text-truncate"><?= e($chef['name']) ?></h6>
                        <small class="text-muted d-block mb-3">@<?= e($chef['username']) ?></small>
                        <a href="<?= BASE_URL ?>/pages/profile.php?username=<?= e($chef['username']) ?>" class="btn-ciy-outline btn-sm w-100">View Profile</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- LATEST RECIPES GRID -->
<section class="py-5">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h3 class="font-heading fw-bold mb-1">Fresh from the Kitchen</h3>
                <p class="text-muted small mb-0">Recently published community recipes</p>
            </div>
            <a href="<?= BASE_URL ?>/pages/explore.php" class="btn-ciy-outline btn-sm">Browse All <i class="fa-solid fa-chevron-right ms-1"></i></a>
        </div>

        <div class="row g-4">
            <?php foreach ($latestRecipes as $recipe): ?>
                <div class="col-md-6 col-lg-4">
                    <?php include __DIR__ . '/../components/recipe_card.php'; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
