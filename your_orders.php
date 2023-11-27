<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Redirect to the login page if not logged in
    exit();
}

$username = $_SESSION['username'];

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

// Fetch user's orders
$ordersQuery = "SELECT * FROM orders WHERE username = '$username'";
$result = $conn->query($ordersQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Orders</title>

    <!-- Include Bootstrap CSS (you can replace this with your local path or use a CDN) -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
</head>
<body>
    <header>
        <h1>Attire HUB</h1>
    </header>
    <nav>
        <a href="index.php">Home</a>
        <a href="your_orders.php">Your Orders</a>
        <a href="cart.php" id="cart-link">Cart</a>
        <a href="contact.php" id="">Contact</a>
        <a href="logout.php">Logout</a>
        <p><?php echo $username; ?></p>
    </nav>

    <div class="container mt-5">
        <h2>Your Orders</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Product ID</th>
                    <th>Product Name</th>
                    <th>Product Price</th>
                    <th>Quantity</th>
                    <th>Order Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . $row['order_id'] . "</td>
                                <td>" . $row['product_id'] . "</td>
                                <td>" . $row['product_name'] . "</td>
                                <td>$" . $row['product_price'] . "</td>
                                <td>" . $row['quantity'] . "</td>
                                <td>" . $row['order_date'] . "</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>You have no orders yet.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
