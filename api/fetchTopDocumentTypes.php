<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lgmsys";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT DocumentType, COUNT(*) as total 
        FROM Documents 
        GROUP BY DocumentType 
        ORDER BY total DESC 
        LIMIT 5"; // Adjust as necessary

$result = $conn->query($sql);

$documentTypes = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $documentTypes[] = $row; // Store each document type and count
    }
}

echo json_encode($documentTypes);
$conn->close();
?>
