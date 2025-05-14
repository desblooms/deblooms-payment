<?php
/**
 * Password Reset Script
 * 
 * This script allows you to reset user passwords.
 * Place this file in your root directory and access it via browser.
 * IMPORTANT: Delete this file after use for security!
 */

// Include necessary files
require_once 'config.php';
require_once 'config/database.php';
require_once 'includes/functions.php';

$success = false;
$error = '';
$username = '';

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $new_password = $_POST['new_password'] ?? '';
    
    if (empty($username) || empty($new_password)) {
        $error = 'Username and new password are required';
    } else {
        try {
            // Check if user exists
            $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
            $stmt->execute([$username]);
            
            if ($stmt->rowCount() === 0) {
                $error = 'User not found';
            } else {
                // Hash the new password
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                
                // Update the password
                $updateStmt = $conn->prepare("UPDATE users SET password = ? WHERE username = ?");
                $result = $updateStmt->execute([$hashed_password, $username]);
                
                if ($result) {
                    $success = true;
                    $username = ''; // Clear form
                } else {
                    $error = 'Failed to update password';
                }
            }
        } catch (PDOException $e) {
            $error = 'Database error: ' . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Payment Status Platform</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <h1 class="text-2xl font-bold mb-6 text-center text-indigo-600">Reset User Password</h1>
        
        <?php if ($success): ?>
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                Password has been reset successfully.
            </div>
        <?php endif; ?>
        
        <?php if (!empty($error)): ?>
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="mb-4">
                <label for="username" class="block text-gray-700 text-sm font-bold mb-2">Username</label>
                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" 
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                    required>
            </div>
            
            <div class="mb-6">
                <label for="new_password" class="block text-gray-700 text-sm font-bold mb-2">New Password</label>
                <input type="password" id="new_password" name="new_password" 
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                    required>
            </div>
            
            <div class="flex items-center justify-between">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full">
                    Reset Password
                </button>
            </div>
        </form>
        
        <div class="mt-6 text-center text-sm text-gray-500">
            <p>Default admin username: <strong>admin</strong></p>
            <p class="mt-4 text-red-500 font-bold">IMPORTANT: Delete this file after use!</p>
        </div>
    </div>
</body>
</html>