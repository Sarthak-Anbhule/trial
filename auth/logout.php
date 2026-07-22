<?php
/**
 * CIY - Cook It Yourself
 * Session Destruction Logout Handler
 */

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/helpers.php';
require_once __DIR__ . '/../classes/Auth.php';

Auth::logout();
redirect('index.php');
