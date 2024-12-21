<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mysqli = new mysqli('localhost', 'root', '', 'lgmsys');

    if ($mysqli->connect_error) {
        die('Database connection failed: ' . $mysqli->connect_error);
    }

    $documentTitle = $_POST['documentTitle'];

    // Check if the document already exists in the database
    $query = "SELECT * FROM documents WHERE documentTitle = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('s', $documentTitle);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Document with this title already exists
        echo "exists";
    } else {
        // Document with this title does not exist
        echo "not_exists";
    }

    $stmt->close();
    $mysqli->close();
}
?>
