// Event listener for when the DOM content is fully loaded
document.addEventListener('DOMContentLoaded', async function() {
    // Fetch data for charts
    await fetchChartData();
    // Fetch the logged-in user's name
    await fetchCurrentUser();
    // Setup search input and card event handlers
    setupSearchInput();
    setupCardHandlers(); // Ensure card handlers are set up
});

// Function to fetch data for all charts
async function fetchChartData() {
    try {
        const chartsData = {
            documentTypes: await fetchDocumentTypes(),
            userActivity: await fetchUserActivity(),
            uploadsThisMonth: await fetchUploadsThisMonth(),
            userRegistrations: await fetchUserRegistrations()
        };

        // Render the charts with fetched data
        renderCharts(chartsData);
    } catch (error) {
        console.error('Error fetching chart data:', error);
    }
}

// Function to handle card setup for showing results in their own modals
function setupCardHandlers() {
    // Event listener for "Total Documents" card
    document.getElementById('totalDocumentsCard').addEventListener('click', async function() {
        try {
            const results = await fetch('fetch_total_documents.php').then(response => response.json());
            displayDocumentResults(results); // New function for documents
            openDocumentModal(); // Open the document modal
        } catch (error) {
            console.error('Error fetching total documents:', error);
        }
    });

    // Event listener for "Total Users" card
    document.getElementById('totalUsersCard').addEventListener('click', async function() {
        try {
            const results = await fetch('fetch_total_users.php').then(response => response.json());
            displayUserResults(results); // New function for users
            openUserModal(); // Open the user modal
        } catch (error) {
            console.error('Error fetching total users:', error);
        }
    });
}

// Function to handle search functionality
document.getElementById('searchButton').addEventListener('click', function() {
    const query = document.getElementById('searchInput').value.trim();
    if (query) {
        performSearch(query);
    }
});

// Optional: Allow pressing Enter to trigger search
document.getElementById('searchInput').addEventListener('keypress', function(event) {
    if (event.key === 'Enter') {
        const query = this.value.trim();
        if (query) {
            performSearch(query);
        }
    }
});

// Function to perform the search
async function performSearch(query) {
    try {
        const results = await fetch(`search.php?q=${encodeURIComponent(query)}`).then(response => response.json());
        displaySearchResults(results);
        if (results.length > 0) {
            openSearchModal(); // Open the search results modal
        } else {
            alert('No results found.'); // Alert if no results are found
        }
    } catch (error) {
        console.error('Error fetching search results:', error);
    }
}

// Function to open the search results modal
function openSearchModal() {
    const searchResultsModal = document.getElementById('searchResultsModal');
    searchResultsModal.style.display = 'block';
}

// Function to open the total documents modal
function openDocumentModal() {
    const documentResultsModal = document.getElementById('total-documents-modal');
    documentResultsModal.style.display = 'block';
}

// Function to open the total users modal
function openUserModal() {
    const userResultsModal = document.getElementById('total-users-modal');
    userResultsModal.style.display = 'block';
}

// Function to display search results
function displaySearchResults(results) {
    const resultsContainer = document.getElementById('searchResults');
    resultsContainer.innerHTML = ''; // Clear previous results

    if (results.length === 0) {
        resultsContainer.innerHTML = '<p>No results found.</p>';
        return;
    }

    const ul = document.createElement('ul');
    results.forEach(result => {
        const li = document.createElement('li');
        li.textContent = `${result.source}: ${result.activity || result.categoryName || result.documentTitle || result.TagName || result.username}`;
        ul.appendChild(li);
    });
    resultsContainer.appendChild(ul);
}

function setupSearchInput() {
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        // You can add further initialization for search input here if needed
        console.log('Search input is set up');
    } else {
        console.error('Search input element not found');
    }
}


// Function to display document results
function displayDocumentResults(results) {
    const resultsContainer = document.getElementById('documentResults');
    resultsContainer.innerHTML = ''; // Clear previous results

    if (results.length === 0) {
        resultsContainer.innerHTML = '<p>No documents found.</p>';
        return;
    }

    const ul = document.createElement('ul');
    results.forEach(result => {
        const li = document.createElement('li');
        li.textContent = result.documentTitle; // Adjust as needed
        ul.appendChild(li);
    });
    resultsContainer.appendChild(ul);
}

// Function to display user results
function displayUserResults(results) {
    const resultsContainer = document.getElementById('userResults');
    resultsContainer.innerHTML = ''; // Clear previous results

    if (results.length === 0) {
        resultsContainer.innerHTML = '<p>No users found.</p>';
        return;
    }

    const ul = document.createElement('ul');
    results.forEach(result => {
        const li = document.createElement('li');
        li.textContent = result.username; // Adjust as needed
        ul.appendChild(li);
    });
    resultsContainer.appendChild(ul);
}

