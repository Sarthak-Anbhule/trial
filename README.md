# CIY - Cook It Yourself

**CIY (Cook It Yourself)** is a premium modern recipe sharing platform with an Apple + Spotify + Pinterest inspired design aesthetic featuring glassmorphism, frosted blur cards, warm gradients, smooth GSAP animations, interactive cooking step timers, and a pure PHP 8 + MySQL OOP backend.

---

## 🌟 Key Highlights & Features

- **Apple-Inspired Glassmorphism Design**: Frosted glass cards, floating glass navigation bar, micro-interactions, dark mode toggle.
- **Pure PHP 8+ OOP Backend**: Strict PDO prepared statements, XSS sanitization, CSRF token validation, session management. No heavy frameworks required.
- **Interactive Cooking Mode**: Step-by-step full screen cooking overlay with countdown timer and audio alerts.
- **Recipe Creator Studio**: Drag-and-drop cover photo preview, dynamic ingredient builder, step builder.
- **Social Engagement**: Like recipes, save bookmarks, post reviews with 5-star ratings, follow top creators.
- **Live Instant AJAX Search**: Rapid search by title, ingredients, cuisine, or category.
- **Complete Admin Panel**: Analytics overview, Chart.js metrics, user suspension, featured recipe toggles.

---

## 🚀 XAMPP Installation & Setup Instructions

### 1. Place Project in XAMPP `htdocs`
Copy or move the `CIY` folder into your XAMPP directory:
- **Windows**: `C:\xampp\htdocs\CIY`
- **macOS (XAMPP)**: `/Applications/XAMPP/xamppfiles/htdocs/CIY`

### 2. Start Apache & MySQL
Launch XAMPP Control Panel and start **Apache** and **MySQL**.

### 3. Database Setup (phpMyAdmin)
1. Open your browser and visit: [http://localhost/phpmyadmin/](http://localhost/phpmyadmin/)
2. Click **Import** tab.
3. Import `database/schema.sql` (Creates database `ciy_db` and all tables).
4. Import `database/seed.sql` (Populates categories, demo recipes, chefs, ingredients, and steps).

### 4. Launch Application
Open your browser and visit:
👉 **[http://localhost/CIY/](http://localhost/CIY/)** (or your local project root URL).

---

## 🔑 Default Test Credentials

All pre-configured test users use the password: `password123`

| Role | Email | Password |
|---|---|---|
| **Chef / Creator** | `sarthak@ciy.com` | `password123` |
| **Chef** | `emma@ciy.com` | `password123` |
| **Master Chef** | `gordon@ciy.com` | `password123` |
| **Administrator** | `admin@ciy.com` | `password123` |

---

## 📁 Directory Architecture

```
CIY/
├── assets/
│   ├── css/style.css        # Glassmorphism design tokens & dark mode
│   ├── js/app.js           # Micro-interactions, GSAP animations, toasts
│   ├── js/cooking_mode.js  # Interactive step countdown timer controller
│   ├── js/recipe_builder.js# Dynamic ingredient & step builder
│   └── images/             # Branding assets & default avatars
├── config/
│   ├── config.php          # Base URL detection, app constants
│   ├── database.php        # PDO Singleton connection manager
│   └── helpers.php         # XSS escaper e(), CSRF helpers, formatters
├── classes/
│   ├── Auth.php            # Security & session management
│   ├── Recipe.php          # Recipe engine, search, filters
│   ├── User.php            # User profiles & creator follow system
│   ├── Interaction.php     # Likes, bookmarks, comments & ratings
│   ├── Category.php        # Category manager
│   ├── Notification.php   # User activity notifications
│   └── Admin.php           # Analytics & moderation panel
├── components/
│   ├── recipe_card.php     # Glassmorphic recipe card
│   └── search_bar.php      # Live search input component
├── includes/
│   ├── header.php          # Shared HTML head & stylesheets
│   ├── navbar.php          # Floating frosted navigation bar
│   └── footer.php          # Shared footer & newsletter
├── database/
│   ├── schema.sql          # MySQL database tables & constraints
│   └── seed.sql            # Rich demo dataset
├── uploads/
│   ├── recipes/            # Recipe cover images
│   └── profiles/           # User avatars & cover photos
├── auth/
│   ├── login.php           # Login page
│   ├── register.php        # Registration page
│   ├── verify_otp.php      # OTP verification
│   └── logout.php          # Session termination
├── admin/
│   ├── index.php           # Admin analytics dashboard
│   ├── users.php           # User moderation
│   └── recipes.php         # Recipe moderation
├── pages/
│   ├── home.php            # Home discovery landing
│   ├── explore.php         # Recipe search & filter grid
│   ├── detail.php          # Recipe detail & cooking mode
│   ├── upload.php          # Recipe creation studio
│   ├── profile.php         # Chef profile & portfolio
│   ├── saved.php           # Saved bookmarks
│   └── notifications.php   # Activity stream
└── index.php               # Main application router
```
