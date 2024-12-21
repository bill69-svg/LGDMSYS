<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lgmsys";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Start session to store user information
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare and execute query to check credentials
    $stmt = $conn->prepare("SELECT UserID, Username, UserRoleID, Password FROM Users WHERE Username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch user data
        $user = $result->fetch_assoc();
        
        // Verify password
        if (password_verify($password, $user['Password'])) {
            // Store user data in session
            $_SESSION['username'] = $user['Username'];
            $_SESSION['role'] = $user['UserRoleID'];

            // Redirect based on role (Admin or Staff)
            if ($user['UserRoleID'] == 1) { // Assuming 1 is Admin role
                header("Location: sample.php");
                exit();
            } elseif ($user['UserRoleID'] == 2) { // Assuming 2 is Staff role
                header("Location: staff.php");
                exit();
            }
        } else {
            echo "Invalid login credentials. Please try again.";
        }
    } else {
        echo "Invalid login credentials. Please try again.";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Local Government Document Management System</title>
    <style>
        /* Your CSS styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }
        .login-container {
            max-width: 500px;
            margin: 0 auto;
            padding: 30px;
            border: 3px solid #ccc;
            border-radius: 5px;
            background-color: #fff;
        }
        img {
            max-width: 100%;
            display: block;
            margin: 0 auto;
            margin-bottom: 30px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input {
            width: 100%;
            padding: 8px;
            border: 3px solid #ccc;
            border-radius: 3px;
        }
        .remember-me {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        button {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #022f5f;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0069d9;
        }
        p {
            text-align: center;
            margin-top: 10px;
        }
        a {
            color: #73aae6;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <img src="logo.jpg" alt="Local Government Logo">
        <h1>LG DOCUMENT MANAGEMENT SYSTEM</h1>

        <form action="login.php" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <div class="remember-me">
                <input type="checkbox" id="remember" name="remember">
                <label for="remember">Remember me</label>
            </div>
            <button type="submit">Login</button>
        </form>

        <p>Forgot your password? <a href="forgot.php">Click here</a></p>
        <p>&copy; 2023 Local Government. All rights reserved.</p>
    </div>
</body>
</html>
