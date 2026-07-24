<?php
/**
 * CIY - Cook It Yourself
 * Floating Glassmorphic Navbar with Mobile Hamburger
 */
?>
<nav class="glass-nav d-flex align-items-center justify-content-between">
    <!-- Brand Logo -->
    <a href="<?= BASE_URL ?>/index.php" class="navbar-brand-logo">
        <i class="fa-solid fa-utensils"></i>
        <span>CIY</span>
    </a>

    <!-- Desktop Navigation Links -->
    <div class="d-none d-md-flex align-items-center gap-2">
        <a href="<?= BASE_URL ?>/index.php" class="nav-link-ciy <?= ($activeNav ?? '') === 'home' ? 'active' : '' ?>"><?= t('home') ?></a>
        <a href="<?= BASE_URL ?>/pages/explore.php" class="nav-link-ciy <?= ($activeNav ?? '') === 'explore' ? 'active' : '' ?>"><?= t('explore') ?></a>
        <a href="<?= BASE_URL ?>/pages/categories.php" class="nav-link-ciy <?= ($activeNav ?? '') === 'categories' ? 'active' : '' ?>"><?= t('categories') ?></a>
        <a href="<?= BASE_URL ?>/pages/about.php" class="nav-link-ciy <?= ($activeNav ?? '') === 'about' ? 'active' : '' ?>"><?= t('about') ?></a>
    </div>

    <!-- Action Group (Search, Language, Theme Toggle, Profile/Auth) -->
    <div class="d-flex align-items-center gap-2 gap-md-3">
        <!-- Live Search Trigger -->
        <a href="<?= BASE_URL ?>/pages/explore.php" class="nav-icon-btn btn btn-sm rounded-circle p-2 border-0 me-1" title="<?= t('search') ?>">
            <i class="fa-solid fa-magnifying-glass fs-5"></i>
        </a>

        <!-- Multiple Language Selector Dropdown -->
        <div class="dropdown">
            <button class="nav-icon-btn btn btn-sm rounded-pill px-2 py-1 d-flex align-items-center gap-1 border-0" data-bs-toggle="dropdown" title="<?= t('language') ?>">
                <i class="fa-solid fa-globe fs-5"></i>
                <span class="small fw-bold text-uppercase d-none d-lg-inline ms-1"><?= CURRENT_LANG ?></span>
                <i class="fa-solid fa-chevron-down ms-1" style="font-size: 0.7rem;"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow-lg glass-card border-0 p-2 mt-2" style="min-width: 180px;">
                <li class="px-3 py-1 text-muted small border-bottom mb-1 fw-bold"><?= t('language') ?></li>
                <?php foreach (SUPPORTED_LANGUAGES as $code => $lang): ?>
                    <li>
                        <a class="dropdown-item rounded-3 py-2 d-flex align-items-center justify-content-between <?= CURRENT_LANG === $code ? 'active fw-bold' : '' ?>" 
                           href="<?= lang_url($code) ?>">
                            <span><?= $lang['icon'] ?> <?= $lang['native'] ?></span>
                            <?php if (CURRENT_LANG === $code): ?>
                                <i class="fa-solid fa-check text-primary ms-2"></i>
                            <?php endif; ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <!-- Dark Mode Toggle -->
        <button id="darkModeToggle" class="nav-icon-btn btn btn-sm rounded-circle p-2 border-0" title="<?= t('dark_mode') ?>">
            <i class="fa-solid fa-moon fs-5"></i>
        </button>

        <?php if ($currentUser): ?>
            <!-- Create Recipe Button -->
            <a href="<?= BASE_URL ?>/pages/upload.php" class="btn-ciy-primary d-none d-sm-inline-flex btn-sm py-2 px-3">
                <i class="fa-solid fa-plus"></i> <?= t('create_recipe') ?>
            </a>

            <!-- Notifications Link -->
            <a href="<?= BASE_URL ?>/pages/notifications.php" class="nav-icon-btn position-relative text-decoration-none p-1">
                <i class="fa-solid fa-bell fs-5"></i>
            </a>

            <!-- User Dropdown Menu -->
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                    <img src="<?= !empty($currentUser['avatar']) && $currentUser['avatar'] !== 'default_avatar.jpg' ? PROFILE_UPLOAD_URL . e($currentUser['avatar']) : DEFAULT_AVATAR ?>" 
                         alt="<?= e($currentUser['name']) ?>" 
                         class="rounded-circle border border-2 border-warning" style="width: 38px; height: 38px; object-fit: cover;">
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow-lg glass-card border-0 p-2 mt-2" style="min-width: 220px;">
                    <li class="px-3 py-2 border-bottom mb-2">
                        <div class="fw-bold text-truncate"><?= e($currentUser['name']) ?></div>
                        <small class="text-muted">@<?= e($currentUser['username']) ?></small>
                    </li>
                    <li><a class="dropdown-item rounded-3 py-2" href="<?= BASE_URL ?>/pages/profile.php"><i class="fa-solid fa-user me-2 text-primary"></i> <?= t('profile') ?></a></li>
                    <li><a class="dropdown-item rounded-3 py-2" href="<?= BASE_URL ?>/pages/saved.php"><i class="fa-solid fa-bookmark me-2 text-warning"></i> <?= t('saved_recipes') ?></a></li>
                    <li><a class="dropdown-item rounded-3 py-2" href="<?= BASE_URL ?>/pages/my_recipes.php"><i class="fa-solid fa-utensils me-2 text-success"></i> <?= t('my_recipes') ?></a></li>
                    <?php if (Auth::isAdmin()): ?>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item rounded-3 py-2 text-danger fw-semibold" href="<?= BASE_URL ?>/admin/index.php"><i class="fa-solid fa-shield-halved me-2"></i> <?= t('admin_panel') ?></a></li>
                    <?php endif; ?>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item rounded-3 py-2 text-danger" href="<?= BASE_URL ?>/auth/logout.php"><i class="fa-solid fa-right-from-bracket me-2"></i> <?= t('logout') ?></a></li>
                </ul>
            </div>
        <?php else: ?>
            <a href="<?= BASE_URL ?>/auth/login.php" class="btn-ciy-outline btn-sm py-2 px-3"><?= t('login') ?></a>
            <a href="<?= BASE_URL ?>/auth/register.php" class="btn-ciy-primary btn-sm py-2 px-4 d-none d-sm-inline-flex"><?= t('sign_up') ?></a>
        <?php endif; ?>

        <!-- Mobile Hamburger Toggle -->
        <button class="nav-icon-btn btn btn-sm d-md-none border-0 fs-4 ms-1" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu">
            <i class="fa-solid fa-bars-staggered"></i>
        </button>
    </div>
