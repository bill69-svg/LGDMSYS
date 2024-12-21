<?php
// view_document.php

// Include session handler for user authentication
include 'session_handler.php';

// Database connection parameters
$host = 'localhost';
$dbname = 'lgmsys';
$user = 'root';
$password = '';

try {
    // Create a new PDO instance for database connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database: " . $e->getMessage());
}

// Initialize variable to hold the document
$document = null;

// Fetch document based on documentID or file name
if (isset($_GET['documentID'])) {
    $documentID = intval($_GET['documentID']);
    $stmt = $pdo->prepare("SELECT d.*, c.categoryName 
                           FROM documents d 
                           LEFT JOIN categories c ON d.categoryID = c.categoryID
                           WHERE d.documentID = :documentID");
    $stmt->execute(['documentID' => $documentID]);
    $document = $stmt->fetch(PDO::FETCH_ASSOC);
} elseif (isset($_GET['file'])) {
    $filePath = urldecode($_GET['file']);
    $fileName = basename($filePath);
    $stmt = $pdo->prepare("SELECT d.*, c.categoryName 
                           FROM documents d 
                           LEFT JOIN categories c ON d.categoryID = c.categoryID
                           WHERE d.DocumentContent LIKE :fileName");
    $stmt->execute(['fileName' => '%' . $fileName]);
    $document = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Check if the document exists
if ($document) {
    $filePath = $document['DocumentContent'];
    $documentID = $document['documentID'];
    $categoryID = $document['categoryID'];

    // Capture the referer URL for the back button functionality
    $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php';

    // HTML structure and styles
    echo "<!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>View Document</title>
        <link rel='stylesheet' href='samplestyle.css'>
        <style>
            /* Your existing CSS here */
            body {
                font-family: 'Arial', sans-serif;
                margin: 0;
                padding: 0;
                background-color: #f4f4f4;
                color: #333;
            }

            .container {
                max-width: 1200px;
                margin: 20px auto;
                padding: 20px;
                background-color: #fff;
                border-radius: 8px;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            }

            h2 {
                text-align: center;
                font-size: 2em;
                margin-bottom: 20px;
                color: #007BFF;
            }

            .details {
                margin-bottom: 20px;
                display: grid;
                grid-template-columns: 1fr 2fr;
                gap: 10px;
            }

            .detail-item {
                margin-bottom: 10px;
            }

            .detail-item strong {
                color: #007BFF;
            }

            iframe {
                width: 100%;
                height: 80vh;
                border: none;
                border-radius: 8px;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            }

            button {
                background-color: #007BFF;
                color: white;
                border: none;
                border-radius: 5px;
                padding: 10px 20px;
                font-size: 1em;
                cursor: pointer;
                transition: background-color 0.3s;
            }

            button:hover {
                background-color: #0056b3;
            }

            .button-container {
                display: flex;
                justify-content: space-between;
                margin-top: 20px;
            }

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
                padding-top: 60px;
            }

            .modal-content {
                background-color: #fefefe;
                margin: 5% auto;
                padding: 20px;
                border: 1px solid #888;
                width: 80%;
                border-radius: 8px;
            }

            .close {
                color: #aaa;
                float: right;
                font-size: 28px;
                font-weight: bold;
            }

            .close:hover, .close:focus {
                color: black;
                text-decoration: none;
                cursor: pointer;
            }

            input[type='text'], input[type='date'], select {
                padding: 10px;
                margin-bottom: 15px;
                border: 1px solid #ccc;
                border-radius: 4px;
                width: 100%;
            }

            @media (max-width: 768px) {
                h2 {
                    font-size: 1.5em;
                }

                button {
                    width: 100%;
                }
            }
        </style>
        <script>
            function openModal() {
                document.getElementById('editModal').style.display = 'block';
            }
            function closeModal() {
                document.getElementById('editModal').style.display = 'none';
            }

            // Set the back button's destination dynamically
            function setBackButton() {
                document.getElementById('backButton').href = '" . $referer . "';
            }
        </script>
    </head>
    <body onload='setBackButton()'>
        <div class='container'>
            <h2>Document Viewer</h2>
            <div class='details'>
                <div class='detail-item'><strong>Title:</strong> " . htmlspecialchars($document['documentTitle']) . "</div>
                <div class='detail-item'><strong>Type:</strong> " . htmlspecialchars($document['documentType']) . "</div>
                <div class='detail-item'><strong>Author ID:</strong> " . htmlspecialchars($document['authorUserID']) . "</div>
                <div class='detail-item'><strong>Creation Date:</strong> " . htmlspecialchars($document['creationDate']) . "</div>
                <div class='detail-item'><strong>Last Modified Date:</strong> " . htmlspecialchars($document['lastModifiedDate']) . "</div>
                <div class='detail-item'><strong>Status:</strong> " . htmlspecialchars($document['Status']) . "</div>
                <div class='detail-item'><strong>Category:</strong> " . htmlspecialchars($document['categoryName']) . "</div>
            </div>
            <iframe src='" . htmlspecialchars($filePath) . "'></iframe>
            <div class='button-container'>
                <button onclick='openModal()'>Edit Document</button>
                <a id='backButton' href='#' class='button'>Back</a>
            </div>
        </div>

        <!-- Modal for editing the document -->
        <div id='editModal' class='modal' style='display:none;'>
            <div class='modal-content'>
                <span onclick='closeModal()' class='close'>&times;</span>
                <h3>Edit Document</h3>
                <form id='editDocumentForm' method='post' action='update_document.php' enctype='multipart/form-data'>
                    <!-- Hidden field for document ID -->
                    <input type='hidden' id='editDocumentID' name='documentID' value='" . htmlspecialchars($documentID) . "'>

                    <!-- Document Title -->
                    <label for='editDocumentTitle'>Document Title</label>
                    <input type='text' id='editDocumentTitle' name='documentTitle' value='" . htmlspecialchars($document['documentTitle']) . "' required>

                    <!-- Document Type -->
                    <label for='editDocumentType'>Type</label>
                    <select id='editDocumentType' name='documentType' required>
                        <option value='' disabled>Select document type</option>
                        <option value='Meeting Minutes' " . ($document['documentType'] == 'Meeting Minutes' ? 'selected' : '') . ">Meeting Minutes</option>
                        <option value='Policy' " . ($document['documentType'] == 'Policy' ? 'selected' : '') . ">Policy</option>
                        <option value='Report' " . ($document['documentType'] == 'Report' ? 'selected' : '') . ">Report</option>
                        <option value='Legal Document' " . ($document['documentType'] == 'Legal Document' ? 'selected' : '') . ">Legal Document</option>
                        <option value='Public Notice' " . ($document['documentType'] == 'Public Notice' ? 'selected' : '') . ">Public Notice</option>
                        <option value='Internal Memo' " . ($document['documentType'] == 'Internal Memo' ? 'selected' : '') . ">Internal Memo</option>
                        <option value='Proposal/Plan' " . ($document['documentType'] == 'Proposal/Plan' ? 'selected' : '') . ">Proposal/Plan</option>
                        <option value='Research Study' " . ($document['documentType'] == 'Research Study' ? 'selected' : '') . ">Research Study</option>
                        <option value='Grant Application' " . ($document['documentType'] == 'Grant Application' ? 'selected' : '') . ">Grant Application</option>
                        <option value='Citizen Feedback/Complaint' " . ($document['documentType'] == 'Citizen Feedback/Complaint' ? 'selected' : '') . ">Citizen Feedback/Complaint</option>
                        <option value='Other' " . ($document['documentType'] == 'Other' ? 'selected' : '') . ">Other</option>
                    </select>

                    <!-- Document Category -->
                    <label for='documentCategory'>Category</label>
                    <select id='createCategoryID' name='categoryID' required>
                        <option value='' disabled>Select Category</option>";
                        
                        // Fetch and display categories
                        $categoryStmt = $pdo->query("SELECT categoryID, categoryName FROM categories");
                        while ($row = $categoryStmt->fetch(PDO::FETCH_ASSOC)) {
                            $selected = ($row['categoryID'] == $categoryID) ? 'selected' : '';
                            echo "<option value='" . $row['categoryID'] . "' $selected>" . htmlspecialchars($row['categoryName']) . "</option>";
                        }
                        
                    echo "</select>

                     <!-- Creation Date (readonly) -->
                    <label for='editCreationDate'>Creation Date</label>
                    <input type='date' id='editCreationDate' name='creationDate' readonly value='" . htmlspecialchars($document['creationDate']) . "'>

                    <!-- Last Modified Date -->
                    <label for='editLastModifiedDate'>Last Modified Date</label>
                    <input type='date' id='editLastModifiedDate' name='lastModifiedDate' required value='" . htmlspecialchars($document['lastModifiedDate']) . "'>

                    <!-- Document Status -->
                    <label for='editDocumentStatus'>Status</label>
                    <select id='editDocumentStatus' name='Status' required>
                        <option value='Draft' " . ($document['Status'] == 'Draft' ? 'selected' : '') . ">Draft</option>
                        <option value='Under Review' " . ($document['Status'] == 'Under Review' ? 'selected' : '') . ">Under Review</option>
                        <option value='Approved' " . ($document['Status'] == 'Approved' ? 'selected' : '') . ">Approved</option>
                        <option value='Rejected' " . ($document['Status'] == 'Rejected' ? 'selected' : '') . ">Rejected</option>
                        <option value='Published' " . ($document['Status'] == 'Published' ? 'selected' : '') . ">Published</option>
                        <option value='Archived' " . ($document['Status'] == 'Archived' ? 'selected' : '') . ">Archived</option>
                        <option value='In Revision' " . ($document['Status'] == 'In Revision' ? 'selected' : '') . ">In Revision</option>
                        <option value='Pending' " . ($document['Status'] == 'Pending' ? 'selected' : '') . ">Pending</option>
                        <option value='Canceled' " . ($document['Status'] == 'Canceled' ? 'selected' : '') . ">Canceled</option>
                        <option value='In Progress' " . ($document['Status'] == 'In Progress' ? 'selected' : '') . ">In Progress</option>
                    </select>

                    <!-- Save Button -->
                    <button type='submit'>Save Changes</button>             
                    
                </form>
            </div>
        </div>
    </body>
    </html>";
} else {
    echo "Document not found.";

}
?>
