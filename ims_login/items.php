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
    <link rel="stylesheet" href="items.css">
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
            <a href="items.php" class="nav-item active"><i data-lucide="package"></i>Items</a>
            <a href="suppliers.php" class="nav-item"><i data-lucide="store"></i>Suppliers</a>
            <a href="sales.php" class="nav-item"><i data-lucide="receipt"></i>Sales</a>
        </div>
    </nav>
    <main class="container">
        <div class="actions">
            <div class="left-actions"></div>
            <div class="right-actions">
            <a href="new_item.php"><button class="btn btn-primary"><i data-lucide="plus"></i>New Item</button></a>
            </div>
        </div>
        <div class="table-container">
            <div class="search-container">
                <input type="text" placeholder="Search" id="search-input">
            </div>
            <table>
                <thead>
                    <tr>
                        <th class="pad">ID</th>
                        <th>Item Name</th>
                        <th>Category</th>
                        <th>Wholesale Price</th>
                        <th>Retail Price</th>
                        <th>Quantity</th>
                    </tr>
                </thead>
                <tbody id="items-table-body">
                    <?php
                    // Fetch data from the database
                    $sql = "SELECT item_id, name, category, wholesale_price, retail_price, quantity FROM items";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["item_id"] . "</td>";
                            echo "<td>" . $row["name"] . "</td>";
                            echo "<td>" . $row["category"] . "</td>";
                            echo "<td>" . $row["wholesale_price"] . "</td>";
                            echo "<td>" . $row["retail_price"] . "</td>";
                            echo "<td>" . $row["quantity"] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>No records found</td></tr>";
                    }
                    $conn->close();
                    ?>
                </tbody>
            </table>
            <div class="table-footer">
                <span id="table-footer-info"></span>
            </div>
        </div>
    </main>
    <script src="items.js"></script>

    <script>
        // Update the table footer dynamically
        document.addEventListener("DOMContentLoaded", function() {
            const tableBody = document.getElementById("items-table-body");
            const footerInfo = document.getElementById("table-footer-info");

            const rowCount = tableBody.getElementsByTagName("tr").length;
            footerInfo.textContent = `Showing 1 to ${rowCount} of ${rowCount} rows`;
        });
    </script>
</body>
</html>
