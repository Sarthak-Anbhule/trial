/**
 * CIY - Cook It Yourself
 * Recipe Creation & Editing Studio Dynamic Row Builder
 */

document.addEventListener('DOMContentLoaded', () => {
    // Dynamic Ingredients Builder
    const addIngBtn = document.getElementById('btnAddIngredient');
    const ingContainer = document.getElementById('ingredientsContainer');

    if (addIngBtn && ingContainer) {
        addIngBtn.addEventListener('click', () => {
            const index = ingContainer.children.length;
            const row = document.createElement('div');
            row.className = 'ingredient-row d-flex gap-2 align-items-center mb-2 animate__animated animate__fadeIn';
            row.innerHTML = `
                <input type="text" name="ingredients[${index}][amount]" class="form-control glass-input" placeholder="200" style="max-width: 100px;">
                <input type="text" name="ingredients[${index}][unit]" class="form-control glass-input" placeholder="g / tbsp / cup" style="max-width: 130px;">
                <input type="text" name="ingredients[${index}][name]" class="form-control glass-input" placeholder="Ingredient name (e.g. Olive Oil)" required>
                <button type="button" class="btn btn-outline-danger btn-sm rounded-circle remove-row-btn" style="width:36px; height:36px;"><i class="fa-solid fa-trash"></i></button>
            `;
            ingContainer.appendChild(row);
        });
    }

    // Dynamic Steps Builder
    const addStepBtn = document.getElementById('btnAddStep');
    const stepContainer = document.getElementById('stepsContainer');

    if (addStepBtn && stepContainer) {
        addStepBtn.addEventListener('click', () => {
            const index = stepContainer.children.length;
            const card = document.createElement('div');
            card.className = 'step-card glass-card p-3 mb-3 animate__animated animate__fadeIn';
            card.innerHTML = `
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="fw-bold mb-0 text-primary"><i class="fa-solid fa-list-ol me-2"></i>Step ${index + 1}</h6>
                    <button type="button" class="btn btn-outline-danger btn-sm rounded-circle remove-row-btn" style="width:32px; height:32px;"><i class="fa-solid fa-trash"></i></button>
                </div>
                <div class="row g-2">
                    <div class="col-md-8">
                        <input type="text" name="steps[${index}][title]" class="form-control glass-input mb-2" placeholder="Step Title (e.g. Searing the Meat)">
                    </div>
                    <div class="col-md-4">
                        <input type="number" name="steps[${index}][time_minutes]" class="form-control glass-input mb-2" placeholder="Timer (Mins)" value="5">
                    </div>
                    <div class="col-12">
                        <textarea name="steps[${index}][instruction]" class="form-control glass-input" rows="2" placeholder="Detailed instruction..." required></textarea>
                    </div>
                </div>
            `;
            stepContainer.appendChild(card);
        });
    }

    // Row Removal Delegation
    document.addEventListener('click', (e) => {
        const removeBtn = e.target.closest('.remove-row-btn');
        if (removeBtn) {
            const parentRow = removeBtn.closest('.ingredient-row, .step-card');
            if (parentRow) parentRow.remove();
        }
    });

    // Image Upload Live Preview
    const coverInput = document.getElementById('coverImageInput');
    const coverPreview = document.getElementById('coverImagePreview');

    if (coverInput && coverPreview) {
        coverInput.addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (event) => {
                    coverPreview.src = event.target.result;
                    coverPreview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        });
    }
});
