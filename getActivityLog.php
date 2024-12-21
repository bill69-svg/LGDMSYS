<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// getActivityLog.php
header('Content-Type: application/json');

// Database connection
$conn = new mysqli("localhost", "root", "", "lgmsys");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Connected successfully!";
}


// Query to retrieve recent activities
$sql = "SELECT Username, activity, createdOn FROM activitylog ORDER BY createdOn DESC LIMIT 10";
$result = $conn->query($sql);

$activities = [];
if ($result->num_rows > 0) {
    echo "Number of rows: " . $result->num_rows;  // Check if rows are returned
    while ($row = $result->fetch_assoc()) {
        $activities[] = [
            'username' => $row['Username'],
            'activity' => $row['activity'],
            'createdOn' => $row['createdOn']
        ];
    }
}  else {
    echo "No records found!";
}

// Close the connection
$conn->close();

// Output the JSON response
echo json_encode($activities);
?>