</nav>

<!-- Mobile Drawer Navigation -->
<div class="offcanvas offcanvas-end glass-card border-0" tabindex="-1" id="mobileMenu">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title font-heading fw-bold text-primary"><i class="fa-solid fa-utensils me-2"></i> CIY Menu</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body d-flex flex-column gap-3 fs-5 font-heading">
        <a href="<?= BASE_URL ?>/index.php" class="nav-link-ciy"><?= t('home') ?></a>
        <a href="<?= BASE_URL ?>/pages/explore.php" class="nav-link-ciy"><?= t('explore') ?></a>
        <a href="<?= BASE_URL ?>/pages/categories.php" class="nav-link-ciy"><?= t('categories') ?></a>
        <a href="<?= BASE_URL ?>/pages/about.php" class="nav-link-ciy"><?= t('about') ?></a>
        
        <div class="mt-2 border-top pt-3">
            <div class="small text-muted mb-2 px-2 fw-normal fs-6"><?= t('language') ?></div>
            <div class="d-flex gap-2">
                <?php foreach (SUPPORTED_LANGUAGES as $code => $lang): ?>
                    <a href="<?= lang_url($code) ?>" class="btn btn-sm <?= CURRENT_LANG === $code ? 'btn-primary' : 'btn-outline-secondary' ?> rounded-pill px-3">
                        <?= $lang['icon'] ?> <?= $lang['native'] ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

        <?php if ($currentUser): ?>
            <hr>
            <a href="<?= BASE_URL ?>/pages/upload.php" class="btn-ciy-primary text-center py-3"><i class="fa-solid fa-plus me-2"></i> <?= t('create_recipe') ?></a>
        <?php else: ?>
            <hr>
            <a href="<?= BASE_URL ?>/auth/login.php" class="btn-ciy-outline text-center py-2"><?= t('login') ?></a>
            <a href="<?= BASE_URL ?>/auth/register.php" class="btn-ciy-primary text-center py-2"><?= t('sign_up') ?></a>
        <?php endif; ?>
    </div>
</div>
