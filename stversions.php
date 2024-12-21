<?php
include 'session_handler.php';
?>

<?php
// Database Connection
$host = 'localhost'; // Database host
$db = 'lgmsys'; // Database name
$user = 'root'; // Database username
$pass = ''; // Database password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

// Fetch Versions
$versions = [];
$query = "SELECT VersionID, DocumentID, VersionNumber, VersionDate, VersionContent, AuthorUserId, Comments, createdBy, createdOn, modifiedBy, modifiedOn FROM version"; // Use your actual column names
$stmt = $pdo->prepare($query);
$stmt->execute();
$versions = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle Add Version Request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"));

    $versionNumber = $data->versionNumber;
    $documentID = $data->documentID; // Assuming you'll have a document ID from somewhere
    $versionDate = $data->versionDate;
    $versionContent = $data->description;
    $authorUserId = 1; // Set this dynamically as needed
    $createdBy = $data->createdBy;
    $comments = $data->comments ?? ''; // Optional comments

    $query = "INSERT INTO version (DocumentID, VersionNumber, VersionDate, VersionContent, AuthorUserId, Comments, createdBy) VALUES (:documentID, :versionNumber, :versionDate, :versionContent, :authorUserId, :comments, :createdBy)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':documentID', $documentID);
    $stmt->bindParam(':versionNumber', $versionNumber);
    $stmt->bindParam(':versionDate', $versionDate);
    $stmt->bindParam(':versionContent', $versionContent);
    $stmt->bindParam(':authorUserId', $authorUserId);
    $stmt->bindParam(':comments', $comments);
    $stmt->bindParam(':createdBy', $createdBy);

    if ($stmt->execute()) {
        echo json_encode(["message" => "Version added successfully!"]);
    } else {
        echo json_encode(["message" => "Failed to add version."]);
    }
    exit; // Stop further execution after handling the request
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Local Government Document Management System - Staff Versions Page.">
    <title>Staff Document Management - Versions</title>
    <link rel="stylesheet" href="staff.css">
    <style>
        /* CSS styles for modal and buttons */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 10% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        .versions-section {
            margin-top: 20px;
        }

        .versions-section h3 {
            font-size: 24px;
            color: var(--blue);
            margin-bottom: 20px;
        }

        .add-version-form {
            display: flex;
            flex-direction: column;
            background-color: var(--white);
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        .versions-form {
            display: flex;
            flex-direction: column;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-group input,
        .form-group textarea {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 100%;
        }

        .form-group textarea {
            resize: none;
        }

        .submit-button {
            padding: 10px 15px;
            background-color: var(--blue);
            color: var(--white);
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .submit-button:hover {
            background-color: var(--light-blue);
        }

        .cancel-button {
            padding: 12px 20px;
            background-color: var(--black2);
            border: none;
            border-radius: 5px;
            color: var(--white);
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s, transform 0.2s;
            width: 100%;
            margin-top: 10px;
        }

        .cancel-button:hover {
            background-color: var(--red);
            transform: translateY(-2px);
        }
        /* Add your existing styles here */
    </style>
</head>

<body class="light-mode">
    <div class="container">
        <nav class="navigation">
            <ul>
                <!-- Navigation items -->
                <li>
                    <a href="stabout.php">
                        <span class="icon">
                            <ion-icon name="logo-apple"></ion-icon>
                        </span>
                        <span class="title">Local Gov. Docs</span>
                    </a>
                </li>
                <li>
                    <a href="staff.php">
                        <span class="icon">
                            <ion-icon name="home-outline"></ion-icon>
                        </span>
                        <span class="title">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="stdoc.php">
                        <span class="icon">
                            <ion-icon name="document-text-outline"></ion-icon>
                        </span>
                        <span class="title">Documents</span>
                    </a>
                </li>
                <li>
                    <a href="stcat.php">
                        <span class="icon">
                            <ion-icon name="folder-outline"></ion-icon>
                        </span>
                        <span class="title">Categories</span>
                    </a>
                </li>
                <li>
                    <a href="sttags.php">
                        <span class="icon">
                            <ion-icon name="pricetags-outline"></ion-icon>
                        </span>
                        <span class="title">Tags</span>
                    </a>
                </li>
                <li class="active">
                    <a href="stversions.php">
                        <span class="icon">
                            <ion-icon name="document-text-outline"></ion-icon>
                        </span>
                        <span class="title">Versions</span>
                    </a>
                </li>
                <!-- Other navigation items -->
            </ul>
        </nav>

        <main class="main versions-page">
            <div class="topbar">
                <div class="toggle">
                    <ion-icon name="menu-outline"></ion-icon>
                </div>
                <div class="search">
                    <label>
                        <input type="text" placeholder="Search versions">
                        <ion-icon name="search-outline"></ion-icon>
                    </label>
                </div>
                <button id="themeToggle" class="button" onclick="toggleTheme()">Toggle Theme</button>
                <div class="dropdown">
                    <img src="google.jpg" alt="Profile Picture" style="cursor:pointer; border-radius: 50%; width: 40px; height: 40px;">
                </div>
            </div>

            <section class="versions-section">
                <h3>Staff Document Versions</h3>
                <button id="addVersionBtn" class="button">Add New Version</button>
                <table class="versions-table">
                    <thead>
                        <tr>
                            <th>Version Number</th>
                            <th>Document ID</th> <!-- Added Document ID for clarity -->
                            <th>Version Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($versions as $version): ?>
                        <tr>
                            <td><?= htmlspecialchars($version['VersionNumber']) ?></td>
                            <td><?= htmlspecialchars($version['DocumentID']) ?></td> <!-- Document ID -->
                            <td><?= htmlspecialchars($version['VersionDate']) ?></td>
                            <td>
                                <button class="button">View</button>
                                <button class="button">Delete</button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </section>
        </main>
    </div>

    <div id="addVersionModal" class="modal">
        <div class="modal-content">
            <span class="close" id="closeModal">&times;</span>
            <h2>Add New Version</h2>
            <form id="addVersionForm" class="version-form">
                <div class="form-group">
                    <label for="versionNumber">Version Number</label>
                    <input type="number" id="versionNumber" name="versionNumber" required>
                </div>
                <div class="form-group">
                    <label for="documentID">Document ID</label>
                    <input type="number" id="documentID" name="documentID" required> <!-- Assuming you'll provide Document ID -->
                </div>
                <div class="form-group">
                    <label for="description">Version Content</label>
                    <textarea id="description" name="description" required></textarea>
                </div>
                <div class="form-group">
                    <label for="createdBy">Created By</label>
                    <input type="text" id="createdBy" name="createdBy" required>
                </div>
                <div class="form-group">
                    <label for="versionDate">Version Date</label>
                    <input type="date" id="versionDate" name="versionDate" required>
                </div>
                <button type="submit" class="submit-button">Add Version</button>
                <button type="button" class="cancel-button" id="cancelBtn">Cancel</button>
            </form>
        </div>
    </div>


    <script src="samplemain.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script src="https://unpkg.com/ionicons@5.5.2/dist/ionicons.js"></script>
    <script>
        document.getElementById('addVersionBtn').addEventListener('click', function() {
            document.getElementById('addVersionModal').style.display = 'block';
        });

        document.getElementById('closeModal').onclick = function() {
            document.getElementById('addVersionModal').style.display = 'none';
        };

        document.getElementById('cancelBtn').onclick = function() {
            document.getElementById('addVersionModal').style.display = 'none';
        };

        document.getElementById('addVersionForm').addEventListener('submit', function (e) {
            e.preventDefault();
            const formData = new FormData(this);
            const data = {
                versionNumber: formData.get('versionNumber'),
                documentID: formData.get('documentID'),
                versionDate: formData.get('versionDate'),
                description: formData.get('description'),
                createdBy: formData.get('createdBy'),
                comments: formData.get('comments') || '' // Optional
            };

            fetch('', { // Same page
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(result => {
                alert(result.message);
                fetchVersions(); // Refresh the versions list
                this.reset(); // Reset form after submission
                document.getElementById('addVersionModal').style.display = "none"; // Close the modal
            })
            .catch(error => console.error('Error adding version:', error));
        });

        // Fetch versions when the page loads
        function fetchVersions() {
            // You might want to add code here to fetch and display the latest versions if needed
        }

        // Close modal when clicking outside of it
        window.onclick = function(event) {
            const modal = document.getElementById('addVersionModal');
            if (event.target == modal) {
                modal.style.display = "none";
            }
        };

        // Theme toggle function
        function toggleTheme() {
            const body = document.body;
            body.classList.toggle("light-mode");
            body.classList.toggle("dark-mode");
        }
    </script>

</body>
</html>
