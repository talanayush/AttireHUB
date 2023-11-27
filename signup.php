<?php
        // Assuming you have a MySQL database connection
        $servername = "localhost:3307";
        $username = "root";
        $password = "";
        $dbname = "website";

        $conn = mysqli_connect($servername, $username, $password, $dbname);

        // Check the connection
        if ($conn) {
            //echo "connection successful";
        }
        else echo "connectuion is not successful";

        // Function to sanitize user input
        function sanitizeInput($data) {
            return htmlspecialchars(stripslashes(trim($data)));
        }

        // Check if form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Get the user's name, username, and password from the form
            echo "pos"; 
            $name = sanitizeInput($_POST["signup-name"]);
            $username = sanitizeInput($_POST["signup-username"]);
            $password = sanitizeInput($_POST["signup-password"]);

            // Hash the password for security
            $hashedPassword = $password;

            // Check if the username is already taken
            $checkUsernameQuery = "SELECT * FROM users WHERE username = '$username'";
            $checkUsernameResult = $conn->query($checkUsernameQuery);

            if ($checkUsernameResult->num_rows > 0) {
                // Username is already taken
                echo "Username is already taken. Please choose another username.";
            } else {
                // Insert the new user into the database
                $insertUserQuery = "INSERT INTO users (name, username, password) VALUES ('$name', '$username', '$hashedPassword')";
                
                if ($conn->query($insertUserQuery) === TRUE) {
                    // User registration successful, redirect to index.html
                    header("Location: login.php");
                    exit();
                } else {
                    // Error in inserting user
                    echo "Error: " . $insertUserQuery . "<br>" . $conn->error;
                }
            }
        }

        // Close the database connection
        $conn->close();
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Sign Up</title>
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
            <img src="user.png" alt="Sign Up Icon" class="mb-4 login-icon">
            <h2>Sign Up</h2>
            <form name="signUpForm" method="POST" action="signup.php">
                <div class="form-group">
                    <label for="signup-name">Name</label>
                    <input type="text" class="form-control" id="signup-name" name="signup-name" placeholder="Enter your name" required>
                </div>
                <div class="form-group">
                    <label for="signup-username">Username</label>
                    <input type="text" class="form-control" id="signup-username" name="signup-username" placeholder="Enter username" required>
                </div>
                <div class="form-group">
                    <label for="signup-password">Password</label>
                    <input type="password" class="form-control" id="signup-password" name="signup-password" placeholder="Enter password" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Sign Up</button>
            </form>
            <p class="mt-3">
                Already have an account? <a href="login.php" class="text-dark">Login</a>
            </p>
        </div>
    </div>

    <!-- Add Bootstrap and jQuery JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    

</body>

</html>
