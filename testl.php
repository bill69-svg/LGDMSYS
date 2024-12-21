<?php
session_start();

// Database connection
$servername = "localhost"; // Your server name
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "lgmsys"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prevent SQL injection
    $username = $conn->real_escape_string($username);
    $password = $conn->real_escape_string($password);

    // Query to check if the user exists and fetch user role
    $sql = "SELECT u.*, ur.RoleName FROM Users u 
            JOIN UserRole ur ON u.UserRoleID = ur.UserRoleID 
            WHERE u.Username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch user data
        $user = $result->fetch_assoc();
        
        // Verify the password (assuming the password is hashed in the database)
        if (password_verify($password, $user['Password'])) { // Use password_hash() to store password in database
            // Set session variables
            $_SESSION['username'] = $user['Username']; // Use null coalescing operator for safety
            $_SESSION['userRoleID'] = $user['UserRoleID']; // Use null coalescing operator for safety
            
            // Redirect based on user role (adjust the role checks as needed)
            if ($user['UserRoleID'] == 1) { // Assuming 1 is for Admin in UserRole table
                header("Location: sample.php");
                exit();
            } elseif ($user['UserRoleID'] == 2) { // Assuming 2 is for Staff in UserRole table
                header("Location: staff.php");
                exit();
            } else {
                echo "User role not recognized.";
            }
        } else {
            // Invalid password
            echo "Invalid username or password.";
        }
    } else {
        // User not found
        echo "Invalid username or password.";
    }
}

$conn->close();
?>

<!-- HTML Login Form -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form method="POST" action="">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <br><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br><br>
        <input type="submit" value="Login">
    </form>
</body>
</html>
