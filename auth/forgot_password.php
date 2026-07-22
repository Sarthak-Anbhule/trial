<?php
/**
 * CIY - Cook It Yourself
 * Password Reset Request Page
 */

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/helpers.php';
require_once __DIR__ . '/../classes/Auth.php';

$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    if (!empty($email)) {
        $auth = new Auth();
        $code = $auth->generateOTP($email);
        redirect("auth/verify_otp.php?email=" . urlencode($email));
    }
}

$pageTitle = 'Forgot Password - CIY';
require_once __DIR__ . '/../includes/header.php';
?>

<div class="container py-5 my-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="glass-card p-4 p-md-5" data-aos="fade-up">
                <div class="text-center mb-4">
                    <h4 class="font-heading fw-bold">Reset Password</h4>
                    <p class="text-muted small">Enter your email address to receive an OTP verification code</p>
                </div>

                <form action="" method="POST">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label font-heading small fw-semibold">Email Address</label>
                        <input type="email" name="email" class="form-control glass-card" placeholder="sarthak@ciy.com" required>
                    </div>

                    <button type="submit" class="btn-ciy-primary w-100 py-3 mt-2">Send OTP Code</button>
                </form>

                <div class="text-center mt-4 text-muted small">
                    Remembered password? <a href="<?= BASE_URL ?>/auth/login.php" class="fw-bold text-primary">Back to Login</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
