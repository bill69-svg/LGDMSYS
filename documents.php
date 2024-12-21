<?php
include 'session_handler.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Local Government Document Management System - Document Page.">
    <title>Document Management - Documents</title>
    <link rel="stylesheet" href="samplestyle.css">
    <style>
    #editDocumentModal {
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.5); /* Dark background with some opacity */
}

.modal-content {
    background-color: #ffffff; /* White background for the modal content */
    margin: 10% auto; /* Center the modal */
    padding: 20px; /* Padding around the content */
    border-radius: 5px; /* Rounded corners */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Shadow for depth */
    width: 80%; /* Width of the modal */
    max-width: 600px; /* Maximum width for larger screens */
}

.modal-content form {
    display: flex;
    flex-direction: column; /* Stack items vertically */
    gap: 15px; /* Space between form fields */
}

.modal-content label {
    font-size: 14px;
    font-weight: 500;
}

.modal-content input[type="text"],
.modal-content input[type="date"],
.modal-content select {
    width: 100%; /* Full width */
    padding: 10px;
    border-radius: 5px;
    border: 1px solid var(--black2);
    background-color: var(--white);
    transition: border-color 0.3s;
}

.modal-content input[type="text"]:focus,
.modal-content input[type="date"]:focus,
.modal-content select:focus {
    border-color: var(--blue);
}

.modal-content button {
    padding: 10px 20px;
    background-color: var(--blue);
    border: none;
    border-radius: 5px;
    color: var(--white);
    cursor: pointer;
    transition: background-color 0.3s;
}

.modal-content button:hover {
    background-color: var(--accent-color);
}

/* Optional: Add some styles to close button, if you have one */
.modal-content .close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.modal-content .close:hover,
.modal-content .close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}

/* Add styles for the modal header if needed */
.modal-header {
    padding: 10px;
    background-color: var(--blue);
    color: white;
    text-align: center;
}

