<?php
/**
 * Simple Database Configuration Test
 * 
 * This script checks if your database configuration is working correctly.
 * It will help identify database connection issues that might be causing login problems.
 * IMPORTANT: Delete this file after use for security!
 */

// Display any errors for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Try to include the database configuration
$results = [];

// Check if the config/database.php file exists
if (file_exists('config/database.php')) {
    $results[] = [
        'test' => 'Locate database.php', 
        'result' => 'File exists at config/database.php',
        'status' => 'Success'
    ];
    
    // Try to include it
    try {
        require_once 'config/database.php';
        $results[] = [
            'test' => 'Include database.php', 
            'result' => 'Successfully included',
            'status' => 'Success'
        ];
        
        // Check if $conn is defined
        if (isset($conn)) {
            $results[] = [
                'test' => 'Database connection variable', 
                'result' => 'Connection variable $conn is defined',
                'status' => 'Success'
            ];
            
            // Test database connection
            try {
                $test_query = $conn->query("SELECT 1");
                $results[] = [
                    'test' => 'Database connection test', 
                    'result' => 'Connection successful',
                    'status' => 'Success'
                ];
                
                // Check tables
                try {
                    $tables = [
                        'users' => 'Check users table',
                        'clients' => 'Check clients table',
                        'projects' => 'Check projects table',
                        'payments' => 'Check payments table',
                        'invoices' => 'Check invoices table'
                    ];
                    
                    foreach ($tables as $table => $description) {
                        $stmt = $conn->prepare("SHOW TABLES LIKE ?");
                        $stmt->execute([$table]);
                        $exists = $stmt->rowCount() > 0;
                        
                        $results[] = [
                            'test' => $description, 
                            'result' => $exists ? "Table $table exists" : "Table $table does not exist",
                            'status' => $exists ? 'Success' : 'Error'
                        ];
                    }
                    
                    // Check if admin user exists
                    $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE username = 'admin'");
                    $stmt->execute();
                    $count = $stmt->fetchColumn();
                    
                    $results[] = [
                        'test' => 'Admin user exists', 
                        'result' => $count > 0 ? "Admin user found" : "Admin user not found",
                        'status' => $count > 0 ? 'Success' : 'Error'
                    ];
                    
                } catch (PDOException $e) {
                    $results[] = [
                        'test' => 'Database schema check', 
                        'result' => 'Error: ' . $e->getMessage(),
                        'status' => 'Error'
                    ];
                }
                
            } catch (PDOException $e) {
                $results[] = [
                    'test' => 'Database connection test', 
                    'result' => 'Connection failed: ' . $e->getMessage(),
                    'status' => 'Error'
                ];
            }
            
        } else {
            $results[] = [
                'test' => 'Database connection variable', 
                'result' => 'Connection variable $conn is not defined',
                'status' => 'Error'
            ];
        }
        
    } catch (Exception $e) {
        $results[] = [
            'test' => 'Include database.php', 
            'result' => 'Error: ' . $e->getMessage(),
            'status' => 'Error'
        ];
    }
    
} else {
    $results[] = [
        'test' => 'Locate database.php', 
        'result' => 'File not found at config/database.php',
        'status' => 'Error'
    ];
}

// Check database constants if they are defined
$constants = ['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASS'];
foreach ($constants as $constant) {
    $results[] = [
        'test' => "Check $constant", 
        'result' => defined($constant) ? "$constant is defined" : "$constant is not defined",
        'status' => defined($constant) ? 'Success' : 'Error'
    ];
    
    if (defined($constant)) {
        $value = constant($constant);
        $masked_value = $constant === 'DB_PASS' ? '********' : $value;
        
        $results[] = [
            'test' => "$constant value", 
            'result' => $masked_value,
            'status' => 'Info'
        ];
    }
}

// Check PHP version
$php_version = phpversion();
$results[] = [
    'test' => 'PHP Version', 
    'result' => $php_version,
    'status' => version_compare($php_version, '7.0.0', '>=') ? 'Success' : 'Warning'
];

// Check PDO extension
$results[] = [
    'test' => 'PDO Extension', 
    'result' => extension_loaded('pdo') ? 'PDO is available' : 'PDO is not available',
    'status' => extension_loaded('pdo') ? 'Success' : 'Error'
];

// Check PDO MySQL extension
$results[] = [
    'test' => 'PDO MySQL Extension', 
    'result' => extension_loaded('pdo_mysql') ? 'PDO MySQL is available' : 'PDO MySQL is not available',
    'status' => extension_loaded('pdo_mysql') ? 'Success' : 'Error'
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Configuration Test</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-2xl">
        <h1 class="text-2xl font-bold mb-6 text-center text-indigo-600">Database Configuration Test</h1>
        
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
                                        case 'Warning':
                                            echo 'bg-yellow-100 text-yellow-800';
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
            <p class="text-red-500 font-bold">IMPORTANT: Delete this file after use!</p>
        </div>
    </div>
</body>
</html>