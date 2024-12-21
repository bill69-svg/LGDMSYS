<?php
// Fetch categories from the database
$mysqli = new mysqli('localhost', 'root', '', 'lgmsys');

if ($mysqli->connect_error) {
    die('Database connection failed: ' . $mysqli->connect_error);
}

// Ensure `$selectedCategoryID` is defined before using this file
if (!isset($selectedCategoryID)) {
    $selectedCategoryID = null;
}

$result = $mysqli->query("SELECT categoryID, categoryName FROM categories");
while ($row = $result->fetch_assoc()) {
    $selected = ($row['categoryID'] == $selectedCategoryID) ? "selected" : "";
    echo "<option value='" . $row['categoryID'] . "' $selected>" . htmlspecialchars($row['categoryName']) . "</option>";
}

$mysqli->close();
?>
