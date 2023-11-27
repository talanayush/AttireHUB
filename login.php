<?php
    // Assuming you have a MySQL database connection
    $servername = "localhost:3307";
    $username = "root";
    $password = "";
    $dbname = "website";

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    // Check the connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Function to sanitize user input
    function sanitizeInput($data) {
        return htmlspecialchars(stripslashes(trim($data)));
    }

    // Check if form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get the username and password from the form
        $username = sanitizeInput($_POST["login-username-email"]);
        $password = sanitizeInput($_POST["login-password"]);

        // SQL query to retrieve user information based on the provided username
        $sql = "SELECT * FROM users WHERE username = '$username'";
        $result = mysqli_query($conn, $sql);

        if ($result !== false && mysqli_num_rows($result) > 0) {
            // User found, now check the password
            $row = mysqli_fetch_assoc($result);
            $storedPassword = $row["password"];
            if ($password == $storedPassword) {
                // Password matched, redirect to index.html
                session_start();
                $_SESSION['username'] = $username;
                header("Location: index.php");
                exit();
            } else {
                // Password didn't match
                echo "Password incorrect. Please try again.";
            }

        } else {
            // User not found
            echo "User not found. Please check your username.";
        }
    }

    // Close the database connection
    mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Login</title>
    
    <!-- Add Bootstrap CSS link -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Add custom CSS -->
    <style>
        body {
            background-color: #f4f4f4;
            color: #333;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .container {
            background-color: #fff;
            max-width: 400px;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
        }
        label, h2 {
            color: #333;
        }
        button {
            background-color: #007bff;
            border-color: #007bff;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
        .login-icon {
            width: 60px; /* Adjust the width as needed */
            height: 60px; /* Adjust the height as needed */
        }
        
    </style>
</head>
<body>
    
    <div class="container mx-auto">
        <div class="card-body text-center">
            <img src="user.png" alt="Login Icon" class="mb-4 login-icon">
            <h2>Login</h2>
            <a href="admin_login.php">admin login</a>
            <form name="loginForm" method="POST" action="login.php">
                <div class="form-group">
                    <label for="login-username-email">Username/Email</label>
                    <input type="text" class="form-control" id="login-username-email" name="login-username-email" placeholder="Enter username/email" required>
                </div>
                <div class="form-group">
                    <label for="login-password">Password</label>
                    <input type="password" class="form-control" id="login-password" name="login-password" placeholder="Enter password" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Login</button>
            </form>
            <p class="mt-3">
                Don't have an account? <a href="signup.php" class="text-dark">Sign Up</a>
            </p>
        </div>
    </div>
    

    <!-- Add Bootstrap and jQuery JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    

</body>
</html>
