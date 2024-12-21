<?php
include 'session_handler.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Local Government Document Management System - Categories Page.">
    <title>Document Management - Categories</title>

    <!-- Stylesheets -->
    <link rel="stylesheet" href="staff.css">

    <style>
        /* ================== General Styles ================== */
        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .categories-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            border-radius: 10px;
            border: none;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); /* Box shadow for the table */
        }

        .categories-table th,
        .categories-table td {
            border: 1px solid var(--border-color);
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid var(--black2);
        }

        .categories-table th {
            background-color: var(--blue);
            color: white;
        }

        .categories-table tbody tr:hover {
            background-color: var(--light-blue); /* Light blue hover effect */
        }

        .action-buttons {
            display: flex;
            gap: 10px;
        }

        .add-category-section {
            display: flex;
            justify-content: flex-start;
            margin-bottom: 20px;
        }

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

        /* ============ Modal Styles ============ */
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

        .modal-content {
            background-color: #fefefe;
            margin: 10% auto; /* Center modal */
            padding: 20px;
            border: 1px solid #888;
            width: 80%; /* Could be more or less, depending on screen size */
            border-radius: 8px; /* Rounded corners */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Shadow effect */
        }

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

        /* ================== Form Styles ================== */
        .category-form {
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

        .form-group input,
        .form-group textarea {
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
</head>

<body class="light-mode">
    <div class="container">

        <!-- Navigation Section -->
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
                <li class="active">
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
            <!-- Topbar -->
            <div class="topbar">
                <div class="toggle">
                    <ion-icon name="menu-outline"></ion-icon>
                </div>

                <!-- Search bar -->
                <div class="search">
                    <label>
                        <input type="text" placeholder="Search documents">
                        <ion-icon name="search-outline"></ion-icon>
                    </label>
                </div>

                <!-- Theme Toggle Button -->
                <button id="themeToggle" class="button" onclick="toggleTheme()">Toggle Theme</button>
            </div>

            <!-- Add New Category Section -->
            <div class="add-category-section">
                <button id="addCategoryBtn" class="button" onclick="showAddCategoryModal()">Add New Category</button>
            </div>

            <!-- Categories Table -->
            <table class="categories-table">
                <thead>
                    <tr>
                        <th>Category Name</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Dynamically load categories from PHP -->
                    <?php
                    // Database connection
                    $servername = "localhost";
                    $username = "root";
                    $password = ""; // Adjust accordingly
                    $dbname = "lgmsys";

                    $conn = new mysqli($servername, $username, $password, $dbname);

                    // Check connection
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    // Fetch categories
                    $sql = "SELECT categoryID, categoryName, description FROM categories";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['categoryName']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['description']) . "</td>";
                            
                            // Correct use of quotes for the delete button and other buttons
                            echo "<td>
                                    <div class='action-buttons'>
                                        <!-- View button: Calls JavaScript function with categoryID -->
                                        <button class='button' onclick=\"viewDocuments(" . $row['categoryID'] . ")\">View</button>
                                        
                                        <!-- Edit button: Opens modal with category data -->
                                        <button class='button' onclick=\"openEditModal(" . htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8') . ")\">Edit</button>
                                        
                                        <!-- Delete button: Calls delete function with categoryID -->
                                        <button class='button' onclick=\"deleteCategory(" . $row['categoryID'] . ")\">Delete</button>
                                    </div>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3'>No categories found</td></tr>";
                    }
                    $conn->close();
                    ?>
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="pagination">
                <button class="button">Previous</button>
                <button class="button">Next</button>
            </div>
        </main>

    </div>

    <!-- Modal for Add Category -->
    <div id="addCategoryModal" class="modal" style="display: none;">
        <div class="modal-content">
            <span class="close" onclick="closeAddCategoryModal()">&times;</span>
            <!-- Add ID for the title -->
            <h2 id="modalTitle">Add New Category</h2>
            <!-- Add ID for the form -->
            <form id="categoryForm" action="add_category.php" method="POST">
                <div class="form-group">
                    <label for="categoryName">Category Name</label>
                    <input type="text" id="categoryName" name="categoryName" placeholder="Enter category name" required>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" placeholder="Enter category description" rows="4" required></textarea>
                </div>
                <div class="form-group">
                    <label for="createdBy">Created By:</label>
                    <input type="text" id="createdBy" name="createdBy" placeholder="Your name" required>
                </div>
                <div class="form-group">
                    <label for="dateCreated">Date Created:</label>
                    <input type="date" id="dateCreated" name="dateCreated" required>
                </div>
                <!-- Add ID for the submit button -->
                <button type="button" id="submitButton" class="submit-button">Add Category</button>
            </form>
        </div>
    </div>

    <!-- Edit Category Modal -->
    <div id="categoryModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeEditModal()">&times;</span>
            <h2>Edit Category</h2>
            <form id="editCategoryForm" method="POST" class="category-form">
            <input type="hidden" id="categoryID" name="categoryID">
            <div class="form-group">
                <label for="categoryName">Category Name:</label>
                <input type="text" id="categoryName" name="categoryName" placeholder="Enter category name" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea id="description" name="description" placeholder="Enter category description" rows="4" required></textarea>
            </div>
            <button type="button" id="updateCategoryButton" class="submit-button">Update Category</button>
        </form>

        </div>
    </div>

    <!-- Modal to display documents -->
    <div id="documentModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeDocumentModal()">&times;</span>
            <h2>Loading Documents...</h2>
        </div>
    </div>


    <!-- Scripts -->
    <script src="samplemain.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script src="https://unpkg.com/ionicons@5.5.2/dist/ionicons.js"></script>


    <script>
    // Toggle Theme
    function toggleTheme() {
        document.body.classList.toggle('dark-mode');
    }

    // Open Add Category Modal
    function showAddCategoryModal() {
        const modalTitle = document.getElementById('modalTitle');
        const submitButton = document.getElementById('submitButton');
        const categoryForm = document.getElementById('categoryForm');
        const addCategoryModal = document.getElementById('addCategoryModal');

        // Update modal title
        if (modalTitle) modalTitle.innerText = "Add Category";

        // Update button text and bind the addCategory function
        if (submitButton) {
            submitButton.innerText = "Add Category";
            submitButton.setAttribute('onclick', 'addCategory()');
        }

        // Reset form
        if (categoryForm) categoryForm.reset();

        // Show modal
        if (addCategoryModal) addCategoryModal.style.display = "block";
    }

    // Close Add Category Modal
    function closeAddCategoryModal() {
        const addCategoryModal = document.getElementById('addCategoryModal');
        if (addCategoryModal) addCategoryModal.style.display = "none";
    }

    // Add Category (AJAX Submission)
    function addCategory() {
        const form = document.getElementById('categoryForm');

        // Check if the form is valid
        if (form.checkValidity()) {
            // Create a FormData object to send form data
            const formData = new FormData(form);

            // Create AJAX request
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'addCategory.php', true);

            // Set up event listener for when the request finishes
            xhr.onload = function () {
                if (xhr.status === 200) {
                    alert('Category added successfully!');
                    closeAddCategoryModal(); // Close the modal after successful submission
                } else {
                    alert('Error adding category.');
                }
            };

            // Send the form data via AJAX
            xhr.send(formData);
        } else {
            alert("Please fill out all required fields.");
        }
    }

    // Show Documents related to Category
    function viewDocuments(categoryID) {
        console.log("Fetching documents for category " + categoryID);

        const url = `get_documents.php?categoryID=${categoryID}`;

        fetch(url)
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    displayDocuments(data.documents);
                } else {
                    alert(data.message || "Failed to fetch documents.");
                }
            })
            .catch((error) => {
                console.error("Error fetching documents:", error);
            });
    }

    // Open Edit Modal
    function openEditModal(categoryData) {
        console.log(categoryData); // Debugging to see data in the modal

        document.getElementById('modalTitle').innerText = "Edit Category";
        document.getElementById('submitButton').innerText = "Update Category";
        document.getElementById('submitButton').setAttribute('onclick', 'updateCategory()'); // Bind the Update function

        // Populate form fields with category data
        document.getElementById('categoryID').value = categoryData.categoryID;
        document.getElementById('categoryName').value = categoryData.categoryName;
        document.getElementById('description').value = categoryData.description;

        document.getElementById('categoryModal').style.display = "block"; // Show the modal when editing
    }

    // Close Edit Modal
    function closeEditModal() {
        document.getElementById('categoryModal').style.display = "none";
    }

    // Function to submit the updated category using PUT request
    function updateCategory() {
        // Get form values
        const categoryID = document.getElementById('categoryID').value;
        const categoryName = document.getElementById('categoryName').value;
        const categoryDescription = document.getElementById('description').value;

        // Ensure the ID exists
        if (!categoryID) {
            alert('Category ID is missing!');
            return;
        }

        // Create data object
        const data = {
            name: categoryName,
            description: categoryDescription
        };

        // Perform the PUT request
        fetch(`http://localhost/lgdmsys-api/api.php/categories/${categoryID}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(result => {
            if (result.message) {
                alert('Category updated successfully!');
                closeEditModal(); // Close the modal
                location.reload(); // Reload the page or update UI
            } else if (result.error) {
                alert(`Error: ${result.error}`);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while updating the category.');
        });
    }

    // Delete Category
    function deleteCategory(categoryID) {
        if (confirm('Are you sure you want to delete this category?')) {
            window.location.href = 'delete_category.php?id=' + categoryID;
        }
    }

    // Display fetched documents in a modal
    function displayDocuments(documents) {
        // Select the modal and its content
        const modal = document.getElementById("documentModal");
        const modalContent = modal.querySelector(".modal-content");

        // Check if modal and content exist
        if (!modal || !modalContent) {
            console.error("Modal or modal content element not found.");
            return;
        }

        // Clear existing modal content
        modalContent.innerHTML = `
            <span class="close" onclick="closeDocumentModal()">&times;</span>
            <h2>Documents</h2>
        `;

        if (documents && documents.length > 0) {
            // Loop through documents and add their details to the modal
            documents.forEach((doc) => {
                const documentHTML = `
                    <div class="document-item">
                        <h3>${doc.documentTitle}</h3>
                        <p>Type: ${doc.documentType}</p>
                        <p>Status: ${doc.Status}</p>
                        <p>Created On: ${doc.creationDate}</p>
                        <p>Last Modified: ${doc.lastModifiedDate}</p>
                    </div>
                    <hr>
                `;
                modalContent.innerHTML += documentHTML;
            });
        } else {
            // If no documents are found
            modalContent.innerHTML += "<p>No documents found for this category.</p>";
        }

        // Display the modal
        modal.style.display = "block";
    }

    // Close Document Modal
    function closeDocumentModal() {
        const modal = document.getElementById("documentModal");
        if (modal) {
            modal.style.display = "none";
        }
    }

    // Close the modal when the user clicks outside it
    window.onclick = function (event) {
        const modal = document.getElementById("documentModal");
        if (event.target === modal) {
            closeDocumentModal();
        }
    };
</script>
  
</body>

</html>
