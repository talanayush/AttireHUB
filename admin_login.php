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
    } else {
        //echo "Connection successful";
    }

    // Function to sanitize user input
    function sanitizeInput($data) {
        return htmlspecialchars(stripslashes(trim($data)));
    }

    // Check if form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get the admin username and password from the form
        $adminUsername = sanitizeInput($_POST["admin-username"]);
        $adminPassword = sanitizeInput($_POST["admin-password"]);

        // SQL query to retrieve admin information based on the provided username
        $sql = "SELECT * FROM admin WHERE admin_username = '$adminUsername'";
        $result = mysqli_query($conn, $sql);

        if ($result !== false && mysqli_num_rows($result) > 0) {
            // Admin found, now check the password
            $row = mysqli_fetch_assoc($result);
            $storedPassword = $row["admin_password"];
            if ($adminPassword == $storedPassword) {
                // Password matched, redirect to admin dashboard or desired page
                session_start();
                $_SESSION['admin_username'] = $adminUsername;
                header("Location: admin_dashboard.php");
                exit();
            } else {
                // Password didn't match
                echo "Password incorrect. Please try again.";
            }

        } else {
            // Admin not found
            echo "Admin not found. Please check your username.";
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
    
    <title>Admin Login</title>
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
            <img src="admin.png" alt="Admin Login Icon" class="mb-4 login-icon">
            <h2>Admin Login</h2>
            <form name="adminLoginForm" method="POST" action="admin_login.php">
                <div class="form-group">
                    <label for="admin-username">Username</label>
                    <input type="text" class="form-control" id="admin-username" name="admin-username" placeholder="Enter admin username" required>
                </div>
                <div class="form-group">
                    <label for="admin-password">Password</label>
                    <input type="password" class="form-control" id="admin-password" name="admin-password" placeholder="Enter admin password" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Login</button>
            </form>
        </div>
    </div>

    <!-- Add Bootstrap and jQuery JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
