<?php
// Start yung session para ma-access ang current session data
session_start();

// Clear all session variables para logout na talaga
session_unset();

// Destroy the session entirely from the server
session_destroy();

// Redirect the user back sa login page pagkatapos ng logout
header("Location: login.php");
exit();
?>