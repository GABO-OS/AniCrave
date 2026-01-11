<?php
// Script para sa ligtas na pag-logout
session_start();

// Burahin lahat ng session variables para walang maiwan na record ng account sa browser
session_unset();

// Tuluyang sirain yung session session data
session_destroy();

// Ibalik ang user sa index page pagkatapos mag-logout
header("Location: index.php");
exit();
?>