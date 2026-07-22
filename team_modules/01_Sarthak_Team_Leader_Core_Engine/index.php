<?php
/**
 * CIY - Cook It Yourself
 * Primary Application Entry & Router
 */

require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/helpers.php';
require_once __DIR__ . '/classes/Auth.php';

// Route directly to Home Page
require_once __DIR__ . '/pages/home.php';
