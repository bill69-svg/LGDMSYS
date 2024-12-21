<?php
header('Content-Type: application/json');

$conn = new mysqli("localhost", "root", "", "lgmsys");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$activityQuery = "SELECT Username, activity, createdOn FROM activitylog ORDER BY createdOn DESC LIMIT 5";
$result = $conn->query($activityQuery);

$activities = [];
while ($row = $result->fetch_assoc()) {
    $activities[] = [
        'username' => $row['Username'],
        'activity' => $row['activity'],
        'createdOn' => $row['createdOn']
    ];
}

$conn->close();

echo json_encode(['recentActivities' => $activities]);
?>
