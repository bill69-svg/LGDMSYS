<?php
include 'session_handler.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="User Profile Page for Local Government Document Management Dashboard.">
    <title>User Profile - Local Government Document Management Dashboard</title>

    <!-- Stylesheets -->
    <link rel="stylesheet" href="samplestyle.css">

    <style>
        /* Global Styles */
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            transition: background-color 0.3s, color 0.3s;
        }

        /* Light Mode Styles */
        .light-mode {
            background-color: #f8f9fa;
            color: #000000;
        }

        /* Dark Mode Styles */
        .dark-mode {
            background-color: #121212;
            color: #ffffff;
        }

        /* Navigation Styles */
        .navigation {
            background: var(--blue);
            width: 300px;
            height: 100%;
            position: fixed;
            border-left: 10px solid var(--blue);
            overflow: hidden;
            box-shadow: 4px 0 15px rgba(0, 0, 0, 0.2);
            transition: width 0.5s ease;
        }

        .navigation ul {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            padding: 20px;
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

        .navigation ul li a:hover {
            color: var(--blue);
        }

        /* Main Content Styles */
        .main {
            position: absolute;
            width: calc(100% - 300px);
            left: 300px;
            min-height: 100vh;
            background: var(--white);
            transition: width 0.5s ease, left 0.5s ease;
            padding: 20px;
            box-sizing: border-box;
        }

        /* Profile Section Styles */
        .profile-section {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin: 10px;
        }

        .profile-title {
            font-size: 24px;
            margin-bottom: 20px;
            font-weight: bold;
        }

        .profile-info {
            margin-bottom: 20px;
        }

        .profile-info label {
            font-weight: bold;
            margin-right: 10px;
        }

        .activity-section {
            margin-top: 40px;
        }

        .activity-log {
            max-height: 200px;
            overflow-y: auto;
            background-color: #eee;
            padding: 10px;
            border-radius: 5px;
            list-style: none;
        }

        .activity-log li {
            padding: 5px 0;
            border-bottom: 1px solid #ddd;
        }

        /* Button Styles */
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

        /* Modal Styles */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1000; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0, 0, 0); /* Fallback color */
            background-color: rgba(0, 0, 0, 0.4); /* Black w/ opacity */
            padding-top: 60px;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto; /* 15% from the top and centered */
            padding: 20px;
            border: 1px solid #888;
            border-radius: 8px;
            width: 400px; /* Could be more or less, depending on screen size */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .modal h2 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .modal label {
            display: block;
            margin: 10px 0 5px;
        }

        .modal input[type="text"],
        .modal input[type="email"],
        .modal input[type="tel"],
        .modal input[type="file"],
        .modal select {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .modal .button {
            width: 100%;
        }
    </style>
</head>

<body class="light-mode">
    <div class="container">

        <!-- Navigation Section -->
        <nav class="navigation">
            <ul>
                <li>
                    <a href="about.php">
                        <span class="icon">
                            <ion-icon name="logo-apple"></ion-icon>
                        </span>
                        <span class="title">Local Gov. Docs</span>
                    </a>
                </li>
                <li>
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

        <!-- Main Content Section -->
        <main class="main">
            <div class="profile-section">
                <h2 class="profile-title">User Profile</h2>
                <div class="profile-info">
                    <label for="userName">Name:</label>
                    <span id="userName"></span> <!-- This will now display the full name -->
                </div>
                <div class="profile-info">
                    <label for="userEmail">Email:</label>
                    <span id="userEmail"></span>
                </div>
                <div class="profile-info">
                    <label for="userRole">Role:</label>
                    <span id="userRole"></span>
                </div>
                <div class="profile-info">
                    <label for="userStatus">Status:</label>
                    <span id="userStatus"></span>
                </div>

                <button class="button" onclick="editProfile()">Edit Profile</button>
                <button class="button" onclick="changePassword()">Change Password</button>
            </div>
        </main>
    </div>

    <!-- Modal for Edit Profile -->
    <div id="editProfileModal" class="modal">
        <div class="modal-content">
            <h2>Edit Profile</h2>
            <form id="editProfileForm">
                <label for="firstName">First Name:</label>
                <input type="text" id="firstName" value="John" required>

                <label for="lastName">Last Name:</label>
                <input type="text" id="lastName" value="Doe" required>

                <label for="userName">Username:</label>
                <input type="text" id="userName" value="John Doe" required>

                <label for="email">Email:</label>
                <input type="email" id="email" value="johndoe@example.com" required>

                <label for="phone">Phone Number:</label>
                <input type="tel" id="phone" value="+123456789" required>

                <label for="profilePicture">Profile Picture:</label>
                <input type="file" id="profilePicture">
                
                <label for="role">Role:</label>
                <select id="role" required>
                    <option value="" selected>Admin</option>
                    <option value="">Staff</option>
                </select>

                <label for="status">Status:</label>
                <select id="status" required>
                    <option value="active" selected>Active</option>
                    <option value="inactive">Inactive</option>
                </select>

                <button type="button" class="button" onclick="saveChanges()">Save Changes</button>
            </form>
        </div>
    </div>

    <!-- Ionicons CDN -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script src="https://unpkg.com/ionicons@5.5.2/dist/ionicons.js"></script>
    <script>
 // Function to fetch the logged-in user's profile data
 function fetchUserProfile() {
            fetch('fetchCurrentUser.php') // Call the new PHP script
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        console.error('Error fetching user profile:', data.error);
                        return;
                    }
                    // Populate the profile information in the HTML
                    document.getElementById('userName').textContent = data.name; // Adjust field names as necessary
                    document.getElementById('userEmail').textContent = data.email;
                    document.getElementById('userRole').textContent = data.role;
                    document.getElementById('userStatus').textContent = data.status;
                })
                .catch(error => console.error('Error fetching user profile:', error));
        }

        // Call the function to fetch user profile on page load
        window.onload = fetchUserProfile;


        function editProfile() {
            // Show the modal
            document.getElementById('editProfileModal').style.display = 'block';
        }

        function changePassword() {
            // Redirect to change password page
            window.location.href = 'http://localhost/lgdmsys/forgot.php'; // Change to your change password page
        }

        function saveChanges() {
            // Logic to save changes
            alert('Changes saved!');
            document.getElementById('editProfileModal').style.display = 'none'; // Hide the modal after saving
        }

        // Close the modal when the user clicks outside of it
        window.onclick = function(event) {
            const modal = document.getElementById('editProfileModal');
            if (event.target === modal) {
                modal.style.display = "none";
            }
        }
    </script>
</body>

</html>
