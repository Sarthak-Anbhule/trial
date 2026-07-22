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
        <a href="<?= BASE_URL ?>/index.php" class="nav-link-ciy <?= ($activeNav ?? '') === 'home' ? 'active' : '' ?>">Home</a>
        <a href="<?= BASE_URL ?>/pages/explore.php" class="nav-link-ciy <?= ($activeNav ?? '') === 'explore' ? 'active' : '' ?>">Explore</a>
        <a href="<?= BASE_URL ?>/pages/categories.php" class="nav-link-ciy <?= ($activeNav ?? '') === 'categories' ? 'active' : '' ?>">Categories</a>
        <a href="<?= BASE_URL ?>/pages/about.php" class="nav-link-ciy <?= ($activeNav ?? '') === 'about' ? 'active' : '' ?>">About</a>
    </div>

    <!-- Action Group (Search, Theme Toggle, Profile/Auth) -->
    <div class="d-flex align-items-center gap-3">
        <!-- Live Search Trigger -->
        <a href="<?= BASE_URL ?>/pages/explore.php" class="btn btn-sm rounded-circle p-2 border-0 text-dark me-1" title="Search Recipes">
            <i class="fa-solid fa-magnifying-glass fs-5"></i>
        </a>

        <!-- Dark Mode Toggle -->
        <button id="darkModeToggle" class="btn btn-sm rounded-circle p-2 border-0 text-dark" title="Toggle Theme">
            <i class="fa-solid fa-moon fs-5"></i>
        </button>

        <?php if ($currentUser): ?>
            <!-- Create Recipe Button -->
            <a href="<?= BASE_URL ?>/pages/upload.php" class="btn-ciy-primary d-none d-sm-inline-flex btn-sm py-2 px-3">
                <i class="fa-solid fa-plus"></i> Create Recipe
            </a>

            <!-- Notifications Link -->
            <a href="<?= BASE_URL ?>/pages/notifications.php" class="position-relative text-dark text-decoration-none">
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
                    <li><a class="dropdown-item rounded-3 py-2" href="<?= BASE_URL ?>/pages/profile.php"><i class="fa-solid fa-user me-2 text-primary"></i> Profile</a></li>
                    <li><a class="dropdown-item rounded-3 py-2" href="<?= BASE_URL ?>/pages/saved.php"><i class="fa-solid fa-bookmark me-2 text-warning"></i> Saved Recipes</a></li>
                    <li><a class="dropdown-item rounded-3 py-2" href="<?= BASE_URL ?>/pages/my_recipes.php"><i class="fa-solid fa-utensils me-2 text-success"></i> My Recipes</a></li>
                    <?php if (Auth::isAdmin()): ?>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item rounded-3 py-2 text-danger fw-semibold" href="<?= BASE_URL ?>/admin/index.php"><i class="fa-solid fa-shield-halved me-2"></i> Admin Panel</a></li>
                    <?php endif; ?>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item rounded-3 py-2 text-danger" href="<?= BASE_URL ?>/auth/logout.php"><i class="fa-solid fa-right-from-bracket me-2"></i> Logout</a></li>
                </ul>
            </div>
        <?php else: ?>
            <a href="<?= BASE_URL ?>/auth/login.php" class="btn-ciy-outline btn-sm py-2 px-3">Log In</a>
            <a href="<?= BASE_URL ?>/auth/register.php" class="btn-ciy-primary btn-sm py-2 px-4">Sign Up</a>
        <?php endif; ?>

        <!-- Mobile Hamburger Toggle -->
        <button class="btn btn-sm d-md-none border-0 text-dark fs-4 ms-1" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu">
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
        <a href="<?= BASE_URL ?>/index.php" class="nav-link-ciy">Home</a>
        <a href="<?= BASE_URL ?>/pages/explore.php" class="nav-link-ciy">Explore Recipes</a>
        <a href="<?= BASE_URL ?>/pages/categories.php" class="nav-link-ciy">Categories</a>
        <a href="<?= BASE_URL ?>/pages/about.php" class="nav-link-ciy">About CIY</a>
        <?php if ($currentUser): ?>
            <hr>
            <a href="<?= BASE_URL ?>/pages/upload.php" class="btn-ciy-primary text-center py-3"><i class="fa-solid fa-plus me-2"></i> Upload Recipe</a>
        <?php endif; ?>
    </div>
</div>
