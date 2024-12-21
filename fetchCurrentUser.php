<?php
session_start();

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lgmsys";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['error' => 'Connection failed: ' . $conn->connect_error]));
}

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    die(json_encode(['error' => 'User not logged in']));
}

// Fetch user data based on the logged-in username
$username = $_SESSION['username'];
$stmt = $conn->prepare("SELECT FirstName, LastName, Email, UserRoleID, Status FROM Users WHERE Username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    
    // Concatenate first and last name
    $fullName = $user['FirstName'] . ' ' . $user['LastName'];

    // Map user role ID to role name
    $userRole = ($user['UserRoleID'] == 1) ? 'Admin' : 'Staff';

    // Return user data as JSON
    echo json_encode([
        'name' => $fullName, // Updated to return the full name
        'email' => $user['Email'],
        'role' => $userRole,
        'status' => $user['Status'],
    ]);
} else {
    echo json_encode(['error' => 'User not found']);
}

$stmt->close();
$conn->close();
?>
