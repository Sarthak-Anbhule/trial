<?php
/**
 * CIY - Cook It Yourself
 * Recipe Detail & Interactive Cooking Studio Page
 */

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/helpers.php';
require_once __DIR__ . '/../classes/Auth.php';
require_once __DIR__ . '/../classes/Recipe.php';
require_once __DIR__ . '/../classes/Interaction.php';
require_once __DIR__ . '/../classes/User.php';

$recipeId = $_GET['id'] ?? $_GET['slug'] ?? 0;
$recipeEngine = new Recipe();
$currentUserId = Auth::id();

$recipe = $recipeEngine->get($recipeId, $currentUserId);
if (!$recipe) {
    redirect('pages/404.php');
}

$userEngine = new User();
$interaction = new Interaction();
$comments = $interaction->getComments($recipe['id']);
$isFollowingAuthor = $userEngine->isFollowing($currentUserId, $recipe['author_id']);

$coverUrl = !empty($recipe['cover_image']) ? RECIPE_UPLOAD_URL . e($recipe['cover_image']) : DEFAULT_RECIPE_COVER;
$authorAvatar = !empty($recipe['author_avatar']) && $recipe['author_avatar'] !== 'default_avatar.jpg' ? PROFILE_UPLOAD_URL . e($recipe['author_avatar']) : DEFAULT_AVATAR;

$pageTitle = e($recipe['title']) . ' - ' . APP_NAME;
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/navbar.php';
?>

<!-- Pass Recipe Step Data to JS for Cooking Mode -->
<script>
    window.CIY_RECIPE_STEPS = <?= json_encode($recipe['steps']) ?>;
</script>

