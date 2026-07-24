<?php
/**
 * CIY - Cook It Yourself
 * Database Connection Manager (PDO Singleton)
 * Supports MySQL with automatic seamless SQLite fallback for instant zero-config hosting
 */

require_once __DIR__ . '/config.php';

class Database {
    private static ?PDO $instance = null;
    private static string $driver = 'mysql';

    private function __construct() {}
    private function __clone() {}

    public static function getInstance(): PDO {
        if (self::$instance === null) {
            // 1. Try MySQL Connection
            try {
                $dsn = "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
                $options = [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES " . DB_CHARSET
                ];
                self::$instance = new PDO($dsn, DB_USER, DB_PASS, $options);
                self::$driver = 'mysql';
            } catch (PDOException $e) {
                // 2. Fallback to SQLite database if MySQL server is not started yet
                try {
                    $sqliteDir = ROOT_PATH . 'database/';
                    if (!is_dir($sqliteDir)) {
                        mkdir($sqliteDir, 0755, true);
                    }
                    $sqlitePath = $sqliteDir . 'ciy_sqlite.db';
                    $isNewDatabase = !file_exists($sqlitePath);

                    self::$instance = new PDO("sqlite:" . $sqlitePath);
                    self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    self::$instance->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                    self::$driver = 'sqlite';

                    if ($isNewDatabase) {
                        self::seedSqlite(self::$instance);
                    }
                } catch (PDOException $ex) {
                    die("<div style='font-family:system-ui,sans-serif; padding:40px; text-align:center;'>
                        <h2>Database Connection Failed</h2>
                        <p>" . htmlspecialchars($ex->getMessage()) . "</p>
                    </div>");
                }
            }
        }
        return self::$instance;
    }

    public static function getDriver(): string {
        return self::$driver;
    }

    /**
     * Auto-seed SQLite database if MySQL server is offline
     */
    private static function seedSqlite(PDO $pdo): void {
        $queries = [
            "CREATE TABLE IF NOT EXISTS users (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                name TEXT NOT NULL,
                username TEXT UNIQUE NOT NULL,
                email TEXT UNIQUE NOT NULL,
                password TEXT NOT NULL,
                avatar TEXT DEFAULT 'default_avatar.jpg',
                cover_image TEXT DEFAULT 'default_cover.jpg',
                bio TEXT DEFAULT NULL,
                role TEXT DEFAULT 'user',
                status TEXT DEFAULT 'active',
                remember_token TEXT DEFAULT NULL,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
            );",
            "CREATE TABLE IF NOT EXISTS categories (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                name TEXT UNIQUE NOT NULL,
                slug TEXT UNIQUE NOT NULL,
                icon TEXT DEFAULT 'fa-utensils',
                image TEXT DEFAULT 'default_category.jpg',
                description TEXT DEFAULT NULL,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            );",
            "CREATE TABLE IF NOT EXISTS recipes (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                user_id INTEGER NOT NULL,
                category_id INTEGER NOT NULL,
                title TEXT NOT NULL,
                slug TEXT UNIQUE NOT NULL,
                description TEXT NOT NULL,
                prep_time INTEGER DEFAULT 15,
                cook_time INTEGER DEFAULT 30,
                servings INTEGER DEFAULT 4,
                difficulty TEXT DEFAULT 'Easy',
                cuisine TEXT DEFAULT 'International',
                video_url TEXT DEFAULT NULL,
                cover_image TEXT NOT NULL,
                is_featured INTEGER DEFAULT 0,
                is_published INTEGER DEFAULT 1,
                views_count INTEGER DEFAULT 0,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
            );",
            "CREATE TABLE IF NOT EXISTS recipe_ingredients (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                recipe_id INTEGER NOT NULL,
                amount TEXT NOT NULL,
                unit TEXT DEFAULT '',
                name TEXT NOT NULL,
                sort_order INTEGER DEFAULT 1
            );",
            "CREATE TABLE IF NOT EXISTS recipe_steps (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                recipe_id INTEGER NOT NULL,
                step_number INTEGER NOT NULL,
                title TEXT DEFAULT NULL,
                instruction TEXT NOT NULL,
                time_minutes INTEGER DEFAULT 0,
                image_url TEXT DEFAULT NULL
            );",
            "CREATE TABLE IF NOT EXISTS recipe_nutrition (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                recipe_id INTEGER UNIQUE NOT NULL,
                calories INTEGER DEFAULT 0,
                protein TEXT DEFAULT '0g',
                carbs TEXT DEFAULT '0g',
                fat TEXT DEFAULT '0g',
                fiber TEXT DEFAULT '0g'
            );",
            "CREATE TABLE IF NOT EXISTS likes (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                user_id INTEGER NOT NULL,
                recipe_id INTEGER NOT NULL,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            );",
            "CREATE TABLE IF NOT EXISTS bookmarks (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                user_id INTEGER NOT NULL,
                recipe_id INTEGER NOT NULL,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            );",
            "CREATE TABLE IF NOT EXISTS comments (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                recipe_id INTEGER NOT NULL,
                user_id INTEGER NOT NULL,
                parent_id INTEGER DEFAULT NULL,
                comment TEXT NOT NULL,
                rating INTEGER DEFAULT 5,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            );",
            "CREATE TABLE IF NOT EXISTS followers (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                follower_id INTEGER NOT NULL,
                following_id INTEGER NOT NULL,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            );",
            "CREATE TABLE IF NOT EXISTS notifications (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                user_id INTEGER NOT NULL,
                actor_id INTEGER NOT NULL,
                type TEXT NOT NULL,
                target_id INTEGER DEFAULT NULL,
                message TEXT NOT NULL,
                is_read INTEGER DEFAULT 0,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            );",
            "CREATE TABLE IF NOT EXISTS reports (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                reporter_id INTEGER NOT NULL,
                recipe_id INTEGER NOT NULL,
                reason TEXT NOT NULL,
                details TEXT DEFAULT NULL,
                status TEXT DEFAULT 'pending',
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            );",
            "CREATE TABLE IF NOT EXISTS otp_verifications (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                email TEXT NOT NULL,
                code TEXT NOT NULL,
                expires_at DATETIME NOT NULL,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            );",
            "CREATE TABLE IF NOT EXISTS password_resets (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                email TEXT NOT NULL,
                token TEXT NOT NULL,
                expires_at DATETIME NOT NULL,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            );"
        ];

        foreach ($queries as $sql) {
            $pdo->exec($sql);
        }

        // Insert seed users
        $pdo->exec("INSERT OR IGNORE INTO users (id, name, username, email, password, avatar, cover_image, bio, role, status) VALUES
        (1, 'Sarthak Anbhule', 'foodie_sarthak', 'sarthak@ciy.com', '\$2y\$10\$YhQAqrV3MzFtCl6lm/jv7.98CHu1tlUul2Mk2uCx5o3Q7wbQeHLdq', 'chef_sarthak.jpg', 'cover_sarthak.jpg', 'Cooking is my passion & sharing is my happiness ❤️', 'chef', 'active'),
        (2, 'Chef Emma Watson', 'chef_emma', 'emma@ciy.com', '\$2y\$10\$YhQAqrV3MzFtCl6lm/jv7.98CHu1tlUul2Mk2uCx5o3Q7wbQeHLdq', 'chef_emma.jpg', 'cover_emma.jpg', 'Michelin star trained chef.', 'chef', 'active'),
        (3, 'Gordon Ramsay', 'chef_gordon', 'gordon@ciy.com', '\$2y\$10\$YhQAqrV3MzFtCl6lm/jv7.98CHu1tlUul2Mk2uCx5o3Q7wbQeHLdq', 'chef_gordon.jpg', 'cover_gordon.jpg', 'Mastering flavor profiles.', 'chef', 'active'),
        (4, 'Admin User', 'admin_ciy', 'admin@ciy.com', '\$2y\$10\$YhQAqrV3MzFtCl6lm/jv7.98CHu1tlUul2Mk2uCx5o3Q7wbQeHLdq', 'default_avatar.jpg', 'default_cover.jpg', 'Administrator.', 'admin', 'active');");

        // Insert seed categories
        $pdo->exec("INSERT OR IGNORE INTO categories (id, name, slug, icon, image, description) VALUES
        (1, 'Quick Meals', 'quick-meals', 'fa-bolt', 'cat_quick.jpg', 'Ready in under 20 minutes'),
        (2, 'Healthy', 'healthy', 'fa-leaf', 'cat_healthy.jpg', 'Nutritious & low calorie'),
        (3, 'Indian', 'indian', 'fa-pepper-hot', 'cat_indian.jpg', 'Rich aromatic curries'),
        (4, 'Italian', 'italian', 'fa-pizza-slice', 'cat_italian.jpg', 'Handcrafted pastas & risottos'),
        (5, 'Desserts', 'desserts', 'fa-cookie-bite', 'cat_desserts.jpg', 'Decadent cakes & sweet indulgences'),
        (6, 'Breakfast', 'breakfast', 'fa-egg', 'cat_breakfast.jpg', 'Energizing morning dishes'),
        (7, 'Asian', 'asian', 'fa-bowl-rice', 'cat_asian.jpg', 'Savory stir-fries & ramen');");

        // Insert seed recipes
        $pdo->exec("INSERT OR IGNORE INTO recipes (id, user_id, category_id, title, slug, description, prep_time, cook_time, servings, difficulty, cuisine, cover_image, is_featured, is_published, views_count) VALUES
        (1, 2, 4, 'Cheesy Chicken Pasta', 'cheesy-chicken-pasta', 'Creamy, cheesy and loaded with rich garlic butter flavor. The perfect comfort food for any day of the week.', 15, 20, 2, 'Easy', 'Italian', 'cheesy_pasta.jpg', 1, 1, 1420),
        (2, 1, 7, 'Spicy Ramen Bowl', 'spicy-ramen-bowl', 'Authentic Japanese ramen with rich pork bone broth, soft-boiled marinated egg, and spicy chili paste.', 20, 25, 2, 'Medium', 'Japanese', 'spicy_ramen.jpg', 1, 1, 980),
        (3, 1, 3, 'Paneer Butter Masala', 'paneer-butter-masala', 'Rich, creamy and delicious paneer dish cooked in restaurant-style tomato cashew gravy.', 15, 25, 4, 'Medium', 'Indian', 'paneer_butter.jpg', 1, 1, 2150),
        (4, 2, 5, 'Chocolate Lava Cake', 'chocolate-lava-cake', 'Decadent molten dark chocolate cake with a warm ooey-gooey center, served with vanilla bean ice cream.', 10, 15, 2, 'Medium', 'French', 'lava_cake.jpg', 1, 1, 1780),
        (5, 3, 2, 'Veggie Stir Fry Bowl', 'veggie-stir-fry-bowl', 'Fresh crisp vegetables tossed in sweet garlic soy reduction with toasted sesame seeds and brown rice.', 10, 15, 2, 'Easy', 'Asian', 'veggie_stirfry.jpg', 0, 1, 640);");

        // Seed Ingredients
        $pdo->exec("INSERT OR IGNORE INTO recipe_ingredients (id, recipe_id, amount, unit, name, sort_order) VALUES
        (1, 1, '200', 'g', 'Fettuccine or Penne Pasta', 1),
        (2, 1, '250', 'g', 'Boneless Chicken Breast (Diced)', 2),
        (3, 1, '1', 'cup', 'Heavy Cream', 3),
        (4, 1, '1', 'cup', 'Grated Parmesan & Mozzarella', 4),
        (5, 1, '2', 'tbsp', 'Extra Virgin Olive Oil & Butter', 5),
        (6, 1, '4', 'cloves', 'Garlic (Minced)', 6),
        (7, 1, '1', 'tsp', 'Italian Herbs & Black Pepper', 7),
        (8, 2, '2', 'packs', 'Ramen Noodles', 1),
        (9, 2, '4', 'cups', 'Rich Chicken or Pork Stock', 2),
        (10, 2, '2', 'tbsp', 'Chili Garlic Oil / Paste', 3),
        (11, 2, '2', 'large', 'Ramen Eggs (Soft Boiled)', 4);");

        // Seed Steps
        $pdo->exec("INSERT OR IGNORE INTO recipe_steps (id, recipe_id, step_number, title, instruction, time_minutes) VALUES
        (1, 1, 1, 'Boil the Pasta', 'Bring a large pot of salted water to boil. Add pasta and cook for 8-10 minutes until al dente. Drain and reserve 1/2 cup pasta water.', 8),
        (2, 1, 2, 'Sear the Chicken', 'Heat olive oil in a pan over medium heat. Season diced chicken with salt and pepper, then sear until golden brown.', 6),
        (3, 1, 3, 'Make the Creamy Sauce', 'In the same pan, melt butter and sauté minced garlic until fragrant. Pour in heavy cream and bring to a simmer.', 4),
        (4, 1, 4, 'Add Cheese & Combine', 'Add grated parmesan and mozzarella cheese. Stir continuously until smooth. Toss in cooked pasta.', 3),
        (5, 2, 1, 'Prepare the Broth', 'Simmer broth with garlic, ginger, soy sauce, and chili oil for 15 minutes to infuse rich flavors.', 15),
        (6, 2, 2, 'Cook Ramen & Assemble', 'Boil ramen noodles for 3 minutes. Transfer to bowl, pour hot broth over, and top with soft egg and scallions.', 5);");

        // Seed Nutrition
        $pdo->exec("INSERT OR IGNORE INTO recipe_nutrition (id, recipe_id, calories, protein, carbs, fat, fiber) VALUES
        (1, 1, 620, '38g', '45g', '32g', '3g'),
        (2, 2, 540, '26g', '58g', '22g', '4g'),
        (3, 3, 480, '18g', '24g', '36g', '5g'),
        (4, 4, 450, '6g', '52g', '24g', '2g'),
        (5, 5, 310, '12g', '42g', '11g', '8g');");

        // Seed Likes & Comments
        $pdo->exec("INSERT OR IGNORE INTO likes (id, user_id, recipe_id) VALUES (1, 1, 1), (2, 1, 4), (3, 2, 2), (4, 3, 1);");
        $pdo->exec("INSERT OR IGNORE INTO comments (id, recipe_id, user_id, comment, rating) VALUES 
        (1, 1, 1, 'Absolutely delicious! The garlic cream sauce was so rich and restaurant quality.', 5),
        (2, 1, 3, 'Good pasta technique! Reminded me of traditional Tuscan Alfredo.', 5);");
    }
}
