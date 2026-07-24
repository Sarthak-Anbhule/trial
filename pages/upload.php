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
                    <h2 class="font-heading fw-bold mb-1"><i class="fa-solid fa-cloud-arrow-up text-primary me-2"></i> <?= t('create_new_recipe') ?></h2>
                    <p class="text-muted"><?= t('upload_subtitle') ?></p>
                </div>

                <?php if ($error): ?>
                    <div class="alert alert-danger rounded-4 py-2 px-3 small border-0 mb-4"><?= e($error) ?></div>
                <?php endif; ?>

                <form action="" method="POST" enctype="multipart/form-data">
                    <?= csrf_field() ?>

                    <!-- Cover Image Upload Box -->
                    <div class="mb-4">
                        <label class="form-label font-heading fw-bold"><?= t('cover_image') ?></label>
                        <div class="border-2 border-dashed rounded-4 p-4 text-center glass-card position-relative">
                            <input type="file" name="cover_image" id="coverImageInput" class="position-absolute top-0 start-0 w-100 h-100 opacity-0 cursor-pointer" accept="image/*" required>
                            <img id="coverImagePreview" src="" alt="Preview" class="img-fluid rounded-4 mb-3 mx-auto" style="display:none; max-height: 240px;">
                            <div class="py-3">
                                <i class="fa-solid fa-image text-primary display-4 mb-2 d-block"></i>
                                <span class="fw-bold d-block mb-1"><?= t('cover_image') ?></span>
                                <small class="text-muted">JPG, PNG or WEBP (Max 5MB)</small>
                            </div>
                        </div>
                    </div>

                    <!-- General Details -->
                    <div class="row g-3 mb-4">
                        <div class="col-12">
                            <label class="form-label font-heading fw-bold"><?= t('recipe_title') ?></label>
                            <input type="text" name="title" class="form-control glass-card" placeholder="<?= t('recipe_title_placeholder') ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label font-heading fw-bold"><?= t('categories') ?></label>
                            <select name="category_id" class="form-select glass-card" required>
                                <option value=""><?= t('all_categories') ?></option>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?= $cat['id'] ?>"><?= t(slugify($cat['name']), e($cat['name'])) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label font-heading fw-bold"><?= t('cuisine') ?></label>
                            <input type="text" name="cuisine" class="form-control glass-card" placeholder="<?= t('cuisine_placeholder') ?>">
                        </div>
                        <div class="col-12">
                            <label class="form-label font-heading fw-bold"><?= t('recipe_description') ?></label>
                            <textarea name="description" class="form-control glass-card" rows="3" placeholder="<?= t('recipe_desc_placeholder') ?>" required></textarea>
                        </div>
                    </div>

                    <!-- Specs Row -->
                    <div class="row g-3 mb-4">
                        <div class="col-4 col-md">
                            <label class="form-label font-heading small fw-bold"><?= t('prep_time') ?> (<?= t('mins') ?>)</label>
                            <input type="number" name="prep_time" class="form-control glass-card" value="15" required>
                        </div>
                        <div class="col-4 col-md">
                            <label class="form-label font-heading small fw-bold"><?= t('cook_time') ?> (<?= t('mins') ?>)</label>
                            <input type="number" name="cook_time" class="form-control glass-card" value="30" required>
                        </div>
                        <div class="col-4 col-md">
                            <label class="form-label font-heading small fw-bold"><?= t('servings') ?></label>
                            <input type="number" name="servings" class="form-control glass-card" value="4" required>
                        </div>
                        <div class="col-6 col-md">
                            <label class="form-label font-heading small fw-bold"><?= t('difficulty') ?></label>
                            <select name="difficulty" class="form-select glass-card">
                                <option value="Easy"><?= t('easy') ?></option>
                                <option value="Medium" selected><?= t('medium') ?></option>
                                <option value="Hard"><?= t('hard') ?></option>
                            </select>
                        </div>
                    </div>

                    <!-- Dynamic Ingredients Builder -->
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="font-heading fw-bold mb-0"><i class="fa-solid fa-basket-shopping text-primary me-2"></i> <?= t('ingredients') ?></h5>
                            <button type="button" id="btnAddIngredient" class="btn btn-sm btn-ciy-outline"><i class="fa-solid fa-plus me-1"></i> <?= t('add_ingredient') ?></button>
                        </div>
                        <div id="ingredientsContainer">
                            <div class="ingredient-row d-flex gap-2 align-items-center mb-2">
                                <input type="text" name="ingredients[0][amount]" class="form-control glass-card" placeholder="200" style="max-width: 100px;">
                                <input type="text" name="ingredients[0][unit]" class="form-control glass-card" placeholder="g / tbsp / cup" style="max-width: 130px;">
                                <input type="text" name="ingredients[0][name]" class="form-control glass-card" placeholder="<?= t('ingredient_name') ?>" required>
                                <button type="button" class="btn btn-outline-danger btn-sm rounded-circle remove-row-btn" style="width:36px; height:36px;"><i class="fa-solid fa-trash"></i></button>
                            </div>
                        </div>
                    </div>

                    <!-- Dynamic Steps Builder -->
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="font-heading fw-bold mb-0"><i class="fa-solid fa-list-check text-success me-2"></i> <?= t('instructions') ?></h5>
                            <button type="button" id="btnAddStep" class="btn btn-sm btn-ciy-outline"><i class="fa-solid fa-plus me-1"></i> <?= t('add_step') ?></button>
                        </div>
                        <div id="stepsContainer">
                            <div class="step-card glass-card p-3 mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h6 class="fw-bold mb-0 text-primary"><i class="fa-solid fa-list-ol me-2"></i><?= t('step_of') ?> 1</h6>
                                </div>
                                <div class="row g-2">
                                    <div class="col-md-8">
                                        <input type="text" name="steps[0][title]" class="form-control glass-card mb-2" placeholder="<?= t('step_title') ?>">
                                    </div>
                                    <div class="col-md-4">
                                        <input type="number" name="steps[0][time_minutes]" class="form-control glass-card mb-2" placeholder="<?= t('step_time') ?>" value="8">
                                    </div>
                                    <div class="col-12">
                                        <textarea name="steps[0][instruction]" class="form-control glass-card" rows="2" placeholder="<?= t('step_instruction') ?>" required></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn-ciy-primary w-100 py-3 mt-3"><?= t('publish_recipe_btn') ?></button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="<?= BASE_URL ?>/assets/js/recipe_builder.js"></script>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
