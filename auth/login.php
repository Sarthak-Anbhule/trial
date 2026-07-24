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

$pageTitle = t('login') . ' - CIY';
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
                    <h4 class="font-heading fw-bold"><?= t('welcome_back') ?></h4>
                    <p class="text-muted small"><?= t('login_subtitle') ?></p>
                </div>

                <?php if ($error): ?>
                    <div class="alert alert-danger rounded-4 py-2 px-3 small border-0 mb-3"><i class="fa-solid fa-triangle-exclamation me-1"></i> <?= e($error) ?></div>
                <?php endif; ?>

                <form action="" method="POST">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label font-heading small fw-semibold"><?= t('email_or_username') ?></label>
                        <div class="input-group">
                            <span class="input-group-text bg-transparent border-end-0 text-muted"><i class="fa-solid fa-user"></i></span>
                            <input type="text" id="loginInput" name="login_input" class="form-control glass-card border-start-0" placeholder="<?= t('email_placeholder') ?>" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <label class="form-label font-heading small fw-semibold"><?= t('password') ?></label>
                            <a href="<?= BASE_URL ?>/auth/forgot_password.php" class="small text-primary text-decoration-none"><?= t('forgot_password') ?></a>
                        </div>
                        <div class="input-group">
                            <span class="input-group-text bg-transparent border-end-0 text-muted"><i class="fa-solid fa-lock"></i></span>
                            <input type="password" id="passwordInput" name="password" class="form-control glass-card border-start-0 border-end-0" placeholder="<?= t('password_placeholder') ?>" required>
                            <button class="btn btn-outline-secondary border-start-0 text-muted" type="button" id="togglePassword">
                                <i class="fa-regular fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="btn-ciy-primary w-100 py-3 mt-3"><?= t('sign_in_btn') ?></button>
                </form>

                <!-- Demo Credentials Quick Selector -->
                <div class="mt-4 p-3 glass-card rounded-4 border border-subtle small">
                    <div class="fw-bold text-muted mb-2 text-center" style="font-size: 0.82rem;">
                        <i class="fa-solid fa-key text-warning me-1"></i> <?= t('demo_credentials') ?>
                    </div>
                    <div class="d-flex flex-column gap-2">
                        <button type="button" class="btn btn-sm btn-outline-secondary border-subtle text-start d-flex justify-content-between align-items-center py-2 px-3 rounded-3 demo-autofill-btn" data-email="sarthak@ciy.com" data-pass="password123">
                            <span><i class="fa-solid fa-user-chef me-2 text-primary"></i> <strong><?= t('user_account') ?>:</strong> sarthak@ciy.com</span>
                            <span class="badge bg-primary-subtle text-primary">pass: password123</span>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-secondary border-subtle text-start d-flex justify-content-between align-items-center py-2 px-3 rounded-3 demo-autofill-btn" data-email="admin@ciy.com" data-pass="password123">
                            <span><i class="fa-solid fa-user-shield me-2 text-danger"></i> <strong><?= t('admin_account') ?>:</strong> admin@ciy.com</span>
                            <span class="badge bg-danger-subtle text-danger">pass: password123</span>
                        </button>
                    </div>
                </div>

                <div class="text-center mt-4 pt-3 border-top border-subtle small text-muted">
                    <?= t('dont_have_account') ?> <a href="<?= BASE_URL ?>/auth/register.php" class="fw-bold text-primary text-decoration-none"><?= t('sign_up_free') ?></a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // Password visibility toggle
    const toggleBtn = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('passwordInput');
    if (toggleBtn && passwordInput) {
        toggleBtn.addEventListener('click', () => {
            const isPassword = passwordInput.type === 'password';
            passwordInput.type = isPassword ? 'text' : 'password';
            toggleBtn.querySelector('i').className = isPassword ? 'fa-regular fa-eye-slash' : 'fa-regular fa-eye';
        });
    }

    // Demo Autofill helper
    document.querySelectorAll('.demo-autofill-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            document.getElementById('loginInput').value = btn.dataset.email;
            document.getElementById('passwordInput').value = btn.dataset.pass;
        });
    });
});
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
