<?php
/**
 * CIY - Cook It Yourself
 * Edit User Profile & Avatar Settings
 */

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/helpers.php';
require_once __DIR__ . '/../classes/Auth.php';
require_once __DIR__ . '/../classes/User.php';

if (!Auth::check()) {
    redirect('auth/login.php');
}

$userEngine = new User();
$user = $userEngine->get(Auth::id());

$msg = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf($_POST['csrf_token'] ?? '')) {
        $error = 'Invalid security token.';
    } else {
        $res = $userEngine->updateProfile(Auth::id(), $_POST, $_FILES);
        if ($res['success']) {
            $msg = $res['message'];
            $user = $userEngine->get(Auth::id()); // Reload
        } else {
            $error = $res['message'];
        }
    }
}

$pageTitle = 'Edit Profile - CIY';
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/navbar.php';
?>

<div class="container py-5 my-4">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="glass-card p-4 p-md-5" data-aos="fade-up">
                <h3 class="font-heading fw-bold mb-4"><i class="fa-solid fa-user-pen text-primary me-2"></i> Edit Profile</h3>

                <?php if ($msg): ?>
                    <div class="alert alert-success rounded-4 py-2 px-3 small border-0 mb-3"><?= e($msg) ?></div>
                <?php endif; ?>

                <?php if ($error): ?>
                    <div class="alert alert-danger rounded-4 py-2 px-3 small border-0 mb-3"><?= e($error) ?></div>
                <?php endif; ?>

                <form action="" method="POST" enctype="multipart/form-data">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label class="form-label font-heading small fw-semibold">Display Name</label>
                        <input type="text" name="name" class="form-control glass-card" value="<?= e($user['name']) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label font-heading small fw-semibold">Bio / Culinary Intro</label>
                        <textarea name="bio" class="form-control glass-card" rows="3"><?= e($user['bio']) ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label font-heading small fw-semibold">Profile Avatar (JPG/PNG)</label>
                        <input type="file" name="avatar" class="form-control glass-card" accept="image/*">
                    </div>

                    <div class="mb-4">
                        <label class="form-label font-heading small fw-semibold">Cover Header Photo</label>
                        <input type="file" name="cover" class="form-control glass-card" accept="image/*">
                    </div>

                    <button type="submit" class="btn-ciy-primary py-3 w-100">Save Profile Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
