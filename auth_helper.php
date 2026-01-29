<?php
require_once 'config.php';

// Check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Redirect to login page if not logged in
function requireLogin() {
    if (!isLoggedIn()) {
        header("Location: login.php");
        exit();
    }
}

// Get current user information
function getCurrentUser() {
    if (isLoggedIn()) {
        return [
            'id' => $_SESSION['user_id'],
            'username' => $_SESSION['username'],
            'email' => $_SESSION['email']
        ];
    }
    return null;
}

// Sanitize input data
function sanitize($data) {
    global $conn;
    return mysqli_real_escape_string($conn, htmlspecialchars(trim($data)));
}

// Display alert messages
function displayAlert($message, $type = 'success') {
    return "<div class='alert {$type}'>{$message}</div>";
}
?>