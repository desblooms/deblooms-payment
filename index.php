<?php
/**
 * PayTrack - Client Payment Portal
 *
 * Landing page that redirects to the appropriate dashboard based on user role
 * or displays a welcome screen for non-logged in users
 */

// Start session
session_start();

// Include functions
require_once 'includes/functions.php';

// Check if user is logged in
if (isset($_SESSION['user_id'])) {
    // Redirect based on user role
    if ($_SESSION['user_role'] === 'admin') {
        header('Location: admin/dashboard.php');
        exit;
    } else {
        header('Location: client/dashboard.php');
        exit;
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PayTrack - Payment Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#6366f1',
                        secondary: '#f472b6',
                        dark: '#121212',
                        card: 'rgba(23, 23, 28, 0.8)',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    <style>
        body {
            background-color: #121212;
            background-image: 
                radial-gradient(circle at 25% 10%, rgba(99, 102, 241, 0.15) 0%, transparent 40%),
                radial-gradient(circle at 75% 75%, rgba(244, 114, 182, 0.15) 0%, transparent 40%);
            color: #fff;
            font-family: 'Inter', sans-serif;
        }
        .glass {
            background: rgba(23, 23, 28, 0.8);
            backdrop-filter: blur(12px);
            border-radius: 16px;
        }
        .btn-gradient {
            background: linear-gradient(135deg, #6366f1 0%, #f472b6 100%);
        }
        .text-gradient {
            background: linear-gradient(135deg, #6366f1 0%, #f472b6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>
<body class="min-h-screen">
    <!-- Header -->
    <header class="p-4 flex items-center justify-between">
        <div class="flex items-center">
            <div class="h-10 w-10 rounded-full btn-gradient flex items-center justify-center">
                <span class="text-white font-bold text-xl">P</span>
            </div>
            <h1 class="ml-2 text-xl font-bold text-gradient">PayTrack</h1>
        </div>
        <a href="login.php" class="px-4 py-2 rounded-full bg-white/10 text-white text-sm hover:bg-white/20 transition">
            Sign In
        </a>
    </header>

    <!-- Hero Section -->
    <section class="px-6 py-12">
        <div class="max-w-md mx-auto text-center">
            <h1 class="text-3xl font-bold mb-4">Manage your <span class="text-gradient">payments</span> with ease</h1>
            <p class="text-gray-400 mb-8">Track project payments, view status, and stay connected with your clients in one simple dashboard.</p>
            <a href="login.php" class="btn-gradient text-white font-medium py-3 px-8 rounded-full inline-block shadow-lg shadow-primary/20 hover:opacity-90 transition">
                Get Started
            </a>
        </div>
    </section>

    <!-- App Preview -->
    <section class="px-6 py-8">
        <div class="relative max-w-sm mx-auto">
            <div class="absolute inset-0 btn-gradient opacity-20 blur-xl rounded-3xl"></div>
            <div class="relative glass border border-white/10 rounded-3xl overflow-hidden shadow-xl">
                <img src="https://cdn.dribbble.com/userupload/17402714/file/original-6d32be8a63486860f02b167daecc967e.png" alt="PayTrack App" class="w-full h-auto">
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="px-6 py-12">
        <h2 class="text-2xl font-bold text-center mb-10">Key Features</h2>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 max-w-4xl mx-auto">
            <!-- Feature 1 -->
            <div class="glass p-6 rounded-xl border border-white/10">
                <div class="h-12 w-12 rounded-full btn-gradient flex items-center justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2">Project Tracking</h3>
                <p class="text-gray-400">Monitor all your projects and their payment status in real-time.</p>
            </div>
            
            <!-- Feature 2 -->
            <div class="glass p-6 rounded-xl border border-white/10">
                <div class="h-12 w-12 rounded-full btn-gradient flex items-center justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2">Payment History</h3>
                <p class="text-gray-400">Review all past payments and upcoming invoices in one place.</p>
            </div>
            
            <!-- Feature 3 -->
            <div class="glass p-6 rounded-xl border border-white/10">
                <div class="h-12 w-12 rounded-full btn-gradient flex items-center justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2">Notifications</h3>
                <p class="text-gray-400">Get alerts for payment due dates and project milestones.</p>
            </div>
            
            <!-- Feature 4 -->
            <div class="glass p-6 rounded-xl border border-white/10">
                <div class="h-12 w-12 rounded-full btn-gradient flex items-center justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2">Client Dashboard</h3>
                <p class="text-gray-400">Custom dashboard for each client with secure login access.</p>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="px-6 py-12 mb-10">
        <div class="glass p-8 rounded-xl border border-white/10 max-w-md mx-auto text-center">
            <h2 class="text-2xl font-bold mb-4">Ready to get started?</h2>
            <p class="text-gray-400 mb-6">Sign in to your account or contact us to set up your payment tracking portal.</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="login.php" class="btn-gradient text-white font-medium py-3 px-6 rounded-full inline-block shadow-lg hover:opacity-90 transition">
                    Sign In
                </a>
                <a href="#contact" class="bg-white/10 text-white font-medium py-3 px-6 rounded-full inline-block hover:bg-white/20 transition">
                    Contact Us
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="glass border-t border-white/10 py-6 px-6">
        <div class="max-w-4xl mx-auto flex flex-col sm:flex-row justify-between items-center">
            <div class="flex items-center mb-4 sm:mb-0">
                <div class="h-8 w-8 rounded-full btn-gradient flex items-center justify-center">
                    <span class="text-white font-bold">P</span>
                </div>
                <span class="ml-2 text-gradient font-semibold">PayTrack</span>
            </div>
            <div class="text-gray-400 text-sm">
                &copy; <?php echo date('Y'); ?> PayTrack. All rights reserved.
            </div>
        </div>
    </footer>
</body>
</html>