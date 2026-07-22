<?php
/**
 * CIY - Cook It Yourself
 * Reusable Recipe Card Glass Component
 * Expected variable: $recipe (array)
 */

if (!isset($recipe)) return;

$coverUrl = !empty($recipe['cover_image']) ? RECIPE_UPLOAD_URL . e($recipe['cover_image']) : DEFAULT_RECIPE_COVER;
$authorAvatar = !empty($recipe['author_avatar']) && $recipe['author_avatar'] !== 'default_avatar.jpg' ? PROFILE_UPLOAD_URL . e($recipe['author_avatar']) : DEFAULT_AVATAR;
$totalTime = ($recipe['prep_time'] ?? 15) + ($recipe['cook_time'] ?? 30);
$avgRating = isset($recipe['avg_rating']) ? number_format((float)$recipe['avg_rating'], 1) : '4.8';
?>
<div class="recipe-card glass-card h-100" data-aos="fade-up">
    <!-- Image Wrap -->
    <div class="recipe-card-img-wrap">
        <a href="<?= BASE_URL ?>/pages/detail.php?id=<?= $recipe['id'] ?>">
            <img src="<?= $coverUrl ?>" alt="<?= e($recipe['title']) ?>" loading="lazy">
        </a>
        <!-- Bookmark Floating Button -->
        <button class="btn-bookmark-floating btn-bookmark-action <?= !empty($recipe['is_bookmarked']) ? 'active' : '' ?>" 
                data-recipe-id="<?= $recipe['id'] ?>" 
                title="Bookmark Recipe">
            <i class="<?= !empty($recipe['is_bookmarked']) ? 'fa-solid fa-bookmark' : 'fa-regular fa-bookmark' ?>"></i>
        </button>

        <!-- Time Badge -->
        <span class="recipe-badge-time">
            <i class="fa-regular fa-clock text-warning"></i> <?= $totalTime ?> min
        </span>
    </div>

    <!-- Body Content -->
    <div class="recipe-card-body">
        <!-- Author Info -->
        <div class="recipe-author-meta">
            <img src="<?= $authorAvatar ?>" alt="<?= e($recipe['author_name']) ?>" class="recipe-author-avatar">
            <span class="small fw-semibold text-muted text-truncate me-auto">
                <a href="<?= BASE_URL ?>/pages/profile.php?username=<?= e($recipe['author_username']) ?>" class="text-reset hover-primary">
                    <?= e($recipe['author_name']) ?>
                </a>
            </span>
            <span class="badge rounded-pill bg-light text-dark border small fw-normal"><?= e($recipe['difficulty'] ?? 'Easy') ?></span>
        </div>

        <!-- Recipe Title -->
        <h5 class="font-heading fw-bold mb-2 fs-6">
            <a href="<?= BASE_URL ?>/pages/detail.php?id=<?= $recipe['id'] ?>" class="text-reset hover-primary">
                <?= e($recipe['title']) ?>
            </a>
        </h5>

        <!-- Meta Footer: Rating & Likes -->
        <div class="d-flex align-items-center justify-content-between mt-auto pt-3 border-top border-subtle">
            <!-- Star Rating -->
            <div class="d-flex align-items-center gap-1 small fw-bold text-dark">
                <i class="fa-solid fa-star text-warning"></i>
                <span><?= $avgRating ?></span>
            </div>

            <!-- Like Action Button -->
            <button class="btn btn-sm btn-link p-0 text-decoration-none text-muted btn-like-action <?= !empty($recipe['is_liked']) ? 'active' : '' ?>" 
                    data-recipe-id="<?= $recipe['id'] ?>">
                <i class="<?= !empty($recipe['is_liked']) ? 'fa-solid fa-heart text-danger' : 'fa-regular fa-heart' ?>"></i>
                <span class="like-count ms-1 small fw-semibold"><?= format_number($recipe['likes_count'] ?? 0) ?></span>
            </button>
        </div>
    </div>
</div>
