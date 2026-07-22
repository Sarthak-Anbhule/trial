/**
 * CIY - Cook It Yourself
 * Master Application JavaScript Framework
 */

document.addEventListener('DOMContentLoaded', () => {
    // 1. Initialize AOS (Animate On Scroll)
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 800,
            easing: 'cubic-bezier(0.16, 1, 0.3, 1)',
            once: true
        });
    }

    // 2. Dark Mode Toggle Engine
    initDarkMode();

    // 3. GSAP Entry Animations
    if (typeof gsap !== 'undefined') {
        gsap.from(".hero-title", { opacity: 0, y: 30, duration: 1, delay: 0.2 });
        gsap.from(".hero-subtitle", { opacity: 0, y: 20, duration: 0.8, delay: 0.4 });
        gsap.from(".hero-cta-group", { opacity: 0, y: 20, duration: 0.8, delay: 0.6 });
    }

    // 4. Global Like & Bookmark AJAX Delegate
    initInteractions();

    // 5. Button Ripple Effects
    initRippleEffect();
});

/**
 * Dark Mode Engine
 */
function initDarkMode() {
    const toggleBtn = document.getElementById('darkModeToggle');
    const currentTheme = localStorage.getItem('ciy_theme') || 'light';

    if (currentTheme === 'dark') {
        document.documentElement.setAttribute('data-theme', 'dark');
        updateThemeIcon('dark');
    }

    if (toggleBtn) {
        toggleBtn.addEventListener('click', () => {
            const activeTheme = document.documentElement.getAttribute('data-theme');
            const newTheme = activeTheme === 'dark' ? 'light' : 'dark';
            document.documentElement.setAttribute('data-theme', newTheme);
            localStorage.setItem('ciy_theme', newTheme);
            updateThemeIcon(newTheme);
            showToast(newTheme === 'dark' ? 'Dark mode enabled 🌙' : 'Light mode enabled ☀️');
        });
    }
}

function updateThemeIcon(theme) {
    const icon = document.querySelector('#darkModeToggle i');
    if (icon) {
        icon.className = theme === 'dark' ? 'fa-solid fa-sun text-warning' : 'fa-solid fa-moon';
    }
}

/**
 * Global Like & Bookmark Async Event Handlers
 */
function initInteractions() {
    document.addEventListener('click', async (e) => {
        // Toggle Bookmark Button
        const bookmarkBtn = e.target.closest('.btn-bookmark-action');
        if (bookmarkBtn) {
            e.preventDefault();
            const recipeId = bookmarkBtn.dataset.recipeId;
            if (!recipeId) return;

            try {
                const res = await fetch(`${window.CIY_BASE_URL || ''}/api/recipe_actions.php`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `action=bookmark&recipe_id=${recipeId}&csrf_token=${window.CIY_CSRF || ''}`
                });
                const data = await res.json();

                if (data.success) {
                    bookmarkBtn.classList.toggle('active', data.data.bookmarked);
                    const icon = bookmarkBtn.querySelector('i');
                    if (icon) {
                        icon.className = data.data.bookmarked ? 'fa-solid fa-bookmark' : 'fa-regular fa-bookmark';
                    }
                    showToast(data.message);
                } else {
                    showToast(data.message || 'Please log in to save recipes.', 'error');
                }
            } catch (err) {
                console.error(err);
                showToast('Failed to connect to server.', 'error');
            }
        }

        // Toggle Like Button
        const likeBtn = e.target.closest('.btn-like-action');
        if (likeBtn) {
            e.preventDefault();
            const recipeId = likeBtn.dataset.recipeId;
            if (!recipeId) return;

            try {
                const res = await fetch(`${window.CIY_BASE_URL || ''}/api/recipe_actions.php`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `action=like&recipe_id=${recipeId}&csrf_token=${window.CIY_CSRF || ''}`
                });
                const data = await res.json();

                if (data.success) {
                    likeBtn.classList.toggle('active', data.data.liked);
                    const icon = likeBtn.querySelector('i');
                    const countSpan = likeBtn.querySelector('.like-count');
                    if (icon) {
                        icon.className = data.data.liked ? 'fa-solid fa-heart text-danger' : 'fa-regular fa-heart';
                    }
                    if (countSpan) countSpan.textContent = data.data.count;
                    showToast(data.message);
                } else {
                    showToast(data.message || 'Please log in to like recipes.', 'error');
                }
            } catch (err) {
                console.error(err);
                showToast('Failed to connect to server.', 'error');
            }
        }
    });
}

/**
 * Global Toast Notification Helper
 */
function showToast(message, type = 'success') {
    const container = document.getElementById('toastContainer') || createToastContainer();
    const toast = document.createElement('div');
    toast.className = `toast-item glass-card p-3 mb-2 text-white style-${type}`;
    toast.style.cssText = `
        background: ${type === 'error' ? 'rgba(249, 65, 68, 0.9)' : 'rgba(17, 24, 39, 0.9)'};
        backdrop-filter: blur(12px);
        border-radius: 14px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        display: flex;
        align-items: center;
        gap: 12px;
        font-weight: 500;
        min-width: 280px;
        transform: translateY(20px);
        opacity: 0;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    `;

    toast.innerHTML = `
        <i class="${type === 'error' ? 'fa-solid fa-circle-exclamation text-danger' : 'fa-solid fa-circle-check text-success'}"></i>
        <span>${message}</span>
    `;

    container.appendChild(toast);

    setTimeout(() => {
        toast.style.transform = 'translateY(0)';
        toast.style.opacity = '1';
    }, 10);

    setTimeout(() => {
        toast.style.transform = 'translateY(-20px)';
        toast.style.opacity = '0';
        setTimeout(() => toast.remove(), 300);
    }, 3500);
}

function createToastContainer() {
    const div = document.createElement('div');
    div.id = 'toastContainer';
    div.style.cssText = 'position: fixed; bottom: 24px; right: 24px; z-index: 9999; display: flex; flex-direction: column-reverse;';
    document.body.appendChild(div);
    return div;
}

/**
 * Button Ripple Micro Interaction
 */
function initRippleEffect() {
    document.addEventListener('click', (e) => {
        const btn = e.target.closest('.btn-ciy-primary, .btn-ciy-outline');
        if (!btn) return;
        const rect = btn.getBoundingClientRect();
        const circle = document.createElement('span');
        const diameter = Math.max(rect.width, rect.height);
        const radius = diameter / 2;

        circle.style.width = circle.style.height = `${diameter}px`;
        circle.style.left = `${e.clientX - rect.left - radius}px`;
        circle.style.top = `${e.clientY - rect.top - radius}px`;
        circle.style.position = 'absolute';
        circle.style.borderRadius = '50%';
        circle.style.background = 'rgba(255, 255, 255, 0.35)';
        circle.style.transform = 'scale(0)';
        circle.style.animation = 'ripple 0.6s linear';
        circle.style.pointerEvents = 'none';

        btn.style.position = 'relative';
        btn.style.overflow = 'hidden';
        btn.appendChild(circle);

        setTimeout(() => circle.remove(), 600);
    });
}
