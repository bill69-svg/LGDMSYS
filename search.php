<?php
$servername = "localhost";
$username = "root"; // Default XAMPP username
$password = ""; // Default XAMPP password (usually empty)
$dbname = "lgmsys"; // Replace with your actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the search query from the request
$query = isset($_GET['q']) ? $_GET['q'] : '';

// Prepare an array to store results
$results = [];

// Perform search only if the query is provided
if ($query) {
    $searchTerm = "%" . $query . "%";

    // Activity log search
    $stmt = $conn->prepare("SELECT 'activitylog' AS source, activity FROM activitylog WHERE activity LIKE ?");
    $stmt->bind_param("s", $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $results[] = $row;
    }
    $stmt->close();

    // Categories search
    $stmt = $conn->prepare("SELECT 'categories' AS source, categoryName FROM categories WHERE categoryName LIKE ?");
    $stmt->bind_param("s", $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $results[] = $row;
    }
    $stmt->close();

    // Documents search
    $stmt = $conn->prepare("SELECT 'documents' AS source, documentTitle FROM documents WHERE documentTitle LIKE ?");
    $stmt->bind_param("s", $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $results[] = $row;
    }
    $stmt->close();

    // Settings search
    $stmt = $conn->prepare("SELECT 'settings' AS source, setting_name FROM settings WHERE setting_name LIKE ?");
    $stmt->bind_param("s", $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $results[] = $row;
    }
    $stmt->close();

    // Tags search
    $stmt = $conn->prepare("SELECT 'tags' AS source, TagName FROM tags WHERE TagName LIKE ?");
    $stmt->bind_param("s", $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $results[] = $row;
    }
    $stmt->close();

    // Users search
    $stmt = $conn->prepare("SELECT 'users' AS source, username FROM users WHERE username LIKE ?");
    $stmt->bind_param("s", $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $results[] = $row;
    }
    $stmt->close();
}

// Return results as JSON
header('Content-Type: application/json');
echo json_encode($results);

$conn->close();
?>
