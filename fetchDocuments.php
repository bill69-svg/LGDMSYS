<?php
header('Content-Type: application/json');

$conn = new mysqli("localhost", "root", "", "lgmsys");

if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

// Execute the query
$query = "SELECT documentTitle, Status FROM Documents"; // Use correct field names
$result = $conn->query($query);

$documents = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $documents[] = $row; // Collect document data
    }
} else {
    // Query failed
    die(json_encode(["error" => "Query failed: " . $conn->error]));
}

$conn->close(); // Close the database connection

// Return the document data as JSON
echo json_encode($documents);
?>
