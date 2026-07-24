<?php
/**
 * CIY - Cook It Yourself
 * Admin Analytics & Management Dashboard
 */

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/helpers.php';
require_once __DIR__ . '/../classes/Auth.php';
require_once __DIR__ . '/../classes/Admin.php';

if (!Auth::isAdmin()) {
    redirect('index.php');
}

$adminEngine = new Admin();
$stats = $adminEngine->getDashboardStats();
$monthlyData = $adminEngine->getMonthlyUploadStats();

$pageTitle = t('admin_panel') . ' - CIY Dashboard';
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/navbar.php';
?>

<div class="container py-5 my-4">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="font-heading fw-bold mb-1"><i class="fa-solid fa-shield-halved text-danger me-2"></i> <?= t('admin_panel') ?></h2>
            <p class="text-muted small">Platform analytics & moderation management</p>
        </div>
        <div class="d-flex gap-2">
            <a href="<?= BASE_URL ?>/admin/users.php" class="btn-ciy-outline btn-sm"><i class="fa-solid fa-users me-1"></i> <?= t('followers') ?></a>
            <a href="<?= BASE_URL ?>/admin/recipes.php" class="btn-ciy-outline btn-sm"><i class="fa-solid fa-utensils me-1"></i> <?= t('explore') ?></a>
        </div>
    </div>

    <!-- Stat Cards Row -->
    <div class="row g-4 mb-5">
        <div class="col-6 col-md-3">
            <div class="glass-card p-4 text-center">
                <i class="fa-solid fa-users text-primary fs-2 mb-2"></i>
                <h3 class="font-heading fw-bold mb-0"><?= $stats['users'] ?></h3>
                <small class="text-muted"><?= t('followers') ?></small>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="glass-card p-4 text-center">
                <i class="fa-solid fa-utensils text-success fs-2 mb-2"></i>
                <h3 class="font-heading fw-bold mb-0"><?= $stats['recipes'] ?></h3>
                <small class="text-muted"><?= t('explore') ?></small>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="glass-card p-4 text-center">
                <i class="fa-solid fa-heart text-danger fs-2 mb-2"></i>
                <h3 class="font-heading fw-bold mb-0"><?= $stats['likes'] ?></h3>
                <small class="text-muted">Likes</small>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="glass-card p-4 text-center">
                <i class="fa-solid fa-flag text-warning fs-2 mb-2"></i>
                <h3 class="font-heading fw-bold mb-0"><?= $stats['pending_reports'] ?></h3>
                <small class="text-muted">Reports</small>
            </div>
        </div>
    </div>

    <!-- Chart Analytics Section -->
    <div class="glass-card p-4 p-md-5 mb-4">
        <h4 class="font-heading fw-bold mb-3"><i class="fa-solid fa-chart-line text-primary me-2"></i> Recipe Publishing Trends</h4>
        <div style="height: 320px;">
            <canvas id="monthlyChart"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('monthlyChart').getContext('2d');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?= json_encode(array_column($monthlyData, 'month_label')) ?>,
        datasets: [{
            label: 'Recipes Uploaded',
            data: <?= json_encode(array_column($monthlyData, 'total')) ?>,
            borderColor: '#FF6B35',
            backgroundColor: 'rgba(255, 107, 53, 0.1)',
            fill: true,
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false
    }
});
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
