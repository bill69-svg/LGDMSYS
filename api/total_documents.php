<?php
header('Content-Type: application/json');  // Set response type to JSON

$conn = new mysqli("localhost", "root", "", "lgmsys");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$totalDocumentsQuery = "SELECT COUNT(*) as total FROM Documents";
$result = $conn->query($totalDocumentsQuery);
$totalDocumentsCount = 0;

if ($result) {
    $row = $result->fetch_assoc();
    $totalDocumentsCount = $row['total'];
}

$conn->close();  // Close database connection

echo json_encode(['totalDocuments' => $totalDocumentsCount]);  // Return data as JSON
?>
