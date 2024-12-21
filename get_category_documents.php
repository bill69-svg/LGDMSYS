<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lgmsys";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['categoryID']) && is_numeric($_GET['categoryID'])) {
    $categoryID = $_GET['categoryID'];

    // Fetch documents for the given category
    $sql = "
        SELECT d.documentID, d.documentTitle, d.creationDate, d.status, d.documentType
        FROM documents d
        WHERE d.categoryID = ? 
        ORDER BY d.creationDate DESC
    ";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $categoryID);  // Bind categoryID as integer
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if there are any documents
        if ($result->num_rows > 0) {
            $documents = [];
            while ($row = $result->fetch_assoc()) {
                $documents[] = $row;
            }

            // Return the documents as a JSON response
            echo json_encode($documents);
        } else {
            echo json_encode(["error" => "No documents found for this category."]);
        }
    } else {
        echo json_encode(["error" => "Database query failed."]);
    }
} else {
    echo json_encode(["error" => "Invalid category ID."]);
}

$conn->close();
?>
