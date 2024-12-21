<?php
header('Content-Type: application/json');

$conn = new mysqli("localhost", "root", "", "lgmsys");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$totalUsersQuery = "SELECT COUNT(*) as total FROM Users";
$result = $conn->query($totalUsersQuery);
$totalUsersCount = 0;

if ($result) {
    $row = $result->fetch_assoc();
    $totalUsersCount = $row['total'];
}

$conn->close();

echo json_encode(['totalUsers' => $totalUsersCount]);
?>
