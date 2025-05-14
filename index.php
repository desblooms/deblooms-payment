<?php
session_start();
require_once 'config.php';
require_once 'includes/functions.php';
require_once 'includes/auth.php';

// Check if user is logged in
$isLoggedIn = isset($_SESSION['user_id']);
$isAdmin = $isLoggedIn && $_SESSION['user_type'] === 'admin';

// Handle logout
if (isset($_GET['logout'])) {
    logoutUser(); // This function handles session destruction and redirection
}

// Redirect to appropriate dashboard if logged in
if ($isLoggedIn) {
    if ($isAdmin) {
        header('Location: admin/dashboard.php');
    } else {
        header('Location: client/dashboard.php');
    }
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Desblooms Payments - Client Payment Status Platform</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">
    <!-- Navigation -->
    <nav class="bg-indigo-600 text-white shadow-lg">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <a href="index.php" class="text-xl font-bold">Desblooms Payments</a>
            <div>
                <a href="login.php" class="bg-indigo-700 hover:bg-indigo-800 px-4 py-2 rounded transition-all">
                    Login
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="flex-grow flex items-center justify-center">
        <div class="container mx-auto px-4 py-12">
            <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="md:flex">
                    <div class="md:w-1/2 bg-indigo-700 text-white p-12">
                        <h1 class="text-3xl font-bold mb-4">Welcome to Desblooms Payments</h1>
                        <p class="text-indigo-100 mb-6">Manage your projects and track your payments with ease. Our platform provides a simple and intuitive way to stay updated on all your payment statuses.</p>
                        <ul class="space-y-3">
                            <li class="flex items-center">
                                <i class="fas fa-check-circle mr-2 text-indigo-300"></i>
                                <span>Real-time payment status tracking</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check-circle mr-2 text-indigo-300"></i>
                                <span>Secure client portal access</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check-circle mr-2 text-indigo-300"></i>
                                <span>Complete project history and details</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check-circle mr-2 text-indigo-300"></i>
                                <span>Invoice management and tracking</span>
                            </li>
                        </ul>
                    </div>
                    <div class="md:w-1/2 p-12">
                        <div class="mb-8 text-center">
                            <h2 class="text-2xl font-bold text-gray-800">Login to Your Account</h2>
                            <p class="text-gray-600">Access your projects and payment information</p>
                        </div>
                        <form action="login.php" method="POST">
                            <div class="mb-6">
                                <label for="username" class="block text-gray-700 text-sm font-bold mb-2">Username</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-user text-gray-400"></i>
                                    </div>
                                    <input type="text" id="username" name="username" 
                                        class="pl-10 w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" 
                                        placeholder="Enter your username" required>
                                </div>
                            </div>
                            <div class="mb-6">
                                <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-lock text-gray-400"></i>
                                    </div>
                                    <input type="password" id="password" name="password" 
                                        class="pl-10 w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" 
                                        placeholder="Enter your password" required>
                                </div>
                            </div>
                            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300">
                                Login <i class="fas fa-sign-in-alt ml-2"></i>
                            </button>
                        </form>
                        <div class="mt-6 text-center text-sm text-gray-600">
                            Don't have an account? Please contact your administrator for access.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white py-4 shadow-inner">
        <div class="container mx-auto px-4 text-center text-gray-500 text-sm">
            &copy; <?php echo date('Y'); ?> Desblooms. All rights reserved.
        </div>
    </footer>
</body>
</html>