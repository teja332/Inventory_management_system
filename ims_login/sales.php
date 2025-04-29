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
    <link rel="stylesheet" href="sales.css">
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
            <a href="suppliers.php" class="nav-item"><i data-lucide="store"></i>Suppliers</a>
            <a href="sales.php" class="nav-item active"><i data-lucide="receipt"></i>Sales</a>
        </div>
    </nav>
    <main class="container">
        
            <div class="left-panel">
                <div class="item-search">
                    <input type="text" id="search-input" placeholder="Search by Item Name, ID, or Quantity...">
                    <a href="add_sale_item.php"><button class="btn btn-primary"><i data-lucide="plus"></i>New Item</button></a>
                </div>
                <div class="cart">
                <table>
    <thead>
        <tr>
            <th style="width: 10%;">Item #</th> <!-- Adjusted width -->
            <th style="width: 20%;">Item Name</th> <!-- Adjusted width -->
            <th style="width: 15%;">Price</th>
            <th style="width: 10%;">Quantity</th>
            <th style="width: 10%;">Disc</th>
            <th style="width: 15%;">Total</th>
            <th style="width: 20%;">Timestamp</th>
        </tr>
    </thead>
    <tbody id="cart-items">
        <?php
        // Fetch sales data from the database
        $sql = "SELECT item_id, item_name, price, quantity, discount, timestamp FROM sales";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $total = $row["price"] * $row["quantity"] * (1 - $row["discount"] / 100);
                echo "<tr>";
                echo "<td>" . $row["item_id"] . "</td>";
                echo "<td>" . $row["item_name"] . "</td>";
                echo "<td>$" . number_format($row["price"], 2) . "</td>";
                echo "<td>" . $row["quantity"] . "</td>";
                echo "<td>" . $row["discount"] . "%</td>";
                echo "<td>$" . number_format($total, 2) . "</td>";
                echo "<td>" . $row["timestamp"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='7'>No sales records found</td></tr>";
        }
        $conn->close();
        ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="7">
                <span id="table-footer-info"></span> <!-- Footer element for dynamic updates -->
            </td>
        </tr>
    </tfoot>
</table>

                </div>
            </div>
        </main>
    <script src="sales.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Lucide icons
            lucide.createIcons();

            // Search functionality
            const searchInput = document.getElementById('search-input');
            searchInput.addEventListener('input', function() {
                const filter = searchInput.value.toLowerCase();
                const rows = document.querySelectorAll('#cart-items tr');

                rows.forEach(row => {
                    const cells = row.querySelectorAll('td');
                    const itemId = cells[0] ? cells[0].textContent.toLowerCase() : '';
                    const itemName = cells[1] ? cells[1].textContent.toLowerCase() : '';
                    const itemQuantity = cells[3] ? cells[3].textContent.toLowerCase() : '';

                    // Check if any cell matches the search filter
                    if (
                        itemId.includes(filter) ||
                        itemName.includes(filter) ||
                        itemQuantity.includes(filter) ||
                        filter === '' // Show all rows if filter is empty
                    ) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        });
    </script>
</body>

</html>
