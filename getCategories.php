<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lgmsys";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM categories";
$result = $conn->query($sql);

$categories = array();
while ($row = $result->fetch_assoc()) {
    $categories[] = $row;
}

echo json_encode($categories);

$conn->close();
?>
