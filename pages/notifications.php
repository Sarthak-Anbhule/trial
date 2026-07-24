<?php
/**
 * CIY - Cook It Yourself
 * User Notifications Feed
 */

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/helpers.php';
require_once __DIR__ . '/../classes/Auth.php';
require_once __DIR__ . '/../classes/Notification.php';

if (!Auth::check()) {
    redirect('auth/login.php');
}

$notifier = new Notification();
$notifications = $notifier->getUserNotifications(Auth::id(), 30);
$notifier->markAllAsRead(Auth::id());

$pageTitle = 'Notifications - CIY';
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/navbar.php';
?>

<div class="container py-5 my-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="glass-card p-4 p-md-5" data-aos="fade-up">
                <h3 class="font-heading fw-bold mb-4"><i class="fa-solid fa-bell text-primary me-2"></i> <?= t('notifications') ?></h3>

                <?php if (!empty($notifications)): ?>
                    <div class="d-flex flex-column gap-3">
                        <?php foreach ($notifications as $n): ?>
                            <div class="d-flex align-items-center gap-3 p-3 border rounded-4 glass-card">
                                <img src="<?= !empty($n['actor_avatar']) && $n['actor_avatar'] !== 'default_avatar.jpg' ? PROFILE_UPLOAD_URL . e($n['actor_avatar']) : DEFAULT_AVATAR ?>" class="rounded-circle" style="width:42px; height:42px; object-fit:cover;">
                                <div class="flex-grow-1">
                                    <div class="small">
                                        <strong><?= t_content(e($n['actor_name'])) ?></strong> <?= t_content(e($n['message'])) ?>
                                    </div>
                                    <small class="text-muted"><?= time_ago($n['created_at']) ?></small>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="text-center py-4 text-muted">
                        <i class="fa-regular fa-bell-slash display-4 mb-2 d-block"></i>
                        <?= t('no_notifications') ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
