<?php
// addTag.php
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

// Add new tag
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"));

    if (isset($data->tagName) && isset($data->description)) {
        $tagName = $data->tagName;
        $description = $data->description;
        $createdBy = "Current User"; // Change to actual user

        $stmt = $conn->prepare("INSERT INTO tags (TagName, Description, createdBy) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $tagName, $description, $createdBy);

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
