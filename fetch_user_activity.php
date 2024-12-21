<?php
$conn = new mysqli("localhost", "root", "", "lgmsys");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch user activity over the last month (or adjust as needed)
$query = "
    SELECT DATE(createdOn) as date, COUNT(*) as activity_count 
    FROM activitylog 
    WHERE createdOn >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)
    GROUP BY DATE(createdOn)
    ORDER BY DATE(createdOn)";

$result = $conn->query($query);

$labels = [];
$data = [];

while ($row = $result->fetch_assoc()) {
    $labels[] = $row['date'];
    $data[] = $row['activity_count'];
}

$conn->close();

echo json_encode(['labels' => $labels, 'data' => $data]);
?>
