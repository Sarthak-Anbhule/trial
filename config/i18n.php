<?php
/**
 * CIY - Cook It Yourself
 * Master Internationalization (i18n) Engine & Comprehensive Translation Dictionary
 * Supported Languages: English (en), Hindi (hi), Marathi (mr)
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Allowed language codes
define('SUPPORTED_LANGUAGES', [
    'en' => ['name' => 'English', 'native' => 'English', 'icon' => '🌐'],
    'hi' => ['name' => 'Hindi', 'native' => 'हिन्दी', 'icon' => '🇮🇳'],
    'mr' => ['name' => 'Marathi', 'native' => 'मराठी', 'icon' => '🚩']
]);

// Determine selected language
if (isset($_GET['lang']) && array_key_exists($_GET['lang'], SUPPORTED_LANGUAGES)) {
    $_SESSION['lang'] = $_GET['lang'];
    setcookie('ciy_lang', $_GET['lang'], time() + (86400 * 30), '/');
}

$currentLang = $_SESSION['lang'] ?? $_COOKIE['ciy_lang'] ?? 'en';
if (!array_key_exists($currentLang, SUPPORTED_LANGUAGES)) {
    $currentLang = 'en';
}

define('CURRENT_LANG', $currentLang);

// Comprehensive Multi-Language Dictionary
$ciy_translations = [
    'en' => [
        'app_name' => 'CIY - Cook It Yourself',
        'home' => 'Home',
        'explore' => 'Explore',
        'categories' => 'Categories',
        'about' => 'About',
        'search' => 'Search Recipes',
        'create_recipe' => 'Create Recipe',
        'login' => 'Log In',
        'sign_up' => 'Sign Up',
        'profile' => 'Profile',
        'saved_recipes' => 'Saved Recipes',
        'my_recipes' => 'My Recipes',
        'admin_panel' => 'Admin Panel',
        'logout' => 'Logout',
        'language' => 'Language',
        
        // Hero Section
        'hero_title' => 'Discover, Cook & Share Master Recipes',
        'hero_subtitle' => 'Join millions of food lovers and master chefs in the world\'s most vibrant culinary community.',
        'hero_btn_explore' => 'Explore All Recipes',
        'hero_btn_join' => 'Join Community',

        // Section Titles
        'featured_recipes' => 'Featured Recipes',
        'featured_subtitle' => 'Handpicked gourmet creations from top culinary creators',
        'browse_categories' => 'Browse Categories',
        'browse_categories_subtitle' => 'Explore dishes by cuisine, dietary preferences, and meal types',
        'community_recipes' => 'Community Recipes',
        'community_recipes_subtitle' => 'Freshly cooked dishes uploaded by food lovers daily',
        'popular_chefs' => 'Popular Chefs',
        'popular_chefs_subtitle' => 'Follow top culinary creators',
        'no_recipes_found' => 'No recipes found matching your criteria.',
        'view_all' => 'View All',
        'view_profile' => 'View Profile',

        // Auth Strings
        'welcome_back' => 'Welcome Back',
        'login_subtitle' => 'Enter your credentials to access your recipes',
        'email_or_username' => 'Email or Username',
        'email_placeholder' => 'name@example.com or username',
        'password' => 'Password',
        'password_placeholder' => '••••••••',
        'forgot_password' => 'Forgot?',
        'sign_in_btn' => 'Sign In',
        'dont_have_account' => "Don't have an account?",
        'sign_up_free' => 'Sign Up Free',
        
        'join_community' => 'Join the Community',
        'register_subtitle' => 'Start discovering & sharing your master recipes',
        'full_name' => 'Full Name',
        'name_placeholder' => 'John Doe',
        'username' => 'Username',
        'username_placeholder' => 'chef_john',
        'email_address' => 'Email Address',
        'reg_email_placeholder' => 'john@example.com',
        'password_min' => 'At least 6 characters',
        'create_free_account' => 'Create Free Account',
        'already_registered' => 'Already registered?',
        
        // Demo Credentials
        'demo_credentials' => 'Quick Demo Login Credentials',
        'user_account' => 'User Account',
        'admin_account' => 'Admin Account',
        'click_to_autofill' => 'Click credential to auto-fill form',

        // Recipe Detail & Card
        'prep_time' => 'Prep Time',
        'cook_time' => 'Cook Time',
        'servings' => 'Servings',
        'mins' => 'mins',
        'difficulty' => 'Difficulty',
        'easy' => 'Easy',
        'medium' => 'Medium',
        'hard' => 'Hard',
        'ingredients' => 'Ingredients',
        'instructions' => 'Instructions',
        'nutrition' => 'Nutrition Information',
        'posted_by' => 'Recipe Created By',
        'comments' => 'Comments & Reviews',
        'add_comment' => 'Post a Comment',
        'write_comment_placeholder' => 'Share your cooking experience or feedback...',
        'submit_comment' => 'Submit Review',

        // COOKING MODE STEPS & MODAL
        'start_cooking' => 'Start Interactive Cooking Mode',
        'cooking_studio' => 'Interactive Cooking Studio',
        'step_of' => 'Step',
        'timer' => 'Timer',
        'start_timer' => 'Start Timer',
        'pause_timer' => 'Pause Timer',
        'reset_timer' => 'Reset',
        'prev_step' => 'Previous Step',
        'next_step' => 'Next Step',
        'finish_cooking' => 'Finish Cooking 🎉',
        'cooking_completed' => 'Bon Appétit! Cooking Completed!',

        // CREATE RECIPE (UPLOAD)
        'create_new_recipe' => 'Create New Recipe',
        'upload_subtitle' => 'Share your master dish with food lovers across the world',
        'recipe_title' => 'Recipe Title',
        'recipe_title_placeholder' => 'e.g. Cheesy Garlic Butter Pasta',
        'recipe_description' => 'Short Description',
        'recipe_desc_placeholder' => 'Briefly describe your dish, its flavor profile, and secret tips...',
        'cuisine' => 'Cuisine Type',
        'cuisine_placeholder' => 'e.g. Italian, Indian, Asian',
        'cover_image' => 'Recipe Cover Photo',
        'amount' => 'Amount',
        'unit' => 'Unit',
        'ingredient_name' => 'Ingredient Name',
        'add_ingredient' => 'Add Ingredient',
        'step_title' => 'Step Title',
        'step_instruction' => 'Step Instruction',
        'step_time' => 'Timer (mins)',
        'add_step' => 'Add Next Step',
        'publish_recipe_btn' => 'Publish Master Recipe',

        // NOTIFICATION SECTION
        'notifications' => 'Notifications',
        'notifications_subtitle' => 'Stay updated with likes, comments, and new followers',
        'mark_all_read' => 'Mark All as Read',
        'no_notifications' => 'No notifications yet.',
        'liked_your_recipe' => 'liked your recipe',
        'commented_on' => 'commented on your recipe',
        'started_following' => 'started following you',

        // PROFILE SECTION
        'edit_profile' => 'Edit Profile',
        'followers' => 'Followers',
        'following' => 'Following',
        'bio' => 'Chef Bio',
        'member_since' => 'Member Since',
        'follow' => 'Follow',
        'following_btn' => 'Following',
        'published_recipes' => 'Published Recipes',
        'no_my_recipes' => 'You haven\'t published any recipes yet.',
        'no_saved_recipes' => 'No saved recipes in your bookmarks yet.',

        // ABOUT SECTION
        'about_us' => 'About CIY - Cook It Yourself',
        'about_hero_subtitle' => 'Revolutionizing the home cooking experience with Apple-inspired modern design and global culinary community.',
        'our_mission' => 'Our Mission',
        'about_mission_desc' => 'CIY empowers food enthusiasts, home cooks, and professional chefs to discover, master, and share world-class recipes seamlessly.',
        'feature_1_title' => 'Apple Glassmorphic Design',
        'feature_1_desc' => 'Fluid, ultra-modern visual aesthetics designed for delight.',
        'feature_2_title' => 'Interactive Cooking Studio',
        'feature_2_desc' => 'Step-by-step guided cooking mode with integrated countdown timers.',
        'feature_3_title' => 'Multi-Language Accessibility',
        'feature_3_desc' => 'Seamless real-time language switching in English, Hindi, and Marathi.',

        // Explore Page
        'search_placeholder' => 'Search by title, ingredient, or chef name...',
        'sort_by' => 'Sort By',
        'sort_latest' => 'Latest First',
        'sort_popular' => 'Most Popular',
        'sort_rating' => 'Highest Rated',
        'all_categories' => 'All Categories',
        'filter_results' => 'Filter Results',

        // Categories
        'quick_meals' => 'Quick Meals',
        'healthy' => 'Healthy',
        'indian' => 'Indian',
        'italian' => 'Italian',
        'desserts' => 'Desserts',
        'breakfast' => 'Breakfast',
        'asian' => 'Asian',

        // Footer & General
        'quick_links' => 'Explore Links',
        'company' => 'Company',
        'newsletter' => 'Culinary Newsletter',
        'all_rights_reserved' => 'CIY - Cook It Yourself. Crafted with excellence.',
        'dark_mode' => 'Dark Mode',
        'light_mode' => 'Light Mode'
    ],

    'hi' => [
        'app_name' => 'सीआईवाई - स्वयं पकाएं',
        'home' => 'होम',
        'explore' => 'खोजें',
        'categories' => 'श्रेणियां',
        'about' => 'हमारे बारे में',
        'search' => 'व्यंजन खोजें',
        'create_recipe' => 'रेसिपी बनाएं',
        'login' => 'लॉग इन',
        'sign_up' => 'साइन अप',
        'profile' => 'प्रोफ़ाइल',
        'saved_recipes' => 'सहेजी गई रेसिपी',
        'my_recipes' => 'मेरी व्यंजन सूची',
        'admin_panel' => 'एडमिन पैनल',
        'logout' => 'लॉग आउट',
        'language' => 'भाषा',

        // Hero Section
        'hero_title' => 'उत्कृष्ट व्यंजन खोजें, पकाएं और साझा करें',
        'hero_subtitle' => 'दुनिया के सबसे जीवंत पाक समुदाय में लाखों भोजन प्रेमियों और मास्टर शेफ से जुड़ें।',
        'hero_btn_explore' => 'सभी व्यंजन देखें',
        'hero_btn_join' => 'समुदाय में शामिल हों',

        // Section Titles
        'featured_recipes' => 'विशेष व्यंजन',
        'featured_subtitle' => 'शीर्ष पाक विशेषज्ञों द्वारा बनाई गई खास रेसिपी',
        'browse_categories' => 'श्रेणियां ब्राउज़ करें',
        'browse_categories_subtitle' => 'व्यंजन, आहार प्राथमिकताओं और भोजन के प्रकारों द्वारा खोजें',
        'community_recipes' => 'समुदाय के व्यंजन',
        'community_recipes_subtitle' => 'प्रतिदिन भोजन प्रेमियों द्वारा अपलोड की गई ताज़ा डिश',
        'popular_chefs' => 'लोकप्रिय शेफ',
        'popular_chefs_subtitle' => 'शीर्ष पाक विशेषज्ञों का अनुसरण करें',
        'no_recipes_found' => 'आपके मानदंडों से मेल खाने वाली कोई रेसिपी नहीं मिली।',
        'view_all' => 'सभी देखें',
        'view_profile' => 'प्रोफ़ाइल देखें',

        // Auth Strings
        'welcome_back' => 'वापसी पर स्वागत है',
        'login_subtitle' => 'अपने व्यंजनों तक पहुँचने के लिए विवरण दर्ज करें',
        'email_or_username' => 'ईमेल या उपयोगकर्ता नाम',
        'email_placeholder' => 'name@example.com या उपयोगकर्ता नाम',
        'password' => 'पासवर्ड',
        'password_placeholder' => '••••••••',
        'forgot_password' => 'भूल गए?',
        'sign_in_btn' => 'साइन इन करें',
        'dont_have_account' => 'खाता नहीं है?',
        'sign_up_free' => 'मुफ्त साइन अप करें',

        'join_community' => 'समुदाय में शामिल हों',
        'register_subtitle' => 'उत्कृष्ट व्यंजनों की खोज और साझा करना शुरू करें',
        'full_name' => 'पूरा नाम',
        'name_placeholder' => 'राहुल शर्मा',
        'username' => 'उपयोगकर्ता नाम',
        'username_placeholder' => 'chef_rahul',
        'email_address' => 'ईमेल पता',
        'reg_email_placeholder' => 'rahul@example.com',
        'password_min' => 'कम से कम 6 अक्षर',
        'create_free_account' => 'मुफ्त खाता बनाएं',
        'already_registered' => 'पहले से पंजीकृत हैं?',

        // Demo Credentials
        'demo_credentials' => 'त्वरित डेमो लॉगिन विवरण',
        'user_account' => 'उपयोगकर्ता खाता',
        'admin_account' => 'एडमिन खाता',
        'click_to_autofill' => 'फॉर्म स्वतः भरने के लिए क्लिक करें',

        // Recipe Detail & Card
        'prep_time' => 'तैयारी का समय',
        'cook_time' => 'पकाने का समय',
        'servings' => 'परोसने की मात्रा',
        'mins' => 'मिनट',
        'difficulty' => 'कठिनाई स्तर',
        'easy' => 'आसान',
        'medium' => 'मध्यम',
        'hard' => 'कठिन',
        'ingredients' => 'आवश्यक सामग्री',
        'instructions' => 'बनाने की विधि / चरण',
        'nutrition' => 'पोषण संबंधी जानकारी',
        'posted_by' => 'रेसिपी निर्माता',
        'comments' => 'टिप्पणियाँ और समीक्षाएं',
        'add_comment' => 'समीक्षा जोड़ें',
        'write_comment_placeholder' => 'अपना खाना पकाने का अनुभव या सुझाव साझा करें...',
        'submit_comment' => 'समीक्षा जमा करें',

        // COOKING MODE STEPS & MODAL (Hindi)
        'start_cooking' => 'इंटरैक्टिव कुकिंग मोड शुरू करें',
        'cooking_studio' => 'इंटरैक्टिव कुकिंग स्टूडियो',
        'step_of' => 'चरण',
        'timer' => 'टाइमर',
        'start_timer' => 'टाइमर शुरू करें',
        'pause_timer' => 'टाइमर रोकें',
        'reset_timer' => 'रीसेट',
        'prev_step' => 'पिछला चरण',
        'next_step' => 'अगला चरण',
        'finish_cooking' => 'खाना पकाना पूरा हुआ 🎉',
        'cooking_completed' => 'बधाई हो! खाना पकाना सफलतापूर्वक पूरा हुआ!',

        // CREATE RECIPE / UPLOAD (Hindi)
        'create_new_recipe' => 'नई रेसिपी बनाएं',
        'upload_subtitle' => 'दुनिया भर के भोजन प्रेमियों के साथ अपनी मास्टर डिश साझा करें',
        'recipe_title' => 'रेसिपी का नाम',
        'recipe_title_placeholder' => 'उदा. चीज़ी गार्लिक बटर पास्ता',
        'recipe_description' => 'संक्षिप्त विवरण',
        'recipe_desc_placeholder' => 'अपनी डिश का संक्षेप में वर्णन करें, इसका स्वाद और खास टिप्स बताएं...',
        'cuisine' => 'व्यंजन का प्रकार',
        'cuisine_placeholder' => 'उदा. इटैलियन, भारतीय, एशियन',
        'cover_image' => 'रेसिपी कवर फोटो',
        'amount' => 'मात्रा',
        'unit' => 'इकाई',
        'ingredient_name' => 'सामग्री का नाम',
        'add_ingredient' => 'सामग्री जोड़ें',
        'step_title' => 'चरण शीर्षक',
        'step_instruction' => 'चरण विवरण',
        'step_time' => 'समय (मिनट)',
        'add_step' => 'अगला चरण जोड़ें',
        'publish_recipe_btn' => 'मास्टर रेसिपी प्रकाशित करें',

        // NOTIFICATION SECTION (Hindi)
        'notifications' => 'सूचनाएं (नोटिफिकेशन)',
        'notifications_subtitle' => 'लाइक, कमेंट और नए फॉलोअर्स के साथ अपडेट रहें',
        'mark_all_read' => 'सभी को पढ़ा हुआ चिन्हित करें',
        'no_notifications' => 'अभी कोई सूचना नहीं है।',
        'liked_your_recipe' => 'आपकी रेसिपी को पसंद किया',
        'commented_on' => 'आपकी रेसिपी पर टिप्पणी की',
        'started_following' => 'आपको फॉलो करना शुरू किया',

        // PROFILE SECTION (Hindi)
        'edit_profile' => 'प्रोफ़ाइल संपादित करें',
        'followers' => 'फॉलोअर्स',
        'following' => 'फॉलो कर रहे हैं',
        'bio' => 'शेफ का परिचय (बायो)',
        'member_since' => 'सदस्यता तिथि',
        'follow' => 'फॉलो करें',
        'following_btn' => 'फॉलो कर रहे हैं',
        'published_recipes' => 'प्रकाशित रेसिपी',
        'no_my_recipes' => 'आपने अभी तक कोई रेसिपी प्रकाशित नहीं की है।',
        'no_saved_recipes' => 'आपकी बुकमार्क सूची में कोई सहेजी गई रेसिपी नहीं है।',

        // ABOUT SECTION (Hindi)
        'about_us' => 'सीआईवाई के बारे में',
        'about_hero_subtitle' => 'एप्पल-प्रेरित आधुनिक डिज़ाइन और वैश्विक पाक समुदाय के साथ घर पर खाना पकाने के अनुभव में क्रांति।',
        'our_mission' => 'हमारा मिशन',
        'about_mission_desc' => 'सीआईवाई भोजन प्रेमियों, घरेलू रसोइयों और पेशेवर शेफ को विश्व स्तरीय व्यंजनों की खोज, सीखने और साझा करने में सक्षम बनाता है।',
        'feature_1_title' => 'एप्पल ग्लासमोर्फिक डिज़ाइन',
        'feature_1_desc' => 'सुंदर और अति-आधुनिक दृश्यात्मक अनुभव।',
        'feature_2_title' => 'इंटरैक्टिव कुकिंग स्टूडियो',
        'feature_2_desc' => 'एकीकृत उलटी गिनती टाइमर के साथ चरण-दर-चरण खाना पकाने का मोड।',
        'feature_3_title' => 'बहु-भाषी पहुंच',
        'feature_3_desc' => 'अंग्रेजी, हिंदी और मराठी में वास्तविक समय में भाषा बदलने की सुविधा।',

        // Explore Page
        'search_placeholder' => 'शीर्षक, सामग्री या शेफ के नाम से खोजें...',
        'sort_by' => 'क्रमानुसार',
        'sort_latest' => 'नवीनतम पहले',
        'sort_popular' => 'सबसे लोकप्रिय',
        'sort_rating' => 'उच्चतम रेटिंग',
        'all_categories' => 'सभी श्रेणियां',
        'filter_results' => 'परिणाम फ़िल्टर करें',

        // Categories
        'quick_meals' => 'झटपट भोजन',
        'healthy' => 'स्वास्थ्यवर्धक',
        'indian' => 'भारतीय व्यंजन',
        'italian' => 'इटैलियन व्यंजन',
        'desserts' => 'मिठाई और स्वीट्स',
        'breakfast' => 'नाश्ता',
        'asian' => 'एशियन व्यंजन',

        // Category Descriptions (Hindi)
        "Ready in under 20 minutes" => "20 मिनट से कम समय में तैयार",
        "Nutritious & low calorie" => "पौष्टिक और कम कैलोरी वाला भोजन",
        "Rich aromatic curries" => "स्वादिष्ट और सुगंधित भारतीय करी",
        "Handcrafted pastas & risottos" => "हस्तनिर्मित पास्ता और रिसोट्टो",
        "Decadent cakes & sweet indulgences" => "स्वादिष्ट केक और मिठाइयाँ",
        "Energizing morning dishes" => "ऊर्जावान सुबह का ताज़ा नाश्ता",
        "Savory stir-fries & ramen" => "स्वादिष्ट स्टिर-फ्राई और रामेन",

        // CHEF ACCOUNT NAMES (Hindi)
        "Sarthak Anbhule" => "सार्थक अनभुले",
        "Chef Emma Watson" => "शेफ एम्मा वाटसन",
        "Gordon Ramsay" => "गॉर्डन रामसे",
        "Admin User" => "एडमिन यूज़र",

        // Dynamic Recipe Titles & Descriptions (Hindi)
        "Cheesy Chicken Pasta" => "चीज़ी चिकन पास्ता",
        "Creamy, cheesy and loaded with rich garlic butter flavor. The perfect comfort food for any day of the week." => "क्रीमी, चीज़ी और भरपूर लहसुन मक्खन के स्वाद से भरपूर। सप्ताह के किसी भी दिन के लिए एकदम सही व्यंजन।",
        "Spicy Ramen Bowl" => "स्पाइसी रामेन बाउल",
        "Authentic Japanese ramen with rich pork bone broth, soft-boiled marinated egg, and spicy chili paste." => "स्वादिष्ट शोरबा, हाफ-बॉइल्ड अंडा और मसालेदार मिर्च पेस्ट के साथ प्रामाणिक जापानी रामेन।",
        "Paneer Butter Masala" => "पनीर बटर मसाला",
        "Rich, creamy and delicious paneer dish cooked in restaurant-style tomato cashew gravy." => "रेस्टोरेंट स्टाइल टमाटर काजू ग्रेवी में पकाया गया समृद्ध, क्रीमी और स्वादिष्ट पनीर व्यंजन।",
        "Chocolate Lava Cake" => "चॉकलेट लावा केक",
        "Decadent molten dark chocolate cake with a warm ooey-gooey center, served with vanilla bean ice cream." => "गर्म डार्क चॉकलेट केक, वेनिला आइसक्रीम के साथ परोसा जाता है।",
        "Veggie Stir Fry Bowl" => "वेजी स्टिर फ्राई बाउल",
        "Fresh crisp vegetables tossed in sweet garlic soy reduction with toasted sesame seeds and brown rice." => "मीठे लहसुन सोया सॉस में तिल और ब्राउन राइस के साथ ताज़ी सब्जियां।",

        // Ingredients (Hindi)
        "Fettuccine or Penne Pasta" => "फेटुकाइन या पेने पास्ता",
        "Boneless Chicken Breast (Diced)" => "बोनलेस चिकन (कटा हुआ)",
        "Heavy Cream" => "हैवी क्रीम",
        "Heavy Heavy Cream" => "हैवी क्रीम",
        "Grated Parmesan & Mozzarella" => "कद्दूकस किया हुआ परमेसन और मोज़ेरेला",
        "Extra Virgin Olive Oil & Butter" => "जैतून का तेल और मक्खन",
        "Garlic (Minced)" => "लहसुन (बारीक कटा हुआ)",
        "Italian Herbs & Black Pepper" => "इटैलियन जड़ी-बूटियाँ और काली मिर्च",
        "Ramen Noodles" => "रामेन नूडल्स",
        "Rich Chicken or Pork Stock" => "चिकन या पॉर्क स्टॉक (शोरबा)",
        "Chili Garlic Oil / Paste" => "मिर्च लहसुन तेल / पेस्ट",
        "Ramen Eggs (Soft Boiled)" => "रामेन अंडे (सॉफ्ट बॉइल्ड)",
        "Sliced Chashu Pork or Mushrooms" => "कटे हुए मशरूम या चिकन",
        "Fresh Green Onions & Nori Sheet" => "हरी प्याज और नोरी शीट",
        "Fresh Cottage Cheese (Paneer)" => "ताज़ा पनीर",
        "Ripe Tomatoes (Pureed)" => "पके हुए टमाटर (प्यूरी)",
        "Cashew Nuts (Soaked & Ground)" => "काजू (भिगोए और पिसे हुए)",
        "Unsalted Butter" => "बिना नमक का मक्खन",
        "Kasuri Methi & Garam Masala" => "कसूरी मेथी और गरम मसाला",

        // Steps (Hindi)
        "Boil the Pasta" => "पास्ता उबालें",
        "Bring a large pot of salted water to boil. Add pasta and cook for 8-10 minutes until al dente. Drain and reserve 1/2 cup pasta water." => "एक बड़े बर्तन में नमकीन पानी उबालें। पास्ता डालें और 8-10 मिनट तक पकाएं। पानी छान लें और 1/2 कप पानी बचा कर रखें।",
        "Sear the Chicken" => "चिकन को भूनें",
        "Heat olive oil in a pan over medium heat. Season diced chicken with salt and pepper, then sear until golden brown." => "पैन में जैतून का तेल गरम करें। कटे हुए चिकन में नमक और मिर्च मिलाकर सुनहरा होने तक भूनें।",
        "Make the Creamy Sauce" => "क्रीमी सॉस बनाएं",
        "In the same pan, melt butter and sauté minced garlic until fragrant. Pour in heavy cream and bring to a simmer." => "उसी पैन में मक्खन पिघलाएं और बारीक कटा लहसुन भूनें। फिर हैवी क्रीम डालें और धीमी आंच पर पकाएं।",
        "Add Cheese & Combine" => "चीज़ मिलाएं",
        "Add grated parmesan and mozzarella cheese. Stir continuously until smooth. Toss in cooked pasta." => "कद्दूकस किया हुआ चीज़ मिलाएं। चिकना होने तक लगातार चलाएं। फिर पका हुआ पास्ता मिलाएं।",
        "Prepare the Broth" => "शोरबा तैयार करें",
        "Simmer broth with garlic, ginger, soy sauce, and chili oil for 15 minutes to infuse rich flavors." => "लहसुन, अदरक, सोया सॉस और मिर्च के तेल के साथ 15 मिनट तक धीमी आंच पर शोरबा पकाएं।",
        "Cook Ramen & Assemble" => "रामेन पकाएं और परोसें",
        "Boil ramen noodles for 3 minutes. Transfer to bowl, pour hot broth over, and top with soft egg and scallions." => "रामेन नूडल्स को 3 मिनट तक उबालें। कटोरे में डालें, ऊपर से गर्म शोरबा और उबला अंडा डालें।",

        // Dynamic Recipe Titles & Descriptions 6-10 (Hindi)
        "Classic Avocado Toast with Poached Egg" => "क्लासिक एवोकैडो टोस्ट पोच्ड एग के साथ",
        "Artisanal sourdough toast topped with creamy smashed avocado, chili flakes, feta cheese, and a perfectly runny poached egg." => "क्रीमी मैश्ड एवोकैडो, चिली फ्लेक्स, फेटा चीज़ और हाफ-बॉइल्ड अंडे के साथ कुरकुरा टोस्ट।",
        "Authentic Butter Chicken (Murgh Makhani)" => "अस्सल बटर चिकन (मुर्ग मखनी)",
        "Tender chicken marinated in yogurt & spices, grilled and simmered in a velvety tomato, butter, and cream sauce." => "दही और मसालों में मैरीनेट किया हुआ चिकन, टमाटर, मक्खन और क्रीम सॉस में पकाया जाता है।",
        "Neapolitan Margherita Pizza" => "नेपोलिटन मार्गरीटा पिज्जा",
        "Authentic Italian pizza featuring a charred puffy crust, San Marzano tomato sauce, fresh mozzarella di bufala, and sweet basil leaves." => "टमाटर सॉस, ताज़ा मोज़ेरेला चीज़ और तुलसी के पत्तों के साथ प्रामाणिक इटैलियन पिज्जा।",
        "Thai Mango Sticky Rice" => "थाई मैंगो स्टिकी राइस",
        "Sweet Thai sticky rice infused with aromatic coconut cream and served with ripe sweet mango slices and toasted sesame." => "नारियल की क्रीम और मीठे पके आम के स्लाइस के साथ परोसा जाने वाला पारंपरिक थाई मीठा चावल।",
        "Crispy Teriyaki Salmon Bowl" => "क्रिस्पी टेरियाकी सैल्मन बाउल",
        "Pan-seared crispy salmon fillets glazed with glossy sweet-savory teriyaki sauce served over steamed jasmine rice and edamame." => "मीठे-नमकीन टेरियाकी सॉस और उबले चावल के साथ कुरकुरी सैल्मन मछली।",

        // Ingredients 6-10 (Hindi)
        "Sourdough Bread" => "साउरडफ ब्रेड / टोस्ट",
        "Ripe Avocado" => "पका हुआ एवोकैडो",
        "Fresh Eggs" => "ताज़े अंडे",
        "Crumbled Feta Cheese" => "फेटा चीज़",
        "Red Chili Flakes & Lemon Juice" => "लाल मिर्च फ्लेक्स और नींबू का रस",
        "Chicken Thighs (Boneless)" => "बोनलेस चिकन",
        "Greek Yogurt & Garlic Ginger Paste" => "गाढ़ा दही और अदरक लहसुन पेस्ट",
        "Garam Masala & Kashmiri Red Chili" => "गरम मसाला और कश्मीरी लाल मिर्च",
        "Tomato Puree" => "टमाटर की प्यूरी",
        "Unsalted Butter & Heavy Cream" => "मक्खन और हैवी क्रीम",
        "Kasuri Methi (Dried Fenugreek)" => "कसूरी मेथी",
        "Tipo 00 Pizza Flour" => "पिज्जा आटा (मैदा)",
        "San Marzano Tomato Sauce" => "इटैलियन टमाटर सॉस",
        "Fresh Mozzarella Di Bufala" => "ताज़ा मोज़ेरेला चीज़",
        "Fresh Sweet Basil" => "तुलसी की पत्तियाँ (बेसिल)",
        "Extra Virgin Olive Oil" => "जैतून का तेल",
        "Thai Sweet Glutinous Sticky Rice" => "थाई स्टिकी राइस (मीठे चावल)",
        "Coconut Milk & Palm Sugar" => "नारियल का दूध और गुड़/चीनी",
        "Sweet Yellow Mangoes" => "मीठे पके आम",
        "Toasted Sesame Seeds" => "भुने हुए तिल",
        "Fresh Salmon Fillets" => "ताज़ी सैल्मन मछली",
        "Teriyaki Sauce & Soy Glaze" => "टेरियाकी सॉस और सोया ग्लेज़",
        "Steamed Jasmine Rice" => "उबले हुए जास्मिन राइस",
        "Steamed Edamame & Cucumber Slices" => "उबले बीन्स और खीरे के स्लाइस",
        "Sesame Oil & Seeds" => "तिल का तेल और तिल",

        // Steps 6-10 (Hindi)
        "Toast Sourdough & Mash Avocado" => "ब्रेड टोस्ट करें और एवोकैडो मैश करें",
        "Poach Egg & Assemble" => "अंडा उबालें और टोस्ट पर परोसें",
        "Marinate & Sear Chicken" => "चिकन मैरीनेट करें और भूनें",
        "Simmer Velvet Makhani Sauce" => "मखमली मखनी ग्रेवी पकाएं",
        "Stretch Dough & Sauce" => "पिज्जा का आटा फैलाएं और सॉस लगाएं",
        "Top & High-Heat Bake" => "चीज़ डालकर तेज आंच पर बेक करें",
        "Steam Sticky Rice" => "स्टिकी राइस भाप में पकाएं",
        "Infuse Coconut Sauce & Serve" => "नारियल सॉस मिलाएं और आम के साथ परोसें",
        "Pan Sear Salmon" => "सैल्मन मछली पैन में भूनें",
        "Glaze & Assemble Bowl" => "सॉस से ग्लेज़ करें और बाउल सजाएं",

        
        // 42 Master Recipe Titles (Hindi)
        'Cheesy Chicken Fettuccine' => 'चीज़ी चिकन फेटुकाइन पास्ता',
        'Neapolitan Margherita Pizza' => 'नेपोलिटन मार्गरीटा पिज्जा',
        'Classic Beef Lasagna' => 'क्लासिक बीफ लसग्ना',
        'Creamy Mushroom Risotto' => 'क्रीमी मशरूम रिसोट्टो',
        'Spaghetti Carbonara' => 'स्पैगेटी कार्बोनारा',
        'Authentic Butter Chicken' => 'अस्सल बटर चिकन',
        'Paneer Butter Masala' => 'पनीर बटर मसाला',
        'Hyderabadi Chicken Biryani' => 'हैदराबादी चिकन बिरयानी',
        'Amritsari Chole Bhature' => 'अमृतसरी छोले भटूरे',
        'Crispy Masala Dosa' => 'कुरकुरी मसाला डोसा',
        'Dal Makhani' => 'दाल मखनी',
        'Spicy Pork Ramen Bowl' => 'स्पाइसी रामेन बाउल',
        'Crispy Teriyaki Salmon Bowl' => 'क्रिस्पी टेरियाकी सैल्मन बाउल',
        'Japanese Chicken Katsu Curry' => 'जापानी चिकन कात्सु करी',
        'Pan-Fried Pork Gyoza' => 'पैन-फ्राइड ग्योज़ा डंपलिंग्स',
        'Authentic Pad Thai Noodles' => 'प्रामाणिक पैड थाई नूडल्स',
        'Thai Green Curry Chicken' => 'थाई ग्रीन करी चिकन',
        'Vietnamese Beef Pho' => 'वियतनामी बीफ फो सूप',
        'Spicy Kimchi Fried Rice' => 'स्पाइसी किमची फ्राइड राइस',
        'Street Style Beef Tacos' => 'स्ट्रीट स्टाइल बीफ टाकोस',
        'Chicken Enchiladas Smothered' => 'चिकन एन्चिलाडास',
        'Fresh Guacamole & Tortilla Chips' => 'ताज़ा गुआकामोल और टॉर्टिला चिप्स',
        'Classic Avocado Toast & Poached Egg' => 'क्लासिक एवोकैडो टोस्ट पोच्ड एग के साथ',
        'Fluffy Golden Pancakes' => 'फ्लफी गोल्डन पैनकेक्स',
        'Eggs Benedict with Hollandaise' => 'एग्स बेनेडिक्ट हॉलिंडेज़ सॉस के साथ',
        'Double Smash Cheeseburger' => 'डबल स्मैश चीजबर्गर',
        'BBQ Pulled Pork Sandwich' => 'बीबीक्यू पुल्ड पोर्क सैंडविच',
        'Crispy Veggie Stir Fry Bowl' => 'वेजी स्टिर फ्राई बाउल',
        'Mediterranean Grilled Chicken Salad' => 'भूमध्यसागरीय ग्रिल्ड चिकन सलाद',
        'Quinoa Power Buddha Bowl' => 'क्विनोआ पावर बुद्धा बाउल',
        'Molten Dark Chocolate Lava Cake' => 'चॉकलेट लावा केक',
        'Classic French Onion Soup' => 'क्लासिक फ्रेंच अनियन सूप',
        'Spanish Seafood Paella' => 'स्पैनिश सीफूड पाएला',
        'Authentic Greek Gyros Wrap' => 'ग्रीक गायरोस रैप',
        'Bavarian Soft Pretzels' => 'बावेरियन सॉफ्ट प्रेट्ज़ेल',
        'Authentic Crispy Falafel Wrap' => 'अस्सल क्रिस्पी फलाफेल रैप',
        'Creamy Hummus with Olive Oil' => 'क्रीमी हुम्मुस जैतून के तेल के साथ',
        'Chicken Shawarma Plate' => 'चिकन शावर्मा प्लेट',
        'Moroccan Lamb Tagine' => 'मोरक्कन लैम्ब ताजीन',
        'Thai Mango Sticky Rice' => 'थाई मैंगो स्टिकी राइस',
        'New York Baked Cheesecake' => 'न्यू यॉर्क बेक्ड चीज़केक',
        'Crispy Spanish Churros' => 'क्रिस्पी स्पैनिश चुरोस',

        // Footer & General
        'quick_links' => 'त्वरित लिंक',
        'company' => 'कंपनी',
        'newsletter' => 'पाक संबंधी समाचार पत्र',
        'all_rights_reserved' => 'सीआईवाई - स्वयं पकाएं। उत्कृष्टता के साथ निर्मित।',
        'dark_mode' => 'डार्क मोड',
        'light_mode' => 'लाइट मोड'
    ],

    'mr' => [
        'app_name' => 'सीआयवाय - स्वतः बनवा',
        'home' => 'मुख्यपृष्ठ',
        'explore' => 'शोधा',
        'categories' => 'वर्ग / श्रेणी',
        'about' => 'आमच्याबद्दल',
        'search' => 'रेसिपी शोधा',
        'create_recipe' => 'रेसिपी तयार करा',
        'login' => 'लॉगइन',
        'sign_up' => 'साइन अप',
        'profile' => 'प्रोफाइल',
        'saved_recipes' => 'साठवलेल्या रेसिपी',
        'my_recipes' => 'माझ्या रेसिपी',
        'admin_panel' => 'ॲडमिन पॅनेल',
        'logout' => 'बाहेर पडा',
        'language' => 'भाषा',

        // Hero Section
        'hero_title' => 'उत्कृष्ट रेसिपी शोधा, शिजवा आणि शेअर करा',
        'hero_subtitle' => 'जगातील सर्वात जिवंत रेसिपी समुदायात लाखो खवय्ये आणि शेफसोबत सामील व्हा.',
        'hero_btn_explore' => 'सर्व रेसिपी शोधा',
        'hero_btn_join' => 'समुदायात सामील व्हा',

        // Section Titles
        'featured_recipes' => 'खास निवडक रेसिपी',
        'featured_subtitle' => 'उत्कृष्ट शेफकडून खास निवडलेल्या चमचमीत रेसिपी',
        'browse_categories' => 'प्रकारनुसार शोधा',
        'browse_categories_subtitle' => 'खाद्यपदार्थ, आहार आणि प्रकारानुसार शोधा',
        'community_recipes' => 'समुदायातील रेसिपी',
        'community_recipes_subtitle' => 'रोज खवय्यांनी अपलोड केलेल्या नवीन रेसिपी',
        'popular_chefs' => 'लोकप्रिय शेफ',
        'popular_chefs_subtitle' => 'उत्कृष्ट शेफ्सना फॉलो करा',
        'no_recipes_found' => 'तुमच्या शोधानुसार कोणतीही रेसिपी सापडली नाही.',
        'view_all' => 'सर्व पहा',
        'view_profile' => 'प्रोफाइल पहा',

        // Auth Strings
        'welcome_back' => 'पुन्हा स्वागत आहे',
        'login_subtitle' => 'तुमच्या रेसिपी पाहण्यासाठी तुमची माहिती प्रविष्ट करा',
        'email_or_username' => 'ईमेल किंवा युझरनेम',
        'email_placeholder' => 'name@example.com किंवा युझरनेम',
        'password' => 'पासवर्ड',
        'password_placeholder' => '••••••••',
        'forgot_password' => 'विसरलात?',
        'sign_in_btn' => 'साइन इन करा',
        'dont_have_account' => 'अकाउंट नाही का?',
        'sign_up_free' => 'मोफत साइन अप करा',

        'join_community' => 'समुदायात सामील व्हा',
        'register_subtitle' => 'उत्कृष्ट रेसिपी शोधणे आणि शेअर करणे सुरू करा',
        'full_name' => 'पूर्ण नाव',
        'name_placeholder' => 'सचिन पाटील',
        'username' => 'युझरनेम',
        'username_placeholder' => 'chef_sachin',
        'email_address' => 'ईमेल पत्ता',
        'reg_email_placeholder' => 'sachin@example.com',
        'password_min' => 'किमान ६ अक्षरे',
        'create_free_account' => 'मोफत अकाउंट तयार करा',
        'already_registered' => 'आधीच नोंदणी केली आहे?',

        // Demo Credentials
        'demo_credentials' => 'डेमो लॉगिन माहिती',
        'user_account' => 'युझर अकाउंट',
        'admin_account' => 'ॲडमिन अकाउंट',
        'click_to_autofill' => 'फॉर्म भरण्यासाठी माहितीवर क्लिक करा',

        // Recipe Detail & Card
        'prep_time' => 'तयारीची वेळ',
        'cook_time' => 'शिजवण्याची वेळ',
        'servings' => 'माणसांसाठी',
        'mins' => 'मिन्टे',
        'difficulty' => 'कठीणता स्तर',
        'easy' => 'सोपे',
        'medium' => 'मध्यम',
        'hard' => 'कठीण',
        'ingredients' => 'लागणारे साहित्य',
        'instructions' => 'कृती / पायऱ्या',
        'nutrition' => 'पोषक मूल्ये',
        'posted_by' => 'रेसिपी लेखक',
        'comments' => 'प्रतिक्रिया आणि पुनरावलोकन',
        'add_comment' => 'प्रतिक्रिया नोंदवा',
        'write_comment_placeholder' => 'तुमचा अनुभव किंवा टीप शेअर करा...',
        'submit_comment' => 'प्रतिक्रिया पाठवा',

        // COOKING MODE STEPS & MODAL (Marathi)
        'start_cooking' => 'इंटरॲक्टिव्ह कुकिंग मोड सुरू करा',
        'cooking_studio' => 'इंटरॲक्टिव्ह कुकिंग स्टुडिओ',
        'step_of' => 'पायरी',
        'timer' => 'टाइमर',
        'start_timer' => 'टाइमर सुरू करा',
        'pause_timer' => 'टाइमर थांबवा',
        'reset_timer' => 'रीसेट',
        'prev_step' => 'मागील पायरी',
        'next_step' => 'पुढील पायरी',
        'finish_cooking' => 'रेसिपी तयार झाली 🎉',
        'cooking_completed' => 'अभिनंदन! रेसिपी यशस्वीपणे पूर्ण झाली!',

        // CREATE RECIPE / UPLOAD (Marathi)
        'create_new_recipe' => 'नवीन रेसिपी तयार करा',
        'upload_subtitle' => 'तुमची खास रेसिपी जगातील खवय्यांसोबत शेअर करा',
        'recipe_title' => 'रेसिपीचे नाव',
        'recipe_title_placeholder' => 'उदा. चीझी गार्लिक बटर पास्ता',
        'recipe_description' => 'थोडक्यात माहिती',
        'recipe_desc_placeholder' => 'तुमच्या रेसिपीबद्दल थोडक्यात सांगा, तिची चव आणि महत्त्वाच्या टिप्स सांगा...',
        'cuisine' => 'प्रकार',
        'cuisine_placeholder' => 'उदा. इटालियन, भारतीय, एशियन',
        'cover_image' => 'रेसिपी फोटो',
        'amount' => 'प्रमाण',
        'unit' => 'एकक',
        'ingredient_name' => 'साहित्याचे नाव',
        'add_ingredient' => 'साहित्य जोडा',
        'step_title' => 'पायरीचे नाव',
        'step_instruction' => 'कृती माहिती',
        'step_time' => 'वेळ (मिन्टे)',
        'add_step' => 'पुढील पायरी जोडा',
        'publish_recipe_btn' => 'रेसिपी पब्लिश करा',

        // NOTIFICATION SECTION (Marathi)
        'notifications' => 'सूचना (नोटिफिकेशन्स)',
        'notifications_subtitle' => 'लाईक्स, कमेंट्स आणि नवीन फॉलोअर्सचे अपडेट्स पहा',
        'mark_all_read' => 'सर्व वाचलेले दाखवा',
        'no_notifications' => 'अद्याप कोणतीही सूचना नाही.',
        'liked_your_recipe' => 'तुमची रेसिपी लाईक केली',
        'commented_on' => 'तुमच्या रेसिपीवर कमेंट केली',
        'started_following' => 'तुम्हाला फॉलो करणे सुरू केले',

        // PROFILE SECTION (Marathi)
        'edit_profile' => 'प्रोफाइल एडिट करा',
        'followers' => 'फॉलोअर्स',
        'following' => 'फॉलो करत आहात',
        'bio' => 'शेफ माहिती (बायो)',
        'member_since' => 'सदस्यता तारीख',
        'follow' => 'फॉलो करा',
        'following_btn' => 'फॉलो करत आहात',
        'published_recipes' => 'पब्लिश केलेल्या रेसिपी',
        'no_my_recipes' => 'तुम्ही अजून कोणतीही रेसिपी पब्लिश केलेली नाही.',
        'no_saved_recipes' => 'तुमच्या सेव्ह केलेल्या यादीत रेसिपी नाहीत.',

        // ABOUT SECTION (Marathi)
        'about_us' => 'सीआयवाय बद्दल',
        'about_hero_subtitle' => 'ॲपल-प्रेरित आधुनिक डिझाईन आणि खवय्यांच्या समुदायासह घरगुती रेसिपी बनवण्याचा उत्तम अनुभव.',
        'our_mission' => 'आमचे ध्येय',
        'about_mission_desc' => 'सीआयवाय खवय्यांना, गृहिणींना आणि शेफ्सना उत्तम रेसिपी शोधण्यासाठी व शेअर करण्यासाठी मदत करते.',
        'feature_1_title' => 'ॲपल ग्लासमोर्फिक डिझाईन',
        'feature_1_desc' => 'सुंदर आणि अत्याधुनिक व्हिज्युअल अनुभव.',
        'feature_2_title' => 'इंटरॲक्टिव्ह कुकिंग स्टुडिओ',
        'feature_2_desc' => 'टाइमरसह पायरी-पायरीने शिजवण्याची कुकिंग मोड सुविधा.',
        'feature_3_title' => 'बहुभाषिक उपलब्धता',
        'feature_3_desc' => 'इंग्रजी, हिंदी आणि मराठीमध्ये थेट भाषा बदलण्याची सोय.',

        // Explore Page
        'search_placeholder' => 'नाव, साहित्य किंवा शेफचे नाव शोधा...',
        'sort_by' => 'क्रमानुसार',
        'sort_latest' => 'नवीन आधी',
        'sort_popular' => 'सर्वात लोकप्रिय',
        'sort_rating' => 'उत्कृष्ट रेटिंग',
        'all_categories' => 'सर्व वर्ग',
        'filter_results' => 'फिल्टर करा',

        // Categories
        'quick_meals' => 'झटपट रेसिपी',
        'healthy' => 'आरोग्यदायी',
        'indian' => 'भारतीय रेसिपी',
        'italian' => 'इटालियन रेसिपी',
        'desserts' => 'गोड पदार्थ',
        'breakfast' => 'नाश्ता',
        'asian' => 'एशियन रेसिपी',

        // Category Descriptions (Marathi)
        "Ready in under 20 minutes" => "२० मिनिटांपेक्षा कमी वेळेत तयार",
        "Nutritious & low calorie" => "पौष्टिक आणि कमी कॅलरी",
        "Rich aromatic curries" => "चमचमीत आणि सुवासिक करी",
        "Handcrafted pastas & risottos" => "इटालियन पास्ता आणि रिसोट्टो",
        "Decadent cakes & sweet indulgences" => "चविष्ट केक आणि गोड पदार्थ",
        "Energizing morning dishes" => "सकाळचा पौष्टिक नाश्ता",
        "Savory stir-fries & ramen" => "खमंग स्टिर-फ्राय आणि रामेन",

        // CHEF ACCOUNT NAMES (Marathi)
        "Sarthak Anbhule" => "सार्थक अनभुले",
        "Chef Emma Watson" => "शेफ एम्मा वाटसन",
        "Gordon Ramsay" => "गॉर्डन रामसे",
        "Admin User" => "ॲडमिन युझर",

        // Dynamic Recipe Titles & Descriptions (Marathi)
        "Cheesy Chicken Pasta" => "चीझी चिकन पास्ता",
        "Creamy, cheesy and loaded with rich garlic butter flavor. The perfect comfort food for any day of the week." => "क्रीमी, चीझी आणि लसूण बटरच्या समृद्ध चवीने परिपूर्ण. आठवड्याच्या कोणत्याही दिवसासाठी उत्तम रेसिपी.",
        "Spicy Ramen Bowl" => "स्पायसी रामेन बोल",
        "Authentic Japanese ramen with rich pork bone broth, soft-boiled marinated egg, and spicy chili paste." => "खमंग रस्सा, उकडलेले अंडे आणि तिखट चटणीसह अस्सल जपानी रामेन रेसिपी.",
        "Paneer Butter Masala" => "पनीर बटर मसाला",
        "Rich, creamy and delicious paneer dish cooked in restaurant-style tomato cashew gravy." => "रेस्टॉरंट स्टाइल टोमॅटो काजू ग्रेव्हीमध्ये शिजवलेली क्रीमी आणि चविष्ट पनीर रेसिपी.",
        "Chocolate Lava Cake" => "चॉकलेट लावा केक",
        "Decadent molten dark chocolate cake with a warm ooey-gooey center, served with vanilla bean ice cream." => "गरम डार्क चॉकलेट केक, व्हॅनिला आईस्क्रीमसोबत सर्व्ह केला जातो.",
        "Veggie Stir Fry Bowl" => "व्हेजी स्टिर फ्राय बोल",
        "Fresh crisp vegetables tossed in sweet garlic soy reduction with toasted sesame seeds and brown rice." => "लसूण सोया सॉसमध्ये तीळ आणि ब्राऊन राईससोबत ताज्या भाज्या.",

        // Ingredients (Marathi)
        "Fettuccine or Penne Pasta" => "पास्ता (फेटुकाइन किंवा पेने)",
        "Boneless Chicken Breast (Diced)" => "बोनलेस चिकन (तुकडे केलेले)",
        "Heavy Cream" => "हेव्ही क्रीम",
        "Heavy Heavy Cream" => "हेव्ही क्रीम",
        "Grated Parmesan & Mozzarella" => "किसलेले चीज (परमेसन आणि मोजरेला)",
        "Extra Virgin Olive Oil & Butter" => "ऑलिव्ह ऑइल आणि बटर",
        "Garlic (Minced)" => "लसूण (बारीक चिरलेला)",
        "Italian Herbs & Black Pepper" => "इटालियन हर्ब्स आणि काळी मिरी",
        "Ramen Noodles" => "रामेन नूडल्स",
        "Rich Chicken or Pork Stock" => "चिकन सूप / सूप स्टॉक",
        "Chili Garlic Oil / Paste" => "तिखट लसूण तेल / पेस्ट",
        "Ramen Eggs (Soft Boiled)" => "उकडलेली अंडी",
        "Sliced Chashu Pork or Mushrooms" => "चिकन / मशरूमचे तुकडे",
        "Fresh Green Onions & Nori Sheet" => "कांद्याची पात आणि नोरी शीट",
        "Fresh Cottage Cheese (Paneer)" => "ताजे पनीर",
        "Ripe Tomatoes (Pureed)" => "पिकलेले टोमॅटो प्युरी",
        "Cashew Nuts (Soaked & Ground)" => "काजू (भिजवलेले व वाटलेले)",
        "Unsalted Butter" => "लोणी / बटर",
        "Kasuri Methi & Garam Masala" => "कसुरी मेथी आणि गरम मसाला",

        // Steps (Marathi)
        "Boil the Pasta" => "पास्ता उकळवा",
        "Bring a large pot of salted water to boil. Add pasta and cook for 8-10 minutes until al dente. Drain and reserve 1/2 cup pasta water." => "एका मोठ्या भांड्यात मीठ टाकून पाणी उकळवा. पास्ता टाकून ८-१० मिनिटे उकळवा. पाणी गाळून १/२ कप पाणी बाजूला ठेवा.",
        "Sear the Chicken" => "चिकन परतावून घ्या",
        "Heat olive oil in a pan over medium heat. Season diced chicken with salt and pepper, then sear until golden brown." => "पॅनमध्ये ऑलिव्ह ऑइल गरम करा. चिकनला मीठ आणि काळी मिरी लावून सोनेरी रंगावर परता.",
        "Make the Creamy Sauce" => "क्रीमी सॉस बनवा",
        "In the same pan, melt butter and sauté minced garlic until fragrant. Pour in heavy cream and bring to a simmer." => "त्याच पॅनमध्ये बटर वितळवून बारीक चिरलेला लसूण परता. नंतर हेव्ही क्रीम घालून मंद आचेवर उकळवा.",
        "Add Cheese & Combine" => "चीज मिक्स करा",
        "Add grated parmesan and mozzarella cheese. Stir continuously until smooth. Toss in cooked pasta." => "किसलेले चीज मिक्स करा. सॉस मऊ होईपर्यंत ढवळा. नंतर उकळलेला पास्ता टाका.",
        "Prepare the Broth" => "सूप / रस्सा तयार करा",
        "Simmer broth with garlic, ginger, soy sauce, and chili oil for 15 minutes to infuse rich flavors." => "लसूण, आले, सोया सॉस आणि तिखट तेलासोबत १५ मिनिटे सूप मंद आचेवर उकळवा.",
        "Cook Ramen & Assemble" => "रामेन शिजवा आणि सर्व्ह करा",
        "Boil ramen noodles for 3 minutes. Transfer to bowl, pour hot broth over, and top with soft egg and scallions." => "रामेन नूडल्स ३ मिनिटे उकळवा. बाऊलमध्ये काढून त्यावर गरम सूप आणि उकडलेले अंडे टाका.",

        // Dynamic Recipe Titles & Descriptions 6-10 (Marathi)
        "Classic Avocado Toast with Poached Egg" => "क्लासिक ॲव्होकॅडो टोस्ट (पोच्ड एगसह)",
        "Artisanal sourdough toast topped with creamy smashed avocado, chili flakes, feta cheese, and a perfectly runny poached egg." => "मऊ ॲव्होकॅडो, चिली फ्लेक्स, फेटा चीज आणि उकडलेल्या अंड्यासह चमचमीत टोस्ट.",
        "Authentic Butter Chicken (Murgh Makhani)" => "अस्सल बटर चिकन (मुर्ग मखनी)",
        "Tender chicken marinated in yogurt & spices, grilled and simmered in a velvety tomato, butter, and cream sauce." => "दही आणि मसाल्यांमध्ये मॅरीनेट केलेले चिकन, टोमॅटो, बटर आणि क्रीमच्या ग्रेव्हीमध्ये शिजवले जाते.",
        "Neapolitan Margherita Pizza" => "नेपोलिटन मार्गरीटा पिझ्झा",
        "Authentic Italian pizza featuring a charred puffy crust, San Marzano tomato sauce, fresh mozzarella di bufala, and sweet basil leaves." => "टोमॅटो सॉस, ताजे मोजरेला चीज आणि तुळशीच्या पानांसह अस्सल इटालियन पिझ्झा.",
        "Thai Mango Sticky Rice" => "थाई मँगो स्टिकी राईस",
        "Sweet Thai sticky rice infused with aromatic coconut cream and served with ripe sweet mango slices and toasted sesame." => "नारळाचे दूध आणि गोड पिकलेल्या आंब्याच्या फोडींसह पारंपरिक थाई गोड भात.",
        "Crispy Teriyaki Salmon Bowl" => "क्रिस्पी टेरियाकी सॅल्मन बाऊल",
        "Pan-seared crispy salmon fillets glazed with glossy sweet-savory teriyaki sauce served over steamed jasmine rice and edamame." => "टेरियाकी सॉस आणि उकडलेल्या भातासोबत कुरकुरीत सॅल्मन मासा.",

        // Ingredients 6-10 (Marathi)
        "Sourdough Bread" => "ब्रेड टोस्ट",
        "Ripe Avocado" => "पिकलेले ॲव्होकॅडो",
        "Fresh Eggs" => "ताजी अंडी",
        "Crumbled Feta Cheese" => "फेटा चीज",
        "Red Chili Flakes & Lemon Juice" => "चिली फ्लेक्स आणि लिंबाचा रस",
        "Chicken Thighs (Boneless)" => "बोनलेस चिकन",
        "Greek Yogurt & Garlic Ginger Paste" => "घट्ट दही आणि आले-लसूण पेस्ट",
        "Garam Masala & Kashmiri Red Chili" => "गरम मसाला आणि कश्मीरी मिरची",
        "Tomato Puree" => "टोमॅटो प्युरी",
        "Unsalted Butter & Heavy Cream" => "लोणी आणि हेव्ही क्रीम",
        "Kasuri Methi (Dried Fenugreek)" => "कसुरी मेथी",
        "Tipo 00 Pizza Flour" => "पिज्जा पीठ",
        "San Marzano Tomato Sauce" => "इटालियन टोमॅटो सॉस",
        "Fresh Mozzarella Di Bufala" => "ताजे मोजरेला चीज",
        "Fresh Sweet Basil" => "तुळशीची पाने (बेसिल)",
        "Extra Virgin Olive Oil" => "ऑलिव्ह ऑइल",
        "Thai Sweet Glutinous Sticky Rice" => "थाई स्टिकी राईस (गोड तांदूळ)",
        "Coconut Milk & Palm Sugar" => "नारळाचे दूध आणि साखर",
        "Sweet Yellow Mangoes" => "गोड पिकलेले आंबे",
        "Toasted Sesame Seeds" => "भाजीलेले तीळ",
        "Fresh Salmon Fillets" => "ताजा सॅल्मन मासा",
        "Teriyaki Sauce & Soy Glaze" => "टेरियाकी सॉस आणि सोया सॉस",
        "Steamed Jasmine Rice" => "उकडलेला जास्मिन भात",
        "Steamed Edamame & Cucumber Slices" => "काकडीच्या फोडी आणि उकडलेले बीन्स",
        "Sesame Oil & Seeds" => "तिळाचे तेल आणि तीळ",

        // Steps 6-10 (Marathi)
        "Toast Sourdough & Mash Avocado" => "ब्रेड टोस्ट करा आणि ॲव्होकॅडो मॅश करा",
        "Poach Egg & Assemble" => "अंडे उकळा आणि टोस्टवर सर्व्ह करा",
        "Marinate & Sear Chicken" => "चिकन मॅरीनेट करा आणि परता",
        "Simmer Velvet Makhani Sauce" => "मखमली मखनी ग्रेव्ही शिजवा",
        "Stretch Dough & Sauce" => "पिज्जा पीठ पसरवा आणि सॉस लावा",
        "Top & High-Heat Bake" => "चीज घालून मोठ्या आचेवर बेक करा",
        "Steam Sticky Rice" => "स्टिकी राईस वाफेवर शिजवा",
        "Infuse Coconut Sauce & Serve" => "नारळाचे दूध मिक्स करा आणि आंब्यासोबत सर्व्ह करा",
        "Pan Sear Salmon" => "सॅल्मन मासा पॅनमध्ये परता",
        "Glaze & Assemble Bowl" => "सॉसने ग्लेझ करा आणि बाऊल तयार करा",

        
        // 42 Master Recipe Titles (Marathi)
        'Cheesy Chicken Fettuccine' => 'चीझी चिकन फेटुकाइन पास्ता',
        'Neapolitan Margherita Pizza' => 'नेपोलिटन मार्गरीटा पिझ्झा',
        'Classic Beef Lasagna' => 'क्लासिक बीफ लसग्ना',
        'Creamy Mushroom Risotto' => 'क्रीमी मशरूम रिसोट्टो',
        'Spaghetti Carbonara' => 'स्पॅगेटी कार्बोनारा',
        'Authentic Butter Chicken' => 'अस्सल बटर चिकन',
        'Paneer Butter Masala' => 'पनीर बटर मसाला',
        'Hyderabadi Chicken Biryani' => 'हैदराबादी चिकन बिर्याणी',
        'Amritsari Chole Bhature' => 'अमृतसरी छोले भटुरे',
        'Crispy Masala Dosa' => 'कुरकुरीत मसाला डोसा',
        'Dal Makhani' => 'दाल मखनी',
        'Spicy Pork Ramen Bowl' => 'स्पायसी रामेन बोल',
        'Crispy Teriyaki Salmon Bowl' => 'क्रिस्पी टेरियाकी सॅल्मन बाऊल',
        'Japanese Chicken Katsu Curry' => 'जपानी चिकन कात्सू करी',
        'Pan-Fried Pork Gyoza' => 'पॅन-फ्राय ग्योझा डम्पलिंग्ज',
        'Authentic Pad Thai Noodles' => 'अस्सल पॅड थाई नूडल्स',
        'Thai Green Curry Chicken' => 'थाई ग्रीन करी चिकन',
        'Vietnamese Beef Pho' => 'व्हिएतनामी बीफ फो सूप',
        'Spicy Kimchi Fried Rice' => 'स्पायसी किमची फ्राय राईस',
        'Street Style Beef Tacos' => 'स्ट्रीट स्टाइल बीफ टाकोस',
        'Chicken Enchiladas Smothered' => 'चिकन एन्चिलाडास',
        'Fresh Guacamole & Tortilla Chips' => 'ताजे गुआकामोल आणि टॉर्टिला चिप्स',
        'Classic Avocado Toast & Poached Egg' => 'क्लासिक ॲव्होकॅडो टोस्ट (पोच्ड एगसह)',
        'Fluffy Golden Pancakes' => 'फ्लफी गोल्डन पॅनकेक्स',
        'Eggs Benedict with Hollandaise' => 'एग्ज बेनेडिक्ट सॉससह',
        'Double Smash Cheeseburger' => 'डबल स्मॅश चीजबर्गर',
        'BBQ Pulled Pork Sandwich' => 'बीबीक्यू पुल्ड पोर्क सँडविच',
        'Crispy Veggie Stir Fry Bowl' => 'व्हेजी स्टिर फ्राय बोल',
        'Mediterranean Grilled Chicken Salad' => 'मेडिटेरेनियन ग्रिल्ड चिकन सॅलड',
        'Quinoa Power Buddha Bowl' => 'क्विनोआ पॉवर बुद्धा बाऊल',
        'Molten Dark Chocolate Lava Cake' => 'चॉकलेट लावा केक',
        'Classic French Onion Soup' => 'क्लासिक फ्रेंच अनियन सूप',
        'Spanish Seafood Paella' => 'स्पॅनिश सीफूड पाएला',
        'Authentic Greek Gyros Wrap' => 'ग्रीक गायरोस रॅप',
        'Bavarian Soft Pretzels' => 'बाव्हेरियन सॉफ्ट प्रेट्झेल',
        'Authentic Crispy Falafel Wrap' => 'अस्सल क्रिस्पी फलाफेल रॅप',
        'Creamy Hummus with Olive Oil' => 'क्रीमी हुमुस ऑलिव्ह ऑइलसह',
        'Chicken Shawarma Plate' => 'चिकन शावर्मा प्लेट',
        'Moroccan Lamb Tagine' => 'मोरक्कन लॅम्ब ताजीन',
        'Thai Mango Sticky Rice' => 'थाई मँगो स्टिकी राईस',
        'New York Baked Cheesecake' => 'न्यू यॉर्क बेक्ड चीजकेक',
        'Crispy Spanish Churros' => 'क्रिस्पी स्पॅनिश चुरोस',

        // Footer & General
        'quick_links' => 'एक्सप्लोर करा',
        'company' => 'कंपनी',
        'newsletter' => 'रेसिपी अपडेट्स',
        'all_rights_reserved' => 'सीआयवाय - स्वतः बनवा. गुणवत्तेसह तयार केले.',
        'dark_mode' => 'डार्क मोड',
        'light_mode' => 'लाइट मोड'
    ]
];

/**
 * Get translation for static UI keys
 */
