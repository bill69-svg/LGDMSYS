<?php
// session_handler.php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // If not logged in, redirect to login page
    header("Location: login2.php");
    exit;
}

// Track pages visited
if (!isset($_SESSION['pages_visited'])) {
    $_SESSION['pages_visited'] = [];
}

$current_page = basename($_SERVER['PHP_SELF']);
$_SESSION['pages_visited'][] = $current_page;

// Store the referring page for back navigation
if (isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER'])) {
    $_SESSION['previous_page'] = $_SERVER['HTTP_REFERER']; // Store previous page URL
}
?>
