<?php
session_start();

// Check if the user is an admin (you can implement your own logic)
if (!isset($_SESSION['admin_username'])) {
    header("Location: admin_login.php"); // Redirect to the admin login page if not logged in
    exit();
}

// Assuming you have a MySQL database connection
$servername = "localhost:3307";
$dbUsername = "root";
$dbPassword = "";
$dbName = "website";

$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbName);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch completed orders from the completed_orders table
$completedOrdersQuery = "SELECT * FROM completed_orders";
$completedOrdersResult = $conn->query($completedOrdersQuery);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Completed Orders</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        header {
            background-color: #333;
            color: #fff;
            padding: 10px 0;
            text-align: center;
        }

        nav {
            background-color: #444;
            color: #fff;
            padding: 10px;
            text-align: center;
            display: flex;
            justify-content: space-evenly;
        }

        nav a {
            color: #fff;
            text-decoration: none;
            padding: 10px;
            display: inline-block;
        }

        nav a:hover {
            background-color: #555;
        }

        .main-content {
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 15px;
            text-align: left;
        }

        th {
            background-color: #333;
            color: #fff;
        }
    </style>
</head>
<body>
    <header>
        <h1>Attire HUB Admin</h1>
    </header>

    <nav>
        <a href="admin_dashboard.php">Dashboard</a>
        <a href="completed_orders.php">Completed Orders</a>
        <!-- Add more admin navigation links as needed -->
    </nav>

    <div class="main-content">
        <h2>Completed Orders</h2>
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Username</th>
                    <th>Product ID</th>
                    <th>Product Name</th>
                    <th>Product Price</th>
                    <th>Quantity</th>
                    <th>Order Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($completedOrdersResult->num_rows > 0) {
                    while ($row = $completedOrdersResult->fetch_assoc()) {
                        echo "<tr>
                                <td>" . $row['order_id'] . "</td>
                                <td>" . $row['username'] . "</td>
                                <td>" . $row['product_id'] . "</td>
                                <td>" . $row['product_name'] . "</td>
                                <td>$" . $row['product_price'] . "</td>
                                <td>" . $row['quantity'] . "</td>
                                <td>" . $row['order_date'] . "</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No completed orders found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
