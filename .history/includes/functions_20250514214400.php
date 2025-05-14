 
<?php
/**
 * Main Configuration File
 * 
 * Contains application-wide settings
 */

// Application settings
define('APP_NAME', 'Payment Status Platform');
define('APP_VERSION', '1.0');
define('APP_URL', 'http://localhost/payment-platform'); // Change this to your actual URL

// Include database configuration
require_once 'config/database.php';

// Error reporting
// Comment these lines in production
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Timezone setting
date_default_timezone_set('UTC');

// Session lifetime (30 days in seconds)
ini_set('session.gc_maxlifetime', 30 * 24 * 60 * 60);
session_set_cookie_params(30 * 24 * 60 * 60);

// Other constants
define('PROJECT_STATUSES', ['pending', 'paid', 'overdue']);
define('USER_TYPES', ['admin', 'client']);