<?php
/**
 * CIY - Cook It Yourself
 * Authentication & Security Manager Class
 */

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/helpers.php';

class Auth {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    /**
     * Register a new user
     */
    public function register(array $data): array {
        $name = trim($data['name'] ?? '');
        $username = strtolower(trim($data['username'] ?? ''));
        $email = strtolower(trim($data['email'] ?? ''));
        $password = $data['password'] ?? '';

        if (empty($name) || empty($username) || empty($email) || empty($password)) {
            return ['success' => false, 'message' => 'All fields are required.'];
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ['success' => false, 'message' => 'Invalid email address syntax.'];
        }

        if (strlen($password) < 6) {
            return ['success' => false, 'message' => 'Password must be at least 6 characters.'];
        }

        // Check unique username and email
        $stmt = $this->db->prepare("SELECT id FROM users WHERE email = :email OR username = :username");
        $stmt->execute([':email' => $email, ':username' => $username]);
        if ($stmt->fetch()) {
            return ['success' => false, 'message' => 'Username or Email is already registered.'];
        }

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $this->db->prepare("INSERT INTO users (name, username, email, password, role) VALUES (:name, :username, :email, :password, 'user')");
        
        if ($stmt->execute([
            ':name' => $name,
            ':username' => $username,
            ':email' => $email,
            ':password' => $hashedPassword
        ])) {
            $userId = (int)$this->db->lastInsertId();
            $this->createSession($userId, $name, $username, $email, 'user');
            return ['success' => true, 'message' => 'Account created successfully! Welcome to CIY.'];
        }

        return ['success' => false, 'message' => 'Registration failed. Please try again.'];
    }

    /**
     * Login User
     */
    public function login(string $loginInput, string $password): array {
        $loginInput = strtolower(trim($loginInput));
        
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :input OR username = :input LIMIT 1");
        $stmt->execute([':input' => $loginInput]);
        $user = $stmt->fetch();

        if (!$user || !password_verify($password, $user['password'])) {
            return ['success' => false, 'message' => 'Invalid credentials provided.'];
        }

        if ($user['status'] === 'banned') {
            return ['success' => false, 'message' => 'Your account has been suspended by an administrator.'];
        }

        $this->createSession((int)$user['id'], $user['name'], $user['username'], $user['email'], $user['role']);
        return ['success' => true, 'message' => 'Logged in successfully!'];
    }

    /**
     * Create session
     */
    private function createSession(int $id, string $name, string $username, string $email, string $role): void {
        session_regenerate_id(true);
        $_SESSION['user_id'] = $id;
        $_SESSION['user_name'] = $name;
        $_SESSION['username'] = $username;
        $_SESSION['user_email'] = $email;
        $_SESSION['user_role'] = $role;
    }

    /**
     * Generate OTP code for email verification or password reset
     */
    public function generateOTP(string $email): string {
        $code = sprintf("%06d", mt_rand(100000, 999999));
        $expires = date('Y-m-d H:i:s', strtotime('+15 minutes'));

        // Clear existing
        $stmt = $this->db->prepare("DELETE FROM otp_verifications WHERE email = :email");
        $stmt->execute([':email' => $email]);

        // Insert new
        $stmt = $this->db->prepare("INSERT INTO otp_verifications (email, code, expires_at) VALUES (:email, :code, :expires)");
        $stmt->execute([':email' => $email, ':code' => $code, ':expires' => $expires]);

        return $code;
    }

    /**
     * Verify OTP Code
     */
    public function verifyOTP(string $email, string $code): bool {
        $stmt = $this->db->prepare("SELECT * FROM otp_verifications WHERE email = :email AND code = :code AND expires_at > NOW() LIMIT 1");
        $stmt->execute([':email' => $email, ':code' => $code]);
        $otp = $stmt->fetch();

        if ($otp) {
            // Delete used OTP
            $this->db->prepare("DELETE FROM otp_verifications WHERE email = :email")->execute([':email' => $email]);
            return true;
        }
        return false;
    }

    /**
     * Check if user is logged in
     */
    public static function check(): bool {
        return !empty($_SESSION['user_id']);
    }

    /**
     * Get Current Logged-in User ID
     */
    public static function id(): ?int {
        return $_SESSION['user_id'] ?? null;
    }

    /**
     * Get Current Logged-in User Data Array
     */
    public static function user(): ?array {
        if (!self::check()) return null;
        
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT id, name, username, email, avatar, cover_image, bio, role, status FROM users WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $_SESSION['user_id']]);
        return $stmt->fetch() ?: null;
    }

    /**
     * Check if logged in user is admin
     */
    public static function isAdmin(): bool {
        return self::check() && ($_SESSION['user_role'] ?? '') === 'admin';
    }

    /**
     * Logout user
     */
    public static function logout(): void {
        $_SESSION = array();
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
    }
}
