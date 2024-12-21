// Function to save changes
function saveChanges() {
    // Get form values
    const userId = document.getElementById('userId').value; // Get the user ID from a hidden input or another source
    const firstName = document.getElementById('firstName').value;
    const lastName = document.getElementById('lastName').value;
    const userName = document.getElementById('userName').value;
    const email = document.getElementById('email').value;
    const phone = document.getElementById('phone').value;
    const profilePicture = document.getElementById('profilePicture').files[0]; // Only if a picture is uploaded
    const role = document.getElementById('role').value;

    // Create a FormData object to hold the form values
    const formData = new FormData();
    formData.append('id', userId); // Add user ID to form data
    formData.append('firstName', firstName);
    formData.append('lastName', lastName);
    formData.append('userName', userName);
    formData.append('email', email);
    formData.append('phone', phone);
    formData.append('role', role);

    // Conditionally append the profile picture if a file is selected
    if (profilePicture) {
        formData.append('profilePicture', profilePicture);
    }

    // Use fetch to send a POST request with the form data
    fetch('http://localhost:3000/api/edit-profile', {
        method: 'POST',
        body: formData, // Send formData as the body
    })
    .then(response => {
        if (response.ok) {
            return response.text(); // Expect text response from the server
        } else {
            throw new Error('Failed to update profile'); // Error if status is not OK
        }
    })
    .then(data => {
        alert(data); // Show the response message from the server
        document.getElementById('editProfileModal').style.display = 'none'; // Close modal on success
    })
    .catch(error => {
        alert(error.message); // Show any errors in an alert
    });
}

// Attach the function to your save button click event
document.getElementById('saveButton').addEventListener('click', function(event) {
    event.preventDefault(); // Prevent the default form submission (page reload)
    saveChanges(); // Call saveChanges on click
});

// Document Ready Event
document.addEventListener('DOMContentLoaded', function () {
    fetchCurrentUser();
    fetchDocumentUploads(); // Call fetchDocumentUploads on load
});

// Modal Functions
function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modalId === 'total-documents-modal') {
        fetchDocuments(); // Fetch documents if the specific modal is opened
    } else if (modalId === 'total-users-modal') {
        fetchUsers(); // Fetch users when opening this specific modal
    }
    modal.style.display = 'flex'; // Use 'flex' to enable centering
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    modal.style.display = 'none';
}

// Fetch Functions
function fetchDocuments() {
    fetch('fetchDocuments.php') 
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log(data); // Log the response data
            const modalContent = document.querySelector('#total-documents-modal .modal-content ul');
            modalContent.innerHTML = ''; // Clear existing content
            if (data.length === 0) {
                const li = document.createElement('li');
                li.textContent = 'No documents found.';
                modalContent.appendChild(li);
            } else {
                data.forEach(doc => {
                    const li = document.createElement('li');
                    li.textContent = `${doc.documentTitle}: ${doc.Status}`; // Use correct keys
                    modalContent.appendChild(li);
                });
            }
        })
        .catch(error => console.error('Error fetching documents:', error));
}

function fetchUsers() {
    fetch('fetchUsers.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            const userList = document.querySelector('#total-users-modal #user-list');
            userList.innerHTML = ''; // Clear existing content
            if (data.length === 0) {
                const li = document.createElement('li');
                li.textContent = 'No users found.';
                userList.appendChild(li);
            } else {
                data.forEach(user => {
                    const li = document.createElement('li');
                    li.textContent = `${user.Username || 'N/A'} (${user.FirstName || 'N/A'} ${user.LastName || 'N/A'}, Role: ${user.UserRoleID || 'N/A'})`;
                    userList.appendChild(li);
                });
            }
        })
        .catch(error => console.error('Error fetching users:', error));
}


// Close modal on background click
window.onclick = function(event) {
    const modal = document.querySelector('.modal'); // Generalized to close any modal
    if (event.target === modal) {
        closeModal(modal.id);
    }
}

//search results js
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
    function performSearch(query) {
        fetch(`search.php?q=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(results => {
                displaySearchResults(results);
            })
            .catch(error => console.error('Error fetching search results:', error));
    }

    // Function to display search results
    function displaySearchResults(results) {
        // Clear previous results
        const resultsContainer = document.getElementById('searchResults');
        resultsContainer.innerHTML = '';

        if (results.length === 0) {
            resultsContainer.innerHTML = '<p>No results found.</p>';
            return;
        }

        // Create list of results
        const ul = document.createElement('ul');
        results.forEach(result => {
            const li = document.createElement('li');
            li.textContent = `${result.source}: ${result.name || result.action || result.title}`;
            ul.appendChild(li);
        });
        resultsContainer.appendChild(ul);
    }




