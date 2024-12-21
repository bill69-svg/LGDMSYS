<?php
// Database configuration
$servername = "localhost"; // Your database server
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "lgmsys"; // Your database name

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to handle the PUT request and extract data
function getPutData() {
    // Parse the raw input from the PUT request
    parse_str(file_get_contents("php://input"), $putData);
    return $putData;
}

// Check if the request method is PUT
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {

    // Get the PUT data from the request
    $putData = getPutData();

    // Validate if all required fields are present
    if (isset($putData['userId'], $putData['username'], $putData['firstName'], $putData['lastName'], $putData['email'], $putData['phone'], $putData['userRoleID'])) {
        
        // Assign the PUT data to variables
        $userId = $putData['userId'];
        $username = $putData['username'];
        $firstName = $putData['firstName'];
        $lastName = $putData['lastName'];
        $email = $putData['email'];
        $phone = $putData['phone'];
        $userRoleID = $putData['userRoleID'];

        // Prepare the SQL query to update the user in the database
        $sql = "UPDATE users SET Username = ?, FirstName = ?, LastName = ?, Email = ?, Phone = ?, UserRoleID = ? WHERE UserID = ?";

        // Prepare the statement and bind parameters
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("ssssssi", $username, $firstName, $lastName, $email, $phone, $userRoleID, $userId);

            // Execute the statement and check if it was successful
            if ($stmt->execute()) {
                echo json_encode(["message" => "User updated successfully"]);
            } else {
                echo json_encode(["message" => "Error updating user: " . $stmt->error]);
            }

            // Close the prepared statement
            $stmt->close();
        } else {
            echo json_encode(["message" => "Error preparing query"]);
        }

    } else {
        // If any required data is missing, return an error message
        echo json_encode(["message" => "Missing required fields in PUT request"]);
    }
    
} else {
    // If the request method is not PUT, return an error message
    echo json_encode(["message" => "Invalid request method. Use PUT to update user."]);
}

// Close the database connection
$conn->close();
?>
