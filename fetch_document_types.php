<?php
$conn = new mysqli("localhost", "root", "", "lgmsys");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch document types and their counts using documentType
$query = "SELECT documentType AS type, COUNT(*) AS count FROM Documents GROUP BY documentType";
$result = $conn->query($query);

$labels = [];
$data = [];

while ($row = $result->fetch_assoc()) {
    $labels[] = $row['type'];
    $data[] = (int)$row['count']; // Ensure count is treated as an integer
}

$conn->close();

echo json_encode(['labels' => $labels, 'data' => $data]);
?>
