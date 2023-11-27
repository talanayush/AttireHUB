<?php
    session_start();

    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
        //echo "Welcome, $username!";
    } else {
        echo "Welcome, Guest!";
    }

    // Assuming you have a MySQL database connection
    $servername = "localhost:3307";
    $db_username = "root";
    $db_password = "";
    $db_name = "website";

    $conn = mysqli_connect($servername, $db_username, $db_password, $db_name);

    // Check the connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add-to-cart'])) {
        $product_id = $_POST['product-id'];
        $product_name = $_POST['product-name'];
        $product_price = $_POST['product-price'];
        $quantity = $_POST['quantity'];

        // Check if the product already exists in the user's cart
        $check_query = "SELECT * FROM cart WHERE username='$username' AND product_id='$product_id'";
        $check_result = mysqli_query($conn, $check_query);

        if (mysqli_num_rows($check_result) > 0) {
            // Product already exists, update the quantity
            $update_query = "UPDATE cart SET quantity = quantity + $quantity WHERE username='$username' AND product_id='$product_id'";
            mysqli_query($conn, $update_query);
        } else {
            // Product doesn't exist, insert new record
            $insert_query = "INSERT INTO cart (username, product_id, product_name, product_price, quantity) VALUES ('$username', '$product_id', '$product_name', '$product_price', '$quantity')";
            mysqli_query($conn, $insert_query);
        }

        // Redirect to avoid form resubmission on page refresh
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your E-Commerce Website</title>
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
            color: #fff; /* Set the text color on hover to match the background color */
        }

        .main-content {
            padding: 20px;
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
        }

        .product {
            flex: 0 0 25%; /* Adjust the width of each product as needed */
            border: 1px solid #ddd;
            padding: 20px;
            margin: 10px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            text-align: center;
        }

        .product img {
            max-width: 100%;
            height: auto;
            margin-bottom: 10px;
        }

        footer {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 20px 0;
            width: 100%;
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
        <a href="contact.php">Contact</a>
        <a href="logout.php">Logout</a>
        <p><?php echo $username; ?></p>
    </nav>

    <div class="main-content">
        <!-- Product 1 -->
        <div class="product" data-product-id="1">
            <img src="1.jpg" alt="T-Shirt">
            <h2>T-Shirt</h2>
            <p>Description of Product 1</p>
            <p>Price: $19.99</p>
            <form method="POST" action="index.php">
                <input type="hidden" name="product-id" value="1">
                <input type="hidden" name="product-name" value="Product 1">
                <input type="hidden" name="product-price" value="19.99">
                <label for="quantity-1">Quantity:</label>
                <button type="button" onclick="decreaseQuantity('quantity-1')">-</button>
                <input type="text" id="quantity-1" name="quantity" value="1" readonly>
                <button type="button" onclick="increaseQuantity('quantity-1')">+</button>
                <button type="submit" name="add-to-cart">Add to Cart</button>
            </form>
        </div>
        <div class="product" data-product-id="2">
            <img src="2.jpg" alt="T-shirt">
            <h2>T-Shirt</h2>
            <p>Description of Product 1</p>
            <p>Price: $60</p>
            <form method="POST" action="index.php">
                <input type="hidden" name="product-id" value="2">
                <input type="hidden" name="product-name" value="Product 2">
                <input type="hidden" name="product-price" value="60">
                <label for="quantity-1">Quantity:</label>
                <button type="button" onclick="decreaseQuantity('quantity-2')">-</button>
                <input type="text" id="quantity-2" name="quantity" value="1" readonly>
                <button type="button" onclick="increaseQuantity('quantity-2')">+</button>
                <button type="submit" name="add-to-cart">Add to Cart</button>
            </form>
        </div>
        <div class="product" data-product-id="3">
            <img src="3.jpg" alt="Sweatshirt">
            <h2>Sweatshirt</h2>
            <p>Description of Product 1</p>
            <p>Price: $45</p>
            <form method="POST" action="index.php">
                <input type="hidden" name="product-id" value="3">
                <input type="hidden" name="product-name" value="Product 3">
                <input type="hidden" name="product-price" value="45">
                <label for="quantity-3">Quantity:</label>
                <button type="button" onclick="decreaseQuantity('quantity-3')">-</button>
                <input type="text" id="quantity-3" name="quantity" value="1" readonly>
                <button type="button" onclick="increaseQuantity('quantity-3')">+</button>
                <button type="submit" name="add-to-cart">Add to Cart</button>
            </form>
        </div>
        <div class="product" data-product-id="4">
            <img src="4.jpg" alt="tank-top">
            <h2>Tank TOP</h2>
            <p>Description of Product 1</p>
            <p>Price: $10</p>
            <form method="POST" action="index.php">
                <input type="hidden" name="product-id" value="4">
                <input type="hidden" name="product-name" value="Tank TOP">
                <input type="hidden" name="product-price" value="10">
                <label for="quantity-3">Quantity:</label>
                <button type="button" onclick="decreaseQuantity('quantity-4')">-</button>
                <input type="text" id="quantity-4" name="quantity" value="1" readonly>
                <button type="button" onclick="increaseQuantity('quantity-4')">+</button>
                <button type="submit" name="add-to-cart">Add to Cart</button>
            </form>
        </div>
        <div class="product" data-product-id="5">
            <img src="5.jpg" alt="dress">
            <h2>DRESS</h2>
            <p>Description of Product 1</p>
            <p>Price: $46</p>
            <form method="POST" action="index.php">
                <input type="hidden" name="product-id" value="5">
                <input type="hidden" name="product-name" value="DRESS">
                <input type="hidden" name="product-price" value="46">
                <label for="quantity-5">Quantity:</label>
                <button type="button" onclick="decreaseQuantity('quantity-5')">-</button>
                <input type="text" id="quantity-5" name="quantity" value="1" readonly>
                <button type="button" onclick="increaseQuantity('quantity-5')">+</button>
                <button type="submit" name="add-to-cart">Add to Cart</button>
            </form>
        </div>
        <div class="product" data-product-id="6">
            <img src="6.jpg" alt="DRESS">
            <h2>DRESS</h2>
            <p>Description of Product 1</p>
            <p>Price: $33</p>
            <form method="POST" action="index.php">
                <input type="hidden" name="product-id" value="6">
                <input type="hidden" name="product-name" value="Product 6">
                <input type="hidden" name="product-price" value="33">
                <label for="quantity-6">Quantity:</label>
                <button type="button" onclick="decreaseQuantity('quantity-6')">-</button>
                <input type="text" id="quantity-6" name="quantity" value="1" readonly>
                <button type="button" onclick="increaseQuantity('quantity-6')">+</button>
                <button type="submit" name="add-to-cart">Add to Cart</button>
            </form>
        </div>
        <!-- Add more product divs as needed -->

    </div>

    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <p>&copy; 2023 Attire Hub. All rights reserved.</p>
                </div>
                
            </div>
        </div>
    </footer>
    <script>
        function decreaseQuantity(inputId) {
            const input = document.getElementById(inputId);
            if (input.value > 1) {
                input.value = parseInt(input.value) - 1;
            }
        }

        function increaseQuantity(inputId) {
            const input = document.getElementById(inputId);
            input.value = parseInt(input.value) + 1;
        }
    </script>
</body>
</html>
