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

$pageTitle = t('sign_up') . ' - CIY';
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
                    <h4 class="font-heading fw-bold"><?= t('join_community') ?></h4>
                    <p class="text-muted small"><?= t('register_subtitle') ?></p>
                </div>

                <?php if ($error): ?>
                    <div class="alert alert-danger rounded-4 py-2 px-3 small border-0 mb-3"><i class="fa-solid fa-triangle-exclamation me-1"></i> <?= e($error) ?></div>
                <?php endif; ?>

                <form action="" method="POST">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label font-heading small fw-semibold"><?= t('full_name') ?></label>
                        <input type="text" name="name" class="form-control glass-card" placeholder="<?= t('name_placeholder') ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label font-heading small fw-semibold"><?= t('username') ?></label>
                        <div class="input-group">
                            <span class="input-group-text bg-transparent text-muted">@</span>
                            <input type="text" name="username" class="form-control glass-card" placeholder="<?= t('username_placeholder') ?>" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label font-heading small fw-semibold"><?= t('email_address') ?></label>
                        <input type="email" name="email" class="form-control glass-card" placeholder="<?= t('reg_email_placeholder') ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label font-heading small fw-semibold"><?= t('password') ?></label>
                        <div class="input-group">
                            <input type="password" id="regPassword" name="password" class="form-control glass-card border-end-0" placeholder="<?= t('password_min') ?>" minlength="6" required>
                            <button class="btn btn-outline-secondary border-start-0 text-muted" type="button" id="toggleRegPassword">
                                <i class="fa-regular fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="btn-ciy-primary w-100 py-3 mt-3"><?= t('create_free_account') ?></button>
                </form>

                <div class="text-center mt-4 pt-3 border-top border-subtle small text-muted">
                    <?= t('already_registered') ?> <a href="<?= BASE_URL ?>/auth/login.php" class="fw-bold text-primary text-decoration-none"><?= t('login') ?></a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const toggleBtn = document.getElementById('toggleRegPassword');
    const passwordInput = document.getElementById('regPassword');
    if (toggleBtn && passwordInput) {
        toggleBtn.addEventListener('click', () => {
            const isPassword = passwordInput.type === 'password';
            passwordInput.type = isPassword ? 'text' : 'password';
            toggleBtn.querySelector('i').className = isPassword ? 'fa-regular fa-eye-slash' : 'fa-regular fa-eye';
        });
    }
});
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
