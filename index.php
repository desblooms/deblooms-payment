<?php
/**
 * PayTrack - Client Payment Tracking System
 * Landing Page
 */

// Include configuration
require_once 'config.php';
require_once 'includes/functions.php';

// Check if user is already logged in
if (isset($_SESSION['user_id'])) {
    // Redirect based on user role
    if ($_SESSION['user_role'] === 'admin') {
        header('Location: admin/index.php');
        exit;
    } else {
        header('Location: client/index.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PayTrack - Payment Tracking System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'battleship-gray': '#868F83',
                        'yellow-green': '#B2C451',
                        'sage': '#C9CF94',
                        'silver': '#B7B7B5',
                        'black-olive': '#353732',
                        'mindaro': '#E7FE66',
                        'eerie-black': '#1C1F0A',
                        'mindaro-2': '#E6FB78',
                        'ebony': '#676548',
                        'mint-cream': '#EAEFEA',
                    }
                }
            }
        }
    </script>
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #C9CF94 0%, #E7FE66 100%);
        }
    </style>
</head>
<body class="gradient-bg min-h-screen flex flex-col">
    <header class="bg-eerie-black py-4 px-4 shadow-lg">
        <div class="container mx-auto flex justify-between items-center">
            <div class="flex items-center">
                <div class="mr-2 text-mindaro text-3xl">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h1 class="text-white text-xl font-bold">PayTrack</h1>
            </div>
            <nav>
                <a href="login.php" class="bg-mindaro text-eerie-black px-4 py-2 rounded-full font-medium hover:bg-mindaro-2 transition duration-300">
                    Login
                </a>
            </nav>
        </div>
    </header>

    <main class="flex-grow flex flex-col items-center justify-center px-4 py-10">
        <div class="max-w-lg w-full">
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-6">
                <div class="p-8">
                    <div class="flex items-center justify-center mb-6">
                        <div class="text-5xl text-yellow-green">
                            <i class="fas fa-chart-line"></i>
                        </div>
                    </div>
                    <h2 class="text-2xl md:text-3xl font-bold text-black-olive text-center mb-6">
                        Track Payments. <br>Manage Projects. <br>Grow Business.
                    </h2>
                    <p class="text-battleship-gray text-center mb-8">
                        The all-in-one platform for managing client projects and payments. Get a clear view of your business at a glance.
                    </p>
                    <div class="flex flex-col space-y-4">
                        <a href="login.php" class="bg-mindaro text-eerie-black text-center py-3 px-6 rounded-lg font-medium hover:bg-mindaro-2 transition duration-300">
                            Login to Your Account
                        </a>
                        <div class="text-center text-battleship-gray text-sm">
                            <p>Administrator? <a href="admin/login.php" class="text-yellow-green hover:underline">Login here</a></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-white p-6 rounded-xl shadow-md">
                    <div class="text-yellow-green text-2xl mb-3">
                        <i class="fas fa-wallet"></i>
                    </div>
                    <h3 class="font-bold text-black-olive mb-2">Track Payments</h3>
                    <p class="text-sm text-battleship-gray">Monitor all incoming payments and keep track of your project finances in real-time.</p>
                </div>
                
                <div class="bg-white p-6 rounded-xl shadow-md">
                    <div class="text-yellow-green text-2xl mb-3">
                        <i class="fas fa-tasks"></i>
                    </div>
                    <h3 class="font-bold text-black-olive mb-2">Manage Projects</h3>
                    <p class="text-sm text-battleship-gray">Keep all your projects organized with status updates and milestone tracking.</p>
                </div>
                
                <div class="bg-white p-6 rounded-xl shadow-md">
                    <div class="text-yellow-green text-2xl mb-3">
                        <i class="fas fa-file-invoice-dollar"></i>
                    </div>
                    <h3 class="font-bold text-black-olive mb-2">Easy Invoicing</h3>
                    <p class="text-sm text-battleship-gray">Create and send professional invoices to clients with just a few clicks.</p>
                </div>
                
                <div class="bg-white p-6 rounded-xl shadow-md">
                    <div class="text-yellow-green text-2xl mb-3">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    <h3 class="font-bold text-black-olive mb-2">Insightful Reports</h3>
                    <p class="text-sm text-battleship-gray">Get powerful insights about your business performance with detailed analytics.</p>
                </div>
            </div>
        </div>
    </main>

    <footer class="bg-eerie-black text-mint-cream py-6 mt-auto">
        <div class="container mx-auto px-4 text-center text-sm">
            <p>&copy; <?php echo date('Y'); ?> PayTrack. All rights reserved.</p>
            <div class="mt-2">
                <a href="#" class="text-mint-cream hover:text-mindaro mx-2">Terms</a>
                <a href="#" class="text-mint-cream hover:text-mindaro mx-2">Privacy</a>
                <a href="#" class="text-mint-cream hover:text-mindaro mx-2">Contact</a>
            </div>
        </div>
    </footer>
</body>
</html>