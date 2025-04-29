document.addEventListener('DOMContentLoaded', function() {
    // Initialize Lucide icons
    lucide.createIcons();

    // Function to update table footer after rendering the customer table
    function updateTableFooter() {
        const tableBody = document.getElementById('customer-table-body');
        const visibleRows = Array.from(tableBody.rows).filter(row => row.style.display !== 'none');
        const rowCount = visibleRows.length;
        const footerInfo = document.getElementById('table-footer-info');
        footerInfo.textContent = `Showing 1 to ${rowCount} of ${rowCount} rows`;
    }

    // Initial footer update
    updateTableFooter();

    // Handle search functionality
    const searchInput = document.getElementById('search-input');
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const tableRows = document.querySelectorAll('#customer-table-body tr');

        tableRows.forEach(row => {
            const cells = row.querySelectorAll('td');
            const [id, lastName, firstName, email, phone, totalSpent] = Array.from(cells).slice(1, 7);

            // Check if any of the cells contain the search term
            const rowMatches = [id, lastName, firstName, email, phone, totalSpent].some(cell =>
                cell.textContent.toLowerCase().includes(searchTerm)
            );

            row.style.display = rowMatches ? '' : 'none';
        });

        // After filtering, update the footer with new row count
        updateTableFooter();
    });

    // Handle select all checkbox
    const selectAllCheckbox = document.getElementById('select-all');
    selectAllCheckbox.addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.customer-select');
        checkboxes.forEach(checkbox => checkbox.checked = this.checked);
    });

    // Handle delete button
    const deleteButton = document.getElementById('delete-btn');
    deleteButton.addEventListener('click', function() {
        const selectedCustomers = document.querySelectorAll('.customer-select:checked');
        if (selectedCustomers.length > 0) {
            alert(`Deleting ${selectedCustomers.length} customer(s)`);
            // Implement actual delete functionality here
        } else {
            alert('No customers selected');
        }
    });

    // Handle new customer button (redirect to form)
    const newCustomerButton = document.querySelector('.btn-primary');
    newCustomerButton.addEventListener('click', function() {
        window.location.href = 'new_customer.php'; // Redirect to the new customer form page
    });

    // Call this function after rendering the customer table
    renderCustomerTable();
});
