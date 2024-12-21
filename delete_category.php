<?php
// Database connection
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

// Check if the 'id' parameter exists in the URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    // Sanitize and validate the ID
    $categoryID = intval($_GET['id']); // Ensures the ID is an integer

    // Prepare the DELETE query
    $stmt = $conn->prepare("DELETE FROM categories WHERE categoryID = ?");
    $stmt->bind_param("i", $categoryID);

    // Execute the query
    if ($stmt->execute()) {
        echo "Category deleted successfully.";
    } else {
        echo "Error deleting category: " . $conn->error;
    }

    // Close the prepared statement
    $stmt->close();
} else {
    echo "Error: Category ID is missing or invalid.";
}

// Close the database connection
$conn->close();
?>
