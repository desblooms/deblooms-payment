<?php
/**
 * Header Template
 * 
 * Provides the header structure for all pages including navigation
 * Uses Tailwind CSS for styling with custom color scheme
 * - Primary: #810041
 * - Dark Background: #18001c
 * - Accent Color: #f2ab8b
 */

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include authentication functions
require_once __DIR__ . '/auth.php';

// Get current page for active navigation highlighting
$current_page = basename($_SERVER['PHP_SELF']);

// Check if user is logged in and get role (admin or client)
$is_logged_in = isset($_SESSION['user_id']);
$user_role = $is_logged_in ? $_SESSION['user_role'] : '';
$user_name = $is_logged_in ? $_SESSION['user_name'] : '';

// Determine which navigation to show based on role
$is_admin = $user_role === 'admin';
$is_client = $user_role === 'client';

?>
<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PayTrack - Project Payment Management</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom Styles -->
    <style>
        :root {
            --primary: #810041;
            --dark-bg: #18001c;
            --accent: #f2ab8b;
        }
        
        .bg-gradient-custom {
            background: linear-gradient(135deg, #18001c 0%, #3a0032 100%);
        }
        
        .primary-gradient {
            background: linear-gradient(135deg, #810041 0%, #b40059 100%);
        }
        
        .accent-gradient {
            background: linear-gradient(135deg, #f2ab8b 0%, #f08e67 100%);
        }
    </style>
</head>
<body class="bg-gradient-custom min-h-screen text-gray-100 flex flex-col">
    <!-- Top Navigation Bar -->
    <header class="sticky top-0 z-50 bg-[#18001c]/95 backdrop-blur-sm border-b border-[#810041]/30 shadow-lg">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <!-- Logo -->
                <div class="flex items-center space-x-2">
                    <div class="primary-gradient p-2 rounded-lg">
                        <i class="fas fa-chart-line text-white text-xl"></i>
                    </div>
                    <span class="text-xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-[#f2ab8b] to-white">PayTrack</span>
                </div>
                
                <?php if ($is_logged_in): ?>
                <!-- User Menu -->
                <div class="flex items-center gap-4">
                    <div class="relative group">
                        <button class="flex items-center gap-2 focus:outline-none">
                            <div class="w-10 h-10 rounded-full primary-gradient flex items-center justify-center">
                                <span class="font-bold text-white"><?= substr($user_name, 0, 1); ?></span>
                            </div>
                            <span class="hidden md:inline-block text-gray-300"><?= htmlspecialchars($user_name); ?></span>
                            <i class="fas fa-chevron-down text-xs text-gray-400"></i>
                        </button>
                        <div class="absolute right-0 mt-2 w-48 bg-[#250028] border border-[#810041]/30 rounded-lg shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition duration-300 ease-in-out z-50">
                            <div class="px-4 py-3 border-b border-[#810041]/30">
                                <p class="text-sm text-gray-400">Logged in as</p>
                                <p class="text-sm font-medium text-gray-200"><?= htmlspecialchars($user_name); ?></p>
                                <p class="text-xs text-[#f2ab8b] capitalize"><?= htmlspecialchars($user_role); ?></p>
                            </div>
                            <div class="py-1">
                                <?php if ($is_client): ?>
                                <a href="/client/profile.php" class="block px-4 py-2 text-sm text-gray-300 hover:bg-[#810041]/20 hover:text-[#f2ab8b]">
                                    <i class="fas fa-user-circle mr-2"></i> Profile
                                </a>
                                <?php elseif ($is_admin): ?>
                                <a href="/admin/settings.php" class="block px-4 py-2 text-sm text-gray-300 hover:bg-[#810041]/20 hover:text-[#f2ab8b]">
                                    <i class="fas fa-cog mr-2"></i> Settings
                                </a>
                                <?php endif; ?>
                                <a href="/logout.php" class="block px-4 py-2 text-sm text-gray-300 hover:bg-[#810041]/20 hover:text-[#f2ab8b]">
                                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php else: ?>
                <!-- Login Button (if not logged in) -->
                <a href="/login.php" class="primary-gradient hover:opacity-90 text-white py-2 px-4 rounded-lg flex items-center gap-2 transition duration-300">
                    <i class="fas fa-sign-in-alt"></i>
                    <span>Login</span>
                </a>
                <?php endif; ?>
            </div>
        </div>
    </header>
    
    <!-- Main Container with Sidebar + Content -->
    <div class="flex flex-1 container mx-auto px-4 mt-6">
        <?php if ($is_logged_in): ?>
        <!-- Sidebar Navigation -->
        <aside class="w-64 hidden lg:block pr-4">
            <div class="bg-[#26002b]/50 backdrop-blur-sm rounded-xl p-4 shadow-lg border border-[#810041]/20 sticky top-24">
                <nav class="space-y-1">
                    <?php if ($is_admin): ?>
                    <!-- Admin Navigation -->
                    <div class="mb-3">
                        <p class="text-xs uppercase text-gray-500 mb-2 ml-2">Dashboard</p>
                        <a href="/admin/dashboard.php" class="flex items-center px-3 py-2 rounded-lg <?= $current_page === 'dashboard.php' ? 'bg-[#810041]/30 text-[#f2ab8b]' : 'text-gray-300 hover:bg-[#810041]/20 hover:text-[#f2ab8b]' ?>">
                            <i class="fas fa-tachometer-alt w-5"></i>
                            <span>Overview</span>
                        </a>
                        <a href="/admin/reports.php" class="flex items-center px-3 py-2 rounded-lg <?= $current_page === 'reports.php' ? 'bg-[#810041]/30 text-[#f2ab8b]' : 'text-gray-300 hover:bg-[#810041]/20 hover:text-[#f2ab8b]' ?>">
                            <i class="fas fa-chart-bar w-5"></i>
                            <span>Reports</span>
                        </a>
                    </div>
                    
                    <div class="mb-3">
                        <p class="text-xs uppercase text-gray-500 mb-2 ml-2">Clients</p>
                        <a href="/admin/all-clients.php" class="flex items-center px-3 py-2 rounded-lg <?= $current_page === 'all-clients.php' ? 'bg-[#810041]/30 text-[#f2ab8b]' : 'text-gray-300 hover:bg-[#810041]/20 hover:text-[#f2ab8b]' ?>">
                            <i class="fas fa-users w-5"></i>
                            <span>All Clients</span>
                        </a>
                        <a href="/admin/add-client.php" class="flex items-center px-3 py-2 rounded-lg <?= $current_page === 'add-client.php' ? 'bg-[#810041]/30 text-[#f2ab8b]' : 'text-gray-300 hover:bg-[#810041]/20 hover:text-[#f2ab8b]' ?>">
                            <i class="fas fa-user-plus w-5"></i>
                            <span>Add Client</span>
                        </a>
                    </div>
                    
                    <div class="mb-3">
                        <p class="text-xs uppercase text-gray-500 mb-2 ml-2">Projects</p>
                        <a href="/admin/all-projects.php" class="flex items-center px-3 py-2 rounded-lg <?= $current_page === 'all-projects.php' ? 'bg-[#810041]/30 text-[#f2ab8b]' : 'text-gray-300 hover:bg-[#810041]/20 hover:text-[#f2ab8b]' ?>">
                            <i class="fas fa-project-diagram w-5"></i>
                            <span>All Projects</span>
                        </a>
                        <a href="/admin/add-project.php" class="flex items-center px-3 py-2 rounded-lg <?= $current_page === 'add-project.php' ? 'bg-[#810041]/30 text-[#f2ab8b]' : 'text-gray-300 hover:bg-[#810041]/20 hover:text-[#f2ab8b]' ?>">
                            <i class="fas fa-plus-circle w-5"></i>
                            <span>Add Project</span>
                        </a>
                    </div>
                    
                    <div class="mb-3">
                        <p class="text-xs uppercase text-gray-500 mb-2 ml-2">Payments</p>
                        <a href="/admin/all-payments.php" class="flex items-center px-3 py-2 rounded-lg <?= $current_page === 'all-payments.php' ? 'bg-[#810041]/30 text-[#f2ab8b]' : 'text-gray-300 hover:bg-[#810041]/20 hover:text-[#f2ab8b]' ?>">
                            <i class="fas fa-money-bill-wave w-5"></i>
                            <span>All Payments</span>
                        </a>
                        <a href="/admin/record-payment.php" class="flex items-center px-3 py-2 rounded-lg <?= $current_page === 'record-payment.php' ? 'bg-[#810041]/30 text-[#f2ab8b]' : 'text-gray-300 hover:bg-[#810041]/20 hover:text-[#f2ab8b]' ?>">
                            <i class="fas fa-cash-register w-5"></i>
                            <span>Record Payment</span>
                        </a>
                    </div>
                    
                    <div class="mb-3">
                        <p class="text-xs uppercase text-gray-500 mb-2 ml-2">Invoices</p>
                        <a href="/admin/create-invoice.php" class="flex items-center px-3 py-2 rounded-lg <?= $current_page === 'create-invoice.php' ? 'bg-[#810041]/30 text-[#f2ab8b]' : 'text-gray-300 hover:bg-[#810041]/20 hover:text-[#f2ab8b]' ?>">
                            <i class="fas fa-file-invoice w-5"></i>
                            <span>Create Invoice</span>
                        </a>
                    </div>
                    
                    <?php elseif ($is_client): ?>
                    <!-- Client Navigation -->
                    <div class="mb-3">
                        <p class="text-xs uppercase text-gray-500 mb-2 ml-2">Dashboard</p>
                        <a href="/client/dashboard.php" class="flex items-center px-3 py-2 rounded-lg <?= $current_page === 'dashboard.php' ? 'bg-[#810041]/30 text-[#f2ab8b]' : 'text-gray-300 hover:bg-[#810041]/20 hover:text-[#f2ab8b]' ?>">
                            <i class="fas fa-tachometer-alt w-5"></i>
                            <span>Overview</span>
                        </a>
                    </div>
                    
                    <div class="mb-3">
                        <p class="text-xs uppercase text-gray-500 mb-2 ml-2">Projects</p>
                        <a href="/client/projects.php" class="flex items-center px-3 py-2 rounded-lg <?= $current_page === 'projects.php' ? 'bg-[#810041]/30 text-[#f2ab8b]' : 'text-gray-300 hover:bg-[#810041]/20 hover:text-[#f2ab8b]' ?>">
                            <i class="fas fa-project-diagram w-5"></i>
                            <span>My Projects</span>
                        </a>
                    </div>
                    
                    <div class="mb-3">
                        <p class="text-xs uppercase text-gray-500 mb-2 ml-2">Payments</p>
                        <a href="/client/payment-history.php" class="flex items-center px-3 py-2 rounded-lg <?= $current_page === 'payment-history.php' ? 'bg-[#810041]/30 text-[#f2ab8b]' : 'text-gray-300 hover:bg-[#810041]/20 hover:text-[#f2ab8b]' ?>">
                            <i class="fas fa-money-bill-wave w-5"></i>
                            <span>Payment History</span>
                        </a>
                    </div>
                    
                    <div class="mb-3">
                        <p class="text-xs uppercase text-gray-500 mb-2 ml-2">Invoices</p>
                        <a href="/client/invoices.php" class="flex items-center px-3 py-2 rounded-lg <?= $current_page === 'invoices.php' ? 'bg-[#810041]/30 text-[#f2ab8b]' : 'text-gray-300 hover:bg-[#810041]/20 hover:text-[#f2ab8b]' ?>">
                            <i class="fas fa-file-invoice w-5"></i>
                            <span>Invoices</span>
                        </a>
                    </div>
                    <?php endif; ?>
                </nav>
                
                <!-- Sidebar Footer -->
                <div class="mt-8 pt-4 border-t border-[#810041]/20">
                    <?php if ($is_admin): ?>
                    <a href="/admin/settings.php" class="flex items-center px-3 py-2 rounded-lg text-gray-300 hover:bg-[#810041]/20 hover:text-[#f2ab8b]">
                        <i class="fas fa-cog w-5"></i>
                        <span>Settings</span>
                    </a>
                    <?php else: ?>
                    <a href="/client/profile.php" class="flex items-center px-3 py-2 rounded-lg text-gray-300 hover:bg-[#810041]/20 hover:text-[#f2ab8b]">
                        <i class="fas fa-user-circle w-5"></i>
                        <span>My Profile</span>
                    </a>
                    <?php endif; ?>
                    <a href="/logout.php" class="flex items-center px-3 py-2 rounded-lg text-gray-300 hover:bg-[#810041]/20 hover:text-[#f2ab8b]">
                        <i class="fas fa-sign-out-alt w-5"></i>
                        <span>Logout</span>
                    </a>
                </div>
            </div>
        </aside>
        <?php endif; ?>
        
        <!-- Mobile Navigation (for small screens) -->
        <?php if ($is_logged_in): ?>
        <div class="lg:hidden w-full mb-6">
            <button id="mobile-menu-button" class="w-full flex items-center justify-between bg-[#26002b]/50 backdrop-blur-sm p-4 rounded-xl shadow-lg border border-[#810041]/20">
                <span class="font-medium text-gray-300">Menu</span>
                <i class="fas fa-bars text-gray-300"></i>
            </button>
            
            <div id="mobile-menu" class="hidden mt-2 bg-[#26002b]/90 backdrop-blur-sm rounded-xl p-4 shadow-lg border border-[#810041]/20">
                <?php if ($is_admin): ?>
                <!-- Admin Mobile Navigation -->
                <div class="grid grid-cols-2 gap-2 mb-4">
                    <a href="/admin/dashboard.php" class="flex items-center px-3 py-2 rounded-lg <?= $current_page === 'dashboard.php' ? 'bg-[#810041]/30 text-[#f2ab8b]' : 'text-gray-300 hover:bg-[#810041]/20 hover:text-[#f2ab8b]' ?>">
                        <i class="fas fa-tachometer-alt w-5"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="/admin/all-clients.php" class="flex items-center px-3 py-2 rounded-lg <?= $current_page === 'all-clients.php' ? 'bg-[#810041]/30 text-[#f2ab8b]' : 'text-gray-300 hover:bg-[#810041]/20 hover:text-[#f2ab8b]' ?>">
                        <i class="fas fa-users w-5"></i>
                        <span>Clients</span>
                    </a>
                    <a href="/admin/all-projects.php" class="flex items-center px-3 py-2 rounded-lg <?= $current_page === 'all-projects.php' ? 'bg-[#810041]/30 text-[#f2ab8b]' : 'text-gray-300 hover:bg-[#810041]/20 hover:text-[#f2ab8b]' ?>">
                        <i class="fas fa-project-diagram w-5"></i>
                        <span>Projects</span>
                    </a>
                    <a href="/admin/all-payments.php" class="flex items-center px-3 py-2 rounded-lg <?= $current_page === 'all-payments.php' ? 'bg-[#810041]/30 text-[#f2ab8b]' : 'text-gray-300 hover:bg-[#810041]/20 hover:text-[#f2ab8b]' ?>">
                        <i class="fas fa-money-bill-wave w-5"></i>
                        <span>Payments</span>
                    </a>
                    <a href="/admin/create-invoice.php" class="flex items-center px-3 py-2 rounded-lg <?= $current_page === 'create-invoice.php' ? 'bg-[#810041]/30 text-[#f2ab8b]' : 'text-gray-300 hover:bg-[#810041]/20 hover:text-[#f2ab8b]' ?>">
                        <i class="fas fa-file-invoice w-5"></i>
                        <span>Invoices</span>
                    </a>
                    <a href="/admin/reports.php" class="flex items-center px-3 py-2 rounded-lg <?= $current_page === 'reports.php' ? 'bg-[#810041]/30 text-[#f2ab8b]' : 'text-gray-300 hover:bg-[#810041]/20 hover:text-[#f2ab8b]' ?>">
                        <i class="fas fa-chart-bar w-5"></i>
                        <span>Reports</span>
                    </a>
                </div>
                <?php elseif ($is_client): ?>
                <!-- Client Mobile Navigation -->
                <div class="grid grid-cols-2 gap-2 mb-4">
                    <a href="/client/dashboard.php" class="flex items-center px-3 py-2 rounded-lg <?= $current_page === 'dashboard.php' ? 'bg-[#810041]/30 text-[#f2ab8b]' : 'text-gray-300 hover:bg-[#810041]/20 hover:text-[#f2ab8b]' ?>">
                        <i class="fas fa-tachometer-alt w-5"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="/client/projects.php" class="flex items-center px-3 py-2 rounded-lg <?= $current_page === 'projects.php' ? 'bg-[#810041]/30 text-[#f2ab8b]' : 'text-gray-300 hover:bg-[#810041]/20 hover:text-[#f2ab8b]' ?>">
                        <i class="fas fa-project-diagram w-5"></i>
                        <span>Projects</span>
                    </a>
                    <a href="/client/payment-history.php" class="flex items-center px-3 py-2 rounded-lg <?= $current_page === 'payment-history.php' ? 'bg-[#810041]/30 text-[#f2ab8b]' : 'text-gray-300 hover:bg-[#810041]/20 hover:text-[#f2ab8b]' ?>">
                        <i class="fas fa-money-bill-wave w-5"></i>
                        <span>Payments</span>
                    </a>
                    <a href="/client/invoices.php" class="flex items-center px-3 py-2 rounded-lg <?= $current_page === 'invoices.php' ? 'bg-[#810041]/30 text-[#f2ab8b]' : 'text-gray-300 hover:bg-[#810041]/20 hover:text-[#f2ab8b]' ?>">
                        <i class="fas fa-file-invoice w-5"></i>
                        <span>Invoices</span>
                    </a>
                </div>
                <?php endif; ?>
                
                <!-- Common Mobile Menu Footer -->
                <div class="pt-2 border-t border-[#810041]/20 grid grid-cols-2 gap-2">
                    <?php if ($is_admin): ?>
                    <a href="/admin/settings.php" class="flex items-center px-3 py-2 rounded-lg text-gray-300 hover:bg-[#810041]/20 hover:text-[#f2ab8b]">
                        <i class="fas fa-cog w-5"></i>
                        <span>Settings</span>
                    </a>
                    <?php else: ?>
                    <a href="/client/profile.php" class="flex items-center px-3 py-2 rounded-lg text-gray-300 hover:bg-[#810041]/20 hover:text-[#f2ab8b]">
                        <i class="fas fa-user-circle w-5"></i>
                        <span>Profile</span>
                    </a>
                    <?php endif; ?>
                    <a href="/logout.php" class="flex items-center px-3 py-2 rounded-lg text-gray-300 hover:bg-[#810041]/20 hover:text-[#f2ab8b]">
                        <i class="fas fa-sign-out-alt w-5"></i>
                        <span>Logout</span>
                    </a>
                </div>
            </div>
        </div>
        <?php endif; ?>
        
        <!-- Main Content Area -->
        <main class="flex-1 mb-10">
            <div class="bg-[#26002b]/50 backdrop-blur-sm rounded-xl p-6 shadow-lg border border-[#810041]/20">
                <!-- Content container - page specific content goes here -->