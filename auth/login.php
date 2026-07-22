<?php
/**
 * CIY - Cook It Yourself
 * Glassmorphic Login Page
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
        $error = 'Security validation failed. Please try again.';
    } else {
        $loginInput = $_POST['login_input'] ?? '';
        $password = $_POST['password'] ?? '';

        $auth = new Auth();
        $res = $auth->login($loginInput, $password);

        if ($res['success']) {
            redirect('index.php');
        } else {
            $error = $res['message'];
        }
    }
}

$pageTitle = 'Login - CIY';
require_once __DIR__ . '/../includes/header.php';
?>

<div class="container py-5 my-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="glass-card p-4 p-md-5" data-aos="fade-up">
                <div class="text-center mb-4">
                    <a href="<?= BASE_URL ?>/index.php" class="navbar-brand-logo justify-content-center mb-2 fs-2">
                        <i class="fa-solid fa-utensils"></i> <span>CIY</span>
                    </a>
                    <h4 class="font-heading fw-bold">Welcome Back</h4>
                    <p class="text-muted small">Enter your credentials to access your recipes</p>
                </div>

                <?php if ($error): ?>
                    <div class="alert alert-danger rounded-4 py-2 px-3 small border-0 mb-3"><i class="fa-solid fa-triangle-exclamation me-1"></i> <?= e($error) ?></div>
                <?php endif; ?>

                <form action="" method="POST">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label font-heading small fw-semibold">Email or Username</label>
                        <div class="input-group">
                            <span class="input-group-text bg-transparent border-end-0 text-muted"><i class="fa-solid fa-user"></i></span>
                            <input type="text" name="login_input" class="form-control glass-card border-start-0" placeholder="sarthak@ciy.com" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <label class="form-label font-heading small fw-semibold">Password</label>
                            <a href="<?= BASE_URL ?>/auth/forgot_password.php" class="small text-primary text-decoration-none">Forgot?</a>
                        </div>
                        <div class="input-group">
                            <span class="input-group-text bg-transparent border-end-0 text-muted"><i class="fa-solid fa-lock"></i></span>
                            <input type="password" name="password" class="form-control glass-card border-start-0" placeholder="••••••••" required>
                        </div>
                    </div>

                    <button type="submit" class="btn-ciy-primary w-100 py-3 mt-3">Sign In</button>
                </form>

                <div class="text-center mt-4 pt-3 border-top border-subtle small text-muted">
                    Don't have an account? <a href="<?= BASE_URL ?>/auth/register.php" class="fw-bold text-primary text-decoration-none">Sign Up Free</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
