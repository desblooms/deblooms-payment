<!-- Modern Header Component -->
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
                        dark: {
                            100: '#2D2D2D',
                            200: '#212121',
                            300: '#171717',
                            400: '#121212',
                        },
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
            background: rgba(25, 25, 25, 0.6);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 4px;
            height: 4px;
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
        
        /* Background animation */
        .bg-gradient-animate {
            background: linear-gradient(45deg, #810041, #18001c, #18001c, #810041);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
        }

        @keyframes gradient {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }
    </style>
</head>
<body class="min-h-screen dark:bg-dark-400 bg-gradient-animate">
    <?php 
    // Determine if user is logged in and their role
    $isLoggedIn = isset($_SESSION['user_id']);
    $userRole = $isLoggedIn ? $_SESSION['user_role'] : '';
    $currentPage = basename($_SERVER['PHP_SELF']);
    ?>

    <!-- Navigation Header -->
    <header class="glass sticky top-0 z-50">
        <nav class="px-4 py-3 flex justify-between items-center border-b border-gray-800">
            <div class="flex items-center">
                <a href="<?php echo $userRole === 'admin' ? 'admin/dashboard.php' : ($isLoggedIn ? 'client/dashboard.php' : 'login.php'); ?>" class="flex items-center">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-r from-[#810041] to-[#f2ab8b] flex items-center justify-center shadow-lg">
                        <span class="text-white font-bold text-lg">P</span>
                    </div>
                    <span class="ml-2 text-xl font-bold bg-gradient-to-r from-[#810041] to-[#f2ab8b] text-transparent bg-clip-text">PayTrack</span>
                </a>
            </div>

            <!-- Notification Icon (Shows only for logged in users) -->
            <?php if($isLoggedIn): ?>
            <div class="flex items-center gap-3">
                <div class="relative">
                    <button class="flex items-center justify-center w-9 h-9 rounded-full bg-gray-800/50 text-gray-300 hover:text-white transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-4 w-4 flex items-center justify-center">2</span>
                    </button>
                </div>
            <?php endif; ?>

                <!-- Mobile menu button -->
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="flex items-center justify-center focus:outline-none">
                        <div class="w-9 h-9 rounded-full flex items-center justify-center bg-gray-800/50 text-gray-300 hover:text-white transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </div>
                    </button>

                    <!-- Mobile menu dropdown -->
                    <div x-show="open" 
                        @click.away="open = false" 
                        x-transition:enter="transition ease-out duration-200" 
                        x-transition:enter-start="opacity-0 transform scale-95" 
                        x-transition:enter-end="opacity-100 transform scale-100" 
                        x-transition:leave="transition ease-in duration-150" 
                        x-transition:leave-start="opacity-100 transform scale-100" 
                        x-transition:leave-end="opacity-0 transform scale-95" 
                        class="absolute right-0 mt-3 w-56 glass rounded-xl shadow-xl py-2 z-50"
                        style="display: none;">
                        
                        <?php if($isLoggedIn): ?>
                        <!-- User profile preview -->
                        <div class="px-4 py-3 border-b border-gray-700/50">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-r from-[#810041] to-[#f2ab8b] flex items-center justify-center">
                                    <span class="text-white font-bold">
                                        <?php echo substr($_SESSION['user_name'] ?? 'U', 0, 1); ?>
                                    </span>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-white"><?php echo $_SESSION['user_name'] ?? 'User'; ?></p>
                                    <p class="text-xs text-gray-400"><?php echo ucfirst($userRole); ?></p>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <?php if($isLoggedIn && $userRole === 'client'): ?>
                        <a href="client/dashboard.php" class="flex items-center px-4 py-2 text-sm <?php echo $currentPage === 'dashboard.php' ? 'text-[#f2ab8b]' : 'text-gray-200 hover:text-[#f2ab8b]'; ?> transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            Dashboard
                        </a>
                        <a href="client/invoices.php" class="flex items-center px-4 py-2 text-sm <?php echo $currentPage === 'invoices.php' ? 'text-[#f2ab8b]' : 'text-gray-200 hover:text-[#f2ab8b]'; ?> transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Invoices
                        </a>
                        <a href="client/payment-history.php" class="flex items-center px-4 py-2 text-sm <?php echo $currentPage === 'payment-history.php' ? 'text-[#f2ab8b]' : 'text-gray-200 hover:text-[#f2ab8b]'; ?> transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Payments
                        </a>
                        <a href="client/profile.php" class="flex items-center px-4 py-2 text-sm <?php echo $currentPage === 'profile.php' ? 'text-[#f2ab8b]' : 'text-gray-200 hover:text-[#f2ab8b]'; ?> transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Profile
                        </a>
                        <?php elseif($isLoggedIn && $userRole === 'admin'): ?>
                        <a href="admin/dashboard.php" class="flex items-center px-4 py-2 text-sm <?php echo $currentPage === 'dashboard.php' ? 'text-[#f2ab8b]' : 'text-gray-200 hover:text-[#f2ab8b]'; ?> transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            Dashboard
                        </a>
                        <a href="admin/clients.php" class="flex items-center px-4 py-2 text-sm <?php echo $currentPage === 'clients.php' ? 'text-[#f2ab8b]' : 'text-gray-200 hover:text-[#f2ab8b]'; ?> transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            Clients
                        </a>
                        <a href="admin/projects.php" class="flex items-center px-4 py-2 text-sm <?php echo $currentPage === 'projects.php' ? 'text-[#f2ab8b]' : 'text-gray-200 hover:text-[#f2ab8b]'; ?> transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                            </svg>
                            Projects
                        </a>
                        <a href="admin/payments.php" class="flex items-center px-4 py-2 text-sm <?php echo $currentPage === 'payments.php' ? 'text-[#f2ab8b]' : 'text-gray-200 hover:text-[#f2ab8b]'; ?> transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Payments
                        </a>
                        <a href="admin/reports.php" class="flex items-center px-4 py-2 text-sm <?php echo $currentPage === 'reports.php' ? 'text-[#f2ab8b]' : 'text-gray-200 hover:text-[#f2ab8b]'; ?> transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                            Reports
                        </a>
                        <a href="admin/settings.php" class="flex items-center px-4 py-2 text-sm <?php echo $currentPage === 'settings.php' ? 'text-[#f2ab8b]' : 'text-gray-200 hover:text-[#f2ab8b]'; ?> transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Settings
                        </a>
                        <?php else: ?>
                        <a href="login.php" class="flex items-center px-4 py-2 text-sm text-gray-200 hover:text-[#f2ab8b] transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                            </svg>
                            Login
                        </a>
                        <?php endif; ?>
                        
                        <?php if($isLoggedIn): ?>
                        <div class="border-t border-gray-700/50 my-2"></div>
                        <a href="logout.php" class="flex items-center px-4 py-2 text-sm text-gray-200 hover:text-red-400 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            Logout
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Content Container -->
    <main class="container mx-auto px-4 py-6">