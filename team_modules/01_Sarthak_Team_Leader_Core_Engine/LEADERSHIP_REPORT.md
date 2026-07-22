# 👑 Team Leader Architecture & UI/UX Design Report

**Lead Software Architect & UI Designer**: Sarthak Anbhule  
**Project**: CIY (Cook It Yourself) - Premium Culinary Platform  
**Total Lines of Code Authored**: ~2,800+ lines across Backend Engine, UI Design System, Auth, Database & Admin Panel.

---

## 🛠️ Key Contributions & Authored Systems

### 1. Master UI/UX Design System & Theme Engine
- **Glassmorphism Design Tokens (`assets/css/style.css`)**: Engineered custom CSS variables, translucent frosted blur containers (`backdrop-filter: blur(18px)`), rounded card shadows, glowing accent borders, custom scrollbars, and dark mode palette (`data-theme="dark"`).
- **Core Layout Architecture (`includes/`)**: Authored floating frosted navbar with responsive offcanvas hamburger menu (`navbar.php`), HTML head font loaders (`header.php`), and glass footer (`footer.php`).
- **Interactive UI Engine (`assets/js/app.js`)**: Designed GSAP entry animations, button ripple micro-interactions, dark mode switcher, and global toast notifications.
- **Home Landing Page (`pages/home.php`)**: Designed Hero banner with live search input, Today's Pick recommendation card, popular category pills, trending recipe carousel, and chef showcase cards.

### 2. Database Schema & Data Modeling
- **MySQL ER Diagram & Schema (`database/schema.sql`)**: Authored 14 normalized SQL tables with strict foreign keys, cascade deletes, and full-text search indexes (`users`, `recipes`, `recipe_ingredients`, `recipe_steps`, `recipe_nutrition`, `likes`, `bookmarks`, `comments`, `followers`, `notifications`, `reports`, `otp_verifications`, `password_resets`).
- **Seed Data Engine (`database/seed.sql`)**: Populated initial database with 4 demo chef accounts, 7 culinary categories, and multi-step recipe datasets.

### 3. Core PHP Architecture & Security Engine
- **Singleton PDO Database Connection (`config/database.php`)**: Developed thread-safe singleton PDO database connector with automatic SQLite fallback driver for zero-config execution.
- **Security & XSS/CSRF Protection (`config/helpers.php`)**: Built global XSS escaping helper `e()`, CSRF token generation/verification `csrf_field()`, BCRYPT password hashing, and dynamic `BASE_URL` routing.
- **Authentication Engine (`classes/Auth.php`, `auth/*`)**: Full user registration, secure login sessions, 6-digit OTP verification, and password reset workflows.

### 4. Admin Dashboard & Platform Moderation
- **Analytics & Moderation (`classes/Admin.php`, `admin/*`)**: Built admin metrics dashboard with Chart.js upload trend charts (`admin/index.php`), user suspension control (`admin/users.php`), and recipe feature/deletion moderation (`admin/recipes.php`).

---

## 📁 Leader Directory Structure
```
01_Sarthak_Team_Leader_Core_Engine/
├── config/
│   ├── config.php          (Core App Settings & Dynamic Base URL)
│   ├── database.php        (Singleton PDO Database Connection)
│   └── helpers.php         (Security Helpers: XSS, CSRF, Password Hashing)
├── database/
│   ├── schema.sql          (14 Database Tables with Foreign Keys)
│   └── seed.sql            (Demo Data Dataset)
├── assets/
│   ├── css/style.css       (Master Glassmorphism Design System)
│   └── js/app.js           (GSAP Animations, Dark Mode, Toasts, Ripple)
├── includes/
│   ├── header.php          (HTML Head, Fonts, Meta Tags)
│   ├── navbar.php          (Floating Glass Navbar & Mobile Drawer)
│   └── footer.php          (Glass Footer & Newsletter)
├── components/
│   └── recipe_card.php     (Reusable Glass Recipe Card Component)
├── pages/
│   └── home.php            (Home Landing Page, Hero & Trending Carousel)
├── classes/
│   ├── Auth.php            (User Registration, Login, Session & OTP)
│   └── Admin.php           (Dashboard Stats & Moderation Engine)
├── auth/                   (Login, Register, OTP, Password Reset, Logout)
├── admin/                  (Dashboard Overview, Users & Recipes Moderation)
├── api/                    (Admin AJAX Controllers)
├── index.php               (Primary Application Router)
└── LEADERSHIP_REPORT.md    (Architecture & UI Design Leadership Report)
```
