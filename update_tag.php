<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lgmsys";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the raw POST data (since it's in JSON format)
$data = json_decode(file_get_contents('php://input'), true);

// Check if the data is set
if (isset($data['tagID']) && isset($data['tagName']) && isset($data['description'])) {
    $tagID = intval($data['tagID']); // Make sure it's an integer to prevent SQL injection
    $tagName = $conn->real_escape_string($data['tagName']); // Sanitize the tag name
    $description = $conn->real_escape_string($data['description']); // Sanitize the description

    // SQL query to update the tag in the database
    $sql = "UPDATE tags SET tagName = '$tagName', description = '$description' WHERE tagID = $tagID";

    // Check if the query was successful
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["message" => "Tag updated successfully."]);
    } else {
        echo json_encode(["message" => "Error updating tag: " . $conn->error]);
    }
} else {
    echo json_encode(["message" => "Missing data."]);
}

// Close the database connection
$conn->close();
?>
