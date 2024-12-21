<?php
header('Content-Type: application/json');

$conn = new mysqli("localhost", "root", "", "lgmsys");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$activeUserQuery = "SELECT Username, COUNT(*) as actions FROM activitylog GROUP BY Username ORDER BY actions DESC LIMIT 1";
$result = $conn->query($activeUserQuery);
$mostActiveUser = "None";

if ($result && $row = $result->fetch_assoc()) {
    $mostActiveUser = $row['Username'];
}

$conn->close();

echo json_encode(['mostActiveUser' => $mostActiveUser]);
?>
