<?php
// deleteTag.php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lgmsys";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the raw POST data (from the JSON body)
$data = json_decode(file_get_contents('php://input'), true);

// Check if tagID is provided
if (isset($data['tagID'])) {
    $tagID = intval($data['tagID']); // Sanitize input

    // SQL query to delete the tag
    $sql = "DELETE FROM tags WHERE TagID = $tagID";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["message" => "Tag deleted successfully."]);
    } else {
        echo json_encode(["message" => "Error deleting tag: " . $conn->error]);
    }
} else {
    echo json_encode(["message" => "Tag ID not provided."]);
}

// Close connection
$conn->close();
?>
