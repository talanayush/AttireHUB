<?php
// Start the session
session_start();

// Destroy all session data
session_destroy();

// Redirect to the login page (you can change this to any other page)
header("Location: admin_login.php");
exit();
?>
