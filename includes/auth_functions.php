<?php
// Start a secure session
function startSecureSession() {
    if (session_status() === PHP_SESSION_NONE) {
        // Set secure session parameters
        ini_set('session.cookie_httponly', 1);
        ini_set('session.use_only_cookies', 1);
        ini_set('session.cookie_secure', 1);
        
        session_start();
    }
}

// Clean user input
function cleanInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Check if user is admin
function isAdmin() {
    return isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true;
}

// Require admin access
function requireAdmin() {
    if (!isAdmin()) {
        header('Location: /travel-site/login.php');
        exit();
    }
}

// Get user avatar
function getUserAvatar($userId) {
    // Default avatar path
    $defaultAvatar = 'assets/images/default-avatar.png';
    
    // Check if user has custom avatar
    global $pdo;
    try {
        $stmt = $pdo->prepare("SELECT avatar_path FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        $result = $stmt->fetch();
        
        if ($result && $result['avatar_path']) {
            return $result['avatar_path'];
        }
    } catch (PDOException $e) {
        error_log("Error fetching user avatar: " . $e->getMessage());
    }
    
    return $defaultAvatar;
}

// Redirect if not logged in
function redirectIfNotLoggedIn() {
    if (!isLoggedIn()) {
        header('Location: /travel-site/login.php');
        exit();
    }
}

// Redirect if not admin
function redirectIfNotAdmin() {
    if (!isAdmin()) {
        header('Location: /travel-site/login.php');
        exit();
    }
}

// Generate CSRF token
function generateCSRFToken() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

// Verify CSRF token
function verifyCSRFToken($token) {
    if (!isset($_SESSION['csrf_token']) || $token !== $_SESSION['csrf_token']) {
        return false;
    }
    return true;
} 