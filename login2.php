<?php
// Start session
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
    die("Connection failed: " . $conn->connect_error);
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

    // Validate username format (alphanumeric)
    if (!preg_match("/^[a-zA-Z0-9]+$/", $username)) {
        echo "<p class='error'>Invalid username. Only letters and numbers are allowed.</p>";
    } else {
        // Check if the user exists in the database
        $stmt = $conn->prepare("SELECT UserRoleID, Password FROM Users WHERE Username=?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // User exists, fetch data
            $user = $result->fetch_assoc();

            // Verify the password
            if (password_verify($password, $user['Password'])) {
                // Set session variables
                $_SESSION['username'] = $username;
                $_SESSION['userRoleID'] = $user['UserRoleID'];
                $_SESSION['loggedin'] = true;  // Add logged-in flag

                // Log the login activity
                $log_sql = "INSERT INTO activitylog (Username, activity, createdOn) VALUES (?, 'Logged in', NOW())";
                $log_stmt = $conn->prepare($log_sql);
                $log_stmt->bind_param("s", $username);
                $log_stmt->execute();
                $log_stmt->close();

                // Redirect based on the user's role
                if ($_SESSION['userRoleID'] == 7) {
                    // Admin user
                    header("Location: sample.php");
                    exit();
                } elseif ($_SESSION['userRoleID'] == 8) {
                    // Staff user
                    header("Location: staff.php");
                    exit();
                } else {
                    echo "<p class='error'>Your user role is not recognized. Please contact the administrator.</p>";
                }
            } else {
                echo "<p class='error'>Invalid username or password.</p>";
            }
        } else {
            // User does not exist, redirect to registration page
            header("Location: register.php");
            exit();
        }

        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Local Government Document Management System</title>
    <style>
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
            margin-bottom: 10px;
        }

        .remember-me {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .remember-me input {
            margin-right: 10px;
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

        .error {
            color: red;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>LG DOCUMENT MANAGEMENT SYSTEM</h1>
        <img src="logo.jpg" alt="Local Government Logo">

        <form action="login2.php" method="post">
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
