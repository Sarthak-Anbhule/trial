<?php
/**
 * CIY - Cook It Yourself
 * OTP Email Verification Screen
 */

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/helpers.php';
require_once __DIR__ . '/../classes/Auth.php';

$email = $_GET['email'] ?? '';
$msg = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $code = trim($_POST['otp_code'] ?? '');
    $emailInput = trim($_POST['email'] ?? '');

    $auth = new Auth();
    if ($auth->verifyOTP($emailInput, $code)) {
        $msg = 'OTP Verified successfully!';
        // Proceed to password reset or login
    } else {
        $error = 'Invalid or expired OTP code.';
    }
}

$pageTitle = 'OTP Verification - CIY';
require_once __DIR__ . '/../includes/header.php';
?>

<div class="container py-5 my-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="glass-card p-4 p-md-5 text-center" data-aos="fade-up">
                <i class="fa-solid fa-shield-halved text-primary display-4 mb-3"></i>
                <h4 class="font-heading fw-bold">Verification Code</h4>
                <p class="text-muted small">Enter the 6-digit OTP code sent to <strong><?= e($email ?: 'your email') ?></strong></p>

                <?php if ($error): ?>
                    <div class="alert alert-danger rounded-4 py-2 px-3 small border-0 mb-3"><?= e($error) ?></div>
                <?php endif; ?>

                <?php if ($msg): ?>
                    <div class="alert alert-success rounded-4 py-2 px-3 small border-0 mb-3"><?= e($msg) ?></div>
                <?php endif; ?>

                <form action="" method="POST">
                    <?= csrf_field() ?>
                    <input type="hidden" name="email" value="<?= e($email) ?>">
                    <div class="mb-4">
                        <input type="text" name="otp_code" class="form-control glass-card text-center fs-3 fw-bold letter-spacing-2" placeholder="0 0 0 0 0 0" maxlength="6" required>
                    </div>

                    <button type="submit" class="btn-ciy-primary w-100 py-3">Verify OTP Code</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
