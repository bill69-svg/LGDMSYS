<?php
// fetchVersions.php
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

// Fetch versions
$sql = "SELECT * FROM version"; // Corrected to your table name 'version'
$result = $conn->query($sql);

$versions = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $versions[] = $row;
    }
}

// Return the versions as JSON
echo json_encode($versions);

// Close connection
$conn->close();
?>
