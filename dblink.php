<!DOCTYPE html>
<html>
<head>
    <title>Local Government Document Management System</title>
    <h1>LG DOCUMENT MANAGMENT SYSTEM</h1>
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
        <img src="logo.jpg" alt="Local Government Logo"><br>
        
        <form action="login.php" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br>
            <div class="remember-me"><br>
                <input type="checkbox" id="remember" name="remember"><br>
                <label for="remember">Remember me</label>
            </div>
            <button type="submit">Login</button>
        </form>
        <p>Forgot your password? <a href="forgot.php">Click here</a></p>
        <p>&copy; 2023 Local Government. All rights reserved.</p>
    </div>
</body>
</html>