<?php
include 'session_handler.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Local Government Document Management Dashboard for tracking documents, users, and activity.">
    <title>Local Government Document Management Dashboard</title>

    <!-- Stylesheets -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="samplestyle.css">
    <link rel="stylesheet" href="sample2.css">

    <style>
        /* Your existing styles here */
        /* Existing modal styles ... */
        /* Modal Background */
        .modal {
            display: none; /* Hidden by default */
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7); /* Semi-transparent dark background */
            align-items: center;
            justify-content: center;
            animation: fadeIn 0.3s ease; /* Fade-in effect */
        }

        /* Modal Content */
        .modal-content {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            width: 90%;
            max-width: 600px;
            text-align: center;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            transform: translateY(-50px);
            animation: slideDown 0.3s ease forwards;
        }

        /* Close Button */
        .modal .close {
            position: absolute;
            top: 15px;
            right: 15px;
            font-size: 20px;
            font-weight: bold;
            color: #333;
            cursor: pointer;
            transition: color 0.2s ease;
        }

        .modal .close:hover {
            color: #f00;
        }

        /* Modal Content Styling */
        .modal h2 {
            font-size: 24px;
            margin-bottom: 15px;
            color: #333;
        }

        .modal p {
            font-size: 16px;
            color: #666;
            margin-bottom: 20px;
        }

        .modal ul {
            list-style: none;
            padding: 0;
        }

        .modal ul li {
            font-size: 16px;
            color: #444;
            padding: 10px 0;
            border-bottom: 1px solid #ddd;
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes slideDown {
            from {
                transform: translateY(-50px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .modal-footer {
            text-align: center;
            margin-top: 20px;
        }

        .view-more-button {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            display: inline-block;
        }

        .view-more-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body class="light-mode">
    <div class="container">
        <!-- Navigation Section -->
        <nav class="navigation">
            <ul>
                <li>
                    <a href="about.php">
                        <span class="icon"><ion-icon name="logo-apple"></ion-icon></span>
                        <span class="title">Local Gov. Docs</span>
                    </a>
                </li>
                <!-- Additional Nav Items Here -->
                <li>
                    <a href="sample.php">
                        <span class="icon">
                            <ion-icon name="home-outline"></ion-icon>
                        </span>
                        <span class="title">Dashboard</span>
                    </a>
                </li>
                <li class="active">
                    <a href="documents.php">
                        <span class="icon">
                            <ion-icon name="document-text-outline"></ion-icon>
                        </span>
                        <span class="title">Documents</span>
                    </a>
                </li>
                <li>
                    <a href="categories.php">
                        <span class="icon">
                            <ion-icon name="folder-outline"></ion-icon>
                        </span>
                        <span class="title">Categories</span>
                    </a>
                </li>
                <li>
                    <a href="tags.php">
                        <span class="icon">
                            <ion-icon name="pricetags-outline"></ion-icon>
                        </span>
                        <span class="title">Tags</span>
                    </a>
                </li>
                <li>
                    <a href="versions.php">
                        <span class="icon">
                            <ion-icon name="document-text-outline"></ion-icon>
                        </span>
                        <span class="title">Versions</span>
                    </a>
                </li>
                <li>
                    <a href="users.php">
                        <span class="icon">
                            <ion-icon name="people-outline"></ion-icon>
                        </span>
                        <span class="title">Users</span>
                    </a>
                </li>
                <li>
                    <a href="settings.php">
                        <span class="icon">
                            <ion-icon name="settings-outline"></ion-icon>
                        </span>
                        <span class="title">Settings</span>
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Main Content Section -->
        <div class="main">
            <div class="topbar">
                <div class="toggle"><ion-icon name="menu-outline"></ion-icon></div>
                <div class="search">
                    <label>
                    <input type="text" id="searchInput" placeholder="Search here">
                        <ion-icon name="search-outline" id="searchButton" style="cursor: pointer;"></ion-icon>
                    </label>
                </div>
                
                <button id="themeToggle" class="button" onclick="toggleTheme()">Toggle Theme</button>
                <div class="dropdown">
                    <img src="fb.jpg" alt="Profile Picture" style="cursor:pointer; border-radius: 50%; width: 40px; height: 40px;">
                    <span id="userNameDisplay" style="margin-left: 10px; font-weight: bold;"></span>
                    <div class="dropdown-content">
                        <a href="profile.php">Profile</a>
                        <a href="logout.php">Logout</a>
                    </div>
                </div>
            </div>

            <h1>Overview</h1>
            <div class="charts-container">
                <div class="card-container">
                    <!-- Card for Total Documents -->
                    <div class="card" onclick="openModal('total-documents-modal')">
                        <div class="card-title">Total Documents</div>
                        <div class="card-value" id="total-documents">
                            <?php
                            $conn = new mysqli("localhost", "root", "", "lgmsys");
                            if ($conn->connect_error) {
                                die("Connection failed: " . $conn->connect_error);
                            }

                            $totalDocumentsQuery = "SELECT COUNT(*) as total FROM Documents";
                            $totalDocumentsResult = $conn->query($totalDocumentsQuery);
                            $totalDocumentsCount = 0;
                            if ($totalDocumentsResult) {
                                $row = $totalDocumentsResult->fetch_assoc();
                                $totalDocumentsCount = $row['total'];
                            }
                            $conn->close();
                            echo htmlspecialchars($totalDocumentsCount);
                            ?>
                        </div>
                        <canvas id="documentsChart" class="chart"></canvas>
                    </div>

                    <!-- Modal for Total Documents -->
                    <div id="total-documents-modal" class="modal">
                        <div class="modal-content">
                            <span class="close" onclick="closeModal('total-documents-modal')">&times;</span>
                            <h2>Total Documents</h2>
                            <p>Document Details:</p>
                            <ul id="document-list">
                                <!-- Document details will be populated here -->
                            </ul>
                            <div class="modal-footer">
                                <a href="documents.php" class="view-more-button">View More</a>
                            </div>
                        </div>
                    </div>

                    <!-- Card for Total Users -->
                    <div class="card" onclick="openModal('total-users-modal')">
                        <div class="card-title">Total Users</div>
                        <div class="card-value" id="total-users">
                            <?php
                            // Database connection
                            $conn = new mysqli("localhost", "root", "", "lgmsys");
                            // Check connection
                            if ($conn->connect_error) {
                                die("Connection failed: " . $conn->connect_error);
                            }

                            // Query to count total users
                            $totalUsersQuery = "SELECT COUNT(*) as total FROM Users"; // Assuming 'Users' is your table name
                            $totalUsersResult = $conn->query($totalUsersQuery);
                            $totalUsersCount = 0;

                            if ($totalUsersResult) {
                                $row = $totalUsersResult->fetch_assoc();
                                $totalUsersCount = $row['total'];
                            }

                            $conn->close(); // Close the connection

                            // Display the total users count
                            echo htmlspecialchars($totalUsersCount);
                            ?>
                        </div>
                    </div>

                    <!-- Modal for Total Users -->
                    <div id="total-users-modal" class="modal">
                        <div class="modal-content">
                            <span class="close" onclick="closeModal('total-users-modal')">&times;</span>
                            <h2>Total Users</h2>
                            <p>User Details:</p>
                            <ul id="user-list">
                                <!-- User list will be populated here -->
                            </ul>
                            <div class="modal-footer">
                                <a href="users.php" class="view-more-button">View More</a>
                            </div>
                        </div>
                    </div>

                    <!-- Card for New Users This Month -->
                    <div class="card">
                        <div class="card-title">New Users This Month</div>
                        <div class="card-value" id="new-users-this-month">
                            <?php
                            $conn = new mysqli("localhost", "root", "", "lgmsys");
                            if ($conn->connect_error) {
                                die("Connection failed: " . $conn->connect_error);
                            }
                            $newUserQuery = "SELECT COUNT(*) as total FROM Users WHERE createdOn >= DATE_SUB(NOW(), INTERVAL 1 MONTH)"; // Assuming 'createdOn' column exists
                            $newUserResult = $conn->query($newUserQuery);
                            $newUsersCount = 0;
                            if ($newUserResult) {
                                $row = $newUserResult->fetch_assoc();
                                $newUsersCount = $row['total'];
                            }
                            $conn->close();
                            echo htmlspecialchars($newUsersCount);
                            ?>
                        </div>
                    </div>

                    <!-- Card for Most Active User -->
                    <div class="card">
                        <div class="card-title">Most Active User</div>
                        <div class="card-value" id="most-active-user">
                            <?php
                            $conn = new mysqli("localhost", "root", "", "lgmsys");
                            if ($conn->connect_error) {
                                die("Connection failed: " . $conn->connect_error);
                            }
                            $activeUserQuery = "
                                SELECT Username, COUNT(*) as actions 
                                FROM activitylog 
                                GROUP BY Username 
                                ORDER BY actions DESC 
                                LIMIT 1";
                            $activeUserResult = $conn->query($activeUserQuery);
                            $mostActiveUser = "None";
                            if ($activeUserResult && $row = $activeUserResult->fetch_assoc()) {
                                $mostActiveUser = htmlspecialchars($row['Username']);
                            }
                            $conn->close();
                            echo $mostActiveUser;
                            ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Content -->
            <div class="activity-section">
                <h2>Recent Activity</h2>
                <div class="recent-activity-container">
                    <ul class="activity-log">
                        <?php
                        $conn = new mysqli("localhost", "root", "", "lgmsys");

                        // Check connection
                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }

                        // Query to fetch recent activities
                        $activityQuery = "SELECT Username, activity, createdOn FROM activitylog ORDER BY createdOn DESC LIMIT 5";
                        $activityResult = $conn->query($activityQuery);

                        if ($activityResult->num_rows > 0) {
                            while ($activity = $activityResult->fetch_assoc()) {
                                echo "<li><strong>" . htmlspecialchars($activity['Username']) . "</strong>: " . htmlspecialchars($activity['activity']) . " <em>(" . htmlspecialchars($activity['createdOn']) . ")</em></li>";
                            }
                        } else {
                            echo "<li>No recent activities found.</li>";
                        }

                        $conn->close();
                        ?>
                    </ul>
                </div>
            </div>

            <!-- Charts Section -->
            <section id="charts" style="margin-top: 20px;">
                <h2>System Charts</h2>
                <div class="charts-container"> <!-- Container for Flexbox -->
                    <div class="chart-card">
                        <h3>Document Types Distribution</h3>
                        <canvas id="documentTypesChart"></canvas>
                    </div>
                    <div class="chart-card">
                        <h3>User Activity Over Time</h3>
                        <canvas id="userActivityChart"></canvas>
                    </div>
                    <div class="chart-card">
                        <h3>Document Uploads This Month</h3>
                        <canvas id="uploadsThisMonthChart"></canvas>
                    </div>
                    <div class="chart-card">
                        <h3>User Registrations Over Time</h3>
                        <canvas id="userRegistrationsChart"></canvas>
                    </div>
                </div>
            </section>

        </div>
    </div>

    <!-- Modal Structure for Search Results -->
<div id="searchResultsModal" class="modal" style="display:none;">
    <div class="modal-content">
        <span class="close-button" id="closeModal">&times;</span>
        <h2>Search Results</h2>
        <div id="searchResults" class="search-results">
            <!-- Search results will be dynamically populated here -->
        </div>
    </div>
</div>




                

    <!-- Script Section -->
    <script src="samplemain.js"></script>
    <script src="sample2.js"></script>
    <script src="sample3.js" defer></script>

    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule="" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

<script>


    
</script>

</body>

</html>

    