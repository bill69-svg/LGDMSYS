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

// Check if data is received via POST
if (isset($_POST['id'], $_POST['name'], $_POST['description'])) {
    // Sanitize inputs
    $categoryID = intval($_POST['id']);
    $categoryName = trim($_POST['name']);
    $categoryDescription = trim($_POST['description']);

    // Prepare and execute SQL statement
    $sql = "UPDATE categories SET categoryName = ?, description = ? WHERE categoryID = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ssi", $categoryName, $categoryDescription, $categoryID);
        
        // Execute and check for success
        if ($stmt->execute()) {
            // Redirect or provide feedback
            echo json_encode(["status" => "success", "message" => "Category updated successfully."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error updating category."]);
        }

        $stmt->close();
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to prepare the SQL statement."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Missing data."]);
}

// Close the database connection
$conn->close();
?>
