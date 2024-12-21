<?php
// addUser.php
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

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO users (Username, Password, FirstName, LastName, Email, Phone, UserRoleID, createdBy) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssss", $username, $password, $firstName, $lastName, $email, $phone, $userRole, $createdBy);

// Get data from POST
$username = $_POST['username'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hashing the password
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$userRole = $_POST['userRole'];
$createdBy = "admin"; // This can be dynamic if you have user sessions

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "User added successfully."]);
} else {
    echo json_encode(["status" => "error", "message" => "Error adding user: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
