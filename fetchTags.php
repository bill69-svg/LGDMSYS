<?php
// fetchTags.php
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

if (isset($_GET['tagID'])) {
    // Fetch a specific tag based on the tagID
    $tagID = intval($_GET['tagID']);
    $sql = "SELECT TagID, TagName, Description, createdBy, createdOn FROM tags WHERE TagID = $tagID";
    $result = $conn->query($sql);

    $tag = null;
    if ($result->num_rows > 0) {
        $tag = $result->fetch_assoc();
    }
    echo json_encode($tag);
} else {
    // Fetch all tags
    $sql = "SELECT TagID, TagName, Description, createdBy, createdOn FROM tags";
    $result = $conn->query($sql);

    $tags = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $tags[] = $row;
        }
    }
    echo json_encode($tags);
}

$conn->close();
?>
