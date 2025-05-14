 
<?php
/**
 * Database Configuration File
 * 
 * This file contains database connection settings for the Payment Status Platform
 */

// Database credentials
define('DB_HOST', 'localhost');
define('DB_NAME', 'payment_status_platform');
define('DB_USER', 'root');     // Change this to your MySQL username
define('DB_PASS', '');         // Change this to your MySQL password

// Establish database connection using PDO
try {
    $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Set default fetch mode to associative array
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    // Set charset to UTF8
    $conn->exec("SET NAMES utf8");
} catch(PDOException $e) {
    // If there is an error with the connection, stop the script and display the error
    die("Database Connection Failed: " . $e->getMessage());
}