<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lgmsys";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT DATE(createdOn) as uploadDate, COUNT(*) as uploads 
        FROM Documents 
        GROUP BY uploadDate 
        ORDER BY uploadDate";
$result = $conn->query($sql);

$uploads = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $uploads[] = $row;
    }
}

echo json_encode($uploads);
$conn->close();
?>
