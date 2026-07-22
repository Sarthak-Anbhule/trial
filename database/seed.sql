-- ============================================================
-- CIY - Cook It Yourself Seed Data
-- Database Name: ciy_db
-- Password for all test users: password123
-- Hash: $2y$10$4.p9aD.u62pS4p2X/K2M5.aG8v0kXv8lQ6Y60.aG8v0kXv8lQ6Y60 (or standard password_hash)
-- ============================================================

USE `ciy_db`;

-- ------------------------------------------------------------
-- SEED USERS
-- ------------------------------------------------------------
INSERT INTO `users` (`id`, `name`, `username`, `email`, `password`, `avatar`, `cover_image`, `bio`, `role`, `status`) VALUES
(1, 'Sarthak Anbhule', 'foodie_sarthak', 'sarthak@ciy.com', '$2y$10$4y9pB/U/r.r4Nn4T3L9s.eWw5jG4d8n6p7q8r9s0t1u2v3w4x5y6z', 'chef_sarthak.jpg', 'cover_sarthak.jpg', 'Cooking is my passion & sharing is my happiness ❤️ Senior Culinary Designer & Food Photographer.', 'chef', 'active'),
(2, 'Chef Emma Watson', 'chef_emma', 'emma@ciy.com', '$2y$10$4y9pB/U/r.r4Nn4T3L9s.eWw5jG4d8n6p7q8r9s0t1u2v3w4x5y6z', 'chef_emma.jpg', 'cover_emma.jpg', 'Michelin star trained chef specializing in modern Italian pasta and Parisian patisserie.', 'chef', 'active'),
(3, 'Gordon Ramsay', 'chef_gordon', 'gordon@ciy.com', '$2y$10$4y9pB/U/r.r4Nn4T3L9s.eWw5jG4d8n6p7q8r9s0t1u2v3w4x5y6z', 'chef_gordon.jpg', 'cover_gordon.jpg', 'Mastering flavor profile, techniques, and precision cooking. Cook it right!', 'chef', 'active'),
(4, 'Admin User', 'admin_ciy', 'admin@ciy.com', '$2y$10$4y9pB/U/r.r4Nn4T3L9s.eWw5jG4d8n6p7q8r9s0t1u2v3w4x5y6z', 'default_avatar.jpg', 'default_cover.jpg', 'CIY Platform Administrator.', 'admin', 'active');

-- ------------------------------------------------------------
-- SEED CATEGORIES
-- ------------------------------------------------------------
INSERT INTO `categories` (`id`, `name`, `slug`, `icon`, `image`, `description`) VALUES
(1, 'Quick Meals', 'quick-meals', 'fa-bolt', 'cat_quick.jpg', 'Delicious recipes ready in under 20 minutes'),
(2, 'Healthy', 'healthy', 'fa-leaf', 'cat_healthy.jpg', 'Nutritious & low calorie balanced meals'),
(3, 'Indian', 'indian', 'fa-pepper-hot', 'cat_indian.jpg', 'Rich aromatic curries and spicy authentic dishes'),
(4, 'Italian', 'italian', 'fa-pizza-slice', 'cat_italian.jpg', 'Handcrafted pastas, risottos, and Neapolitan pizzas'),
(5, 'Desserts', 'desserts', 'fa-cookie-bite', 'cat_desserts.jpg', 'Decadent cakes, pastries, and sweet indulgences'),
(6, 'Breakfast', 'breakfast', 'fa-egg', 'cat_breakfast.jpg', 'Energizing morning dishes and fluffy pancakes'),
(7, 'Asian', 'asian', 'fa-bowl-rice', 'cat_asian.jpg', 'Savory stir-fries, ramen bowls, and sushi rolls');

-- ------------------------------------------------------------
-- SEED RECIPES
-- ------------------------------------------------------------
INSERT INTO `recipes` (`id`, `user_id`, `category_id`, `title`, `slug`, `description`, `prep_time`, `cook_time`, `servings`, `difficulty`, `cuisine`, `cover_image`, `is_featured`, `is_published`, `views_count`) VALUES
(1, 2, 4, 'Cheesy Chicken Pasta', 'cheesy-chicken-pasta', 'Creamy, cheesy and loaded with rich garlic butter flavor. The perfect comfort food for any day of the week.', 15, 20, 2, 'Easy', 'Italian', 'cheesy_pasta.jpg', 1, 1, 1420),
(2, 1, 7, 'Spicy Ramen Bowl', 'spicy-ramen-bowl', 'Authentic Japanese ramen with rich pork bone broth, soft-boiled marinated egg, and spicy chili paste.', 20, 25, 2, 'Medium', 'Japanese', 'spicy_ramen.jpg', 1, 1, 980),
(3, 1, 3, 'Paneer Butter Masala', 'paneer-butter-masala', 'Rich, creamy and delicious paneer dish cooked in restaurant-style tomato cashew gravy.', 15, 25, 4, 'Medium', 'Indian', 'paneer_butter.jpg', 1, 1, 2150),
(4, 2, 5, 'Chocolate Lava Cake', 'chocolate-lava-cake', 'Decadent molten dark chocolate cake with a warm ooey-gooey center, served with vanilla bean ice cream.', 10, 15, 2, 'Medium', 'French', 'lava_cake.jpg', 1, 1, 1780),
(5, 3, 2, 'Veggie Stir Fry Bowl', 'veggie-stir-fry-bowl', 'Fresh crisp vegetables tossed in sweet garlic soy reduction with toasted sesame seeds and brown rice.', 10, 15, 2, 'Easy', 'Asian', 'veggie_stirfry.jpg', 0, 1, 640);

