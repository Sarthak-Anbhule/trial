# 👑 Module 1: Core Engine, UI Design System, Auth & Admin Dashboard

**Assigned Member**: Sarthak (Team Leader)  
**Role**: Lead Full-Stack Software Engineer, System Architect & UI/UX Design Lead  
**Contributions**: ~60% of total codebase (Core Architecture, UI/UX Design System, Security, Database, Auth, Landing Page & Admin Moderation).

---

## 📋 Responsibilities & Authored Modules

### 1. Master UI/UX Design System & Layouts
- **Glassmorphism CSS Engine (`assets/css/style.css`)**: Frosted glass tokens, custom gradients, dark mode palette, card hover lift effects.
- **Global JS Engine (`assets/js/app.js`)**: GSAP entry animations, button ripple effects, dark mode switcher, toast notifications.
- **Shared UI Layouts (`includes/`)**: Floating glass header, mobile offcanvas drawer, footer & brand logo.
- **Home Landing Page (`pages/home.php`)**: Hero search section, Today's Pick recommendation banner, popular categories pills, trending recipe carousel.

### 2. Core Backend Engine & Security
- **Configuration & Connection**: Dynamic Base URL resolver (`config/config.php`), thread-safe PDO Singleton connection (`config/database.php`).
- **Security Functions (`config/helpers.php`)**: XSS escaper `e()`, CSRF generation/validation `csrf_field()`, BCRYPT password hashing.
- **Database ER Schema (`database/schema.sql`, `seed.sql`)**: 14 normalized SQL tables with foreign key constraints.

### 3. Authentication & Admin Dashboard
- **Authentication System (`classes/Auth.php`, `auth/*`)**: Registration, Login, OTP Verification, Password Reset.
- **Admin Control Panel (`classes/Admin.php`, `admin/*`)**: Analytics overview, Chart.js metrics, user moderation & recipe deletion.

---

## 📁 Module File Manifest
```
01_Sarthak_Team_Leader_Core_Engine/
├── config/
│   ├── config.php
│   ├── database.php
│   └── helpers.php
├── database/
│   ├── schema.sql
│   └── seed.sql
├── assets/
│   ├── css/style.css
│   └── js/app.js
├── includes/
│   ├── header.php
│   ├── navbar.php
│   └── footer.php
├── components/
│   └── recipe_card.php
├── pages/
│   └── home.php
├── classes/
│   ├── Auth.php
│   └── Admin.php
├── auth/
│   ├── login.php
│   ├── register.php
│   ├── forgot_password.php
│   ├── verify_otp.php
│   └── logout.php
├── admin/
│   ├── index.php
│   ├── users.php
│   └── recipes.php
├── api/
│   └── admin.php
├── index.php
└── LEADERSHIP_REPORT.md
```
