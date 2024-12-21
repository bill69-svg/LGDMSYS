<?php
include 'session_handler.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Local Government Document Management System - Tags Management Page.">
    <title>Document Management - Tags</title>
    <link rel="stylesheet" href="tags.css">
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

        /* ============ Tags Table Styles ============ */
        .tags-list-section {
            margin-top: 40px;
        }

        .tags-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Added shadow to the table */
        }

        .tags-table th,
        .tags-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid var(--black2); /* Changed to solid for visibility */
        }

        .tags-table th {
            background-color: var(--blue); /* Header background color */
            color: var(--white); /* Header text color */
            font-weight: 600; /* Bold text */
        }

        .tags-table tr:hover {
            background-color: var(--light-blue); /* Highlight row on hover */
        }

        .tags-table td {
            transition: background-color 0.3s; /* Smooth background change */
        }

        /* Buttons */
        .button {
            background-color: var(--blue);
            font-size: 12px;
            color: var(--white);
            padding: 8px 12px;
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
            background-color: lightblue;
            margin-right: 5px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .tags-table th,
            .tags-table td {
                padding: 8px;
                font-size: 14px;
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
                <li class="active">
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
        <main class="main tags-page">
            <!-- Topbar -->
            <div class="topbar">
                <div class="toggle">
                    <ion-icon name="menu-outline"></ion-icon>
                </div>

                <!-- Search bar -->
                <div class="search">
                    <label>
                        <input type="text" placeholder="Search tags">
                        <ion-icon name="search-outline"></ion-icon>
                    </label>
                </div>

                <!-- Theme Toggle Button -->
                <button id="themeToggle" class="button" onclick="toggleTheme()">Toggle Theme</button>
            </div>

            <!-- Tags Upload Section -->
            <section class="upload-section">
                <h3>Add New Tag</h3>
                <button id="addTagButton" class="button">Add Tag</button>
            </section>

            <!-- Tags Table Section -->
            <section class="tags-list-section">
                <h3>Present Tags</h3>
                <table class="tags-table">
                    <thead>
                        <tr>
                            <th>Tag Name</th>
                            <th>Description</th>
                            <th>Created By</th>
                            <th>Date Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Tags will be dynamically generated here -->
                    </tbody>
                </table>
            </section>
        </main>
    </div>

    <!-- Modal for Adding New Tag -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close" id="closeModal">&times;</span>
            <h2>Add New Tag</h2>
            <form id="addTagForm" class="tag-form">
                <div class="form-group">
                    <label for="tagName">Tag Name:</label>
                    <input type="text" id="tagName" name="tagName" placeholder="Enter tag name" required>
                </div>
                <div class="form-group">
                    <label for="description">Description:</label>
                    <input type="text" id="description" name="description" placeholder="Enter tag description" required>
                </div>
                <button type="submit" class="button">Add Tag</button>
            </form>
        </div>
    </div>

    <!-- Modal for Editing Tag -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" id="closeEditModal">&times;</span>
            <h2>Edit Tag</h2>
            <form id="editTagForm" class="tag-form">
                <div class="form-group">
                    <label for="editTagName">Tag Name:</label>
                    <input type="text" id="editTagName" name="tagName" placeholder="Enter tag name" required>
                </div>
                <div class="form-group">
                    <label for="editDescription">Description:</label>
                    <input type="text" id="editDescription" name="description" placeholder="Enter tag description" required>
                </div>
                <input type="hidden" id="editTagId"> <!-- Hidden field for tag ID -->
                <button type="submit" class="button">Save Changes</button>
            </form>
        </div>
    </div>


    <!-- Scripts -->
    <script>
    // Toggle theme function
    function toggleTheme() {
        const body = document.body;
        body.classList.toggle('light-mode');
        body.classList.toggle('dark-mode');
    }

    // Fetch tags on page load
    document.addEventListener("DOMContentLoaded", function () {
        fetchTags();
    });

    function fetchTags() {
        fetch('fetchTags.php')
            .then(response => response.json())
            .then(data => {
                const tbody = document.querySelector('.tags-table tbody');
                tbody.innerHTML = ''; // Clear existing rows
                data.forEach(tag => {
                    const newRow = document.createElement('tr');
                    newRow.innerHTML = `
                        <td>${tag.TagName}</td>
                        <td>${tag.Description}</td>
                        <td>${tag.createdBy}</td>
                        <td>${tag.createdOn}</td>
                        <td>
                            <button class="button edit-button" onclick="editTag(${tag.TagID})">Edit</button>
                            <button class="button delete-button" onclick="deleteTag(${tag.TagID})">Delete</button>
                        </td>
                    `;
                    tbody.appendChild(newRow);
                });
            })
            .catch(error => console.error('Error fetching tags:', error));
    }

    // Show the modal when the button is clicked
    document.getElementById('addTagButton').addEventListener('click', function () {
        document.getElementById('myModal').style.display = 'block';
    });

    // Close the modal
    document.getElementById('closeModal').addEventListener('click', function () {
        document.getElementById('myModal').style.display = 'none';
    });

    // Add tag form submission
    document.getElementById('addTagForm').addEventListener('submit', function (e) {
        e.preventDefault();
        const tagName = document.getElementById('tagName').value;
        const description = document.getElementById('description').value;

        fetch('addTags.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                tagName: tagName,
                description: description
            })
        })
        .then(response => response.json())
        .then(result => {
            alert(result.message);
            fetchTags(); // Refresh the tags list
            document.getElementById('myModal').style.display = 'none'; // Close modal
            this.reset(); // Reset the form
        })
        .catch(error => console.error('Error adding tag:', error));
    });

    // Handle Edit Button Click
    function editTag(tagID) {
        console.log("Fetching data for tagID:", tagID); // Debugging line

        // Fetch tag details from the server
        fetch(`fetchTags.php?tagID=${tagID}`)
            .then(response => response.json())
            .then(data => {
                console.log("Fetched tag data:", data); // Debugging line
                
                // Check if the data was found
                if (!data) {
                    alert("Tag not found.");
                    return;
                }

                // Populate the form with the fetched tag data
                document.getElementById('editTagId').value = data.TagID;
                document.getElementById('editTagName').value = data.TagName;
                document.getElementById('editDescription').value = data.Description;

                // Display the edit modal
                document.getElementById('editModal').style.display = 'block';
            })
            .catch(error => console.error('Error fetching tag details:', error));
    }

    // Close Edit Modal
    document.getElementById('closeEditModal').addEventListener('click', function () {
        document.getElementById('editModal').style.display = 'none';
    });

    // Edit Tag Form Submission
    document.getElementById('editTagForm').addEventListener('submit', function (e) {
        e.preventDefault();
        
        const tagID = document.getElementById('editTagId').value;
        const tagName = document.getElementById('editTagName').value;
        const description = document.getElementById('editDescription').value;

        // Send updated data to the server (using update_tag.php)
        fetch('update_tag.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                tagID: tagID,
                tagName: tagName,
                description: description
            })
        })
        .then(response => response.json())
        .then(result => {
            alert(result.message); // Show success or error message
            fetchTags(); // Refresh the tags list
            document.getElementById('editModal').style.display = 'none'; // Close modal
            this.reset(); // Reset the form
        })
        .catch(error => console.error('Error editing tag:', error));
    });

    // Handle Delete Button Click
    function deleteTag(tagID) {
        if (confirm("Are you sure you want to delete this tag?")) {
            fetch('deleteTag.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ tagID: tagID }) // Send tagID in the JSON body
            })
            .then(response => response.json())
            .then(result => {
                alert(result.message); // Show success or error message
                fetchTags(); // Refresh the tags list
            })
            .catch(error => console.error('Error deleting tag:', error));
        }
    }


</script>

    <script src="samplemain.js"></script>
    <!-- Ionicons -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@6.0.0/dist/ionicons.js"></script>
</body>

</html>
