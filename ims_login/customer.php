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
    <link rel="stylesheet" href="customer.css">
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
            <a href="customer.php" class="nav-item active"><i data-lucide="users"></i>Customers</a>
            <a href="items.php" class="nav-item "><i data-lucide="package"></i>Items</a>
            <a href="suppliers.php" class="nav-item"><i data-lucide="store"></i>Suppliers</a>
            <a href="sales.php" class="nav-item"><i data-lucide="receipt"></i>Sales</a>
        </div>
    </nav>
    <main class="container">
        <div class="actions">
            <div>
                <button class="btn btn-secondary"><i data-lucide="mail"></i>Email</button>
            </div>
            <div>
                <a href="new_customer.php"><button class="btn btn-primary">New Customer</button></a>
            </div>
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
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th>Total Spent</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="customer-table-body">
                    <?php
                    // Fetch data from the database
                    $sql = "SELECT id, firstName, lastName, email, phone, total_spent FROM customers";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td><input type='checkbox' class='customer-select'></td>";
                            echo "<td>" . $row["id"] . "</td>";
                            echo "<td>" . $row["firstName"] . "</td>";
                            echo "<td>" . $row["lastName"] . "</td>";
                            echo "<td>" . ($row["email"] ? "<a href='mailto:" . $row["email"] . "'>" . $row["email"] . "</a>" : "") . "</td>";
                            echo "<td>" . $row["phone"] . "</td>";
                            echo "<td>" . $row["total_spent"] . "</td>";
                            echo "<td><button class='btn btn-secondary btn-sm'><i data-lucide='pencil'></i></button></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8'>No records found</td></tr>";
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
    <script src="customer.js"></script>
</body>

</html>