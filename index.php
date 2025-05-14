<?php
/**
 * PayTrack - Client Payment Portal
 * 
 * Landing page that redirects users to appropriate dashboards or login page
 * based on authentication status
 */

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include configuration files
require_once 'config.php';
require_once 'includes/functions.php';

// Check if user is logged in
if (isset($_SESSION['user_id'])) {
    // Redirect based on user role
    if ($_SESSION['user_role'] === 'admin') {
        header('Location: admin/dashboard.php');
        exit;
    } else if ($_SESSION['user_role'] === 'client') {
        header('Location: client/dashboard.php');
        exit;
    }
}

// If not logged in, show landing page
?>

<?php include 'includes/header.php'; ?>

<!-- Landing Page Content -->
<div class="flex flex-col min-h-[90vh] justify-center items-center px-4 py-8">
    <!-- Hero Section -->
    <div class="glass w-full max-w-md rounded-2xl overflow-hidden shadow-xl mb-8 border border-[#810041]/20">
        <div class="relative">
            <!-- Hero Background with Gradient Overlay -->
            <div class="h-48 bg-gradient-to-r from-[#810041] to-[#18001c] flex items-center justify-center">
                <div class="w-20 h-20 rounded-full bg-white/10 backdrop-blur-md flex items-center justify-center">
                    <div class="w-16 h-16 rounded-full bg-gradient-to-r from-[#810041] to-[#f2ab8b] flex items-center justify-center">
                        <span class="text-white text-3xl font-bold">P</span>
                    </div>
                </div>
            </div>
            
            <!-- Content -->
            <div class="p-6 text-center">
                <h1 class="text-2xl font-bold bg-gradient-to-r from-[#810041] to-[#f2ab8b] text-transparent bg-clip-text mb-3">Welcome to PayTrack</h1>
                <p class="text-gray-300 mb-6">Streamline your payment tracking and client collaboration with our modern platform.</p>
                
                <div class="flex flex-col space-y-4">
                    <a href="login.php" class="bg-gradient-to-r from-[#810041] to-[#f2ab8b] text-white font-medium py-3 px-6 rounded-lg hover:opacity-90 transition duration-300 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                        </svg>
                        Login to Your Account
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Feature Cards -->
    <div class="grid grid-cols-1 gap-4 w-full max-w-md">
        <!-- Feature 1 -->
        <div class="glass rounded-xl p-5 border border-[#810041]/20">
            <div class="flex items-start">
                <div class="bg-gradient-to-r from-[#810041] to-[#f2ab8b] w-12 h-12 rounded-full flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-white mb-1">Project Tracking</h3>
                    <p class="text-gray-400 text-sm">Track all your projects with real-time updates on progress and payments.</p>
                </div>
            </div>
        </div>
        
        <!-- Feature 2 -->
        <div class="glass rounded-xl p-5 border border-[#810041]/20">
            <div class="flex items-start">
                <div class="bg-gradient-to-r from-[#810041] to-[#f2ab8b] w-12 h-12 rounded-full flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-white mb-1">Payment Management</h3>
                    <p class="text-gray-400 text-sm">Secure and transparent payment tracking for all your client transactions.</p>
                </div>
            </div>
        </div>
        
        <!-- Feature 3 -->
        <div class="glass rounded-xl p-5 border border-[#810041]/20">
            <div class="flex items-start">
                <div class="bg-gradient-to-r from-[#810041] to-[#f2ab8b] w-12 h-12 rounded-full flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-white mb-1">Client Portal</h3>
                    <p class="text-gray-400 text-sm">Dedicated client accounts with secure access to invoices and project details.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Benefit Section -->
<div class="w-full bg-[#18001c]/50 py-10 mt-6 backdrop-blur-sm">
    <div class="container mx-auto px-4">
        <h2 class="text-xl font-bold text-center text-white mb-6">Why Choose PayTrack?</h2>
        
        <div class="grid grid-cols-1 gap-4 max-w-md mx-auto">
            <!-- Benefit 1 -->
            <div class="flex items-start">
                <div class="flex-shrink-0 mt-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#f2ab8b]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-white font-medium">Mobile-First Design</h3>
                    <p class="text-gray-400 text-sm">Access your portal from any device with our responsive interface.</p>
                </div>
            </div>
            
            <!-- Benefit 2 -->
            <div class="flex items-start">
                <div class="flex-shrink-0 mt-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#f2ab8b]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-white font-medium">Real-Time Updates</h3>
                    <p class="text-gray-400 text-sm">Stay informed with immediate status updates for all your payments.</p>
                </div>
            </div>
            
            <!-- Benefit 3 -->
            <div class="flex items-start">
                <div class="flex-shrink-0 mt-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#f2ab8b]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-white font-medium">Secure Access</h3>
                    <p class="text-gray-400 text-sm">Individual logins for each client with encrypted data protection.</p>
                </div>
            </div>
            
            <!-- Benefit 4 -->
            <div class="flex items-start">
                <div class="flex-shrink-0 mt-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#f2ab8b]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-white font-medium">Comprehensive Reporting</h3>
                    <p class="text-gray-400 text-sm">Detailed insights into your payment history and project statuses.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>