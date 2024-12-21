<?php
// deleteVersion.php
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

// Check if versionID is provided
if (isset($data['versionID'])) {
    $versionID = intval($data['versionID']); // Sanitize input

    // SQL query to delete the version from the correct table
    $sql = "DELETE FROM version WHERE VersionID = $versionID"; // Ensure table name is `version`

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["message" => "Version deleted successfully."]);
    } else {
        echo json_encode(["message" => "Error deleting version: " . $conn->error]);
    }
} else {
    echo json_encode(["message" => "Version ID not provided."]);
}

// Close connection
$conn->close();
?>
