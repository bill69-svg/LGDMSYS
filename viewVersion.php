<?php
// viewVersion.php
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

    // SQL query to fetch the version details
    $sql = "SELECT * FROM version WHERE VersionID = $versionID"; // Adjust table name and field name if necessary
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Return the fetched data
        $version = $result->fetch_assoc();
        echo json_encode($version);
    } else {
        echo json_encode(["message" => "Version not found."]);
    }
} else {
    echo json_encode(["message" => "Version ID not provided."]);
}

// Close connection
$conn->close();
?>
