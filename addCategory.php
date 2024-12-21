<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capture form data
    $categoryName = $_POST['categoryName'];
    $description = $_POST['description'];
    $createdBy = $_POST['createdBy'];
    $createdOn = $_POST['dateCreated'];

    // Connect to the database
    $servername = "localhost";
    $username = "root"; // Adjust accordingly
    $password = ""; // Adjust accordingly
    $dbname = "lgmsys";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert new category into the database
    $sql = "INSERT INTO categories (categoryName, description, createdBy, createdOn)
            VALUES ('$categoryName', '$description', '$createdBy', '$createdOn')";

    if ($conn->query($sql) === TRUE) {
        echo "New category added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();

    // Redirect back to categories page (optional)
    header("Location: categories.php");
}
?>
