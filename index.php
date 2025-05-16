<?php
// Main entry point for the website
// Redirect to the login page if not logged in

session_start();

// Check if user is logged in
if (isset($_SESSION['user_id'])) {
    // Redirect to dashboard if logged in
    header("Location: User/user_dashboard.php");
    exit();
} else {
    // Redirect to login page
    header("Location: User/login.php");
    exit();
}
?> 