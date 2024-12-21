<?php
$conn = new mysqli("localhost", "root", "", "lgmsys");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch document uploads this month
$query = "
    SELECT DAY(createdOn) as day, COUNT(*) as uploads 
    FROM Documents 
    WHERE MONTH(createdOn) = MONTH(CURRENT_DATE()) AND YEAR(createdOn) = YEAR(CURRENT_DATE())
    GROUP BY DAY(createdOn)";

$result = $conn->query($query);

$labels = [];
$data = [];

while ($row = $result->fetch_assoc()) {
    $labels[] = $row['day'];
    $data[] = $row['uploads'];
}

$conn->close();

echo json_encode(['labels' => $labels, 'data' => $data]);
?>
