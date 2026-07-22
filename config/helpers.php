<?php
/**
 * CIY - Cook It Yourself
 * Global Helper Functions (Security, Sanitization, Formatting)
 */

require_once __DIR__ . '/config.php';

/**
 * Escape HTML output to prevent XSS vulnerability
 */
function e(?string $string): string {
    return htmlspecialchars($string ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/**
 * Generate CSRF Token for Forms
 */
function csrf_token(): string {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Render Hidden CSRF Input Element
 */
function csrf_field(): string {
    return '<input type="hidden" name="csrf_token" value="' . csrf_token() . '">';
}

/**
 * Verify CSRF Token
 */
function verify_csrf(?string $token): bool {
    if (!isset($_SESSION['csrf_token']) || empty($token)) {
        return false;
    }
    return hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * JSON Response Helper
 */
function json_response(bool $success, string $message = '', array $data = [], int $http_code = 200): void {
    http_response_code($http_code);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode([
        'success' => $success,
        'message' => $message,
        'data' => $data
    ]);
    exit;
}

/**
 * Redirect Helper
 */
function redirect(string $path = ''): void {
    $url = (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) 
        ? $path 
        : BASE_URL . '/' . ltrim($path, '/');
    header("Location: $url");
    exit;
}

/**
 * Relative Time Ago Formatter
 */
function time_ago(string $datetime): string {
    $timestamp = strtotime($datetime);
    if (!$timestamp) return 'Recently';

    $difference = time() - $timestamp;
    
    if ($difference < 60) {
        return 'Just now';
    } elseif ($difference < 3600) {
        $mins = round($difference / 60);
        return $mins . ' min' . ($mins > 1 ? 's' : '') . ' ago';
    } elseif ($difference < 86400) {
        $hours = round($difference / 3600);
        return $hours . ' hr' . ($hours > 1 ? 's' : '') . ' ago';
    } elseif ($difference < 604800) {
        $days = round($difference / 86400);
        return $days . ' day' . ($days > 1 ? 's' : '') . ' ago';
    } elseif ($difference < 2592000) {
        $weeks = round($difference / 604800);
        return $weeks . ' wk' . ($weeks > 1 ? 's' : '') . ' ago';
    } else {
        return date('M j, Y', $timestamp);
    }
}

/**
 * Slugify strings for URLs
 */
function slugify(string $text): string {
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    $text = preg_replace('~[^-\w]+~', '', $text);
    $text = trim($text, '-');
    $text = preg_replace('~-+~', '-', $text);
    $text = strtolower($text);
    return empty($text) ? 'n-a' : $text;
}

/**
 * Format numbers (e.g. 1200 -> 1.2K)
 */
function format_number(int $num): string {
    if ($num >= 1000000) {
        return round($num / 1000000, 1) . 'M';
    } elseif ($num >= 1000) {
        return round($num / 1000, 1) . 'K';
    }
    return (string)$num;
}
