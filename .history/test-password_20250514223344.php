<?php
/**
 * This is a test login script to verify password hashing is working correctly.
 * Place this file in your root directory and access it via browser.
 * IMPORTANT: Delete this file after use for security!
 */

// Include necessary files
require_once 'config.php';
require_once 'config/database.php';

// Display any errors for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

$results = [];
$conn_test_result = "Unknown";

// Test database connection
try {
    $test_query = $conn->query("SELECT 1");
    $conn_test_result = "Success";
} catch (PDOException $e) {
    $conn_test_result = "Failed: " . $e->getMessage();
}

$results[] = [
    'test' => 'Database Connection', 
    'result' => $conn_test_result,
    'status' => strpos($conn_test_result, 'Failed') === false ? 'Success' : 'Error'
];

// Test password hashing
$test_password = 'admin123';
$hashed_password = password_hash($test_password, PASSWORD_DEFAULT);
$results[] = [
    'test' => 'Generate hash for "admin123"', 
    'result' => $hashed_password,
    'status' => 'Info'
];

// Test password verification with the default admin password from database.sql
$stored_hash = '$2y$10$8tPJXX8MwVRFYUwHbP4UJ.jyW6IgIWJw5mQYYIgQ2UwP2U5.fgiie';
$verify_result = password_verify($test_password, $stored_hash);
$results[] = [
    'test' => 'Verify "admin123" against stored hash', 
    'result' => $verify_result ? 'Success' : 'Failed',
    'status' => $verify_result ? 'Success' : 'Error'
];

// Check PHP version - password_hash requires PHP 5.5+
$php_version = phpversion();
$results[] = [
    'test' => 'PHP Version', 
    'result' => $php_version,
    'status' => version_compare($php_version, '5.5.0', '>=') ? 'Success' : 'Error'
];

// Check for admin user in database
try {
    $stmt = $conn->prepare("SELECT username, password FROM users WHERE username = 'admin'");
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user) {
        $results[] = [
            'test' => 'Found admin user in database', 
            'result' => 'Username: ' . $user['username'],
            'status' => 'Success'
        ];
        
        // Test actual stored hash
        $db_verify_result = password_verify($test_password, $user['password']);
        $results[] = [
            'test' => 'Verify "admin123" against database hash', 
            'result' => $db_verify_result ? 'Success' : 'Failed',
            'status' => $db_verify_result ? 'Success' : 'Error'
        ];
        
        // Show hash from database
        $results[] = [
            'test' => 'Admin password hash in database', 
            'result' => $user['password'],
            'status' => 'Info'
        ];
    } else {
        $results[] = [
            'test' => 'Find admin user in database', 
            'result' => 'Admin user not found',
            'status' => 'Error'
        ];
    }
} catch (PDOException $e) {
    $results[] = [
        'test' => 'Database query', 
        'result' => 'Error: ' . $e->getMessage(),
        'status' => 'Error'
    ];
}

// Get database configuration
$results[] = [
    'test' => 'Database Host', 
    'result' => defined('DB_HOST') ? DB_HOST : 'Not defined',
    'status' => defined('DB_HOST') ? 'Info' : 'Error'
];

$results[] = [
    'test' => 'Database Name', 
    'result' => defined('DB_NAME') ? DB_NAME : 'Not defined',
    'status' => defined('DB_NAME') ? 'Info' : 'Error'
];

$results[] = [
    'test' => 'Database User', 
    'result' => defined('DB_USER') ? DB_USER : 'Not defined',
    'status' => defined('DB_USER') ? 'Info' : 'Error'
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Hash Test - Payment Status Platform</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-2xl">
        <h1 class="text-2xl font-bold mb-6 text-center text-indigo-600">Password System Test</h1>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Test</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Result</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($results as $result): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                <?php echo htmlspecialchars($result['test']); ?>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 break-all">
                                <?php echo htmlspecialchars($result['result']); ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                <?php 
                                    switch($result['status']) {
                                        case 'Success':
                                            echo 'bg-green-100 text-green-800';
                                            break;
                                        case 'Error':
                                            echo 'bg-red-100 text-red-800';
                                            break;
                                        default:
                                            echo 'bg-blue-100 text-blue-800';
                                    }
                                ?>">
                                    <?php echo htmlspecialchars($result['status']); ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <div class="mt-6 text-center text-sm text-gray-500">
            <p class="mt-4 text-red-500 font-bold">IMPORTANT: Delete this file after use!</p>
        </div>
    </div>
</body>
</html>