<?php
/**
 * CIY - Cook It Yourself
 * Upload & Create Recipe Studio
 */

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/helpers.php';
require_once __DIR__ . '/../classes/Auth.php';
require_once __DIR__ . '/../classes/Recipe.php';
require_once __DIR__ . '/../classes/Category.php';

if (!Auth::check()) {
    redirect('auth/login.php');
}

$categoryEngine = new Category();
$categories = $categoryEngine->getAll();

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf($_POST['csrf_token'] ?? '')) {
        $error = 'Security token invalid.';
    } else {
        $recipeEngine = new Recipe();
        $res = $recipeEngine->create($_POST, $_FILES, Auth::id());

        if ($res['success']) {
            redirect('pages/detail.php?id=' . $res['recipe_id']);
        } else {
            $error = $res['message'];
        }
    }
}

$pageTitle = 'Publish New Recipe - CIY Studio';
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/navbar.php';
?>

<div class="container py-5 my-4">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="glass-card p-4 p-md-5" data-aos="fade-up">
                <div class="mb-4">
                    <h2 class="font-heading fw-bold mb-1"><i class="fa-solid fa-cloud-arrow-up text-primary me-2"></i> Create Recipe Studio</h2>
                    <p class="text-muted">Share your masterpiece with thousands of food lovers around the world.</p>
                </div>

                <?php if ($error): ?>
                    <div class="alert alert-danger rounded-4 py-2 px-3 small border-0 mb-4"><?= e($error) ?></div>
                <?php endif; ?>

                <form action="" method="POST" enctype="multipart/form-data">
                    <?= csrf_field() ?>

                    <!-- Cover Image Upload Box -->
                    <div class="mb-4">
                        <label class="form-label font-heading fw-bold">Recipe Cover Photo</label>
                        <div class="border-2 border-dashed rounded-4 p-4 text-center glass-card position-relative">
                            <input type="file" name="cover_image" id="coverImageInput" class="position-absolute top-0 start-0 w-100 h-100 opacity-0 cursor-pointer" accept="image/*" required>
                            <img id="coverImagePreview" src="" alt="Preview" class="img-fluid rounded-4 mb-3 mx-auto" style="display:none; max-height: 240px;">
                            <div class="py-3">
                                <i class="fa-solid fa-image text-primary display-4 mb-2 d-block"></i>
                                <span class="fw-bold d-block mb-1">Drag & Drop Cover Image Here</span>
                                <small class="text-muted">Supports High Res JPG, PNG or WEBP (Max 5MB)</small>
                            </div>
                        </div>
                    </div>

                    <!-- General Details -->
                    <div class="row g-3 mb-4">
                        <div class="col-12">
                            <label class="form-label font-heading fw-bold">Recipe Title</label>
                            <input type="text" name="title" class="form-control glass-card" placeholder="e.g. Creamy Tuscan Garlic Chicken Pasta" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label font-heading fw-bold">Category</label>
                            <select name="category_id" class="form-select glass-card" required>
                                <option value="">Select Category</option>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?= $cat['id'] ?>"><?= e($cat['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label font-heading fw-bold">Cuisine</label>
                            <input type="text" name="cuisine" class="form-control glass-card" placeholder="Italian / Indian / Mexican">
                        </div>
                        <div class="col-12">
                            <label class="form-label font-heading fw-bold">Short Description</label>
                            <textarea name="description" class="form-control glass-card" rows="3" placeholder="Brief story or flavor profile of the recipe..." required></textarea>
                        </div>
                    </div>

                    <!-- Specs Row -->
                    <div class="row g-3 mb-4">
                        <div class="col-4 col-md">
                            <label class="form-label font-heading small fw-bold">Prep Time (Mins)</label>
                            <input type="number" name="prep_time" class="form-control glass-card" value="15" required>
                        </div>
                        <div class="col-4 col-md">
                            <label class="form-label font-heading small fw-bold">Cook Time (Mins)</label>
                            <input type="number" name="cook_time" class="form-control glass-card" value="30" required>
                        </div>
                        <div class="col-4 col-md">
                            <label class="form-label font-heading small fw-bold">Servings</label>
                            <input type="number" name="servings" class="form-control glass-card" value="4" required>
                        </div>
                        <div class="col-6 col-md">
                            <label class="form-label font-heading small fw-bold">Difficulty</label>
                            <select name="difficulty" class="form-select glass-card">
                                <option value="Easy">Easy</option>
                                <option value="Medium" selected>Medium</option>
                                <option value="Hard">Hard</option>
                                <option value="Expert">Expert</option>
                            </select>
                        </div>
                    </div>

                    <!-- Dynamic Ingredients Builder -->
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="font-heading fw-bold mb-0"><i class="fa-solid fa-basket-shopping text-primary me-2"></i> Ingredients</h5>
                            <button type="button" id="btnAddIngredient" class="btn btn-sm btn-ciy-outline"><i class="fa-solid fa-plus me-1"></i> Add Ingredient</button>
                        </div>
                        <div id="ingredientsContainer">
                            <div class="ingredient-row d-flex gap-2 align-items-center mb-2">
                                <input type="text" name="ingredients[0][amount]" class="form-control glass-card" placeholder="200" style="max-width: 100px;">
                                <input type="text" name="ingredients[0][unit]" class="form-control glass-card" placeholder="g / tbsp / cup" style="max-width: 130px;">
                                <input type="text" name="ingredients[0][name]" class="form-control glass-card" placeholder="Ingredient name (e.g. Fettuccine Pasta)" required>
                                <button type="button" class="btn btn-outline-danger btn-sm rounded-circle remove-row-btn" style="width:36px; height:36px;"><i class="fa-solid fa-trash"></i></button>
                            </div>
                        </div>
                    </div>

                    <!-- Dynamic Steps Builder -->
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="font-heading fw-bold mb-0"><i class="fa-solid fa-list-check text-success me-2"></i> Cooking Steps</h5>
                            <button type="button" id="btnAddStep" class="btn btn-sm btn-ciy-outline"><i class="fa-solid fa-plus me-1"></i> Add Step</button>
                        </div>
                        <div id="stepsContainer">
                            <div class="step-card glass-card p-3 mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h6 class="fw-bold mb-0 text-primary"><i class="fa-solid fa-list-ol me-2"></i>Step 1</h6>
                                </div>
                                <div class="row g-2">
                                    <div class="col-md-8">
                                        <input type="text" name="steps[0][title]" class="form-control glass-card mb-2" placeholder="Step Title (e.g. Boiling Pasta)">
                                    </div>
                                    <div class="col-md-4">
                                        <input type="number" name="steps[0][time_minutes]" class="form-control glass-card mb-2" placeholder="Timer (Mins)" value="8">
                                    </div>
                                    <div class="col-12">
                                        <textarea name="steps[0][instruction]" class="form-control glass-card" rows="2" placeholder="Detailed instruction..." required></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn-ciy-primary w-100 py-3 mt-3">Publish Recipe Now</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="<?= BASE_URL ?>/assets/js/recipe_builder.js"></script>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
