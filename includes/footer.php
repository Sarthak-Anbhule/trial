<?php
/**
 * CIY - Cook It Yourself
 * Global Shared Footer Component
 */
?>
<footer class="mt-auto py-5 glass-card rounded-0 border-bottom-0 border-start-0 border-end-0">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4">
                <a href="<?= BASE_URL ?>/index.php" class="navbar-brand-logo mb-3 display-6">
                    <i class="fa-solid fa-utensils"></i>
                    <span>CIY</span>
                </a>
                <p class="text-muted small pr-md-4">
                    Cook It Yourself is a premier Apple-inspired culinary community platform designed for food enthusiasts, professional chefs, and home cooks to share and discover world-class recipes.
                </p>
                <div class="d-flex gap-3 fs-5 text-muted mt-3">
                    <a href="#" class="text-secondary hover-primary"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#" class="text-secondary hover-primary"><i class="fa-brands fa-pinterest"></i></a>
                    <a href="#" class="text-secondary hover-primary"><i class="fa-brands fa-youtube"></i></a>
                    <a href="#" class="text-secondary hover-primary"><i class="fa-brands fa-twitter"></i></a>
                </div>
            </div>

            <div class="col-6 col-lg-2">
                <h6 class="font-heading fw-bold mb-3"><?= t('quick_links') ?></h6>
                <ul class="list-unstyled d-flex flex-column gap-2 small text-muted">
                    <li><a href="<?= BASE_URL ?>/pages/explore.php"><?= t('explore') ?></a></li>
                    <li><a href="<?= BASE_URL ?>/pages/categories.php"><?= t('categories') ?></a></li>
                    <li><a href="<?= BASE_URL ?>/pages/explore.php?sort=popular">Trending Dishes</a></li>
                    <li><a href="<?= BASE_URL ?>/pages/explore.php?difficulty=easy">Quick & Easy</a></li>
                </ul>
            </div>

            <div class="col-6 col-lg-2">
                <h6 class="font-heading fw-bold mb-3"><?= t('company') ?></h6>
                <ul class="list-unstyled d-flex flex-column gap-2 small text-muted">
                    <li><a href="<?= BASE_URL ?>/pages/about.php"><?= t('about') ?></a></li>
                    <li><a href="<?= BASE_URL ?>/pages/contact.php">Contact Support</a></li>
                    <li><a href="<?= BASE_URL ?>/pages/privacy.php">Privacy Policy</a></li>
                    <li><a href="<?= BASE_URL ?>/pages/terms.php">Terms of Service</a></li>
                </ul>
            </div>

            <div class="col-lg-4">
                <h6 class="font-heading fw-bold mb-3"><?= t('newsletter') ?></h6>
                <p class="text-muted small mb-3">Subscribe to receive curated weekly recipes and chef techniques directly in your inbox.</p>
                <form onsubmit="event.preventDefault(); showToast('Subscribed to newsletter!');" class="d-flex gap-2">
                    <input type="email" class="form-control rounded-pill glass-card border-0 px-3" placeholder="<?= t('reg_email_placeholder') ?>" required>
                    <button type="submit" class="btn-ciy-primary btn-sm px-4">Join</button>
                </form>
            </div>
        </div>

        <hr class="my-4 opacity-25">

        <div class="d-flex flex-column flex-md-row align-items-center justify-content-between text-muted small">
            <div>&copy; <?= date('Y') ?> <?= t('all_rights_reserved') ?></div>
            <div class="d-flex gap-3 mt-2 mt-md-0">
                <a href="<?= BASE_URL ?>/pages/privacy.php">Privacy</a>
                <a href="<?= BASE_URL ?>/pages/terms.php">Terms</a>
            </div>
        </div>
    </div>
</footer>

<!-- JS Script Imports -->
<script href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="<?= BASE_URL ?>/assets/js/app.js"></script>

</body>
</html>
