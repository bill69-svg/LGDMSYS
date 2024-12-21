<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lgmsys";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT Status, COUNT(*) as total 
        FROM Users 
        GROUP BY Status";
$result = $conn->query($sql);

$statusCounts = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $statusCounts[$row['Status']] = $row['total'];
    }
}

echo json_encode($statusCounts);
$conn->close();
?>
