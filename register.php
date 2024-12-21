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

// Process registration form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);
    $firstname = htmlspecialchars($_POST['firstname']);
    $lastname = htmlspecialchars($_POST['lastname']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $userrole = htmlspecialchars($_POST['userrole']);

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Check if the username or email already exists
    $stmt = $conn->prepare("SELECT * FROM Users WHERE Username=? OR Email=?");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // User already exists
        echo "<p class='error'>Username or email already exists. Please use a different one.</p>";
    } else {
        // Insert the new user into the database
        $stmt = $conn->prepare("INSERT INTO Users (Username, Password, FirstName, LastName, Email, Phone, UserRoleID) VALUES (?, ?, ?, ?, ?, ?, ?)");
        
        // Assign UserRoleID based on selection
        $userrole_id = ($userrole == 'admin') ? 7 : 8;
        $stmt->bind_param("ssssssi", $username, $hashed_password, $firstname, $lastname, $email, $phone, $userrole_id);

        if ($stmt->execute()) {
            // Registration successful, redirect to login page
            header("Location: login2.php");
            exit();
        } else {
            echo "<p class='error'>Registration failed. Please try again.</p>";
        }
    }

    $stmt->close();
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }

        .register-container {
            max-width: 400px;
            margin: 0 auto;
            padding: 30px;
            border: 3px solid #ccc;
            border-radius: 5px;
            background-color: #fff;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input, select {
            width: 100%;
            padding: 8px;
            border: 3px solid #ccc;
            border-radius: 3px;
            margin-bottom: 10px;
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
    </style>
</head>
<body>
    <div class="register-container">
        <h1>Registration</h1>
        <form action="register.php" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <label for="firstname">First Name:</label>
            <input type="text" id="firstname" name="firstname" required>
            <label for="lastname">Last Name:</label>
            <input type="text" id="lastname" name="lastname" required>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <label for="phone">Phone Number:</label>
            <input type="tel" id="phone" name="phone" required>
            <label for="userrole">User Role:</label>
            <select id="userrole" name="userrole" required>
                <option value="admin">Admin</option>
                <option value="staff">Staff</option>
            </select>
            <button type="submit">Register</button>
        </form>
    </div>
</body>
</html>
