// General navigation elements and functionality for the Staff page
const staffNavigation = document.querySelector(".navigation");
const staffListItems = document.querySelectorAll(".navigation li");
const themeToggleButton = document.getElementById("themeToggle");
const mainContent = document.querySelector(".main");
const body = document.body;

// Function to handle hovering over navigation items
function handleStaffHover(event) {
    const selectedItem = event.target.closest("li");
    if (selectedItem) {
        staffListItems.forEach(item => item.classList.remove("hovered"));
        selectedItem.classList.add("hovered");
    }
}

// Add event listener for mouseover on staff navigation
staffNavigation.addEventListener("mouseover", handleStaffHover);

// Menu Toggle functionality for collapsing the sidebar
const menuToggleButton = document.querySelector(".toggle");
menuToggleButton.addEventListener("click", () => {
    staffNavigation.classList.toggle("active");
    mainContent.classList.toggle("active");
});

// Theme toggle functionality for dark mode
themeToggleButton.addEventListener("click", () => {
    body.classList.toggle("dark-mode");
});

// Initialize the Staff Page
function initStaffPage() {
    const modals = {
        addTag: {
            modal: document.getElementById("myModal"),
            openButton: document.querySelector('.add-tag-section button'), // Button for opening Add Tag modal
            closeButton: document.getElementById("closeModal"), // Close button for modal
            form: document.getElementById("addTagForm"),
            submitCallback: handleAddTag,
        },
        addVersion: {
            modal: document.getElementById("addVersionModal"),
            openButton: document.getElementById("addVersionBtn"), // Button for opening Add Version modal
            closeButton: document.getElementById("closeVersionModal"), // Close button for version modal
            form: document.getElementById("addVersionForm"),
            submitCallback: handleAddVersion,
        },
        uploadDocument: {
            modal: document.getElementById("uploadDocumentModal"),
            openButton: document.getElementById("uploadDocumentBtn"), // Button for opening Upload Document modal
            closeButton: document.getElementById("closeUploadModal"), // Close button for upload modal
            form: document.getElementById("uploadDocumentForm"),
            submitCallback: handleUploadDocument,
        },
    };

    // Loop through each modal configuration and set up event listeners
    for (const key in modals) {
        const modalConfig = modals[key];

        // Open modal functionality
        if (modalConfig.openButton) {
            modalConfig.openButton.addEventListener("click", () => {
                modalConfig.modal.style.display = "block";
            });
        }

        // Close button functionality
        if (modalConfig.closeButton) {
            modalConfig.closeButton.addEventListener("click", () => {
                modalConfig.modal.style.display = "none";
            });
        }

        // Close modal when clicking outside of it
        window.addEventListener("click", (event) => {
            if (event.target === modalConfig.modal) {
                modalConfig.modal.style.display = "none";
            }
        });

        // Form submission logic
        modalConfig.form.addEventListener("submit", function (event) {
            event.preventDefault();
            modalConfig.submitCallback(modalConfig);
        });
    }
}

// Tag handling logic
function handleAddTag(modalConfig) {
    const tagData = {
        name: document.getElementById("tagName").value,
        description: document.getElementById("description").value,
    };

    console.log("Tag Added:", tagData);

    // Logic to append the new tag to the tags table
    const tagsTable = document.querySelector('.tag-table tbody');
    const newRow = tagsTable.insertRow();
    newRow.innerHTML = `
        <td>${tagsTable.rows.length + 200}</td>
        <td>${tagData.name}</td>
        <td>${tagData.description}</td>
        <td>0</td>
        <td>
            <div class="action-buttons">
                <button class="button">Edit</button>
                <button class="button">Delete</button>
            </div>
        </td>
    `;

    modalConfig.modal.style.display = "none"; // Close modal after addition
    modalConfig.form.reset(); // Optionally reset the form
}

// Version handling logic for "Add New Version"
function handleAddVersion(modalConfig) {
    const versionData = {
        versionName: document.getElementById("versionName").value,
        description: document.getElementById("description").value,
        createdBy: document.getElementById("createdBy").value,
        dateCreated: document.getElementById("dateCreated").value,
    };

    // Logic to append the new version to the versions table
    const versionsTable = document.querySelector('.versions-table tbody');
    const newRow = versionsTable.insertRow();
    newRow.innerHTML = `
        <td>${versionData.versionName}</td>
        <td>${versionData.description}</td>
        <td>${versionData.dateCreated}</td>
        <td>
            <button class="button">View</button>
        </td>
    `;

    alert('Version added successfully!'); // Confirm success
    modalConfig.modal.style.display = "none"; // Close modal after addition
    modalConfig.form.reset(); // Reset the form
}

// Document upload handling logic
function handleUploadDocument(modalConfig) {
    const fileInput = document.getElementById("documentFile").files[0];
    const documentData = {
        fileName: fileInput.name,
        fileSize: fileInput.size,
        fileType: fileInput.type,
    };

    console.log("Document Uploaded:", documentData);

    // Logic to append the new document information to the documents table
    const documentsTable = document.querySelector('.documents-table tbody');
    const newRow = documentsTable.insertRow();
    newRow.innerHTML = `
        <td>${documentData.fileName}</td>
        <td>${documentData.fileSize / 1024} KB</td>
        <td>${documentData.fileType}</td>
        <td>
            <button class="button">View</button>
        </td>
    `;

    alert('Document uploaded successfully!'); // Confirm success
    modalConfig.modal.style.display = "none"; // Close modal after addition
    modalConfig.form.reset(); // Reset the form
}

// Call the initialization function when the document is ready
document.addEventListener("DOMContentLoaded", initStaffPage);
