 
<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include required files
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/auth.php';

// Check if user is logged in
$isLoggedIn = isLoggedIn();
$isAdmin = $isLoggedIn && isAdmin();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Status Platform</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Additional CSS -->
    <style>
        .transition-all {
            transition: all 0.3s ease;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">
    <!-- Navigation -->
    <nav class="bg-indigo-600 text-white shadow-lg">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <a href="index.php" class="text-xl font-bold">Payment Platform</a>
            <div>
                <?php if ($isLoggedIn): ?>
                    <span class="mr-4">
                        Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?> 
                        (<?php echo $_SESSION['user_type'] === 'admin' ? 'Admin' : 'Client'; ?>)
                    </span>
                    <a href="logout.php" class="bg-indigo-700 hover:bg-indigo-800 px-4 py-2 rounded transition-all">
                        Logout
                    </a>
                <?php else: ?>
                    <a href="login.php" class="bg-indigo-700 hover:bg-indigo-800 px-4 py-2 rounded transition-all">
                        Login
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Main Content Container -->
    <div class="container mx-auto px-4 py-6 flex-grow">
        <?php displayFlashMessage(); ?>