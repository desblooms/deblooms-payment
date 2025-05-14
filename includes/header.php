<!-- includes/header.php -->
<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PayTrack - Client Payment Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: '#810041',
                        secondary: '#f2ab8b',
                        accent: '#18001c',
                        'dark-bg': '#121212',
                        'card-bg': 'rgba(30, 30, 30, 0.7)',
                    },
                    fontFamily: {
                        'sans': ['Inter', 'sans-serif'],
                    },
                    boxShadow: {
                        'glass': '0 4px 20px 0 rgba(0, 0, 0, 0.05)',
                    }
                }
            }
        }
    </script>
    <style>
        /* Custom Color Variables */
        :root {
            --primary: #810041;
            --secondary: #f2ab8b;
            --accent: #18001c;
            --dark-bg: #121212;
            --card-bg: rgba(30, 30, 30, 0.7);
        }

        /* Glassmorphism Effect */
        .glass {
            background: rgba(30, 30, 30, 0.5);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.07);
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: var(--dark-bg);
        }
        ::-webkit-scrollbar-thumb {
            background: var(--primary);
            border-radius: 4px;
        }

        body {
            background-color: var(--dark-bg);
            color: #ffffff;
            font-family: 'Inter', sans-serif;
            background-image: radial-gradient(circle at center, #300030 0%, #18001c 100%);
        }

        .primary-bg {
            background-color: var(--primary);
        }
        .secondary-bg {
            background-color: var(--secondary);
        }
        .accent-bg {
            background-color: var(--accent);
        }
        .primary-text {
            color: var(--primary);
        }
        .secondary-text {
            color: var(--secondary);
        }
        .accent-text {
            color: var(--accent);
        }
        
        /* Custom card effect */
        .card-gradient {
            background: linear-gradient(135deg, rgba(129, 0, 65, 0.2) 0%, rgba(242, 171, 139, 0.1) 100%);
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="min-h-screen bg-gradient-to-b from-[#18001c] to-[#300030]">
    <?php 
    // Determine if user is logged in and their role
    $isLoggedIn = isset($_SESSION['user_id']);
    $userRole = $isLoggedIn ? $_SESSION['user_role'] : '';
    $currentPage = basename($_SERVER['PHP_SELF']);
    ?>

    <!-- Navigation Header -->
    <header class="glass sticky top-0 z-50">
        <nav class="px-4 py-3 flex justify-between items-center border-b border-[#810041]/20">
            <div class="flex items-center">
                <a href="<?php echo $userRole === 'admin' ? 'admin/dashboard.php' : 'client/dashboard.php'; ?>" class="flex items-center">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-r from-[#810041] to-[#f2ab8b] flex items-center justify-center shadow-lg">
                        <span class="text-white font-bold text-lg">P</span>
                    </div>
                    <span class="ml-3 text-xl font-semibold bg-gradient-to-r from-[#810041] to-[#f2ab8b] text-transparent bg-clip-text">PayTrack</span>
                </a>
            </div>

            <?php if($isLoggedIn): ?>
            <!-- Notification Icon -->
            <div class="flex items-center space-x-4">
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="p-2 rounded-full hover:bg-[#810041]/20 transition relative">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        <span class="absolute top-1 right-1 h-4 w-4 rounded-full bg-[#f2ab8b] text-xs flex items-center justify-center">2</span>
                    </button>
                    
                    <!-- Notifications Dropdown -->
                    <div x-show="open" 
                        @click.away="open = false" 
                        x-transition:enter="transition ease-out duration-200" 
                        x-transition:enter-start="opacity-0 scale-95" 
                        x-transition:enter-end="opacity-100 scale-100" 
                        x-transition:leave="transition ease-in duration-150" 
                        x-transition:leave-start="opacity-100 scale-100" 
                        x-transition:leave-end="opacity-0 scale-95" 
                        class="absolute right-0 mt-2 w-80 glass rounded-lg shadow-lg py-2 z-50"
                        style="display: none;">
                        <div class="px-4 py-2 border-b border-[#810041]/20">
                            <h3 class="font-semibold text-white">Notifications</h3>
                        </div>
                        <div class="max-h-60 overflow-y-auto">
                            <!-- Notification Items -->
                            <a href="#" class="block px-4 py-3 hover:bg-[#810041]/10 border-b border-[#810041]/10">
                                <div class="flex items-start">
                                    <div class="bg-blue-900/30 text-blue-400 rounded-full p-2 mr-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-white">New Project Created</p>
                                        <p class="text-xs text-gray-400 mt-1">A new project has been created: Website Redesign</p>
                                        <p class="text-xs text-gray-500 mt-1">2 hours ago</p>
                                    </div>
                                </div>
                            </a>
                            <a href="#" class="block px-4 py-3 hover:bg-[#810041]/10">
                                <div class="flex items-start">
                                    <div class="bg-green-900/30 text-green-400 rounded-full p-2 mr-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-white">Payment Received</p>
                                        <p class="text-xs text-gray-400 mt-1">Payment received for Invoice #INV-2023-05</p>
                                        <p class="text-xs text-gray-500 mt-1">1 day ago</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="px-4 py-2 border-t border-[#810041]/20">
                            <a href="#" class="text-xs text-[#f2ab8b] hover:underline">View all notifications</a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

                <!-- Mobile menu button -->
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="flex items-center space-x-1 text-gray-200 focus:outline-none">
                        <div class="w-9 h-9 rounded-full flex items-center justify-center border border-[#810041]/30 hover:border-[#f2ab8b]/70 transition">
                            <?php if($isLoggedIn): ?>
                            <!-- User Avatar -->
                            <span class="text-sm font-medium text-white">
                                <?php echo substr($_SESSION['user_name'] ?? 'U', 0, 1); ?>
                            </span>
                            <?php else: ?>
                            <!-- Menu Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                            <?php endif; ?>
                        </div>
                    </button>

                    <!-- Mobile menu dropdown -->
                    <div x-show="open" 
                        @click.away="open = false" 
                        x-transition:enter="transition ease-out duration-200" 
                        x-transition:enter-start="opacity-0 scale-95" 
                        x-transition:enter-end="opacity-100 scale-100" 
                        x-transition:leave="transition ease-in duration-150" 
                        x-transition:leave-start="opacity-100 scale-100" 
                        x-transition:leave-end="opacity-0 scale-95" 
                        class="absolute right-0 mt-2 w-56 glass rounded-lg shadow-lg overflow-hidden z-50"
                        style="display: none;">
                        
                        <?php if($isLoggedIn): ?>
                        <!-- User Info -->
                        <div class="px-4 py-3 border-b border-[#810041]/20">
                            <p class="text-sm font-medium text-white"><?php echo $_SESSION['user_name'] ?? 'User'; ?></p>
                            <p class="text-xs text-gray-400 mt-1"><?php echo $_SESSION['user_email'] ?? ''; ?></p>
                        </div>
                        <?php endif; ?>
                        
                        <div class="py-1">
                            <?php if($isLoggedIn && $userRole === 'client'): ?>
                            <a href="<?php echo getBasePath(); ?>client/dashboard.php" class="block px-4 py-2 text-sm <?php echo $currentPage === 'dashboard.php' ? 'text-[#f2ab8b]' : 'text-gray-200 hover:text-[#f2ab8b]'; ?> hover:bg-[#810041]/10 transition">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                    </svg>
                                    Dashboard
                                </div>
                            </a>
                            <a href="<?php echo getBasePath(); ?>client/invoices.php" class="block px-4 py-2 text-sm <?php echo $currentPage === 'invoices.php' ? 'text-[#f2ab8b]' : 'text-gray-200 hover:text-[#f2ab8b]'; ?> hover:bg-[#810041]/10 transition">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    Invoices
                                </div>
                            </a>
                            <a href="<?php echo getBasePath(); ?>client/payment-history.php" class="block px-4 py-2 text-sm <?php echo $currentPage === 'payment-history.php' ? 'text-[#f2ab8b]' : 'text-gray-200 hover:text-[#f2ab8b]'; ?> hover:bg-[#810041]/10 transition">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Payments
                                </div>
                            </a>
                            <a href="<?php echo getBasePath(); ?>client/profile.php" class="block px-4 py-2 text-sm <?php echo $currentPage === 'profile.php' ? 'text-[#f2ab8b]' : 'text-gray-200 hover:text-[#f2ab8b]'; ?> hover:bg-[#810041]/10 transition">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    Profile
                                </div>
                            </a>
                            <?php elseif($isLoggedIn && $userRole === 'admin'): ?>
                            <a href="<?php echo getBasePath(); ?>admin/dashboard.php" class="block px-4 py-2 text-sm <?php echo $currentPage === 'dashboard.php' ? 'text-[#f2ab8b]' : 'text-gray-200 hover:text-[#f2ab8b]'; ?> hover:bg-[#810041]/10 transition">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                    </svg>
                                    Dashboard
                                </div>
                            </a>
                            <a href="<?php echo getBasePath(); ?>admin/clients.php" class="block px-4 py-2 text-sm <?php echo $currentPage === 'clients.php' ? 'text-[#f2ab8b]' : 'text-gray-200 hover:text-[#f2ab8b]'; ?> hover:bg-[#810041]/10 transition">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    Clients
                                </div>
                            </a>
                            <a href="<?php echo getBasePath(); ?>admin/projects.php" class="block px-4 py-2 text-sm <?php echo $currentPage === 'projects.php' ? 'text-[#f2ab8b]' : 'text-gray-200 hover:text-[#f2ab8b]'; ?> hover:bg-[#810041]/10 transition">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                    </svg>
                                    Projects
                                </div>
                            </a>
                            <a href="<?php echo getBasePath(); ?>admin/payments.php" class="block px-4 py-2 text-sm <?php echo $currentPage === 'payments.php' ? 'text-[#f2ab8b]' : 'text-gray-200 hover:text-[#f2ab8b]'; ?> hover:bg-[#810041]/10 transition">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Payments
                                </div>
                            </a>
                            <a href="<?php echo getBasePath(); ?>admin/reports.php" class="block px-4 py-2 text-sm <?php echo $currentPage === 'reports.php' ? 'text-[#f2ab8b]' : 'text-gray-200 hover:text-[#f2ab8b]'; ?> hover:bg-[#810041]/10 transition">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                    </svg>
                                    Reports
                                </div>
                            </a>
                            <a href="<?php echo getBasePath(); ?>admin/settings.php" class="block px-4 py-2 text-sm <?php echo $currentPage === 'settings.php' ? 'text-[#f2ab8b]' : 'text-gray-200 hover:text-[#f2ab8b]'; ?> hover:bg-[#810041]/10 transition">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    Settings
                                </div>
                            </a>
                            <?php else: ?>
                            <a href="login.php" class="block px-4 py-2 text-sm text-gray-200 hover:text-[#f2ab8b] hover:bg-[#810041]/10 transition">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                    </svg>
                                    Login
                                </div>
                            </a>
                            <?php endif; ?>
                        </div>
                        
                        <?php if($isLoggedIn): ?>
                        <div class="border-t border-[#810041]/20 mt-1">
                            <a href="<?php echo getBasePath(); ?>logout.php" class="block px-4 py-2 text-sm text-gray-200 hover:text-[#f2ab8b] hover:bg-[#810041]/10 transition">
                                <div class="flex items-center text-red-400 hover:text-red-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    Logout
                                </div>
                            </a>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Content Container -->
    <main class="container mx-auto px-4 py-6">