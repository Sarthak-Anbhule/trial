<?php
/**
 * CIY - Cook It Yourself
 * Admin User Moderation Panel
 */

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/helpers.php';
require_once __DIR__ . '/../classes/Auth.php';
require_once __DIR__ . '/../classes/Admin.php';

if (!Auth::isAdmin()) {
    redirect('index.php');
}

$adminEngine = new Admin();

if (isset($_GET['status_id']) && isset($_GET['set_status'])) {
    $adminEngine->updateUserStatus((int)$_GET['status_id'], $_GET['set_status']);
    redirect('admin/users.php');
}

$users = $adminEngine->getUsers(1, 20);

$pageTitle = 'Manage Users - CIY Admin';
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/navbar.php';
?>

<div class="container py-5 my-4">
    <div class="glass-card p-4 p-md-5" data-aos="fade-up">
        <h3 class="font-heading fw-bold mb-4"><i class="fa-solid fa-users text-primary me-2"></i> User Moderation</h3>
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Recipes</th>
                        <th>Joined</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $u): ?>
                        <tr>
                            <td>
                                <div class="fw-bold"><?= e($u['name']) ?></div>
                                <small class="text-muted">@<?= e($u['username']) ?> • <?= e($u['email']) ?></small>
                            </td>
                            <td><span class="badge bg-light text-dark border"><?= e($u['role']) ?></span></td>
                            <td>
                                <span class="badge bg-<?= $u['status'] === 'active' ? 'success' : 'danger' ?>"><?= e($u['status']) ?></span>
                            </td>
                            <td><?= $u['recipe_count'] ?></td>
                            <td><?= date('M j, Y', strtotime($u['created_at'])) ?></td>
                            <td>
                                <?php if ($u['role'] !== 'admin'): ?>
                                    <?php if ($u['status'] === 'active'): ?>
                                        <a href="?status_id=<?= $u['id'] ?>&set_status=suspended" class="btn btn-outline-warning btn-sm rounded-pill">Suspend</a>
                                    <?php else: ?>
                                        <a href="?status_id=<?= $u['id'] ?>&set_status=active" class="btn btn-outline-success btn-sm rounded-pill">Activate</a>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
