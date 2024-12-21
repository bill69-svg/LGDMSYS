<?php
include 'session_handler.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Local Government Document Management System - Versions Page.">
    <title>Document Management - Versions</title>
    <link rel="stylesheet" href="versions.css">
</head>

<body class="light-mode">
    <div class="container">

        <!-- Navigation Section -->
        <nav class="navigation">
            <ul>
                <li><a href="about.php"><span class="icon"><ion-icon name="logo-apple"></ion-icon></span><span class="title">Local Gov. Docs</span></a></li>
                <li><a href="sample.php"><span class="icon"><ion-icon name="home-outline"></ion-icon></span><span class="title">Dashboard</span></a></li>
                <li><a href="documents.php"><span class="icon"><ion-icon name="document-text-outline"></ion-icon></span><span class="title">Documents</span></a></li>
                <li><a href="categories.php"><span class="icon"><ion-icon name="folder-outline"></ion-icon></span><span class="title">Categories</span></a></li>
                <li><a href="tags.php"><span class="icon"><ion-icon name="pricetags-outline"></ion-icon></span><span class="title">Tags</span></a></li>
                <li class="active"><a href="versions.php"><span class="icon"><ion-icon name="document-text-outline"></ion-icon></span><span class="title">Versions</span></a></li>
                <li><a href="users.php"><span class="icon"><ion-icon name="people-outline"></ion-icon></span><span class="title">Users</span></a></li>
                <li><a href="settings.php"><span class="icon"><ion-icon name="settings-outline"></ion-icon></span><span class="title">Settings</span></a></li>
            </ul>
        </nav>

        <!-- Main Content Section -->
        <main class="main versions-page">
            <!-- Topbar -->
            <div class="topbar">
                <div class="toggle"><ion-icon name="menu-outline"></ion-icon></div>
                <div class="search">
                    <label>
                        <input type="text" placeholder="Search versions">
                        <ion-icon name="search-outline"></ion-icon>
                    </label>
                </div>
                <button id="themeToggle" class="button" onclick="toggleTheme()">Toggle Theme</button>
            </div>

            <!-- Versions Section -->
            <section class="versions-section">
                <h3>Document Versions</h3>
                <button id="addVersionBtn" class="button">Add New Version</button>
                <table class="versions-table">
                    <thead>
                        <tr>
                            <th>Version Number</th>
                            <th>Document Name</th>
                            <th>Date Modified</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Versions will be populated here -->
                    </tbody>
                </table>
            </section>
        </main>
    </div>

    <!-- Modal for Adding New Version -->
    <div id="addVersionModal" class="modal">
        <div class="modal-content">
            <span class="close" id="closeModal">&times;</span>
            <h2>Add New Version</h2>
            <form id="addVersionForm" class="version-form">
                <div class="form-group">
                    <label for="versionName">Version Name:</label>
                    <input type="text" id="versionName" name="versionName" required>
                </div>
                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea id="description" name="description" rows="4" required></textarea>
                </div>
                <div class="form-group">
                    <label for="createdBy">Created By:</label>
                    <input type="text" id="createdBy" name="createdBy" required>
                </div>
                <div class="form-group">
                    <label for="dateCreated">Date Created:</label>
                    <input type="date" id="dateCreated" name="dateCreated" required>
                </div>
                <button type="submit" class="submit-button">Add Version</button>
            </form>
        </div>
    </div>

        <!-- Modal Structure -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Version Details</h3>
                <span class="close" onclick="closeModal()">&times;</span>
            </div>
            <div class="modal-body">
                <p>Version Content Goes Here.</p>
            </div>
            <div class="modal-footer">
                <button onclick="closeModal()">Close</button>
            </div>
        </div>
    </div>

    <!-- Trigger Button -->
    <button onclick="openModal()">View Version</button>


    <!-- Scripts -->
    <script src="samplemain.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script src="https://unpkg.com/ionicons@5.5.2/dist/ionicons.js"></script>

    <script>
        // Fetch versions on page load
document.addEventListener("DOMContentLoaded", function () {
    fetchVersions();
});

