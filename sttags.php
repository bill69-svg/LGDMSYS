<?php
include 'session_handler.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Staff Tags Page for managing document tags.">
    <title>Staff Tags</title>

    <!-- Stylesheets -->
    <link rel="stylesheet" href="staff.css">
</head>

<style>
    /* Topbar Styles */
    .topbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }

    /* Tags Table Styles */
    .tags-list-section {
        margin-top: 40px;
    }

    .tags-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        border-radius: 10px;
        border: none;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); /* Box shadow for the table */
    }

    .tags-table th,
    .tags-table td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid var(--black2);
    }

    /* Header Styles */
    .tags-table thead th {
        background-color: var(--blue); /* Blue header background */
        color: white; /* Header text color */
        font-weight: bold;
        border: none;
    }

    /* Table Row Styles */
    .tags-table tbody tr {
        background-color: var(--white); /* Normal row background */
    }

    .tags-table tbody tr:hover {
        background-color: var(--light-blue); /* Light blue hover effect */
    }

    /* Action Buttons */
    .action-buttons .button {
        background-color: var(--blue); /* blue button */
        color: white;
        border: none;
        padding: 6px 12px;
        margin-right: 5px;
        cursor: pointer;
        border-radius: 5px;
    }

    .action-buttons .button:hover {
        background-color: var(--lightblue); /* Darker lightblue on hover */
    }

    .action-buttons .delete {
        background-color: var(--red); /* red button for delete */
    }

    .action-buttons .delete:hover {
        background-color: var(--lightred); /* Darker red on hover */
    }

    /* Pagination Styles */
    .pagination {
        margin-top: 20px;
        display: flex;
        justify-content: center;
    }

    .pagination button {
        padding: 8px 12px;
        margin: 0 5px;
        border: none;
        background-color: var(--button-bg-color);
        color: white;
        border-radius: 4px;
        cursor: pointer;
    }

    /* Modal Styles */
    .modal {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 1; /* Sit on top */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgba(0, 0, 0, 0.5); /* Black w/ opacity */
    }

    .modal-content {
        background-color: var(--white);
        margin: 15% auto; /* Center modal */
        padding: 20px;
        border: 1px solid var(--border-color);
        width: 80%; /* Could be more or less, depending on screen size */
        border-radius: 8px; /* Rounded corners */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Shadow effect */
    }

    .close {
        color: var(--secondary-color);
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: var(--black);
        text-decoration: none;
        cursor: pointer;
    }

    /* Form Styles */
    .tags-form {
        display: flex;
        flex-direction: column;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        margin-bottom: 5px;
        font-weight: bold;
    }

    .form-group input {
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        width: 100%;
    }

    .submit-button {
        padding: 10px 15px;
        background-color: var(--blue);
        color: var(--white);
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
        transition: background-color 0.3s;
    }

    .submit-button:hover {
        background-color: var(--light-blue);
    }
</style>

<body class="light-mode">
    <div class="container">
        <!-- Navigation Section -->
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
                <li class="active">
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

        <!-- Main Content Section -->
        <main class="main">
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

                <!-- User Profile Dropdown -->
                <div class="dropdown">
                    <img src="google.jpg" alt="Profile Picture" style="cursor:pointer; border-radius: 50%; width: 40px; height: 40px;">
                </div>
            </div>

            <!-- Add New Tag Section -->
            <div class="add-tag-section">
                <button class="button" onclick="showAddTagModal()">Add New Tag</button>
            </div>

            <!-- Tags Table -->
            <section class="tags-list-section">
                <h3>Present Tags</h3>
                <table class="tags-table">
                    <thead>
                        <tr>
                            <th>Tag ID</th>
                            <th>Tag Name</th>
                            <th>Description</th>
                            <th>Document Count</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="tagsTableBody">
                        <!-- Tags will be dynamically populated here -->
                    </tbody>
                </table>
            </section>

            <!-- Pagination -->
            <div class="pagination">
                <button>&laquo; Prev</button>
                <button>Next &raquo;</button>
            </div>
        </main>
    </div>

    <!-- Add Tag Modal -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close" id="closeModal">&times;</span>
            <h2>Add New Tag</h2>
            <form id="addTagForm" class="tags-form">
                <div class="form-group">
                    <label for="tagName">Tag Name:</label>
                    <input type="text" id="tagName" name="tagName" placeholder="Enter tag name" required>
                </div>
                <div class="form-group">
                    <label for="description">Description:</label>
                    <input type="text" id="description" name="description" placeholder="Enter tag description" required>
                </div>
                <button type="submit" class="submit-button">Add Tag</button>
            </form>
        </div>
    </div>

    <!-- scripts -->
    <script src="staff.js"></script>
    <script src="https://unpkg.com/ionicons@5.5.2/dist/ionicons.js"></script>
    <script>
        // Modal functionality
        function showAddTagModal() {
            document.getElementById("myModal").style.display = "block";
        }

        function closeAddTagModal() {
            document.getElementById("myModal").style.display = "none";
        }

        // Fetch tags on page load
        document.addEventListener("DOMContentLoaded", function () {
            fetchTags();
        });

        function fetchTags() {
            fetch('fetchTags.php') // Make sure the path to your PHP file is correct
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok ' + response.statusText);
                    }
                    return response.json();
                })
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
                                <button class="button edit-button">Edit</button>
                                <button class="button delete-button">Delete</button>
                            </td>
                        `;
                        tbody.appendChild(newRow);
                    });
                })
                .catch(error => console.error('Error fetching tags:', error));
        }
        // Add tag form submission
        document.getElementById("addTagForm").addEventListener("submit", async function (event) {
            event.preventDefault();
            const tagName = document.getElementById("tagName").value;
            const description = document.getElementById("description").value;

            try {
                const response = await fetch('/api/tags', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ name: tagName, description })
                });

                if (response.ok) {
                    alert("Tag added successfully!");
                    fetchTags(); // Refresh the tags list
                    closeAddTagModal();
                } else {
                    alert("Error adding tag.");
                }
            } catch (error) {
                console.error('Error adding tag:', error);
            }
        });

        // Edit tag functionality (example)
        function editTag(tagId) {
            // Fetch the tag details, populate the form, and show modal (to be implemented)
        }

        // Delete tag functionality (example)
        async function deleteTag(tagId) {
            if (confirm("Are you sure you want to delete this tag?")) {
                try {
                    const response = await fetch(`/api/tags/${tagId}`, { method: 'DELETE' });
                    if (response.ok) {
                        alert("Tag deleted successfully!");
                        fetchTags(); // Refresh the tags list
                    } else {
                        alert("Error deleting tag.");
                    }
                } catch (error) {
                    console.error('Error deleting tag:', error);
                }
            }
        }

        // Initial fetch of tags
        fetchTags();

        // Close modal
        document.getElementById("closeModal").onclick = closeAddTagModal;
        window.onclick = function (event) {
            if (event.target == document.getElementById("myModal")) {
                closeAddTagModal();
            }
        };
    </script>
</body>

</html>
