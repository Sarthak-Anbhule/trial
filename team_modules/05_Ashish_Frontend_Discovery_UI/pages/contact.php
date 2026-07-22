<?php
/**
 * CIY - Cook It Yourself
 * Contact Support Page
 */

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/helpers.php';

$pageTitle = 'Contact Us - CIY';
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/navbar.php';
?>

<div class="container py-5 my-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="glass-card p-4 p-md-5" data-aos="fade-up">
                <h3 class="font-heading fw-bold mb-2">Get in Touch</h3>
                <p class="text-muted small mb-4">Have questions, feedback, or need help? Send us a message.</p>

                <form onsubmit="event.preventDefault(); showToast('Message sent successfully!');">
                    <div class="mb-3">
                        <label class="form-label font-heading small fw-bold">Name</label>
                        <input type="text" class="form-control glass-card" placeholder="Your Name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label font-heading small fw-bold">Email</label>
                        <input type="email" class="form-control glass-card" placeholder="you@example.com" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label font-heading small fw-bold">Message</label>
                        <textarea class="form-control glass-card" rows="4" placeholder="How can we help you?" required></textarea>
                    </div>
                    <button type="submit" class="btn-ciy-primary w-100 py-3">Send Message</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
