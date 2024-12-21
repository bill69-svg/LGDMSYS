<?php
// deleteUser.php
$servername = "localhost"; // Your database server
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "lgmsys"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get user ID from POST
$userId = $_POST['userId'];

// Prepare and bind
$stmt = $conn->prepare("DELETE FROM users WHERE UserID = ?");
$stmt->bind_param("i", $userId);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "User deleted successfully."]);
} else {
    echo json_encode(["status" => "error", "message" => "Error deleting user: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
