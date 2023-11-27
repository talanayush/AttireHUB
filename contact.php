<?php
    session_start();

    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
        //echo "Welcome, $username!";
    } else {
        echo "Welcome, Guest!";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>

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
        <a href="contact.php">Contact</a>
        <a href="logout.php">Logout</a>
        <p><?php echo $username; ?></p>
    </nav>

    <div class="container mt-5">
        <h2>Contact Us</h2>

        <?php
        // Handle form submission
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = $_POST["name"];
            $email = $_POST["email"];
            $message = $_POST["message"];

            // You can add additional validation and processing here
            // For simplicity, this example just displays the submitted information

            echo "<div class='alert alert-success' role='alert'>
                    Thank you, $name! We have received your message.<br>
                    We will get back to you at $email as soon as possible.
                  </div>";
        }
        ?>

        <form method="post" action="contact.php">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="message">Message:</label>
                <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</body>
</html>