function fetchVersions() {
    fetch('fetchVersions.php')
        .then(response => response.json())
        .then(data => {
            const tbody = document.querySelector('.versions-table tbody');
            tbody.innerHTML = ''; // Clear existing rows
            data.forEach(version => {
                const newRow = document.createElement('tr');
                newRow.innerHTML = `
                    <td>${version.VersionNumber}</td>
                    <td>${version.DocumentID}</td> <!-- Display Document ID -->
                    <td>${version.VersionDate}</td>
                    <td>
                        <button class="button" onclick="viewVersion(${version.VersionID})">View</button>
                        <button class="button" onclick="deleteVersion(${version.VersionID})">Delete</button>
                    </td>
                `;
                tbody.appendChild(newRow);
            });
        })
        .catch(error => console.error('Error fetching versions:', error));
}

// Delete Version Function
function deleteVersion(versionID) {
    console.log("Version ID to delete:", versionID);  // Log the versionID to confirm it's passed correctly

    if (!versionID) {
        alert("Version ID is missing!");
        return;
    }

    const confirmation = confirm("Are you sure you want to delete this version?");
    if (confirmation) {
        fetch('deleteVersion.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ versionID: versionID })
        })
        .then(response => response.json())
        .then(result => {
            alert(result.message); // Show success or error message
            fetchVersions(); // Refresh the versions list after deletion
        })
        .catch(error => console.error('Error deleting version:', error));
    }
}

// Handle adding new version
document.getElementById('addVersionForm').addEventListener('submit', function (e) {
    e.preventDefault();
    const formData = new FormData(this);
    const data = {
        versionName: formData.get('versionName'),
        description: formData.get('description'),
        createdBy: formData.get('createdBy'),
        dateCreated: formData.get('dateCreated'),
    };

    fetch('addVersion.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(result => {
        alert(result.message);
        fetchVersions(); // Refresh the versions list
        this.reset(); // Reset form after submission
        modal.style.display = "none"; // Close the modal
    })
    .catch(error => console.error('Error adding version:', error));
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

// Modal functionality for add version
const modal = document.getElementById("addVersionModal");
const addVersionBtn = document.getElementById("addVersionBtn");
const closeModalBtn = document.getElementById("closeModal");

// Open the modal
addVersionBtn.onclick = function () {
    modal.style.display = "block";
}

// Close the modal
closeModalBtn.onclick = function () {
    modal.style.display = "none";
}

// Close the modal when clicking outside of it
window.onclick = function (event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

// Handle viewing version details
function viewVersion(versionID) {
    fetch('viewVersion.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ versionID: versionID })
    })
    .then(response => response.json())
    .then(data => {
        if (data.message) {
            alert(data.message); // Display error message if any
        } else {
            // Display version details in a modal or container
            showVersionModal(data);
        }
    })
    .catch(error => console.error('Error fetching version details:', error));
}

// Function to display version details in a modal
function showVersionModal(version) {
    // Target the modal-body for displaying version details
    const modalBody = document.querySelector('.modal-body');
    
    if (modalBody) {
        modalBody.innerHTML = `
            <p><strong>Version Number:</strong> ${version.VersionNumber}</p>
            <p><strong>Document Name:</strong> ${version.DocumentName}</p>
            <p><strong>Version Date:</strong> ${version.VersionDate}</p>
            <p><strong>Version Content:</strong> ${version.VersionContent}</p>
            <p><strong>Author:</strong> ${version.AuthorUserId}</p>
            <p><strong>Comments:</strong> ${version.Comments}</p>
            <p><strong>Created By:</strong> ${version.createdBy}</p>
            <p><strong>Created On:</strong> ${version.createdOn}</p>
        `;
    } else {
        console.error("Error: The modal body '.modal-body' is not found in the HTML.");
    }

    // Show the modal
    const versionModal = document.getElementById('myModal');
    if (versionModal) {
        versionModal.style.display = "block";
    } else {
        console.error("Error: The version modal '#myModal' is not found in the HTML.");
    }
}

// Function to close the version modal
function closeVersionModal() {
    const versionModal = document.getElementById('myModal');
    if (versionModal) {
        versionModal.style.display = "none";
    }
}

// Close the version modal when clicking outside of it
window.onclick = function (event) {
    const versionModal = document.getElementById('myModal');
    if (event.target == versionModal) {
        versionModal.style.display = "none";
    }
}


    </script>
</body>

</html>
