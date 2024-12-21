<?php
include 'session_handler.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Local Government Document Management System - Settings Page.">
    <title>Document Management - Settings</title>
    <link rel="stylesheet" href="settings.css">
    <style>
        /* Basic modal styling */
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

        /* New layout and card styling */
        .card {
            background-color: #fff;
            margin: 20px 0;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .toggle-button {
            background-color: #007BFF;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            margin-bottom: 10px; /* Added spacing */
        }

        .hidden {
            display: none; /* Ensure the hidden class hides elements */
        }

        .settings-form .form-group {
            margin-bottom: 15px; /* Added spacing between form fields */
        }
    </style>
</head>

<body class="light-mode">
    <div class="container">

        <!-- Navigation Section -->
        <nav class="navigation">
            <ul>
                <li><a href="about.php"><span class="icon"><ion-icon name="logo-apple"></ion-icon></span><span class="title">Local Gov. Docs</span></a></li>
                <li><a href="sample.php"><span class="icon"><ion-icon name="home-outline"></ion-icon></span><span class="title">Dashboard</span></a></li>
                <li><a href="documents.php"><span class="icon"><ion-icon name="document-text-outline"></ion-icon></span><span class="title">Documents</span></a></li>
                <li><a href="categories.php"><span class="icon"><ion-icon name="folder-outline"></ion-icon></span><span class="title">Categories</span></a></li>
                <li><a href="tags.php"><span class="icon"><ion-icon name="pricetags-outline"></ion-icon></span><span class="title">Tags</span></a></li>
                <li><a href="versions.php"><span class="icon"><ion-icon name="document-text-outline"></ion-icon></span><span class="title">Versions</span></a></li>
                <li><a href="users.php"><span class="icon"><ion-icon name="people-outline"></ion-icon></span><span class="title">Users</span></a></li>
                <li class="active"><a href="settings.php"><span class="icon"><ion-icon name="settings-outline"></ion-icon></span><span class="title">Settings</span></a></li>
            </ul>
        </nav>

        <!-- Main Content Section -->
        <main class="main settings-page">
            <div class="topbar">
                <div class="toggle"><ion-icon name="menu-outline"></ion-icon></div>
                <div class="search">
                    <label><input type="text" placeholder="Search settings" aria-label="Search settings"><ion-icon name="search-outline"></ion-icon></label>
                </div>
                <button id="themeToggle" class="button" onclick="toggleTheme()">Toggle Theme</button>
            </div>

            <section class="settings-section">
                <h3>System Settings</h3>

                <!-- Security Settings Section -->
                <div class="card">
                    <button class="toggle-button" onclick="toggleForm('securitySettingsForm')">Security Settings</button>
                    <div id="securitySettingsForm" class="hidden">
                        <form class="settings-form" onsubmit="event.preventDefault(); saveSettings('securitySettingsForm', 'updateSecurity.php');">
                            <div class="form-group">
                                <label for="mfa">Enable Multi-Factor Authentication (MFA):</label>
                                <input type="checkbox" id="mfa" name="mfa">
                            </div>
                            <div class="form-group">
                                <label for="passwordPolicy">Password Policy:</label>
                                <select id="passwordPolicy" name="passwordPolicy">
                                    <option value="strong">Strong</option>
                                    <option value="moderate">Moderate</option>
                                    <option value="weak">Weak</option>
                                </select>
                            </div>
                            <button type="submit" class="button">Save Security Settings</button>
                        </form>
                    </div>
                </div>

                <!-- Backup Settings Section -->
                <div class="card">
                    <button class="toggle-button" onclick="toggleForm('backupSettingsForm')">Backup Settings</button>
                    <div id="backupSettingsForm" class="hidden">
                        <form class="settings-form" onsubmit="event.preventDefault(); saveSettings('backupSettingsForm', 'updateBackup.php');">
                            <div class="form-group">
                                <label for="backupFrequency">Backup Frequency:</label>
                                <select id="backupFrequency" name="backupFrequency">
                                    <option value="daily">Daily</option>
                                    <option value="weekly">Weekly</option>
                                    <option value="monthly">Monthly</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="backupLocation">Backup Location:</label>
                                <input type="text" id="backupLocation" name="backupLocation" placeholder="Enter backup location" required aria-required="true">
                            </div>
                            <div class="form-group">
                                <label for="backupRetention">Backup Retention Policy:</label>
                                <select id="backupRetention" name="backupRetention">
                                    <option value="7">7 days</option>
                                    <option value="30">30 days</option>
                                    <option value="60">60 days</option>
                                    <option value="90">90 days</option>
                                    <option value="custom">Custom (Specify below)</option>
                                </select>
                                <input type="number" id="customRetention" name="customRetention" placeholder="Enter custom retention period in days" min="1" style="display:none;">
                            </div>
                            <div class="form-group">
                                <label for="backupMethod">Backup Method:</label>
                                <select id="backupMethod" name="backupMethod">
                                    <option value="full">Full</option>
                                    <option value="incremental">Incremental</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="backupTime">Scheduled Backup Time:</label>
                                <input type="time" id="backupTime" name="backupTime" required aria-required="true">
                            </div>
                            <div class="form-group">
                                <label for="encryption">Enable Backup Encryption:</label>
                                <input type="checkbox" id="encryption" name="encryption">
                                <span>Encrypt backup files for added security.</span>
                            </div>
                            <div class="form-group">
                                <label for="backupVerification">Enable Backup Verification:</label>
                                <input type="checkbox" id="backupVerification" name="backupVerification">
                                <span>Verify backups after creation to ensure integrity.</span>
                            </div>
                            <div class="form-group">
                                <label for="emailNotifications">Email Notifications:</label>
                                <input type="checkbox" id="emailNotifications" name="emailNotifications">
                                <span>Receive email notifications on backup completion or failure.</span>
                            </div>
                            <button type="submit" class="button">Save Backup Settings</button>
                        </form>
                    </div>
                </div>

                <!-- User Permissions Section -->
                <div class="card">
                    <button class="toggle-button" onclick="toggleForm('userPermissionsForm')">User Permissions</button>
                    <div id="userPermissionsForm" class="hidden">
                        <form class="settings-form" onsubmit="event.preventDefault(); saveSettings('userPermissionsForm', 'updatePermissions.php');">
                            <div class="form-group">
                                <label for="defaultRole">Default Role for New Users:</label>
                                <select id="defaultRole" name="defaultRole">
                                    <option value="admin">Admin</option>
                                    <option value="editor">Staff</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="permissionLevels">Set Permission Levels:</label>
                                <select id="permissionLevels" name="permissionLevels">
                                    <option value="full">Full Access</option>
                                    <option value="limited">Limited Access</option>
                                    <option value="none">No Access</option>
                                </select>
                            </div>
                            <button type="submit" class="button">Save User Permissions</button>
                        </form>
                    </div>
                </div>

                <!-- User Permissions Section -->
                <div class="card">
                    <button class="toggle-button" onclick="toggleForm('userPermissionsForm')">User Permissions</button>
                    <div id="userPermissionsForm" class="hidden">
                        <form class="settings-form" onsubmit="event.preventDefault(); saveSettings('userPermissionsForm', 'updatePermissions.php');">
                            <div class="form-group">
                                <label for="defaultRole">Default Role for New Users:</label>
                                <select id="defaultRole" name="defaultRole">
                                    <option value="viewer">Staff</option>
                                    <option value="admin">Admin</option>
                                </select>
                            </div>
                            <button type="submit" class="button">Save Permissions</button>
                        </form>
                    </div>
                </div>

                <!-- Notification Settings Section -->
                <div class="card">
                    <button class="toggle-button" onclick="toggleForm('notificationSettingsForm')">Notification Settings</button>
                    <div id="notificationSettingsForm" class="hidden">
                        <form class="settings-form" onsubmit="event.preventDefault(); saveSettings('notificationSettingsForm', 'updateNotifications.php');">
                            <div class="form-group">
                                <label for="documentUpdateNotify">Notify on Document Update:</label>
                                <input type="checkbox" id="documentUpdateNotify" name="documentUpdateNotify">
                            </div>
                            <div class="form-group">
                                <label for="newDocumentNotify">Notify on New Document Upload:</label>
                                <input type="checkbox" id="newDocumentNotify" name="newDocumentNotify">
                            </div>
                            <button type="submit" class="button">Save Notification Settings</button>
                        </form>
                    </div>
                </div>

                <!-- General Settings Section -->
                <div class="card">
        <button class="toggle-button" onclick="toggleForm('generalSettingsForm')">General Settings</button>
         <div id="generalSettingsForm" class="hidden">
        <form class="settings-form" onsubmit="event.preventDefault(); saveSettings('generalSettingsForm', 'updateSettings.php');">
            <div class="form-group">
                <label for="siteTitle">Site Title:</label>
                <input type="text" id="siteTitle" name="siteTitle" placeholder="Enter site title" required aria-required="true">
            </div>
            <div class="form-group">
                <label for="siteDescription">Site Description:</label>
                <textarea id="siteDescription" name="siteDescription" placeholder="Enter a brief site description" rows="3"></textarea>
            </div>
            <div class="form-group">
                <label for="siteLogo">Upload Site Logo:</label>
                <input type="file" id="siteLogo" name="siteLogo" accept="image/*">
            </div>
            <div class="form-group">
                <label for="siteLanguage">Site Language:</label>
                <select id="siteLanguage" name="siteLanguage">
                    <option value="en">English</option>
                    <option value="es">Spanish</option>
                    <option value="fr">French</option>
                </select>
            </div>
            <div class="form-group">
                <label for="timezone">Timezone:</label>
                <select id="timezone" name="timezone">
                    <option value="GMT">GMT</option>
                    <option value="EST">EST</option>
                    <option value="PST">PST</option>
                    <!-- Additional timezones can be added here -->
                </select>
            </div>
            <div class="form-group">
                <label for="maintenanceMode">Maintenance Mode:</label>
                <input type="checkbox" id="maintenanceMode" name="maintenanceMode">
                <span>Enable maintenance mode to take the site offline for updates.</span>
            </div>
            <div class="form-group">
                <label for="defaultHomePage">Default Home Page:</label>
                <input type="text" id="defaultHomePage" name="defaultHomePage" placeholder="Enter default home page URL">
            </div>
            <div class="form-group">
                <label for="emailNotifications">Email Notifications:</label>
                <select id="emailNotifications" name="emailNotifications">
                    <option value="enabled">Enabled</option>
                    <option value="disabled">Disabled</option>
                </select>
                <span>Select whether to enable or disable email notifications for site events.</span>
            </div>
            <button type="submit" class="button">Save General Settings</button>
        </form>
    </div>
</div> 

                <!-- Display Current Settings -->
                <h4>Current Settings:</h4>
                <div id="currentSettings"></div>

            </section>
        </main>
    </div>

    <script>
        function toggleForm(formId) {
            const form = document.getElementById(formId);
            if (form.classList.contains('hidden')) {
                form.classList.remove('hidden');
            } else {
                form.classList.add('hidden');
            }
        }

        function toggleTheme() {
            document.body.classList.toggle('dark-mode');
        }

        function saveSettings(formId, actionUrl) {
            const formData = new FormData(document.getElementById(formId));
            fetch(actionUrl, {
                method: 'POST',
                body: formData
            }).then(response => {
                if (response.ok) {
                    alert('Settings saved successfully!');
                    // Optionally, update the current settings display
                    updateCurrentSettings();
                } else {
                    alert('Error saving settings.');
                }
            }).catch(error => {
                console.error('Error:', error);
                alert('An error occurred while saving settings.');
            });
        }

        function updateCurrentSettings() {
            // Placeholder function to display current settings
            // You can implement logic to fetch and display current settings from the server
            const currentSettings = document.getElementById('currentSettings');
            currentSettings.innerHTML = '<p>Current settings displayed here...</p>';
        }
    </script>
    <script src="samplemain.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script src="https://unpkg.com/ionicons@5.5.2/dist/ionicons.js"></script>
</body>

</html>
