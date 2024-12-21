<?php
// Start the session and include session handling if necessary
include 'session_handler.php';

// Database connection parameters
$host = 'localhost';
$dbname = 'lgmsys';
$user = 'root';
$password = '';

// Create a new PDO instance for database connection
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database: " . $e->getMessage());
}

// Check if the form is submitted with required fields
if (isset($_POST['documentID'], $_POST['documentTitle'], $_POST['documentType'], $_POST['Status'], $_POST['categoryID'])) {
    // Sanitize input data
    $documentID = intval($_POST['documentID']);
    $documentTitle = htmlspecialchars($_POST['documentTitle']);
    $documentType = htmlspecialchars($_POST['documentType']);
    $categoryID = intval($_POST['categoryID']); // Sanitize category ID
    
    // If 'authorUserID' is optional, we check if it's set before sanitizing
    $authorUserID = isset($_POST['authorUserID']) ? htmlspecialchars($_POST['authorUserID']) : null;

    $status = htmlspecialchars($_POST['Status']);
    $lastModifiedDate = date('Y-m-d H:i:s'); // Update modified date to current date and time

    $uploadPath = null;

    // Check if a new document file is uploaded
    if (isset($_FILES['documentContent']) && $_FILES['documentContent']['error'] == UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/'; // Adjust path as necessary
        $fileTmpPath = $_FILES['documentContent']['tmp_name'];
        $fileName = basename($_FILES['documentContent']['name']);
        $uploadPath = $uploadDir . $fileName;

        // Move the uploaded file to the designated folder
        if (move_uploaded_file($fileTmpPath, $uploadPath)) {
            // File uploaded successfully
        } else {
            echo "Error uploading file.<br>";
            $uploadPath = null; // Reset upload path on error
        }
    }

    try {
        // Prepare the SQL update statement
        $sql = "
            UPDATE documents 
            SET 
                documentTitle = :documentTitle,
                documentType = :documentType,
                categoryID = :categoryID,
                Status = :status,
                lastModifiedDate = :lastModifiedDate";

        // Only include 'authorUserID' if it's set
        if ($authorUserID !== null) {
            $sql .= ", authorUserID = :authorUserID";
        }

        // Only update DocumentContent if a new file was uploaded
        if ($uploadPath) {
            $sql .= ", DocumentContent = :DocumentContent";
        }

        $sql .= " WHERE documentID = :documentID";

        // Prepare and execute the statement
        $stmt = $pdo->prepare($sql);
        
        // Bind the parameters
        $params = [
            ':documentTitle' => $documentTitle,
            ':documentType' => $documentType,
            ':categoryID' => $categoryID,
            ':status' => $status,
            ':lastModifiedDate' => $lastModifiedDate,
            ':documentID' => $documentID
        ];

        // Bind the authorUserID only if it's set
        if ($authorUserID !== null) {
            $params[':authorUserID'] = $authorUserID;
        }

        // Bind the uploaded file path if it's set
        if ($uploadPath) {
            $params[':DocumentContent'] = $uploadPath;
        }

        $stmt->execute($params);

        // Check if the update was successful
        if ($stmt->rowCount() > 0) {
            // Redirect back to the previous page or view document page without the success query string
            if (isset($_SESSION['previous_page'])) {
                header("Location: " . $_SESSION['previous_page']);
            } else {
                header("Location: view_document.php?documentID=" . $documentID);
            }
            exit(); // Ensure to exit after the redirect
        } else {
            echo "No changes were made or the document was not found.";
        }

    } catch (PDOException $e) {
        echo "Error updating document: " . $e->getMessage();
    }
} else {
    echo "Required fields are missing.";
}

// Close the database connection
$pdo = null;
?>
