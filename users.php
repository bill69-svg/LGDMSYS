<?php
include 'session_handler.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Local Government Document Management System - Users Management Page.">
    <title>Document Management - Users</title>
    <link rel="stylesheet" href="users.css">
    <style>
        /* Basic modal styling */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0, 0, 0); /* Fallback color */
            background-color: rgba(0, 0, 0, 0.4); /* Black w/ opacity */
        }

        /* Modal Content */
        .modal-content {
            background-color: #fefefe;
            margin: 10% auto; /* Center modal */
            padding: 20px;
            border: 1px solid #888;
            width: 80%; /* Could be more or less, depending on screen size */
            border-radius: 8px; /* Rounded corners */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Shadow effect */
        }

        /* Close button */
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        /* ============ Users Table Styles ============ */
        .user-list-section {
            margin-top: 40px;
        }

        .users-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Added shadow to the table */
        }

        .users-table th,
        .users-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid var(--black2); /* Changed to solid for visibility */
        }

        .users-table th {
            background-color: var(--blue); /* Header background color */
            color: var(--white); /* Header text color */
            font-weight: 600; /* Bold text */
        }

        .users-table tr:hover {
            background-color: var(--light-blue); /* Highlight row on hover */
        }

        .users-table td {
            transition: background-color 0.3s; /* Smooth background change */
        }

    
        .button {
            background-color: var(--blue);
            font-size: 12px;
            color: var(--white);
            padding: 8px 12px; /* More padding for buttons */
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .button:hover {
            background-color: var(--dark-blue); /* Darker blue on hover */
        }

        .edit-button,
        .delete-button {
            background-color: lightblue; /* Green */
            margin-right: 5px;
        }

        .delete-button {
            background-color:  lightblue; /* Red */
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .users-table th,
            .users-table td {
                padding: 8px; /* Less padding on small screens */
                font-size: 14px; /* Smaller font */
            }
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
                <li class="active">
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
        <main class="main users-page">
            <!-- Topbar -->
            <div class="topbar">
                <div class="toggle">
                    <ion-icon name="menu-outline"></ion-icon>
                </div>

                <!-- Search bar -->
                <div class="search">
                    <label>
                        <input type="text" placeholder="Search users">
                        <ion-icon name="search-outline"></ion-icon>
                    </label>
                </div>

                <!-- Theme Toggle Button -->
                <button id="themeToggle" class="button" onclick="toggleTheme()">Toggle Theme</button>
            </div>

            <!-- User Upload Section -->
            <section class="upload-section">
                <h3>Add New User</h3>
                <button id="addUserBtn" class="button">Add User</button>
            </section>

            <!-- Users Table Section -->
            <section class="user-list-section">
                <h3>All Users</h3>
                <table class="users-table">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Role ID</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>john_doe</td>
                            <td>John</td>
                            <td>Doe</td>
                            <td>john@example.com</td>
                            <td>(123) 456-7890</td>
                            <td>1</td>
                            <td>
                                <button class="button edit-button">Edit</button>
                                <button class="button delete-button">Delete</button>
                            </td>
                        </tr>
                        <!-- Additional rows can be dynamically generated here -->
                    </tbody>
                </table>
            </section>
        </main>
    </div>

    <!-- Modal for Adding New User -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close" id="closeModal">&times;</span>
            <h2>Add New User</h2>
            <form id="addUserForm" class="user-form">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" placeholder="Enter username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" placeholder="Enter password" required>
                </div>
                <div class="form-group">
                    <label for="firstName">First Name:</label>
                    <input type="text" id="firstName" name="firstName" placeholder="Enter first name" required>
                </div>
                <div class="form-group">
                    <label for="lastName">Last Name:</label>
                    <input type="text" id="lastName" name="lastName" placeholder="Enter last name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" placeholder="Enter email" required>
                </div>
                <div class="form-group">
                    <label for="phone">Phone:</label>
                    <input type="tel" id="phone" name="phone" placeholder="Enter phone number" required>
                </div>
                <div class="form-group">
                    <label for="userRole">Role:</label>
                    <select id="userRole" name="userRole" required>
                        <option value="1">Admin</option>
                        <option value="2">Staff</option>
                        
                    </select>
                </div>
                <button type="submit" class="button">Add User</button>
            </form>
        </div>
    </div>
   <!-- Modal for Editing User -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" id="closeEditModal">&times;</span>
            <h2>Edit User</h2>
            <form id="editUserForm" class="user-form">
                <input type="hidden" id="editUserId" name="userId"> <!-- Hidden field for User ID -->
                <div class="form-group">
                    <label for="editUsername">Username:</label>
                    <input type="text" id="editUsername" name="username" required>
                </div>
                <div class="form-group">
                    <label for="editFirstName">First Name:</label>
                    <input type="text" id="editFirstName" name="firstName" required>
                </div>
                <div class="form-group">
                    <label for="editLastName">Last Name:</label>
                    <input type="text" id="editLastName" name="lastName" required>
                </div>
                <div class="form-group">
                    <label for="editEmail">Email:</label>
                    <input type="email" id="editEmail" name="email" required>
                </div>
                <div class="form-group">
                    <label for="editPhone">Phone:</label>
                    <input type="tel" id="editPhone" name="phone" required>
                </div>
                <div class="form-group">
                    <label for="editUserRole">Role:</label>
                    <select id="editUserRole" name="userRoleID" required> <!-- Change 'userRole' to 'userRoleID' -->
                        <option value="7">Admin</option>
                        <option value="8">Staff</option>
                    </select>
                </div>
                <button type="submit" class="button">Update User</button>
            </form>
        </div>
    </div>


    <!-- Scripts -->

    <script src="samplemain.js"></script>
   <script>
    // Function to fetch users
    function fetchUsers() {
        fetch('fetchUsers.php')
            .then(response => response.json())
            .then(data => {
                const tbody = document.querySelector('.users-table tbody');
                tbody.innerHTML = ''; // Clear existing table data
                
                data.forEach(user => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${user.Username}</td>
                        <td>${user.FirstName}</td>
                        <td>${user.LastName}</td>
                        <td>${user.Email}</td>
                        <td>${user.Phone}</td>
                        <td>${user.UserRoleID}</td>
                        <td>
                            <button class="button edit-button" onclick="editUser(${user.UserID})">Edit</button>
                            <button class="button delete-button" onclick="deleteUser(${user.UserID})">Delete</button>
                        </td>
                    `;
                    tbody.appendChild(row);
                });
            })
            .catch(error => console.error('Error fetching users:', error));
    }

    // Form submission logic for adding user
    document.getElementById("addUserForm").addEventListener("submit", function (event) {
        event.preventDefault();

        const formData = new FormData(this);
        fetch('addUser.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            fetchUsers(); // Refresh the user list
            modal.style.display = "none"; // Close modal
            this.reset(); // Reset form after submission
        })
        .catch(error => console.error('Error adding user:', error));
    });

    // Delete user function
    function deleteUser(userId) {
        if (confirm("Are you sure you want to delete this user?")) {
            fetch('deleteUser.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `userId=${userId}`
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                fetchUsers(); // Refresh the user list
            })
            .catch(error => console.error('Error deleting user:', error));
        }
    }

    // Search functionality
    document.querySelector('.search input').addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const rows = document.querySelectorAll('.users-table tbody tr');
        
        rows.forEach(row => {
            const username = row.cells[0].textContent.toLowerCase();
            const firstName = row.cells[1].textContent.toLowerCase();
            const lastName = row.cells[2].textContent.toLowerCase();
            
            if (username.includes(searchTerm) || firstName.includes(searchTerm) || lastName.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    // Call fetchUsers on page load
    document.addEventListener('DOMContentLoaded', fetchUsers);

    // Get modal element
    var modal = document.getElementById("myModal");
    // Get open modal button
    var addUserBtn = document.getElementById("addUserBtn");
    // Get close button
    var closeModal = document.getElementById("closeModal");

    // Listen for open click
    addUserBtn.addEventListener("click", function () {
        modal.style.display = "block";
    });

    // Listen for close click
    closeModal.addEventListener("click", function () {
        modal.style.display = "none";
    });

    // Listen for outside click
    window.addEventListener("click", function (event) {
        if (event.target === modal) {
            modal.style.display = "none";
        }
    });

    // Toggle Theme Function
    function toggleTheme() {
        const body = document.body;
        if (body.classList.contains('light-mode')) {
            body.classList.remove('light-mode');
            body.classList.add('dark-mode');
        } else {
            body.classList.remove('dark-mode');
            body.classList.add('light-mode');
        }
    }

    // Open edit modal and populate form
    function editUser(userId) {
        fetch(`getUser.php?userId=${userId}`)
            .then(response => response.json())
            .then(data => {
                // Populate form with user data
                document.getElementById("editUserId").value = data.UserID;
                document.getElementById("editUsername").value = data.Username;
                document.getElementById("editFirstName").value = data.FirstName;
                document.getElementById("editLastName").value = data.LastName;
                document.getElementById("editEmail").value = data.Email;
                document.getElementById("editPhone").value = data.Phone;
                document.getElementById("editUserRole").value = data.UserRoleID;

                // Show modal
                document.getElementById("editModal").style.display = "block";
            })
            .catch(error => console.error('Error fetching user data:', error));
    }

    // Close edit modal
    document.getElementById("closeEditModal").addEventListener("click", function () {
        document.getElementById("editModal").style.display = "none";
    });

    // Submit edit form (using PUT method)
    document.getElementById("editUserForm").addEventListener("submit", function (event) {
    event.preventDefault();

    // Collect form data manually
    const formData = new URLSearchParams({
        userId: document.getElementById("editUserId").value,
        username: document.getElementById("editUsername").value,
        firstName: document.getElementById("editFirstName").value,
        lastName: document.getElementById("editLastName").value,
        email: document.getElementById("editEmail").value,
        phone: document.getElementById("editPhone").value,
        userRoleID: document.getElementById("editUserRole").value
    });

    fetch('editUser.php', {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: formData.toString() // Convert URLSearchParams to a query string
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message); // Show server message
        fetchUsers(); // Refresh the user list
        document.getElementById("editModal").style.display = "none"; // Close modal
    })
    .catch(error => console.error('Error updating user:', error));
});

</script>

    <!-- Ionicons CDN -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script src="https://unpkg.com/ionicons@5.5.2/dist/ionicons.js"></script>
</body>

</html>
