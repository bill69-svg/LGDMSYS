<?php
header('Content-Type: application/json');

$conn = new mysqli("localhost", "root", "", "lgmsys");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$newUserQuery = "SELECT COUNT(*) as total FROM Users WHERE createdOn >= DATE_SUB(NOW(), INTERVAL 1 MONTH)";
$result = $conn->query($newUserQuery);
$newUsersCount = 0;

if ($result) {
    $row = $result->fetch_assoc();
    $newUsersCount = $row['total'];
}

$conn->close();

echo json_encode(['newUsers' => $newUsersCount]);
?>
