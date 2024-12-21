<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lgmsys"; // Corrected database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check for database connection errors
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Database connection failed: ' . $conn->connect_error]));
}

// Get the categoryID from the query string
$categoryID = isset($_GET['categoryID']) ? $_GET['categoryID'] : null;

$response = array(); // Initialize the response array

// If categoryID is provided
if ($categoryID && is_numeric($categoryID)) {
    // Query to fetch documents related to the categoryID
    $sql = "SELECT 
                documentID, 
                documentTitle, 
                documentType, 
                authorUserID, 
                creationDate, 
                lastModifiedDate, 
                Status 
            FROM documents 
            WHERE categoryID = ?";
    
    // Prepare the statement
    $stmt = $conn->prepare($sql);

    // Check if query preparation was successful
    if ($stmt === false) {
        die(json_encode(['success' => false, 'message' => 'Query preparation failed: ' . $conn->error]));
    }

    // Bind the categoryID as an integer
    $stmt->bind_param("i", $categoryID);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if documents were found
    if ($result->num_rows > 0) {
        $documents = array();
        
        // Loop through the documents and add them to the response array
        while ($row = $result->fetch_assoc()) {
            $documents[] = $row;
        }

        // Successful response with documents
        $response['success'] = true;
        $response['documents'] = $documents;
    } else {
        // No documents found for the category
        $response['success'] = false;
        $response['message'] = 'No documents found for this category';
    }
} else {
    // If categoryID is not provided or not a valid number
    $response['success'] = false;
    $response['message'] = 'Invalid category ID';
}

// Close the statement and connection if $stmt is defined
if (isset($stmt)) {
    $stmt->close();
}
$conn->close();

// Return the response as a JSON object
echo json_encode($response);
?>
