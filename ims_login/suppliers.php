<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}
include("connect.php");
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IMS Inventory Management System</title>
    <link rel="stylesheet" href="suppliers.css">
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body>
<header>
        <div class="container">
            <h1>I M S</h1>
            <div class="user-info">
                <span>
                    <?php
                    echo isset($_SESSION['firstName']) && isset($_SESSION['lastName'])
                        ? $_SESSION['firstName'] . ' ' . $_SESSION['lastName']
                        : 'Guest';
                    ?>
                </span>
                <a href="logout.php" class="logout">Logout</a>
            </div>

        </div>
    </header>
    <nav>
        <div class="container">
            <a href="customer.php" class="nav-item"><i data-lucide="users"></i>Customers</a>
            <a href="items.php" class="nav-item"><i data-lucide="package"></i>Items</a>
            <a href="suppliers.php" class="nav-item active"><i data-lucide="store"></i>Suppliers</a>
            <a href="sales.php" class="nav-item"><i data-lucide="receipt"></i>Sales</a>
        </div>
    </nav>
    <main class="container">
        <div class="actions">
            <div>
                <button class="btn btn-secondary"><i data-lucide="mail"></i>Email</button>
            </div>
            <a href="add_supplier.php"><button class="btn btn-primary"><i data-lucide="user-plus"></i>New Supplier</button></a>
        </div>
        <div class="table-container">
            <div class="search-container">
                <input type="text" placeholder="Search" id="search-input">
            </div>
            <table>
                <thead>
                    <tr>
                        <th><input type="checkbox" id="select-all"></th>
                        <th>ID</th>
                        <th>Company Name</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="suppliers-table-body"></tbody>
            </table>
            <div class="table-footer">
                <span id="table-footer-info"></span>
            </div>
        </div>
    </main>

    <?php
    // Fetch data from the database
    $suppliers = [];
    $sql = "SELECT id, company_name, first_name, last_name, email, phone FROM suppliers";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $suppliers[] = $row;
        }
    }
    $conn->close();
    ?>

    <!-- Pass suppliers data to JavaScript -->
    <script>
        const suppliers = <?php echo json_encode($suppliers); ?>;
    </script>
    <script src="suppliers.js"></script>
</body>
</html>