function t(string $key, ?string $fallback = null): string {
    global $ciy_translations, $currentLang;
    if (isset($ciy_translations[$currentLang][$key])) {
        return $ciy_translations[$currentLang][$key];
    }
    if (isset($ciy_translations['en'][$key])) {
        return $ciy_translations['en'][$key];
    }
    return $fallback ?? $key;
}

/**
 * Translate dynamic recipe content (Titles, Descriptions, Ingredients, Steps, Chef Names)
 */
function t_content(?string $text): string {
    if (empty($text)) return '';
    global $ciy_translations, $currentLang;
    
    if ($currentLang === 'en') {
        return $text;
    }
    
    $trimmed = trim($text);
    if (isset($ciy_translations[$currentLang][$trimmed])) {
        return $ciy_translations[$currentLang][$trimmed];
    }
    
    return $text;
}

/**
 * Generate language switcher URL while preserving existing GET query parameters
 */
function lang_url(string $langCode): string {
    $params = $_GET;
    $params['lang'] = $langCode;
    
    $requestUri = $_SERVER['REQUEST_URI'] ?? '/index.php';
    $path = parse_url($requestUri, PHP_URL_PATH) ?? '/index.php';
    
    return htmlspecialchars($path . '?' . http_build_query($params), ENT_QUOTES, 'UTF-8');
}
