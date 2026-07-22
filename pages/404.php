<?php
/**
 * CIY - Cook It Yourself
 * 404 Page Not Found
 */

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/helpers.php';

$pageTitle = '404 Page Not Found - CIY';
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/navbar.php';
?>

<div class="container py-5 my-5 text-center">
    <div class="glass-card p-5 my-5 mx-auto" style="max-width:540px;" data-aos="zoom-in">
        <h1 class="display-1 font-heading fw-bold text-primary mb-2">404</h1>
        <h4 class="font-heading fw-bold mb-3">Recipe Not Found</h4>
        <p class="text-muted mb-4">The dish or page you are looking for has been moved or eaten!</p>
        <a href="<?= BASE_URL ?>/index.php" class="btn-ciy-primary py-3 px-4"><i class="fa-solid fa-house me-2"></i> Back to Home</a>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
