<!-- includes/header.php -->
<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PayTrack - Client Payment Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
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
    </style>
</head>
<body class="min-h-screen dark:bg-gray-900">
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
                <a href="<?php echo $userRole === 'admin' ? 'admin/dashboard.php' : 'client/dashboard.php'; ?>" class="flex items-center">
                    <div class="w-8 h-8 rounded-full primary-bg flex items-center justify-center">
                        <span class="text-white font-bold">P</span>
                    </div>
                    <span class="ml-2 text-xl font-semibold bg-gradient-to-r from-[#810041] to-[#f2ab8b] text-transparent bg-clip-text">PayTrack</span>
                </a>
            </div>

            <!-- Mobile menu button -->
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open" class="flex items-center space-x-1 text-gray-200 focus:outline-none">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center border border-gray-700 hover:border-[#f2ab8b] transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
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
                     class="absolute right-0 mt-2 w-48 glass rounded-lg shadow-lg py-1 z-50"
                     style="display: none;">
                    
                    <?php if($isLoggedIn && $userRole === 'client'): ?>
                    <a href="client/dashboard.php" class="block px-4 py-2 text-sm <?php echo $currentPage === 'dashboard.php' ? 'text-[#f2ab8b]' : 'text-gray-200 hover:text-[#f2ab8b]'; ?> transition">Dashboard</a>
                    <a href="client/invoices.php" class="block px-4 py-2 text-sm <?php echo $currentPage === 'invoices.php' ? 'text-[#f2ab8b]' : 'text-gray-200 hover:text-[#f2ab8b]'; ?> transition">Invoices</a>
                    <a href="client/payment-history.php" class="block px-4 py-2 text-sm <?php echo $currentPage === 'payment-history.php' ? 'text-[#f2ab8b]' : 'text-gray-200 hover:text-[#f2ab8b]'; ?> transition">Payments</a>
                    <a href="client/profile.php" class="block px-4 py-2 text-sm <?php echo $currentPage === 'profile.php' ? 'text-[#f2ab8b]' : 'text-gray-200 hover:text-[#f2ab8b]'; ?> transition">Profile</a>
                    <?php elseif($isLoggedIn && $userRole === 'admin'): ?>
                    <a href="admin/dashboard.php" class="block px-4 py-2 text-sm <?php echo $currentPage === 'dashboard.php' ? 'text-[#f2ab8b]' : 'text-gray-200 hover:text-[#f2ab8b]'; ?> transition">Dashboard</a>
                    <a href="admin/clients.php" class="block px-4 py-2 text-sm <?php echo $currentPage === 'clients.php' ? 'text-[#f2ab8b]' : 'text-gray-200 hover:text-[#f2ab8b]'; ?> transition">Clients</a>
                    <a href="admin/projects.php" class="block px-4 py-2 text-sm <?php echo $currentPage === 'projects.php' ? 'text-[#f2ab8b]' : 'text-gray-200 hover:text-[#f2ab8b]'; ?> transition">Projects</a>
                    <a href="admin/payments.php" class="block px-4 py-2 text-sm <?php echo $currentPage === 'payments.php' ? 'text-[#f2ab8b]' : 'text-gray-200 hover:text-[#f2ab8b]'; ?> transition">Payments</a>
                    <a href="admin/reports.php" class="block px-4 py-2 text-sm <?php echo $currentPage === 'reports.php' ? 'text-[#f2ab8b]' : 'text-gray-200 hover:text-[#f2ab8b]'; ?> transition">Reports</a>
                    <a href="admin/settings.php" class="block px-4 py-2 text-sm <?php echo $currentPage === 'settings.php' ? 'text-[#f2ab8b]' : 'text-gray-200 hover:text-[#f2ab8b]'; ?> transition">Settings</a>
                    <?php else: ?>
                    <a href="login.php" class="block px-4 py-2 text-sm text-gray-200 hover:text-[#f2ab8b] transition">Login</a>
                    <?php endif; ?>
                    
                    <?php if($isLoggedIn): ?>
                    <div class="border-t border-gray-700 my-1"></div>
                    <a href="logout.php" class="block px-4 py-2 text-sm text-gray-200 hover:text-[#f2ab8b] transition">Logout</a>
                    <?php endif; ?>
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Content Container -->
    <main class="container mx-auto px-4 py-6">