<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lgmsys";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$query = "SELECT DATE_FORMAT(createdOn, '%Y-%m') as month, COUNT(*) as total FROM Users GROUP BY month ORDER BY month DESC";
$result = $conn->query($query);

$userGrowth = [];
while ($row = $result->fetch_assoc()) {
    $userGrowth[] = $row;
}

echo json_encode($userGrowth);
$conn->close();
?>
