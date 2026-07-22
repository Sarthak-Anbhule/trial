<?php
/**
 * CIY - Cook It Yourself
 * Comments AJAX API Controller
 */

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/helpers.php';
require_once __DIR__ . '/../classes/Auth.php';
require_once __DIR__ . '/../classes/Interaction.php';

header('Content-Type: application/json; charset=utf-8');

if (!Auth::check()) {
    json_response(false, 'Please log in to leave a comment.', [], 401);
}

$recipeId = (int)($_POST['recipe_id'] ?? 0);
$commentText = trim($_POST['comment'] ?? '');
$rating = (int)($_POST['rating'] ?? 5);

if ($recipeId <= 0 || empty($commentText)) {
    json_response(false, 'Recipe ID and comment text are required.', [], 400);
}

$interaction = new Interaction();
$res = $interaction->addComment(Auth::id(), $recipeId, $commentText, $rating);

json_response($res['success'], $res['message'], $res);
