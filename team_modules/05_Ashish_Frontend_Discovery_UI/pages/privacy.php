<?php
/**
 * CIY - Cook It Yourself
 * Privacy Policy Page
 */

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/helpers.php';

$pageTitle = 'Privacy Policy - CIY';
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/navbar.php';
?>

<div class="container py-5 my-4">
    <div class="glass-card p-4 p-md-5" data-aos="fade-up">
        <h2 class="font-heading fw-bold mb-4">Privacy Policy</h2>
        <p class="text-muted">Last updated: July 2026</p>
        <p class="text-muted">At CIY (Cook It Yourself), we respect your privacy and are committed to protecting your personal data. We collect minimal information required to deliver a seamless culinary social platform experience.</p>
        <h5 class="font-heading fw-bold mt-4">1. Data We Collect</h5>
        <p class="text-muted">Your name, email address, username, profile picture, uploaded recipes, and activity interactions (likes, bookmarks, comments).</p>
        <h5 class="font-heading fw-bold mt-4">2. Security</h5>
        <p class="text-muted">All passwords are securely hashed using BCRYPT algorithm. Prepared statements and CSRF protection safeguard your interactions.</p>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
