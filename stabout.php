<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="About Local Government Document Management Dashboard">
    <title>About Us - Local Government Document Management Dashboard</title>

    <!-- Stylesheets -->
    <link rel="stylesheet" href="staff.css">
    
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            color: #333;
        }

        .container {
            padding: 20px;
            width: 100%;
            position: relative;
        }

        h1, h2 {
            color: var(--blue);
        }

        .section {
            margin-bottom: 20px;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }

        .navigation {
            background: var(--blue);
            width: 300px;
            height: 100%;
            position: fixed;
            border-right: 10px solid var(--blue);
            overflow: hidden;
            box-shadow: 4px 0 15px rgba(0, 0, 0, 0.2);
            transition: width 0.5s ease;
            z-index: 1000;
        }

        .navigation ul {
            padding: 20px;
            list-style-type: none;
        }

        .navigation li {
            margin: 10px 0;
        }

        .navigation ul li a {
            display: flex;
            align-items: center;
            text-decoration: none;
            color: var(--white);
            padding: 10px;
            border-radius: 30px;
            transition: color 0.3s, background 0.3s;
        }

        .navigation ul li:hover a {
            color: var(--blue);
        }

        .button {
            background-color: var(--blue);
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
        }

        .button:hover {
            background-color: var(--light-blue);
            transform: translate(-2px);
        }
    </style>
</head>

<body class="light-mode">
    <nav class="navigation">
        <ul>
            <li>
                <a href="stabout.php">
                    <span class="icon">
                         <ion-icon name="logo-apple"></ion-icon>
                    </span>
                    <span class="title">Local Gov. Docs</span>
                </a>
            </li>
            <li>
                <a href="staff.php">
                    <span class="icon">
                        <ion-icon name="home-outline"></ion-icon>
                    </span>
                    <span class="title">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="stdoc.php">
                    <span class="icon">
                        <ion-icon name="document-text-outline"></ion-icon>
                    </span>
                    <span class="title">Documents</span>
                </a>
            </li>
            <li>
                <a href="stcat.php">
                    <span class="icon">
                        <ion-icon name="folder-outline"></ion-icon>
                    </span>
                    <span class="title">Categories</span>
                </a>
            </li>
            <li>
                <a href="sttags.php">
                    <span class="icon">
                        <ion-icon name="pricetags-outline"></ion-icon>
                    </span>
                    <span class="title">Tags</span>
                </a>
            </li>
            <li>
                <a href="stversions.php">
                    <span class="icon">
                        <ion-icon name="document-text-outline"></ion-icon>
                    </span>
                    <span class="title">Versions</span>
                </a>
            </li>
           
        </ul>
    </nav>

    <main class="main">
        <div class="container">
            <h1>About Us</h1>
            <div class="section">
                <h2>Overview</h2>
                <p>
                    The Local Government Document Management System is designed to streamline the organization, storage, and retrieval of documents. It provides a centralized platform for managing important documents related to local governance, ensuring that information is easily accessible to authorized users while maintaining security and compliance.
                </p>
            </div>

            <div class="section">
                <h2>Key Features</h2>
                <ul>
                    <li>Document Upload and Management: Users can upload, categorize, and manage documents efficiently.</li>
                    <li>User Management: Admins can add, edit, or remove users and assign roles based on their responsibilities.</li>
                    <li>Search Functionality: A robust search feature allows users to quickly find documents based on various criteria.</li>
                    <li>Activity Tracking: The system logs user activity for accountability and auditing purposes.</li>
                    <li>Responsive Design: The dashboard is accessible on various devices, including smartphones and tablets.</li>
                </ul>
            </div>

            <div class="section">
                <h2>Mission Statement</h2>
                <p>
                    Our mission is to enhance transparency, efficiency, and accessibility in local government operations by providing a user-friendly document management solution. We strive to empower officials and citizens alike with the information they need to make informed decisions.
                </p>
            </div>

            <div class="section">
                <h2>Contact Us</h2>
                <p>If you have any questions or need assistance, please reach out to us:</p>
                <button class="button" onclick="alert('Contact form is not implemented yet.')">Contact Support</button>
            </div>
        </div>
    </main>
    <!-- scripts -->
    <script src="staff.js"></script>
    <script src="https://unpkg.com/ionicons@5.5.2/dist/ionicons.js"></script>
</body>

</html>
