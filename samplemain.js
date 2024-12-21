// General (existing) navigation elements and functionality
const navigation = document.querySelector(".navigation");
const listItems = document.querySelectorAll(".navigation li");
const themeToggle = document.querySelector(".theme-toggle");
const mainContent = document.querySelector(".main");
const body = document.body;

// Function to handle hovering over navigation items
function handleHover(event) {
    const selectedItem = event.target.closest("li");
    if (selectedItem) {
        listItems.forEach(item => item.classList.remove("hovered"));
        selectedItem.classList.add("hovered");
    }
}

function toggleTheme() {
    document.body.classList.toggle("dark-mode");
}


// Add event listener for mouseover on general navigation
navigation.addEventListener("mouseover", handleHover);

// Menu Toggle functionality for collapsing the sidebar
const menuToggle = document.querySelector(".toggle");
menuToggle.addEventListener("click", () => {
    navigation.classList.toggle("active");
    mainContent.classList.toggle("active");
});

// General sample activity data
const sampleActivityData = [
    {
        id: 1,
        documentName: "Annual Budget Report",
        action: "Edited",
        user: "Bill Dominic",
        date: "2024-10-08 12:00"
    },
    {
        id: 2,
        documentName: "Meeting Minutes",
        action: "Reviewed",
        user: "Jane Smith",
        date: "2024-10-07 09:30"
    },
];

// Function to create a list item for activity (general)
function createActivityItem(activity) {
    const listItem = document.createElement('li');
    listItem.innerHTML = `
        <ion-icon name="document-text-outline"></ion-icon>
        <span>
            <strong>Document Name:</strong> ${activity.documentName}
            <br>
            <strong>Action:</strong> ${activity.action}
            <br>
            <strong>User:</strong> ${activity.user}
            <br>
            <strong>Date:</strong> ${activity.date}
        </span>
    `;
    return listItem;
}

// Function to update the activity list dynamically (general)
function updateActivityList(activityData) {
    const activityList = document.querySelector('.activity-list');
    activityList.innerHTML = '';

    activityData.forEach(activity => {
        const listItem = createActivityItem(activity);
        activityList.appendChild(listItem);
    });
}

// Populate the activity list (general)
updateActivityList(sampleActivityData);

// Chart data and configuration
const labels = ['January', 'February', 'March', 'April', 'May', 'June', 'July'];

const data1 = {
    labels: labels,
    datasets: [{
        label: 'My First dataset',
        backgroundColor: 'rgba(255, 99, 132, 0.2)',
        borderColor: 'rgba(255, 99, 132, 1)',
        borderWidth: 1,
        data: [0, 10, 5, 2, 20, 30, 45],
    }]
};

const data2 = {
    labels: labels,
    datasets: [{
        label: 'My Second dataset',
        backgroundColor: 'rgba(54, 162, 235, 0.2)',
        borderColor: 'rgba(54, 162, 235, 1)',
        borderWidth: 1,
        data: [10, 15, 20, 25, 30, 35, 40],
    }]
};

// Chart configurations
const config1 = {
    type: 'line',
    data: data1,
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
};

const config2 = {
    type: 'bar',
    data: data2,
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
};

// Function to create charts
function createCharts() {
    const myChart1 = new Chart(document.getElementById('myChart1'), config1);
    const myChart2 = new Chart(document.getElementById('myChart2'), config2);
}

// Call function to create charts initially
createCharts();

// Notification functionality
function showNotification(message) {
    const notification = document.querySelector('.notification');
    notification.textContent = message;
    notification.classList.add('show');

    // Hide the notification after 3 seconds
    setTimeout(() => {
        notification.classList.remove('show');
    }, 3000);
}

// Example of triggering a notification
showNotification('Dashboard loaded successfully');

// Document page-specific logic (isolated)
function initDocumentPage() {
    // Document-specific navigation elements
    const docNavigation = document.querySelector(".doc-navigation");
    const docListItems = document.querySelectorAll(".doc-navigation li");
    const docThemeToggle = document.querySelector(".doc-theme-toggle");
    const docMainContent = document.querySelector(".doc-main");

    // Function to handle hovering over document navigation items
    function handleDocHover(event) {
        const selectedItem = event.target.closest("li");
        if (selectedItem) {
            docListItems.forEach(item => item.classList.remove("hovered"));
            selectedItem.classList.add("hovered");
        }
    }

    // Add event listener for mouseover on document navigation
    docNavigation.addEventListener("mouseover", handleDocHover);

    // Menu Toggle functionality for document page sidebar
    const docMenuToggle = document.querySelector(".doc-toggle");
    docMenuToggle.addEventListener("click", () => {
        docNavigation.classList.toggle("active");
        docMainContent.classList.toggle("active");
    });

    // Theme toggle functionality for document page
    docThemeToggle.addEventListener("click", () => {
        document.body.classList.toggle("dark-mode");
    });

    // Document-specific sample activity data
    const docSampleActivityData = [
        {
            id: 1,
            documentName: "Financial Summary Q3",
            action: "Reviewed",
            user: "Alice Green",
            date: "2024-10-10 14:30"
        },
        {
            id: 2,
            documentName: "Project Plan Update",
            action: "Approved",
            user: "David Wilson",
            date: "2024-10-09 11:00"
        },
    ];

    // Function to update the document-specific activity list
    function updateDocActivityList(activityData) {
        const docActivityList = document.querySelector('.doc-activity-list');
        docActivityList.innerHTML = '';

        activityData.forEach(activity => {
            const listItem = createActivityItem(activity); // Reuse the same general function
            docActivityList.appendChild(listItem);
        });
    }

    // Populate the document-specific activity list
    updateDocActivityList(docSampleActivityData);

    // Document-specific notification
    function showDocNotification(message) {
        const docNotification = document.querySelector('.doc-notification');
        docNotification.textContent = message;
        docNotification.classList.add('show');

        setTimeout(() => {
            docNotification.classList.remove('show');
        }, 3000);
    }

    // Trigger a document page-specific notification
    showDocNotification('Document page loaded successfully');
}

// Check if the document page is loaded and initialize it
if (document.querySelector('.doc-main')) {
    initDocumentPage(); // Call the document-specific logic
}
// Optional JavaScript for form submission and activity logging
document.getElementById("userForm").addEventListener("submit", function (event) {
    event.preventDefault();
    const username = document.getElementById("username").value;
    const role = document.getElementById("role").value;

    // Append new user to the table
    const table = document.querySelector(".user-management-table tbody");
    const newRow = table.insertRow();
    newRow.innerHTML = `<td>${username}</td><td>${role}</td>`;

    // Log recent activity
    const activityLog = document.querySelector(".activity-log");
    const logItem = document.createElement("li");
    logItem.textContent = `User ${username} with role ${role} added.`;
    activityLog.appendChild(logItem);

    // Clear form
    document.getElementById("userForm").reset();
});
