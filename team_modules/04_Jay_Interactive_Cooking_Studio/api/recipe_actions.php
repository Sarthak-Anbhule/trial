<?php
/**
 * CIY - Cook It Yourself
 * Like & Bookmark AJAX API Controller
 */

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/helpers.php';
require_once __DIR__ . '/../classes/Auth.php';
require_once __DIR__ . '/../classes/Interaction.php';

header('Content-Type: application/json; charset=utf-8');

if (!Auth::check()) {
    json_response(false, 'Please log in to interact with recipes.', [], 401);
}

$userId = Auth::id();
$action = $_POST['action'] ?? '';
$recipeId = (int)($_POST['recipe_id'] ?? 0);

if ($recipeId <= 0) {
    json_response(false, 'Invalid recipe identifier.', [], 400);
}

$interaction = new Interaction();

if ($action === 'like') {
    $res = $interaction->toggleLike($userId, $recipeId);
    json_response($res['success'], $res['message'], $res);
} elseif ($action === 'bookmark') {
    $res = $interaction->toggleBookmark($userId, $recipeId);
    json_response($res['success'], $res['message'], $res);
} else {
    json_response(false, 'Invalid action specified.', [], 400);
}
