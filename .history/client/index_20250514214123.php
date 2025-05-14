 
<?php
session_start();
require_once '../config.php';
require_once '../functions.php';

// Check if user is logged in and is a client
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'client') {
    header('Location: ../login.php');
    exit;
}

// Redirect to dashboard
header('Location: dashboard.php');
exit;
?>