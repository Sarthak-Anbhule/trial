<?php
/**
 * CIY - Cook It Yourself
 * About Us Page
 */

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/helpers.php';

$activeNav = 'about';
$pageTitle = 'About CIY - Cook It Yourself';
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/navbar.php';
?>

<div class="container py-5 my-4">
    <div class="row align-items-center g-5 py-4">
        <div class="col-lg-6" data-aos="fade-right">
            <span class="badge bg-primary rounded-pill px-3 py-2 mb-3">Our Culinary Philosophy</span>
            <h1 class="display-4 font-heading fw-bold mb-4">Where Passion Meets Kitchen Precision</h1>
            <p class="text-muted lead mb-4">
                CIY (Cook It Yourself) was founded to redefine how recipes are created, shared, and experienced online. Inspired by Apple's elegant minimalism and Spotify's fluid discovery engine, we empower food lovers worldwide.
            </p>
            <div class="row g-3 text-center">
                <div class="col-4"><div class="glass-card p-3"><h3 class="font-heading fw-bold text-primary mb-0">10K+</h3><small class="text-muted">Chefs</small></div></div>
                <div class="col-4"><div class="glass-card p-3"><h3 class="font-heading fw-bold text-primary mb-0">50K+</h3><small class="text-muted">Recipes</small></div></div>
                <div class="col-4"><div class="glass-card p-3"><h3 class="font-heading fw-bold text-primary mb-0">4.9★</h3><small class="text-muted">Rating</small></div></div>
            </div>
        </div>
        <div class="col-lg-6" data-aos="fade-left">
            <div class="glass-card p-4 text-center">
                <i class="fa-solid fa-utensils text-primary display-1 mb-3"></i>
                <h4 class="font-heading fw-bold">Designed for Pure Cooking Enjoyment</h4>
                <p class="text-muted small mb-0">With our interactive step countdown timers, ingredient scaling, and live discovery engine, cooking at home is an absolute joy.</p>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
