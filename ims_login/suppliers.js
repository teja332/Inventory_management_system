document.addEventListener('DOMContentLoaded', function() {
    // Initialize Lucide icons
    lucide.createIcons();

    // Function to render suppliers table
    function renderSuppliersTable(suppliersList = suppliers) {
        const tableBody = document.getElementById('suppliers-table-body');
        tableBody.innerHTML = '';

        suppliersList.forEach(supplier => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td><input type="checkbox" class="supplier-select"></td>
                <td>${supplier.id}</td>
                <td>${supplier.company_name}</td>
                <td>${supplier.first_name}</td>
                <td>${supplier.last_name}</td>
                <td><a href="mailto:${supplier.email}">${supplier.email}</a></td>
                <td>${supplier.phone}</td>
                <td><button class="btn btn-secondary btn-sm"><i data-lucide="pencil"></i></button></td>
            `;
            tableBody.appendChild(row);
        });

        // Re-initialize Lucide icons for newly added elements
        lucide.createIcons();

        // Update table footer
        const footerInfo = document.getElementById('table-footer-info');
        footerInfo.textContent = `Showing 1 to ${suppliersList.length} of ${suppliersList.length} rows`;
    }

    // Initial render with all suppliers
    renderSuppliersTable();

    // Handle search functionality
    const searchInput = document.getElementById('search-input');
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const filteredSuppliers = suppliers.filter(supplier => 
            supplier.company_name.toLowerCase().includes(searchTerm) ||
            supplier.first_name.toLowerCase().includes(searchTerm) ||
            supplier.last_name.toLowerCase().includes(searchTerm) ||
            supplier.email.toLowerCase().includes(searchTerm) ||
            supplier.phone.toLowerCase().includes(searchTerm)
        );
        renderSuppliersTable(filteredSuppliers);
    });

    // Handle select all checkbox
    const selectAllCheckbox = document.getElementById('select-all');
    selectAllCheckbox.addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.supplier-select');
        checkboxes.forEach(checkbox => checkbox.checked = this.checked);
    });

    // Handle delete button
    const deleteButton = document.querySelector('.btn-secondary');
    deleteButton.addEventListener('click', function() {
        const selectedSuppliers = document.querySelectorAll('.supplier-select:checked');
        if (selectedSuppliers.length > 0) {
            alert(`Deleting ${selectedSuppliers.length} supplier(s)`);
            // Implement actual delete functionality here
        } else {
            alert('No suppliers selected');
        }
    });

    // Handle new supplier button
    const newSupplierButton = document.querySelector('.btn-primary');
    newSupplierButton.addEventListener('click', function() {
        alert('Opening new supplier form');
        // Implement new supplier form functionality here
    });

    // Handle email button
    const emailButton = document.querySelectorAll('.btn-secondary')[1];
    emailButton.addEventListener('click', function() {
        const selectedSuppliers = document.querySelectorAll('.supplier-select:checked');
        if (selectedSuppliers.length > 0) {
            alert(`Emailing ${selectedSuppliers.length} supplier(s)`);
            // Implement email functionality here
        } else {
            alert('No suppliers selected');
        }
    });
});
