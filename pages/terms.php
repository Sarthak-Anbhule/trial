<?php
/**
 * CIY - Cook It Yourself
 * Terms of Service Page
 */

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/helpers.php';

$pageTitle = 'Terms of Service - CIY';
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/navbar.php';
?>

<div class="container py-5 my-4">
    <div class="glass-card p-4 p-md-5" data-aos="fade-up">
        <h2 class="font-heading fw-bold mb-4">Terms of Service</h2>
        <p class="text-muted">By using CIY - Cook It Yourself, you agree to publish authentic culinary content, respect community guidelines, and maintain constructive engagement.</p>
        <h5 class="font-heading fw-bold mt-4">1. Content Rights</h5>
        <p class="text-muted">You retain ownership of all recipes and photos you upload to CIY.</p>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
