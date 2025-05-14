 
<?php
session_start();
require_once 'includes/functions.php';
require_once 'includes/auth.php';

// Log the user out
logoutUser();
// This function will redirect to index.php after destroying the session
?>