<div class="container py-5 my-4">
    <!-- Hero Image & Title Banner -->
    <div class="glass-card p-4 p-md-5 mb-5 overflow-hidden" data-aos="fade-up">
        <div class="row align-items-center g-4">
            <div class="col-lg-6">
                <span class="badge bg-primary rounded-pill px-3 py-2 mb-3">
                    <i class="fa-solid <?= e($recipe['category_icon']) ?> me-1"></i> <?= e($recipe['category_name']) ?>
                </span>
                <h1 class="display-4 font-heading fw-bold mb-3"><?= e($recipe['title']) ?></h1>
                <p class="text-muted lead mb-4"><?= e($recipe['description']) ?></p>

                <!-- Author & Actions Row -->
                <div class="d-flex flex-wrap align-items-center gap-3 mb-4">
                    <a href="<?= BASE_URL ?>/pages/profile.php?username=<?= e($recipe['author_username']) ?>" class="d-flex align-items-center gap-2 text-decoration-none text-dark">
                        <img src="<?= $authorAvatar ?>" alt="<?= e($recipe['author_name']) ?>" class="rounded-circle border border-2 border-warning" style="width:44px; height:44px; object-fit:cover;">
                        <div>
                            <div class="fw-bold small"><?= e($recipe['author_name']) ?></div>
                            <small class="text-muted">@<?= e($recipe['author_username']) ?></small>
                        </div>
                    </a>

                    <?php if ($currentUserId && $currentUserId !== (int)$recipe['author_id']): ?>
                        <button id="btnFollowAuthor" class="btn btn-sm btn-ciy-outline rounded-pill px-3 ms-md-2" onclick="toggleFollowUser(<?= $recipe['author_id'] ?>)">
                            <i class="fa-solid <?= $isFollowingAuthor ? 'fa-user-check' : 'fa-user-plus' ?>"></i>
                            <span id="followText"><?= $isFollowingAuthor ? 'Following' : 'Follow' ?></span>
                        </button>
                    <?php endif; ?>
                </div>

                <!-- Recipe Specs Row -->
                <div class="row g-3 text-center mb-4">
                    <div class="col-3">
                        <div class="glass-card p-2">
                            <small class="text-muted d-block">Prep Time</small>
                            <span class="fw-bold"><?= $recipe['prep_time'] ?> min</span>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="glass-card p-2">
                            <small class="text-muted d-block">Cook Time</small>
                            <span class="fw-bold"><?= $recipe['cook_time'] ?> min</span>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="glass-card p-2">
                            <small class="text-muted d-block">Servings</small>
                            <span class="fw-bold"><?= $recipe['servings'] ?></span>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="glass-card p-2">
                            <small class="text-muted d-block">Difficulty</small>
                            <span class="fw-bold text-primary"><?= e($recipe['difficulty']) ?></span>
                        </div>
                    </div>
                </div>

                <!-- CTA Row -->
                <div class="d-flex flex-wrap gap-3">
                    <button id="btnStartCooking" class="btn-ciy-primary py-3 px-4">
                        <i class="fa-solid fa-fire-burner me-2"></i> Start Cooking Mode
                    </button>
                    <button class="btn-ciy-outline btn-bookmark-action <?= !empty($recipe['is_bookmarked']) ? 'active' : '' ?>" data-recipe-id="<?= $recipe['id'] ?>">
                        <i class="<?= !empty($recipe['is_bookmarked']) ? 'fa-solid fa-bookmark' : 'fa-regular fa-bookmark' ?>"></i> Save
                    </button>
                    <button class="btn-ciy-outline btn-like-action <?= !empty($recipe['is_liked']) ? 'active' : '' ?>" data-recipe-id="<?= $recipe['id'] ?>">
                        <i class="<?= !empty($recipe['is_liked']) ? 'fa-solid fa-heart text-danger' : 'fa-regular fa-heart' ?>"></i>
                        <span class="like-count ms-1"><?= $recipe['likes_count'] ?></span>
                    </button>
                </div>
            </div>

            <!-- Hero Cover Image -->
            <div class="col-lg-6">
                <img src="<?= $coverUrl ?>" alt="<?= e($recipe['title']) ?>" class="img-fluid rounded-4 shadow-lg w-100" style="max-height:480px; object-fit:cover;">
            </div>
        </div>
    </div>

    <!-- Main Content: Ingredients & Instructions -->
    <div class="row g-4">
        <!-- Ingredients Checklist -->
        <div class="col-lg-4">
            <div class="glass-card p-4 sticky-top" style="top: 100px;">
                <h4 class="font-heading fw-bold mb-3"><i class="fa-solid fa-basket-shopping text-primary me-2"></i> Ingredients</h4>
                <ul class="list-group list-group-flush bg-transparent">
                    <?php foreach ($recipe['ingredients'] as $ing): ?>
                        <li class="list-group-item bg-transparent d-flex align-items-center gap-3 px-0 border-subtle">
                            <input class="form-check-input rounded-circle border-2" type="checkbox" id="ing_<?= $ing['id'] ?>">
                            <label class="form-check-label flex-grow-1 cursor-pointer" for="ing_<?= $ing['id'] ?>">
                                <strong><?= e($ing['amount']) ?> <?= e($ing['unit']) ?></strong> <?= e($ing['name']) ?>
                            </label>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>

        <!-- Step-by-Step Instructions & Nutrition -->
        <div class="col-lg-8">
            <!-- Nutrition Summary Cards -->
            <div class="glass-card p-4 mb-4">
                <h5 class="font-heading fw-bold mb-3"><i class="fa-solid fa-chart-pie me-2 text-warning"></i> Nutrition per Serving</h5>
                <div class="row g-2 text-center">
                    <div class="col-4 col-md"><div class="p-2 border rounded-3"><small class="text-muted d-block">Calories</small><strong><?= $recipe['nutrition']['calories'] ?> kcal</strong></div></div>
                    <div class="col-4 col-md"><div class="p-2 border rounded-3"><small class="text-muted d-block">Protein</small><strong><?= e($recipe['nutrition']['protein']) ?></strong></div></div>
                    <div class="col-4 col-md"><div class="p-2 border rounded-3"><small class="text-muted d-block">Carbs</small><strong><?= e($recipe['nutrition']['carbs']) ?></strong></div></div>
                    <div class="col-4 col-md"><div class="p-2 border rounded-3"><small class="text-muted d-block">Fat</small><strong><?= e($recipe['nutrition']['fat']) ?></strong></div></div>
                    <div class="col-4 col-md"><div class="p-2 border rounded-3"><small class="text-muted d-block">Fiber</small><strong><?= e($recipe['nutrition']['fiber']) ?></strong></div></div>
                </div>
            </div>

            <!-- Steps List -->
            <div class="glass-card p-4 mb-4">
                <h4 class="font-heading fw-bold mb-4"><i class="fa-solid fa-list-check text-success me-2"></i> Step-by-Step Instructions</h4>
                <div class="d-flex flex-column gap-4">
                    <?php foreach ($recipe['steps'] as $step): ?>
                        <div class="step-item d-flex gap-3">
                            <div class="badge rounded-circle bg-primary text-white d-flex align-items-center justify-content-center flex-shrink-0" style="width:38px; height:38px; font-size:1.1rem;">
                                <?= $step['step_number'] ?>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="font-heading fw-bold mb-1"><?= e($step['title'] ?: 'Step ' . $step['step_number']) ?></h6>
                                <p class="text-muted mb-2"><?= e($step['instruction']) ?></p>
                                <?php if (!empty($step['time_minutes'])): ?>
                                    <small class="badge bg-light text-dark border"><i class="fa-regular fa-clock me-1"></i> Timer: <?= $step['time_minutes'] ?> mins</small>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Comments & Reviews Section -->
            <div class="glass-card p-4">
                <h4 class="font-heading fw-bold mb-4"><i class="fa-solid fa-comments text-info me-2"></i> Community Reviews</h4>

                <?php if ($currentUserId): ?>
                    <!-- Comment Input Form -->
                    <form onsubmit="submitComment(event, <?= $recipe['id'] ?>)" class="mb-4">
                        <div class="mb-3">
                            <label class="form-label font-heading small fw-semibold">Your Rating</label>
                            <select id="commentRating" class="form-select glass-card w-auto mb-2">
                                <option value="5">⭐⭐⭐⭐⭐ (5/5 Excellent)</option>
                                <option value="4">⭐⭐⭐⭐ (4/5 Very Good)</option>
                                <option value="3">⭐⭐⭐ (3/5 Good)</option>
                                <option value="2">⭐⭐ (2/5 Fair)</option>
                                <option value="1">⭐ (1/5 Poor)</option>
                            </select>
                            <textarea id="commentText" class="form-control glass-card" rows="3" placeholder="Share your cooking outcome, tips, or feedback..." required></textarea>
                        </div>
                        <button type="submit" class="btn-ciy-primary py-2 px-4">Post Comment</button>
                    </form>
                <?php else: ?>
                    <div class="alert alert-info rounded-4 py-2 px-3 small border-0 mb-4">
                        Please <a href="<?= BASE_URL ?>/auth/login.php" class="fw-bold">Log In</a> to post a review.
                    </div>
                <?php endif; ?>

                <!-- Comments List -->
                <div class="d-flex flex-column gap-3">
                    <?php foreach ($comments as $c): ?>
                        <div class="p-3 border rounded-3">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <div class="d-flex align-items-center gap-2">
                                    <img src="<?= !empty($c['user_avatar']) && $c['user_avatar'] !== 'default_avatar.jpg' ? PROFILE_UPLOAD_URL . e($c['user_avatar']) : DEFAULT_AVATAR ?>" class="rounded-circle" style="width:32px; height:32px; object-fit:cover;">
                                    <span class="fw-bold small"><?= e($c['user_name']) ?></span>
                                </div>
                                <span class="small text-muted"><?= time_ago($c['created_at']) ?></span>
                            </div>
                            <p class="small text-muted mb-0"><?= e($c['comment']) ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FULLSCREEN COOKING MODE MODAL -->
