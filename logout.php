<?php
session_start();

// Destroy all session variables and the session itself
session_unset();
session_destroy();

// Redirect to the common login page (or home page)
header("Location: loginc.php");
exit;
?>
