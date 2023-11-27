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

// Handle remove action
if (isset($_POST['remove'])) {
    $productId = $_POST['remove'];
    // Assuming you have a function to remove the product from the cart in your database
    $conn->query("DELETE FROM cart WHERE username = '$username' AND product_id = $productId");
}

// Handle update quantity action
if (isset($_POST['update'])) {
    $productId = $_POST['update'];
    $newQuantity = $_POST['quantity'];
    // Assuming you have a function to update the quantity in your cart in the database
    $conn->query("UPDATE cart SET quantity = $newQuantity WHERE username = '$username' AND product_id = $productId");
}

// Handle checkout action
if (isset($_POST['checkout'])) {
    // Assuming you have a function to handle the checkout process, and you move cart items to the orders table
    $conn->query("INSERT INTO orders (username, product_id, product_name, product_price, quantity) SELECT username, product_id, product_name, product_price, quantity FROM cart WHERE username = '$username'");
    $conn->query("DELETE FROM cart WHERE username = '$username'");
    // You may also want to perform additional actions, such as updating product stock, calculating the total amount, etc.
}

// Fetch and display cart contents
$cartQuery = "SELECT * FROM cart WHERE username = '$username'";
$result = $conn->query($cartQuery);

// Calculate total amount
$totalAmount = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>

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
        <a href="your_orders.php">Your orders</a>
        <a href="cart.php" id="cart-link">Cart</a>
        <a href="contact.php">Contact</a>
        <a href="logout.php">Logout</a>
        <p><?php echo $username; ?></p>
    </nav>

    <div class="container mt-5">
        <h2>Your Cart</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Product ID</th>
                    <th>Product Name</th>
                    <th>Product Price</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $totalPrice = $row['product_price'] * $row['quantity'];
                        echo "<tr>
                                <td>" . $row['product_id'] . "</td>
                                <td>" . $row['product_name'] . "</td>
                                <td>$" . $row['product_price'] . "</td>
                                <td>
                                    <form method='post'>
                                        <input type='number' name='quantity' value='" . $row['quantity'] . "' min='1'>
                                        <input type='hidden' name='update' value='" . $row['product_id'] . "'>
                                        <button type='submit' class='btn btn-sm btn-primary'>Update</button>
                                    </form>
                                </td>
                                <td>$" . $totalPrice . "</td>
                                <td>
                                    <form method='post'>
                                        <input type='hidden' name='remove' value='" . $row['product_id'] . "'>
                                        <button type='submit' class='btn btn-sm btn-danger'>Remove</button>
                                    </form>
                                </td>
                            </tr>";
                        $totalAmount += $totalPrice;
                    }
                    echo "<tr>
                            <td colspan='4' class='text-right'><strong>Total Amount:</strong></td>
                            <td><strong>$" . $totalAmount . "</strong></td>
                            <td>
                                <form method='post'>
                                    <button type='submit' name='checkout' class='btn btn-success'>Checkout</button>
                                </form>
                            </td>
                        </tr>";
                } else {
                    echo "<tr><td colspan='6'>Your cart is empty.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

</body>
</html>