<div class="modal fade cooking-mode-modal" id="cookingModeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content glass-card border-0">
            <div class="modal-header border-bottom p-4">
                <h5 class="modal-title font-heading fw-bold text-primary"><i class="fa-solid fa-fire-burner me-2"></i> Cooking Mode - <?= e($recipe['title']) ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4 p-md-5 d-flex flex-column justify-content-between">
                <div>
                    <!-- Step Progress Bar -->
                    <div class="progress mb-4" style="height: 8px;">
                        <div id="cookProgressBar" class="progress-bar bg-primary" style="width: 25%;"></div>
                    </div>

                    <span id="cookStepCounter" class="badge bg-light text-primary border mb-3 fs-6 px-3 py-2 font-heading">Step 1 of 4</span>
                    <h2 id="cookStepTitle" class="display-5 font-heading fw-bold mb-3">Step Title</h2>
                    <p id="cookStepInstruction" class="lead text-muted mb-4 fs-4">Step instructions here...</p>
                </div>

                <!-- Timer Controls Box -->
                <div class="cooking-timer-box mx-auto my-4 w-100" style="max-width: 480px;">
                    <small class="text-muted fw-bold d-block mb-1">STEP TIMER</small>
                    <div id="cookTimerDisplay" class="cooking-timer-display mb-3">05:00</div>
                    <div class="d-flex justify-content-center gap-3">
                        <button id="cookToggleTimer" class="btn-ciy-primary py-2 px-4"><i class="fa-solid fa-play me-1"></i> Start Timer</button>
                        <button id="cookResetTimer" class="btn-ciy-outline py-2 px-3"><i class="fa-solid fa-rotate-left"></i></button>
                    </div>
                </div>

                <!-- Bottom Step Navigation Row -->
                <div class="d-flex align-items-center justify-content-between border-top pt-4">
                    <button id="cookPrevStep" class="btn-ciy-outline py-3 px-4"><i class="fa-solid fa-arrow-left me-1"></i> Previous Step</button>
                    <button id="cookNextStep" class="btn-ciy-primary py-3 px-5">Next Step <i class="fa-solid fa-arrow-right ms-1"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= BASE_URL ?>/assets/js/cooking_mode.js"></script>
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
            document.getElementById('followText').textContent = data.data.following ? 'Following' : 'Follow';
            showToast(data.message);
        }
    } catch (e) {
        showToast('Error executing follow action', 'error');
    }
}

async function submitComment(e, recipeId) {
    e.preventDefault();
    const comment = document.getElementById('commentText').value;
    const rating = document.getElementById('commentRating').value;

    try {
        const res = await fetch(`${window.CIY_BASE_URL}/api/comment.php`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `recipe_id=${recipeId}&comment=${encodeURIComponent(comment)}&rating=${rating}`
        });
        const data = await res.json();
        if (data.success) {
            showToast('Comment posted successfully!');
            location.reload();
        } else {
            showToast(data.message, 'error');
        }
    } catch (err) {
        showToast('Failed to post comment', 'error');
    }
}
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
