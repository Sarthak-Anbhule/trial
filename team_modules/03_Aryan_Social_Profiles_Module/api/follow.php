<?php
/**
 * CIY - Cook It Yourself
 * Creator Follow / Unfollow AJAX API Controller
 */

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/helpers.php';
require_once __DIR__ . '/../classes/Auth.php';
require_once __DIR__ . '/../classes/User.php';

header('Content-Type: application/json; charset=utf-8');

if (!Auth::check()) {
    json_response(false, 'Please log in to follow creators.', [], 401);
}

$followingId = (int)($_POST['user_id'] ?? 0);
if ($followingId <= 0) {
    json_response(false, 'Invalid user ID.', [], 400);
}

$userEngine = new User();
$res = $userEngine->toggleFollow(Auth::id(), $followingId);

json_response($res['success'], $res['message'], $res);
