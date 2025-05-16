<?php
// includes/auth_functions.php

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function isAdmin() {
    return isset($_SESSION['is_admin']) && $_SESSION['is_admin'];
}

function requireLogin($redirect = 'login.php') {
    if (!isLoggedIn()) {
        header("Location: $redirect");
        exit();
    }
}

function requireAdmin($redirect = 'index.php') {
    requireLogin();
    if (!isAdmin()) {
        header("Location: $redirect");
        exit();
    }
}

function logoutUser() {
    session_unset();
    session_destroy();
}

function getUserAvatar($userId) {
    // Implement your avatar logic here
    return 'images/default-avatar.jpg'; // Default avatar
}
?>