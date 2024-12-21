<?php
include 'session_handler.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Staff Categories Page for managing document categories.">
    <title>Staff Categories</title>

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

        .category-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            border-radius: 10px;
            border: none;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .category-table th,
        .category-table td {
            border: 1px solid var(--border-color);
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid var(--black2);
        }

        .category-table th {
            background-color: var(--blue);
            color: white;
        }

        .category-table tbody tr:hover {
            background-color: var(--light-blue);
        }

        .action-buttons {
            display: flex;
            gap: 10px;
        }

        .add-category-section {
            display: flex;
            justify-content: space-between;
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
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 10% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
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
                <li class="active">
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
                        <input type="text" placeholder="Search categories">
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

            <!-- Add New Category Section -->
            <div class="add-category-section">
                <button class="button" onclick="showAddCategoryModal()">Add New Category</button>
            </div>

            <!-- Categories Table -->
            <table class="category-table">
                <thead>
                    <tr>
                        
                        <th>Category Name</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
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
                            echo "<td>
                                    <div class='action-buttons'>
                                        <!-- View button: Calls JavaScript function with categoryID -->
                                        <button class='button' onclick=\"viewDocuments(" . $row['categoryID'] . ")\">View</button>
                                        <button class='button'>Edit</button>
                                        <button class='button'>Delete</button>
                                    </div>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>No categories found</td></tr>";
                    }

                    $conn->close();
                    ?>
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="pagination">
                <button>&laquo; Prev</button>
                <button>Next &raquo;</button>
            </div>
        </main>
    </div>

    <!-- Modal for Adding New Category -->
    <div id="categoryModal" class="modal">
        <div class="modal-content">
            <span class="close" id="closeCategoryModal">&times;</span>
            <h2>Add New Category</h2>
            <form id="addCategoryForm" class="category-form" action="addCategory.php" method="POST">
                <div class="form-group">
                    <label for="categoryName">Category Name:</label>
                    <input type="text" id="categoryName" name="categoryName" placeholder="Enter category name" required>
                </div>
                <div class="form-group">
                    <label for="description">Description:</label>
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
                <button type="submit" class="submit-button">Add Category</button>
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
    <script src="staff.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script src="https://unpkg.com/ionicons@5.5.2/dist/ionicons.js"></script>
    <script>
        // Modal functionality
        function showAddCategoryModal() {
            document.getElementById('categoryModal').style.display = 'block';
        }

        function closeAddCategoryModal() {
            document.getElementById('categoryModal').style.display = 'none';
        }

        document.getElementById('closeCategoryModal').addEventListener('click', closeAddCategoryModal);

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


    </script>
</body>

</html>