/* Add styles for the modal footer if needed */
.modal-footer {
    padding: 10px;
    text-align: right;
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
                <li class="active">
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
        <main class="main documents-page">
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

            <!-- Document Upload Section -->
            <section class="upload-section">
                <h3>Upload New Document</h3>
                <form id="uploadDocumentForm" method="post" enctype="multipart/form-data">
                <label for="documentTitle">Document Title</label>
                <input type="text" id="documentTitle" name="documentTitle" placeholder="Enter document title" required>

                <label for="documentType">Document Type</label>
                <select id="documentType" name="documentType" required>
                    <option value="" disabled selected>Select document type</option>
                    <option value="Meeting Minutes">Meeting Minutes</option>
                    <option value="Policy">Policy</option>
                    <option value="Report">Report</option>
                    <option value="Legal Document">Legal Document</option>
                    <option value="Public Notice">Public Notice</option>
                    <option value="Internal Memo">Internal Memo</option>
                    <option value="Proposal/Plan">Proposal/Plan</option>
                    <option value="Research Study">Research Study</option>
                    <option value="Grant Application">Grant Application</option>
                    <option value="Citizen Feedback/Complaint">Citizen Feedback/Complaint</option>
                    <option value="Other">Other</option>
                </select>

                <label for="authorUserId">Author (User ID)</label>
                <input type="text" id="authorUserId" name="authorUserId" placeholder="Enter author User ID">

                <label for="creationDate">Creation Date</label>
                <input type="date" id="creationDate" name="creationDate" required>

                <label for="lastModifiedDate">Last Modified Date</label>
                <input type="date" id="lastModifiedDate" name="lastModifiedDate" required>

                <label for="documentContent">Select File</label>
                <input type="file" id="documentContent" name="documentContent" accept=".pdf,.doc,.docx,.txt" required>

                <label for="documentStatus">Status</label>
                <select id="documentStatus" name="documentStatus" required>
                    <option value="Draft">Draft</option>
                    <option value="Under Review">Under Review</option>
                    <option value="Approved">Approved</option>
                    <option value="Rejected">Rejected</option>
                    <option value="Published">Published</option>
                    <option value="Archived">Archived</option>
                    <option value="In Revision">In Revision</option>
                    <option value="Pending">Pending</option>
                    <option value="Canceled">Canceled</option>
                    <option value="In Progress">In Progress</option>
                </select>

                <label for="categoryID">Category</label>
                <select id="createCategoryID" name="categoryID" required>
                    <option value="" disabled selected>Select Category</option>
                    <?php include 'category_dropdown.php'; ?>
                </select>

                <button type="submit" class="button">Upload</button>
            </form>

                <?php
                // PHP code to handle form submission and file upload
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Database connection
                $mysqli = new mysqli('localhost', 'root', '', 'lgmsys');

                if ($mysqli->connect_error) {
                    die('Database connection failed: ' . $mysqli->connect_error);
                }

                // Get form data
                $documentTitle = $_POST['documentTitle'];
                $documentType = $_POST['documentType'];
                $authorUserId = !empty($_POST['authorUserId']) ? $_POST['authorUserId'] : null; // Retrieve input or set to NULL
                $creationDate = $_POST['creationDate'];
                $lastModifiedDate = $_POST['lastModifiedDate'];
                $documentStatus = $_POST['documentStatus'];
                $categoryID = $_POST['categoryID']; // Correct field name for categoryID

                // Validate `authorUserId` against the `users` table
                if (!empty($authorUserId)) {
                    $query = "SELECT UserID FROM users WHERE UserID = ?";
                    $stmt = $mysqli->prepare($query);
                    $stmt->bind_param("i", $authorUserId);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows === 0) {
                        $authorUserId = null; // Set to NULL if not valid
                    }
                    $stmt->close();
                }

                // Retrieve the current user for 'createdBy' from the session
                $createdBy = isset($_SESSION['Username']) ? $_SESSION['Username'] : 'unknown'; // Fallback to 'unknown' if not set

                // Handle file upload
                $targetDir = "uploads/";
                $targetFile = $targetDir . basename($_FILES["documentContent"]["name"]);
                $uploadOk = 1;

                // Check if file is a valid document
                $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
                if (!in_array($fileType, ['pdf', 'doc', 'docx', 'txt'])) {
                    echo "Sorry, only PDF, DOC, DOCX, & TXT files are allowed.";
                    $uploadOk = 0;
                }

                // Check if uploadOk is set to 0 by an error
                if ($uploadOk == 1) {
                    if (move_uploaded_file($_FILES["documentContent"]["tmp_name"], $targetFile)) {
                        // Prepare the statement to include categoryID and createdBy
                        $stmt = $mysqli->prepare("INSERT INTO documents (documentTitle, documentType, authorUserID, creationDate, lastModifiedDate, DocumentContent, Status, categoryID, createdBy, createdOn) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");

                        // Bind the parameters, including the `createdBy` variable
                        $stmt->bind_param('ssisssssi', $documentTitle, $documentType, $authorUserId, $creationDate, $lastModifiedDate, $targetFile, $documentStatus, $categoryID, $createdBy);

                        if ($stmt->execute()) {
                            echo "Document uploaded successfully!";
                        } else {
                            echo "Error: " . $stmt->error;
                        }

                        $stmt->close();
                    } else {
                        echo "Sorry, there was an error uploading your file.";
                    }
                }

                $mysqli->close();
            }

            ?>               

            </section>

            <!-- Document Table Section -->
            <section class="document-list-section">
                <h3>All Documents</h3>
                <table class="document-table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Type</th>
                            <th>Author</th>
                            <th>Creation Date</th>
                            <th>Last Modified</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    // Database connection parameters
                    $mysqli = new mysqli('localhost', 'root', '', 'lgmsys');

                    // Check for a database connection error
                    if ($mysqli->connect_error) {
                        die('Database connection failed: ' . $mysqli->connect_error);
                    }

                    // Fetch required fields from the documents table
                    $query = "SELECT documentID, documentTitle, documentType, authorUserID, creationDate, lastModifiedDate, DocumentContent, Status, categoryID FROM documents";
                    $result = $mysqli->query($query);

                    if ($result->num_rows > 0) {
                        // Iterate over each document record
                        while ($row = $result->fetch_assoc()) {
                            // Extract only the filename from DocumentContent
                            $fileName = basename($row['DocumentContent']);
                            $filePath = '/lgdmsys/uploads/' . urlencode($fileName); // Build correct file path

                            // Output document details in a table row
                            echo "<tr>
                                <td>" . htmlspecialchars($row['documentTitle']) . "</td>
                                <td>" . htmlspecialchars($row['documentType']) . "</td>
                                <td>" . htmlspecialchars($row['authorUserID']) . "</td>
                                <td>" . htmlspecialchars($row['creationDate']) . "</td>
                                <td>" . htmlspecialchars($row['lastModifiedDate']) . "</td>
                                <td>" . htmlspecialchars($row['Status']) . "</td>
                                <td>
                                    <button class='button' onclick=\"viewDocument('$filePath')\">View</button>
                                    <button class='button' onclick=\"openEditModal(" . htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8') . ")\">Edit</button>
                                    <button class='button' onclick=\"deleteDocument(" . intval($row['documentID']) . ", '$filePath')\">Delete</button>
                                </td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>No documents found.</td></tr>";
                    }

                    // Close the database connection
                    $mysqli->close();
                    ?>

                    </tbody>
                </table>
            </section>
        </main>
    </div>

   <!-- Modal Structure for Editing Document -->
    <div id="editDocumentModal" style="display:none;">
        <div class="modal-content"> 
            <span onclick="closeEditModal()" class="close" style="cursor:pointer;">&times;</span> <!-- Close Button -->
            <h3>Edit Document</h3>
            <form id="editDocumentForm" method="post" action="update_document.php"> <!-- Ensure the action is set to your update document PHP -->
                <!-- Document ID (Hidden) -->
                <input type="hidden" id="editDocumentID" name="documentID">

                <!-- Document Title -->
                <label for="editDocumentTitle">Document Title</label>
                <input type="text" id="editDocumentTitle" name="documentTitle" placeholder="Enter document title" required>

                <!-- Document Type -->
                <label for="editDocumentType">Document Type</label>
                <select id="editDocumentType" name="documentType" required>
                    <option value="" disabled>Select document type</option>
                    <option value="Meeting Minutes">Meeting Minutes</option>
                    <option value="Policy">Policy</option>
                    <option value="Report">Report</option>
                    <option value="Legal Document">Legal Document</option>
                    <option value="Public Notice">Public Notice</option>
                    <option value="Internal Memo">Internal Memo</option>
                    <option value="Proposal/Plan">Proposal/Plan</option>
                    <option value="Research Study">Research Study</option>
                    <option value="Grant Application">Grant Application</option>
                    <option value="Citizen Feedback/Complaint">Citizen Feedback/Complaint</option>
                    <option value="Other">Other</option>
                </select>

                <!-- Creation Date (Read-only) -->
                <label for="editCreationDate">Creation Date</label>
                <input type="date" id="editCreationDate" name="creationDate" readonly>

                <!-- Last Modified Date -->
                <label for="editLastModifiedDate">Last Modified Date</label>
                <input type="date" id="editLastModifiedDate" name="lastModifiedDate" required>
                
                <label for="documentCategory">Category</label>
                <select id="editCategoryID" name="categoryID" required>
                    <option value="" disabled>Select Category</option>
                    <?php
                    $selectedCategoryID = $row['categoryID']; // Assign the document's categoryID
                    include 'category_dropdown.php'; // Dynamically render the dropdown
                    ?>
                </select>

                <!-- Document Status -->
                <label for="editDocumentStatus">Status</label>
                <select id="editDocumentStatus" name="Status" required>
                    <option value="Draft">Draft</option>
                    <option value="Under Review">Under Review</option>
                    <option value="Approved">Approved</option>
                    <option value="Rejected">Rejected</option>
                    <option value="Published">Published</option>
                    <option value="Archived">Archived</option>
                    <option value="In Revision">In Revision</option>
                    <option value="Pending">Pending</option>
                    <option value="Canceled">Canceled</option>
                    <option value="In Progress">In Progress</option>
                </select>

                <!-- Submit Button -->
                <button type="submit" class="button">Save Changes</button>
            </form>
        </div>
    </div>


    
    
    <!-- Scripts -->
    <script src="samplemain.js"></script>
    <!-- Ionicons CDN -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script src="https://unpkg.com/ionicons@5.5.2/dist/ionicons.js"></script>

    <script>
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

   // JavaScript functions for document viewing
   function viewDocument(filePath) {
       const fullUrl = `view_document.php?file=${encodeURIComponent(filePath)}`; // Redirect to the dedicated page
       window.location.href = fullUrl; // Navigate to the dedicated document viewer page
   }

   // JavaScript to open and close the modal
   // Function to open the edit modal with pre-filled data
   function openEditModal(documentData) {
    // Debugging: Ensure data is correct
    console.log("Opening edit modal with data:", documentData);

    // Set the form fields
    document.getElementById("editDocumentID").value = documentData.documentID;
    document.getElementById("editDocumentTitle").value = documentData.documentTitle;
    document.getElementById("editDocumentType").value = documentData.documentType;
    document.getElementById("editCreationDate").value = documentData.creationDate;
    document.getElementById("editLastModifiedDate").value = new Date().toISOString().slice(0, 10); // Current date
    document.getElementById("editCategoryID").value = String(documentData.categoryID); // Match types
    document.getElementById("editDocumentStatus").value = documentData.Status;

    // Error handling for category dropdown
    const categoryDropdown = document.getElementById("editCategoryID");
    if (categoryDropdown.value !== String(documentData.categoryID)) {
        console.error("Category ID not found in dropdown:", documentData.categoryID);
    }

    // Show the modal
    document.getElementById("editDocumentModal").style.display = "block";
    }

   // Function to close the edit modal
   function closeEditModal() {
       const modal = document.getElementById("editDocumentModal");
       if (modal) {
           modal.style.display = "none";
       }
   }

   // Optional: Close modal when clicking outside of it
   window.onclick = function(event) {
       let modal = document.getElementById("editDocumentModal");
       if (event.target === modal) {
           closeEditModal();
       }
   };

   function deleteDocument(documentID, filePath) {
       // Confirm before deletion
       if (confirm('Are you sure you want to delete this document?')) {
           // Create a new XMLHttpRequest object
           var xhr = new XMLHttpRequest();

           // Prepare the request (POST method, URL, asynchronous)
           xhr.open("POST", "delete_document.php", true); // Ensure the URL matches your backend script
           xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

           // Define the callback function to handle the server response
           xhr.onreadystatechange = function() {
               if (xhr.readyState == 4 && xhr.status == 200) {
                   if (xhr.responseText == "success") {
                       alert("Document deleted successfully.");
                       location.reload(); // Reload the page to update the document list
                   } else {
                       alert("Error deleting document.");
                   }
               }
           };

           // Send the request with the documentID and filePath
           xhr.send("documentID=" + documentID + "&filePath=" + encodeURIComponent(filePath));
       }
   }
</script>


</body>

</html>
