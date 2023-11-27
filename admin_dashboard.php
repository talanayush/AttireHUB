<?php
session_start();

// Check if the admin is logged in
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

// Handle complete action
if (isset($_POST['complete'])) {
    $orderId = $_POST['complete'];

    // Assuming you have a function to fetch order details
    $orderDetailsQuery = "SELECT * FROM orders WHERE order_id = $orderId";
    $orderDetailsResult = $conn->query($orderDetailsQuery);

    if ($orderDetailsResult->num_rows > 0) {
        $orderDetails = $orderDetailsResult->fetch_assoc();

        // Assuming you have a function to insert into completed_orders table
        $completedOrdersInsertQuery = "INSERT INTO completed_orders (order_id, username, product_id, product_name, product_price, quantity, order_date)
                                       VALUES (" . $orderDetails['order_id'] . ", '" . $orderDetails['username'] . "', " . $orderDetails['product_id'] . ",
                                               '" . $orderDetails['product_name'] . "', " . $orderDetails['product_price'] . ", " . $orderDetails['quantity'] . ",
                                               '" . $orderDetails['order_date'] . "')";

        // Execute the insert query
        $conn->query($completedOrdersInsertQuery);

        // Assuming you have a function to delete the order from orders table
        $deleteOrderQuery = "DELETE FROM orders WHERE order_id = $orderId";
        $conn->query($deleteOrderQuery);
    }
}

// Fetch and display orders
$ordersQuery = "SELECT * FROM orders";
$result = $conn->query($ordersQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Include Bootstrap CSS (you can replace this with your local path or use a CDN) -->
    <style>
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
            justify-content: space-evenly; /* Use this property for even distribution */
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
    </style>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <header>
        <h1>Attire HUB</h1>
    </header>
    <nav>
        <a href="admin_dashboard.php" class="active">Dashboard</a>
        <a href="admin_completed_orders.php">Completed Orders</a>
        <a href="logout.php">Logout</a>
    </nav>

<div class="container mt-5">
    <h2>Admin Dashboard</h2>
    <table class="table">
        <thead>
        <tr>
            <th>Order ID</th>
            <th>Username</th>
            <th>Product ID</th>
            <th>Product Name</th>
            <th>Product Price</th>
            <th>Quantity</th>
            <th>Order Date</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row['order_id'] . "</td>
                        <td>" . $row['username'] . "</td>
                        <td>" . $row['product_id'] . "</td>
                        <td>" . $row['product_name'] . "</td>
                        <td>$" . $row['product_price'] . "</td>
                        <td>" . $row['quantity'] . "</td>
                        <td>" . $row['order_date'] . "</td>
                        <td>";
                echo "<form method='post'>
                            <input type='hidden' name='complete' value='" . $row['order_id'] . "'>
                            <button type='submit' class='btn btn-sm btn-success'>Complete</button>
                          </form>";
                echo "</td></tr>";
            }
        } else {
            echo "<tr><td colspan='8'>No orders available.</td></tr>";
        }
        ?>
        </tbody>
    </table>
</div>

</body>
</html>
