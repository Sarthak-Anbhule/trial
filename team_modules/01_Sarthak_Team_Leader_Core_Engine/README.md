# 👑 Module 1: Core Engine, Security & Admin Dashboard

**Assigned Member**: Sarthak (Team Leader)  
**Role**: System Architect & Security Lead

---

## 📋 Responsibilities & Scope
1. **Core Configuration & Connection**: Dynamic Base URL resolver (`config/config.php`), PDO Singleton connection (`config/database.php`).
2. **Security & Helpers**: XSS sanitization `e()`, CSRF generation & verification (`config/helpers.php`), Password Hashing (BCRYPT).
3. **Database Schema & Seed**: Designing normalized MySQL database tables & demo data (`database/schema.sql`, `database/seed.sql`).
4. **Authentication System**: Login, Registration, OTP Verification, Password Reset (`classes/Auth.php`, `auth/*`).
5. **Admin Moderation & Analytics**: Dashboard metrics, Chart.js trend graphs, user suspension & recipe moderation (`classes/Admin.php`, `admin/*`).

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
└── index.php
```
