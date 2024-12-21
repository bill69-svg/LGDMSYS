<?php
// logout.php

// Initialize the session
session_start();

// Unset all of the session variables
$_SESSION = [];

// Destroy the session
session_destroy();

// Redirect to the login page
header("Location: login2.php");
exit;
?>
