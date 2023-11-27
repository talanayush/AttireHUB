<?php
        // Assuming you have a MySQL database connection
        $servername = "localhost:3307";
        $username = "root";
        $password = "";
        $dbname = "website";

        $conn = mysqli_connect($servername, $username, $password, $dbname);

        // Check the connection
        if ($conn) {
            echo "connection successful";
        }
        else echo "connectuion is not successful";

        
    ?>