<?php
$conn = new mysqli("localhost", "root", "", "lgmsys");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch user registrations over the last month
$query = "
    SELECT DATE(createdOn) as date, COUNT(*) as registrations 
    FROM Users 
    WHERE createdOn >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)
    GROUP BY DATE(createdOn)
    ORDER BY DATE(createdOn)";

$result = $conn->query($query);

$labels = [];
$data = [];

while ($row = $result->fetch_assoc()) {
    $labels[] = $row['date'];
    $data[] = $row['registrations'];
}

$conn->close();

echo json_encode(['labels' => $labels, 'data' => $data]);
?>