-- ------------------------------------------------------------
-- SEED INGREDIENTS (Recipe #1: Cheesy Chicken Pasta)
-- ------------------------------------------------------------
INSERT INTO `recipe_ingredients` (`recipe_id`, `amount`, `unit`, `name`, `sort_order`) VALUES
(1, '200', 'g', 'Fettuccine or Penne Pasta', 1),
(1, '250', 'g', 'Boneless Chicken Breast (Diced)', 2),
(1, '1', 'cup', 'Heavy Heavy Cream', 3),
(1, '1', 'cup', 'Grated Parmesan & Mozzarella', 4),
(1, '2', 'tbsp', 'Extra Virgin Olive Oil & Butter', 5),
(1, '4', 'cloves', 'Garlic (Minced)', 6),
(1, '1', 'tsp', 'Italian Herbs & Black Pepper', 7);

-- INGREDIENTS (Recipe #2: Spicy Ramen Bowl)
INSERT INTO `recipe_ingredients` (`recipe_id`, `amount`, `unit`, `name`, `sort_order`) VALUES
(2, '2', 'packs', 'Ramen Noodles', 1),
(2, '4', 'cups', 'Rich Chicken or Pork Stock', 2),
(2, '2', 'tbsp', 'Chili Garlic Oil / Paste', 3),
(2, '2', 'large', 'Ramen Eggs (Soft Boiled)', 4),
(2, '100', 'g', 'Sliced Chashu Pork or Mushrooms', 5),
(2, '1', 'handful', 'Fresh Green Onions & Nori Sheet', 6);

-- INGREDIENTS (Recipe #3: Paneer Butter Masala)
INSERT INTO `recipe_ingredients` (`recipe_id`, `amount`, `unit`, `name`, `sort_order`) VALUES
(3, '300', 'g', 'Fresh Cottage Cheese (Paneer)', 1),
(3, '4', 'large', 'Ripe Tomatoes (Pureed)', 2),
(3, '12', 'whole', 'Cashew Nuts (Soaked & Ground)', 3),
(3, '3', 'tbsp', 'Unsalted Butter', 4),
(3, '1', 'tbsp', 'Kasuri Methi & Garam Masala', 5),
(3, '2', 'tbsp', 'Fresh Cream', 6);

-- ------------------------------------------------------------
-- SEED STEPS (Recipe #1: Cheesy Chicken Pasta)
-- ------------------------------------------------------------
INSERT INTO `recipe_steps` (`recipe_id`, `step_number`, `title`, `instruction`, `time_minutes`, `image_url`) VALUES
(1, 1, 'Boil the Pasta', 'Bring a large pot of salted water to boil. Add pasta and cook for 8-10 minutes until al dente. Drain and reserve 1/2 cup pasta water.', 8, 'step_boil_pasta.jpg'),
(1, 2, 'Sear the Chicken', 'Heat olive oil in a pan over medium heat. Season diced chicken with salt and pepper, then sear until golden brown and cooked through (5-7 mins). Remove chicken.', 6, 'step_sear_chicken.jpg'),
(1, 3, 'Make the Creamy Sauce', 'In the same pan, melt butter and sauté minced garlic until fragrant. Pour in heavy cream and bring to a simmer.', 4, 'step_make_sauce.jpg'),
(1, 4, 'Add Cheese & Combine', 'Add grated parmesan and mozzarella cheese. Stir continuously until smooth. Toss in cooked pasta, chicken, and pasta water until coated.', 3, 'step_combine_pasta.jpg');

-- STEPS (Recipe #2: Spicy Ramen Bowl)
INSERT INTO `recipe_steps` (`recipe_id`, `step_number`, `title`, `instruction`, `time_minutes`, `image_url`) VALUES
(2, 1, 'Prepare the Broth', 'Simmer broth with garlic, ginger, soy sauce, and chili oil for 15 minutes to infuse rich flavors.', 15, 'step_ramen_broth.jpg'),
(2, 2, 'Cook Ramen & Assemble', 'Boil ramen noodles for 3 minutes. Transfer to bowl, pour hot broth over, and top with soft egg, pork, and scallions.', 5, 'step_ramen_assemble.jpg');

-- ------------------------------------------------------------
-- SEED NUTRITION
-- ------------------------------------------------------------
INSERT INTO `recipe_nutrition` (`recipe_id`, `calories`, `protein`, `carbs`, `fat`, `fiber`) VALUES
(1, 620, '38g', '45g', '32g', '3g'),
(2, 540, '26g', '58g', '22g', '4g'),
(3, 480, '18g', '24g', '36g', '5g'),
(4, 450, '6g', '52g', '24g', '2g'),
(5, 310, '12g', '42g', '11g', '8g');

-- ------------------------------------------------------------
-- SEED LIKES & BOOKMARKS
-- ------------------------------------------------------------
INSERT INTO `likes` (`user_id`, `recipe_id`) VALUES
(1, 1), (1, 4), (2, 2), (2, 3), (3, 1), (3, 2);

INSERT INTO `bookmarks` (`user_id`, `recipe_id`) VALUES
(1, 1), (1, 2), (2, 4);

-- ------------------------------------------------------------
-- SEED COMMENTS
-- ------------------------------------------------------------
INSERT INTO `comments` (`recipe_id`, `user_id`, `comment`, `rating`) VALUES
(1, 1, 'Absolutely delicious! The garlic cream sauce was so rich and restaurant quality.', 5),
(1, 3, 'Good pasta technique! Reminded me of traditional Tuscan Alfredo.', 5),
(2, 2, 'Spicy, warming and perfect for rainy nights!', 5);

-- ------------------------------------------------------------
-- SEED FOLLOWERS
-- ------------------------------------------------------------
INSERT INTO `followers` (`follower_id`, `following_id`) VALUES
(1, 2), (1, 3), (2, 1), (3, 1);
