<?php
/**
 * CIY - Cook It Yourself
 * Application Core Configuration
 */

// Start session if not started
if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.cookie_httponly', 1);
    ini_set('session.use_only_cookies', 1);
    session_start();
}

require_once __DIR__ . '/i18n.php';

// Timezone & Environment
date_default_timezone_set('Asia/Kolkata');
error_reporting(E_ALL);
ini_set('display_errors', 1);

// App Name & Branding
define('APP_NAME', 'CIY - Cook It Yourself');
define('APP_TAGLINE', 'Discover. Cook. Share. Your Culinary Journey Starts Here.');
define('APP_VERSION', '1.0.0');

// Database Credentials (Default for XAMPP)
define('DB_HOST', '127.0.0.1');
define('DB_PORT', '3306');
define('DB_NAME', 'ciy_db');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

// System Root Path
define('ROOT_PATH', dirname(__DIR__) . '/');

// Bulletproof Base URL detection regardless of script depth or server setup
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || ($_SERVER['SERVER_PORT'] ?? 80) == 443) ? "https://" : "http://";
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';

$docRoot = str_replace('\\', '/', realpath($_SERVER['DOCUMENT_ROOT'] ?? ROOT_PATH) ?: '');
$appRoot = str_replace('\\', '/', realpath(ROOT_PATH) ?: '');

$subDir = '';
if (!empty($docRoot) && !empty($appRoot) && str_starts_with($appRoot, $docRoot)) {
    $subDir = substr($appRoot, strlen($docRoot));
}
$subDir = '/' . trim(str_replace('\\', '/', $subDir), '/');
$subDir = rtrim($subDir, '/');

define('BASE_URL', $protocol . $host . $subDir);

// Upload Paths & URLs
define('UPLOAD_PATH', ROOT_PATH . 'uploads/');
define('RECIPE_UPLOAD_PATH', UPLOAD_PATH . 'recipes/');
define('PROFILE_UPLOAD_PATH', UPLOAD_PATH . 'profiles/');

define('RECIPE_UPLOAD_URL', BASE_URL . '/uploads/recipes/');
define('PROFILE_UPLOAD_URL', BASE_URL . '/uploads/profiles/');

// Helper for default images
define('DEFAULT_AVATAR', BASE_URL . '/assets/images/default_avatar.svg');
define('DEFAULT_COVER', BASE_URL . '/uploads/profiles/default_cover.jpg');
define('DEFAULT_RECIPE_COVER', BASE_URL . '/uploads/recipes/default_recipe.jpg');
