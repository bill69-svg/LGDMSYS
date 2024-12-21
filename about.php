<?php
include 'session_handler.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="About Local Government Document Management Dashboard">
    <title>About Us - Local Government Document Management Dashboard</title>

    <!-- Stylesheets -->
    <link rel="stylesheet" href="samplestyle.css">
    
    <style>
       

        body {
            margin: 0;
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            color: #333;
            line-height: 1.6;
        }

        .container {
            padding: 30px;
            max-width: 1200px;
            margin: auto;
        }

        h1 {
            color: var(--blue);
            text-align: center;
            margin-bottom: 20px;
        }

        h2 {
            color: var(--blue);
            margin-bottom: 10px;
        }

        .section {
            margin-bottom: 30px;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }

        .navigation {
            background: var(--blue);
            width: 300px;
            height: 100%;
            position: fixed;
            border-right: 5px solid var(--blue);
            overflow: hidden;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.2);
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
            padding: 12px;
            border-radius: 30px;
            transition: color 0.3s, background 0.3s;
        }

        .navigation ul li:hover a {
            background-color: rgba(255, 255, 255, 0.2);
        }

        .button {
            background-color: var(--blue);
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
            display: inline-block;
            text-align: center;
            margin-top: 10px;
        }

        .button:hover {
            background-color: var(--light-blue);
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            .navigation {
                width: 100%;
                position: relative;
                border-right: none;
            }
            .container {
                padding: 15px;
            }
        }
        .form-group {
    margin-bottom: 15px;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
}

.form-group input,
.form-group textarea {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
    transition: border-color 0.3s;
}

.form-group input:focus,
.form-group textarea:focus {
    border-color: var(--blue);
    outline: none;
}
#contactFormContainer {
    margin-top: 15px;
    padding: 15px;
    border-radius: 5px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    background-color: #fff;
}


    </style>
</head>

<body class="light-mode">
    <nav class="navigation">
        <ul>
            <li>
                <a href="#">
                    <span class="icon">
                        <ion-icon name="logo-apple"></ion-icon>
                    </span>
                    <span class="title">Local Gov. Docs</span>
                </a>
            </li>
            <li class="active">
                <a href="sample.php">
                    <span class="icon">
                        <ion-icon name="home-outline"></ion-icon>
                    </span>
                    <span class="title">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="documents.php">
                    <span class="icon">
                        <ion-icon name="document-text-outline"></ion-icon>
                    </span>
                    <span class="title">Documents</span>
                </a>
            </li>
            <li>
                <a href="categories.php">
                    <span class="icon">
                        <ion-icon name="folder-outline"></ion-icon>
                    </span>
                    <span class="title">Categories</span>
                </a>
            </li>
            <li>
                <a href="tags.php">
                    <span class="icon">
                        <ion-icon name="pricetags-outline"></ion-icon>
                    </span>
                    <span class="title">Tags</span>
                </a>
            </li>
            <li>
                <a href="versions.php">
                    <span class="icon">
                        <ion-icon name="document-text-outline"></ion-icon>
                    </span>
                    <span class="title">Versions</span>
                </a>
            </li>
            <li>
                <a href="users.php">
                    <span class="icon">
                        <ion-icon name="people-outline"></ion-icon>
                    </span>
                    <span class="title">Users</span>
                </a>
            </li>
            <li>
                <a href="settings.php">
                    <span class="icon">
                        <ion-icon name="settings-outline"></ion-icon>
                    </span>
                    <span class="title">Settings</span>
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
    <button class="button" id="contactSupportBtn">Contact Support</button>
    
    <div id="contactFormContainer" style="display: none;">
        <h3>Contact Support</h3>
        <p>If you have any questions or need assistance, please fill out the form below:</p>
        <form id="contactForm" action="submit_contact.php" method="POST">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="subject">Subject:</label>
                <input type="text" id="subject" name="subject" required>
            </div>
            <div class="form-group">
                <label for="message">Message:</label>
                <textarea id="message" name="message" rows="4" required></textarea>
            </div>
            <button class="button" type="submit">Send Message</button>
        </form>
    </div>
</div>


                
        </div>
    </main>

    <script src="samplemain.js"></script>
    <script src="https://unpkg.com/ionicons@5.5.2/dist/ionicons.js"></script>
    <script>
    document.getElementById('contactSupportBtn').addEventListener('click', function() {
        var formContainer = document.getElementById('contactFormContainer');
        if (formContainer.style.display === 'none' || formContainer.style.display === '') {
            formContainer.style.display = 'block';
        } else {
            formContainer.style.display = 'none';
        }
    });
</script>

</body>

</html>
