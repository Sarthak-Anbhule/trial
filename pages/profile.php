<?php
/**
 * CIY - Cook It Yourself
 * User Profile & Culinary Portfolio
 */

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/helpers.php';
require_once __DIR__ . '/../classes/Auth.php';
require_once __DIR__ . '/../classes/User.php';
require_once __DIR__ . '/../classes/Recipe.php';

$username = $_GET['username'] ?? ($_SESSION['username'] ?? '');
$userEngine = new User();
$recipeEngine = new Recipe();

$profileUser = $userEngine->get($username);
if (!$profileUser) {
    redirect('pages/404.php');
}

$currentUserId = Auth::id();
$isOwnProfile = ($currentUserId && $currentUserId === (int)$profileUser['id']);
$isFollowing = $userEngine->isFollowing($currentUserId, $profileUser['id']);

$userRecipes = $recipeEngine->getRecipes(['user_id' => $profileUser['id']], 1, 12, $currentUserId)['items'];

$avatarUrl = !empty($profileUser['avatar']) && $profileUser['avatar'] !== 'default_avatar.jpg' ? PROFILE_UPLOAD_URL . e($profileUser['avatar']) : DEFAULT_AVATAR;
$coverUrl = !empty($profileUser['cover_image']) && $profileUser['cover_image'] !== 'default_cover.jpg' ? PROFILE_UPLOAD_URL . e($profileUser['cover_image']) : DEFAULT_COVER;

$pageTitle = e($profileUser['name']) . ' (@' . e($profileUser['username']) . ') - ' . APP_NAME;
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/navbar.php';
?>

<div class="container py-5 my-4">
    <!-- Cover & Avatar Profile Header -->
    <div class="glass-card mb-5 overflow-hidden p-0 position-relative" data-aos="fade-up">
        <div style="height: 220px; background: url('<?= $coverUrl ?>') center/cover no-repeat;"></div>
        <div class="p-4 p-md-5 pt-0">
            <div class="d-flex flex-column flex-md-row align-items-center align-items-md-end justify-content-between gap-3" style="margin-top: -60px;">
                <div class="d-flex flex-column flex-md-row align-items-center align-items-md-end gap-3 text-center text-md-start">
                    <img src="<?= $avatarUrl ?>" alt="<?= e($profileUser['name']) ?>" class="rounded-circle border border-4 border-white shadow-lg" style="width:120px; height:120px; object-fit:cover; background:#fff;">
                    <div class="mb-2">
                        <h3 class="font-heading fw-bold mb-1"><?= t_content(e($profileUser['name'])) ?></h3>
                        <div class="text-muted small">@<?= e($profileUser['username']) ?> • <span class="badge bg-light text-dark border"><?= ucfirst(e($profileUser['role'])) ?></span></div>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <?php if ($isOwnProfile): ?>
                        <a href="<?= BASE_URL ?>/pages/edit_profile.php" class="btn-ciy-outline btn-sm"><i class="fa-solid fa-pen me-1"></i> <?= t('edit_profile') ?></a>
                    <?php elseif ($currentUserId): ?>
                        <button class="btn-ciy-primary btn-sm px-4" onclick="toggleFollowUser(<?= $profileUser['id'] ?>)">
                            <span id="profileFollowText"><?= $isFollowing ? t('following_btn') : t('follow') ?></span>
                        </button>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Stats Bar -->
            <div class="row g-3 text-center my-4 py-3 border-top border-bottom">
                <div class="col-4">
                    <h4 class="font-heading fw-bold mb-0 text-primary"><?= $profileUser['recipes_count'] ?></h4>
                    <small class="text-muted"><?= t('explore') ?></small>
                </div>
                <div class="col-4">
                    <h4 class="font-heading fw-bold mb-0 text-primary"><?= format_number($profileUser['followers_count']) ?></h4>
                    <small class="text-muted"><?= t('followers') ?></small>
                </div>
                <div class="col-4">
                    <h4 class="font-heading fw-bold mb-0 text-primary"><?= format_number($profileUser['following_count']) ?></h4>
                    <small class="text-muted"><?= t('following') ?></small>
                </div>
            </div>

            <?php if (!empty($profileUser['bio'])): ?>
                <p class="text-muted mb-0 small text-center text-md-start"><?= t_content(e($profileUser['bio'])) ?></p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Uploaded Recipes Showcase -->
    <div class="mb-4 d-flex justify-content-between align-items-center">
        <h4 class="font-heading fw-bold mb-0"><?= t('published_recipes') ?></h4>
        <?php if ($isOwnProfile): ?>
            <a href="<?= BASE_URL ?>/pages/upload.php" class="btn-ciy-primary btn-sm"><i class="fa-solid fa-plus me-1"></i> <?= t('create_recipe') ?></a>
        <?php endif; ?>
    </div>

    <?php if (!empty($userRecipes)): ?>
        <div class="row g-4">
            <?php foreach ($userRecipes as $recipe): ?>
                <div class="col-md-6 col-lg-4">
                    <?php include __DIR__ . '/../components/recipe_card.php'; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="glass-card text-center py-5">
            <i class="fa-solid fa-utensils text-muted display-3 mb-3"></i>
            <h5 class="font-heading fw-bold"><?= t('no_my_recipes') ?></h5>
        </div>
    <?php endif; ?>
</div>

<script>
async function toggleFollowUser(userId) {
    try {
        const res = await fetch(`${window.CIY_BASE_URL}/api/follow.php`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `user_id=${userId}`
        });
        const data = await res.json();
        if (data.success) {
            document.getElementById('profileFollowText').textContent = data.data.following ? 'Following' : 'Follow Creator';
            showToast(data.message);
        }
    } catch (e) {
        showToast('Error', 'error');
    }
}
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
