<?php
// delete_document.php

// Database connection parameters
$mysqli = new mysqli('localhost', 'root', '', 'lgmsys');

// Check for a database connection error
if ($mysqli->connect_error) {
    die('Database connection failed: ' . $mysqli->connect_error);
}

// Check if both documentID and filePath are provided in the POST request
if (isset($_POST['documentID']) && isset($_POST['filePath'])) {
    $documentID = intval($_POST['documentID']);
    $filePath = urldecode($_POST['filePath']); // Get file path from the POST request

    // Step 1: Verify that the document exists in the database
    $stmt = $mysqli->prepare("SELECT * FROM documents WHERE documentID = ?");
    $stmt->bind_param("i", $documentID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Document found
        $document = $result->fetch_assoc();

        // Step 2: Delete the file from the server if it exists
        if (file_exists($filePath)) {
            if (unlink($filePath)) { // Attempt to delete the file
                // File deleted successfully
                // Step 3: Delete the document record from the database
                $stmt = $mysqli->prepare("DELETE FROM documents WHERE documentID = ?");
                $stmt->bind_param("i", $documentID);

                if ($stmt->execute()) {
                    echo "success"; // File and record deleted successfully
                } else {
                    echo "error: Database deletion failed - " . $stmt->error;
                }
            } else {
                // Failed to delete the file from the server
                echo "error: Could not delete file from server.";
            }
        } else {
            // File does not exist on the server, but we'll still delete the database record
            $stmt = $mysqli->prepare("DELETE FROM documents WHERE documentID = ?");
            $stmt->bind_param("i", $documentID);

            if ($stmt->execute()) {
                echo "success"; // Record deleted, file not found
            } else {
                echo "error: Database deletion failed - " . $stmt->error;
            }
        }
    } else {
        echo "error: Document not found.";
    }

    // Free result and close statement
    $result->free();
    $stmt->close();
} else {
    echo "error: Missing documentID or filePath.";
}

// Close the database connection
$mysqli->close();
?>
