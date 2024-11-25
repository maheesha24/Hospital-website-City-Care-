<?php
session_start(); // Start the session
session_destroy(); // Destroy all session data
header("Location: home.php"); // Redirect back to the homepage
exit(); // Make sure the script stops running
