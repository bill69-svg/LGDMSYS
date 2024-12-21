<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
    <style>
        /* ... your CSS styles ... */
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
            text-align: center; /* Added this line */
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

        .remember-me input {
            margin-right: 10px;
        }

        .remember-me {
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
        <h1>Forgot Password</h1>
        <p>Enter your email address below, and a link will be sent for password reset.</p>
        <form action="" method="post">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br>
            <br><button type="submit">Send Reset Link</button>
        </form>
        <p>Remember your password? <a href="login.php">Login</a></p>
    </div>

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

    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $_POST['email'];

        // Query the database to check if the email exists
        $query = "SELECT id FROM users WHERE email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // User found, generate a password reset token
            $token = bin2hex(random_bytes(32));

            // Store the token in the database (adjust expiration time as needed)
            $insertQuery = "INSERT INTO password_resets (user_id, token, expires_at) VALUES (?, ?, NOW() + INTERVAL 1 DAY)";
            $stmt = $conn->prepare($insertQuery);
            $stmt->bind_param('ss', $userId, $token);
            $stmt->execute();

            // Send the password reset link to the user's email
            $resetLink = "https://yourwebsite.com/reset_password.php?token=" . $token;
            sendEmail($email, $resetLink);

            // Redirect to a success page or display a message indicating that an email has been sent
        } else {
            // User not found, display an error message
        }
    }

    // Function to send the password reset email
    function sendEmail($email, $resetLink) {
        $subject = "Password Reset Request";
        $message = "You requested a password reset. Please click the following link to reset your password: " . $resetLink;

        // Replace with your email server settings
        $headers = "From: your_email@example.com";

        mail($email, $subject, $message, $headers);
    }
    ?>
</body>
</html>