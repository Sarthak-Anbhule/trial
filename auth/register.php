<?php
/**
 * CIY - Cook It Yourself
 * Glassmorphic Registration Page
 */

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/helpers.php';
require_once __DIR__ . '/../classes/Auth.php';

if (Auth::check()) {
    redirect('index.php');
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf($_POST['csrf_token'] ?? '')) {
        $error = 'Security token expired. Please retry.';
    } else {
        $auth = new Auth();
        $res = $auth->register([
            'name' => $_POST['name'] ?? '',
            'username' => $_POST['username'] ?? '',
            'email' => $_POST['email'] ?? '',
            'password' => $_POST['password'] ?? ''
        ]);

        if ($res['success']) {
            redirect('index.php');
        } else {
            $error = $res['message'];
        }
    }
}

$pageTitle = 'Create Account - CIY';
require_once __DIR__ . '/../includes/header.php';
?>

<div class="container py-5 my-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="glass-card p-4 p-md-5" data-aos="fade-up">
                <div class="text-center mb-4">
                    <a href="<?= BASE_URL ?>/index.php" class="navbar-brand-logo justify-content-center mb-2 fs-2">
                        <i class="fa-solid fa-utensils"></i> <span>CIY</span>
                    </a>
                    <h4 class="font-heading fw-bold">Join the Community</h4>
                    <p class="text-muted small">Start discovering & sharing your master recipes</p>
                </div>

                <?php if ($error): ?>
                    <div class="alert alert-danger rounded-4 py-2 px-3 small border-0 mb-3"><i class="fa-solid fa-triangle-exclamation me-1"></i> <?= e($error) ?></div>
                <?php endif; ?>

                <form action="" method="POST">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label font-heading small fw-semibold">Full Name</label>
                        <input type="text" name="name" class="form-control glass-card" placeholder="Sarthak Anbhule" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label font-heading small fw-semibold">Username</label>
                        <div class="input-group">
                            <span class="input-group-text bg-transparent text-muted">@</span>
                            <input type="text" name="username" class="form-control glass-card" placeholder="foodie_sarthak" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label font-heading small fw-semibold">Email Address</label>
                        <input type="email" name="email" class="form-control glass-card" placeholder="sarthak@ciy.com" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label font-heading small fw-semibold">Password</label>
                        <input type="password" name="password" class="form-control glass-card" placeholder="At least 6 characters" minlength="6" required>
                    </div>

                    <button type="submit" class="btn-ciy-primary w-100 py-3 mt-3">Create Free Account</button>
                </form>

                <div class="text-center mt-4 pt-3 border-top border-subtle small text-muted">
                    Already registered? <a href="<?= BASE_URL ?>/auth/login.php" class="fw-bold text-primary text-decoration-none">Sign In</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
