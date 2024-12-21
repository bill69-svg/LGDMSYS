<?php
// addVersion.php
$servername = "localhost"; // Your database server
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "lgmsys"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Add new version
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"));

    if (isset($data->versionName) && isset($data->description) && isset($data->createdBy) && isset($data->dateCreated)) {
        $versionName = $data->versionName;
        $description = $data->description;
        $createdBy = $data->createdBy;
        $dateCreated = $data->dateCreated;

        $stmt = $conn->prepare("INSERT INTO version (VersionNumber, VersionContent, AuthorUserId, VersionDate, createdBy) VALUES (?, ?, ?, ?, ?)");
        // Replace 1 with logic to determine the correct version number
        $versionNumber = 1; // This should be the next version number
        $authorUserId = 1; // Replace with actual user ID

        $stmt->bind_param("issss", $versionNumber, $description, $authorUserId, $dateCreated, $createdBy);

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Database error: ' . $stmt->error]);
        }
        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid input']);
    }
}

$conn->close();
?>