// Function to close the search results modal
document.getElementById('closeModal').addEventListener('click', function() {
    document.getElementById('searchResultsModal').style.display = 'none';
});

// Function to close the document results modal
document.querySelector('#total-documents-modal .close').addEventListener('click', function() {
    document.getElementById('total-documents-modal').style.display = 'none';
});

// Function to close the user results modal
document.querySelector('#total-users-modal .close').addEventListener('click', function() {
    document.getElementById('total-users-modal').style.display = 'none';
});

// Close the modal when clicking outside of it (for search results modal)
window.onclick = function(event) {
    const searchResultsModal = document.getElementById('searchResultsModal');
    if (event.target === searchResultsModal) {
        searchResultsModal.style.display = 'none'; // Hide the search results modal if clicked outside
    }
};

// Fetch current user data
async function fetchCurrentUser() {
    try {
        const response = await fetch('fetchCurrentUser.php');
        const data = await response.json();
        const userNameDisplay = document.getElementById('userNameDisplay');
        userNameDisplay.textContent = data.name; // Display user name
    } catch (error) {
        console.error('Error fetching user data:', error);
    }
}

// Function to fetch document types data
async function fetchDocumentTypes() {
    try {
        const response = await fetch('fetch_document_types.php');
        if (!response.ok) throw new Error('Network response was not ok');
        return await response.json();
    } catch (error) {
        console.error('Failed to fetch document types:', error);
        return { labels: [], data: [] }; // Return empty data on error
    }
}

// Function to fetch user activity data
async function fetchUserActivity() {
    try {
        const response = await fetch('fetch_user_activity.php');
        if (!response.ok) throw new Error('Network response was not ok');
        return await response.json();
    } catch (error) {
        console.error('Failed to fetch user activity:', error);
        return { labels: [], data: [] }; // Return empty data on error
    }
}

// Function to fetch uploads this month data
async function fetchUploadsThisMonth() {
    try {
        const response = await fetch('fetch_uploads_this_month.php');
        if (!response.ok) throw new Error('Network response was not ok');
        return await response.json();
    } catch (error) {
        console.error('Failed to fetch uploads this month:', error);
        return { labels: [], data: [] }; // Return empty data on error
    }
}

// Function to fetch user registrations data
async function fetchUserRegistrations() {
    try {
        const response = await fetch('fetch_user_registrations.php');
        if (!response.ok) throw new Error('Network response was not ok');
        return await response.json();
    } catch (error) {
        console.error('Failed to fetch user registrations:', error);
        return { labels: [], data: [] }; // Return empty data on error
    }
}

// Function to render the charts with the fetched data
function renderCharts(data) {
    console.log('Data for charts:', data); // Log the data being passed

    // Document Types Chart
    const ctxDocumentTypes = document.getElementById('documentTypesChart');
    if (ctxDocumentTypes) {
        new Chart(ctxDocumentTypes.getContext('2d'), {
            type: 'pie',
            data: {
                labels: data.documentTypes.labels,
                datasets: [{
                    data: data.documentTypes.data,
                    backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56'], // Customize colors as needed
                }]
            }
        });
    }

    // User Activity Chart
    const ctxUserActivity = document.getElementById('userActivityChart');
    if (ctxUserActivity) {
        new Chart(ctxUserActivity.getContext('2d'), {
            type: 'line',
            data: {
                labels: data.userActivity.labels,
                datasets: [{
                    label: 'User Activity',
                    data: data.userActivity.data,
                    borderColor: '#36A2EB',
                    fill: false,
                }]
            }
        });
    }

    // Uploads This Month Chart
    const ctxUploadsThisMonth = document.getElementById('uploadsThisMonthChart');
    if (ctxUploadsThisMonth) {
        new Chart(ctxUploadsThisMonth.getContext('2d'), {
            type: 'bar',
            data: {
                labels: data.uploadsThisMonth.labels,
                datasets: [{
                    label: 'Uploads',
                    data: data.uploadsThisMonth.data,
                    backgroundColor: '#FFCE56',
                }]
            }
        });
    }

    // User Registrations Chart
    const ctxUserRegistrations = document.getElementById('userRegistrationsChart');
    if (ctxUserRegistrations) {
        new Chart(ctxUserRegistrations.getContext('2d'), {
            type: 'bar',
            data: {
                labels: data.userRegistrations.labels,
                datasets: [{
                    label: 'User Registrations',
                    data: data.userRegistrations.data,
                    backgroundColor: '#FF6384',
                }]
            }
        });
    }
}
