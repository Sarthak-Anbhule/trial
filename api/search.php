<?php
/**
 * CIY - Cook It Yourself
 * Live AJAX Search API Endpoint
 */

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/helpers.php';
require_once __DIR__ . '/../classes/Recipe.php';

header('Content-Type: application/json; charset=utf-8');

$query = trim($_GET['q'] ?? '');
if (strlen($query) < 2) {
    json_response(true, 'Query too short', ['items' => []]);
}

$recipeEngine = new Recipe();
$results = $recipeEngine->getRecipes(['search' => $query], 1, 6, Auth::id());

json_response(true, 'Search results fetched', [
    'query' => $query,
    'items' => array_map(function($r) {
        return [
            'id' => $r['id'],
            'title' => $r['title'],
            'slug' => $r['slug'],
            'category' => $r['category_name'],
            'cover_image' => !empty($r['cover_image']) ? RECIPE_UPLOAD_URL . $r['cover_image'] : DEFAULT_RECIPE_COVER,
            'time' => ($r['prep_time'] + $r['cook_time']) . ' min',
            'url' => BASE_URL . '/pages/detail.php?id=' . $r['id']
        ];
    }, $results['items'])
]);
