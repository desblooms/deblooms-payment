<?php
/**
 * Header Template
 * 
 * Primary header template for the PayTrack application
 */

// Make sure we have a session started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include utility functions if not already included
if (!function_exists('getBasePath')) {
    require_once __DIR__ . '/functions.php';
}

// Get current page for navigation highlighting
$currentPage = basename($_SERVER['PHP_SELF']);

// Check if user is logged in
$isLoggedIn = isset($_SESSION['user_id']);
$userRole = $isLoggedIn ? $_SESSION['user_role'] : '';
$userName = $isLoggedIn ? $_SESSION['user_name'] : '';

// Get unread notification count if user is logged in
$notificationCount = $isLoggedIn ? getUnreadNotificationCount($_SESSION['user_id']) : 0;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PayTrack - Client Payment Tracking</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #810041;
            --primary-light: #f2ab8b;
            --dark-bg: #26002b;
            --dark-surface: #3a0042;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #26002b 0%, #120014 100%);
            background-attachment: fixed;
            color: #fff;
            min-height: 100vh;
        }
        
        .glass-card {
            background: rgba(58, 0, 66, 0.5);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(129, 0, 65, 0.2);
            border-radius: 16px;
        }
        
        .gradient-text {
            background: linear-gradient(to right, #810041, #f2ab8b);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        
        .gradient-bg {
            background: linear-gradient(to right, #810041, #f2ab8b);
        }
        
        /* Mobile navigation tweaks */
        .mobile-nav-item {
            @apply flex items-center justify-center flex-col p-2 rounded-lg text-xs;
        }
        
        .mobile-nav-item.active {
            @apply bg-[#810041]/20 text-[#f2ab8b];
        }
        
        .mobile-nav-item:not(.active) {
            @apply text-gray-400 hover:text-[#f2ab8b];
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        
        ::-webkit-scrollbar-track {
            background: rgba(58, 0, 66, 0.3);
        }
        
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(to bottom, #810041, #f2ab8b);
            border-radius: 3px;
        }
    </style>
</head>
<body class="flex flex-col min-h-screen bg-gradient-to-br from-[#26002b] to-[#120014]">
    <!-- Top Navigation Bar -->
    <header class="w-full py-3 px-4 bg-[#26002b]/90 backdrop-blur-md border-b border-[#810041]/20 sticky top-0 z-30">
        <div class="container mx-auto">
            <div class="flex items-center justify-between">
                <!-- Left - Logo -->
                <div class="flex items-center">
                    <a href="<?php echo getBasePath(); ?>/<?php echo $userRole === 'admin' ? 'admin/' : ($userRole === 'client' ? 'client/' : ''); ?>" class="flex items-center">
                        <div class="h-10 w-10 flex items-center justify-center rounded-xl bg-gradient-to-r from-[#810041] to-[#f2ab8b] mr-2">
                            <span class="text-white font-bold text-xl">P</span>
                        </div>
                        <div>
                            <h1 class="text-xl font-bold gradient-text">PayTrack</h1>
                            <p class="text-xs text-gray-400">Payment Tracking System</p>
                        </div>
                    </a>
                </div>
                
                <!-- Right - User Menu & Notifications -->
                <div class="flex items-center space-x-3">
                    <?php if ($isLoggedIn): ?>
                        <!-- Notifications -->
                        <div class="relative">
                            <button class="p-2 rounded-full text-gray-400 hover:text-[#f2ab8b] relative" id="notificationButton">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                </svg>
                                <?php if ($notificationCount > 0): ?>
                                <span class="absolute -top-1 -right-1 h-5 w-5 rounded-full bg-red-500 flex items-center justify-center text-white text-xs">
                                    <?php echo $notificationCount; ?>
                                </span>
                                <?php endif; ?>
                            </button>
                            
                            <!-- Notification Dropdown (hidden by default) -->
                            <div id="notificationDropdown" class="hidden absolute right-0 mt-2 w-80 glass-card shadow-lg z-40 origin-top-right">
                                <div class="p-3 border-b border-[#810041]/20">
                                    <h3 class="font-medium">Notifications</h3>
                                </div>
                                <div class="max-h-80 overflow-y-auto">
                                    <?php 
                                    $notifications = getNotifications($_SESSION['user_id'], 5);
                                    if (empty($notifications)): 
                                    ?>
                                    <div class="p-4 text-center text-gray-400">
                                        <p>No notifications</p>
                                    </div>
                                    <?php else: ?>
                                    <?php foreach ($notifications as $notification): ?>
                                    <div class="p-3 border-b border-[#810041]/20 hover:bg-[#810041]/10 <?php echo $notification['read'] ? 'opacity-70' : ''; ?>">
                                        <div class="flex">
                                            <?php
                                            $iconClass = 'text-blue-400';
                                            $bgClass = 'bg-blue-900/30';
                                            
                                            if ($notification['level'] === 'success') {
                                                $iconClass = 'text-green-400';
                                                $bgClass = 'bg-green-900/30';
                                            } elseif ($notification['level'] === 'warning') {
                                                $iconClass = 'text-yellow-400';
                                                $bgClass = 'bg-yellow-900/30';
                                            } elseif ($notification['level'] === 'error') {
                                                $iconClass = 'text-red-400';
                                                $bgClass = 'bg-red-900/30';
                                            }
                                            ?>
                                            <div class="flex-shrink-0 mr-3">
                                                <div class="h-8 w-8 rounded-full <?php echo $bgClass; ?> flex items-center justify-center <?php echo $iconClass; ?>">
                                                    <i class="fas fa-<?php echo $notification['level'] === 'success' ? 'check' : ($notification['level'] === 'warning' ? 'exclamation' : ($notification['level'] === 'error' ? 'times' : 'bell')); ?>"></i>
                                                </div>
                                            </div>
                                            <div class="flex-1 overflow-hidden">
                                                <p class="font-medium text-sm"><?php echo $notification['title']; ?></p>
                                                <p class="text-gray-400 text-xs mt-1 truncate"><?php echo $notification['message']; ?></p>
                                                <p class="text-gray-500 text-xs mt-1"><?php echo $notification['time']; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                                <div class="p-2 border-t border-[#810041]/20 text-center">
                                    <a href="#" class="text-sm text-[#f2ab8b] hover:underline">View All</a>
                                </div>
                            </div>
                        </div>
                        
                        <!-- User Menu -->
                        <div class="relative">
                            <button class="flex items-center space-x-2 text-gray-300 hover:text-white" id="userMenuButton">
                                <div class="h-8 w-8 rounded-full bg-gradient-to-r from-[#810041] to-[#f2ab8b] flex items-center justify-center">
                                    <span class="text-white font-medium"><?php echo substr($userName, 0, 1); ?></span>
                                </div>
                                <span class="hidden md:block text-sm"><?php echo $userName; ?></span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                            
                            <!-- User Menu Dropdown (hidden by default) -->
                            <div id="userMenuDropdown" class="hidden absolute right-0 mt-2 w-48 glass-card shadow-lg z-40 origin-top-right">
                                <div class="p-2 border-b border-[#810041]/20">
                                    <p class="text-sm font-medium"><?php echo $userName; ?></p>
                                    <p class="text-xs text-gray-400"><?php echo ucfirst($userRole); ?></p>
                                </div>
                                <div class="py-1">
                                    <a href="<?php echo getBasePath(); ?>/<?php echo $userRole === 'admin' ? 'admin/' : 'client/'; ?>profile.php" class="block px-4 py-2 text-sm text-gray-300 hover:bg-[#810041]/20 hover:text-[#f2ab8b]">
                                        <div class="flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                            Profile
                                        </div>
                                    </a>
                                    <a href="<?php echo getBasePath(); ?>/<?php echo $userRole === 'admin' ? 'admin/' : 'client/'; ?>settings.php" class="block px-4 py-2 text-sm text-gray-300 hover:bg-[#810041]/20 hover:text-[#f2ab8b]">
                                        <div class="flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            Settings
                                        </div>
                                    </a>
                                </div>
                                <div class="py-1 border-t border-[#810041]/20">
                                    <a href="<?php echo getBasePath(); ?>/logout.php" class="block px-4 py-2 text-sm text-red-400 hover:bg-red-900/20">
                                        <div class="flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                            </svg>
                                            Logout
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <!-- Login Button for guests -->
                        <a href="<?php echo getBasePath(); ?>/login.php" class="px-4 py-2 rounded-lg bg-gradient-to-r from-[#810041] to-[#f2ab8b] text-white text-sm font-medium hover:opacity-90 transition duration-300">
                            Login
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </header>
    
    <!-- Main Content Wrapper -->
    <main class="flex-grow p-4 container mx-auto">
        <?php if ($isLoggedIn): ?>
            <?php if ($userRole === 'admin'): ?>
                <!-- Admin Breadcrumb / Page Title would go here if needed -->
            <?php elseif ($userRole === 'client'): ?>
                <!-- Client Breadcrumb / Page Title would go here if needed -->
            <?php endif; ?>
        <?php endif; ?>
        
        <!-- Page content will be inserted here -->

<script>
// Handle mobile navigation toggles
document.addEventListener('DOMContentLoaded', function() {
    // User menu toggle
    const userMenuButton = document.getElementById('userMenuButton');
    const userMenuDropdown = document.getElementById('userMenuDropdown');
    
    if (userMenuButton && userMenuDropdown) {
        userMenuButton.addEventListener('click', function() {
            userMenuDropdown.classList.toggle('hidden');
            // Hide notification dropdown when user menu is shown
            if (notificationDropdown) {
                notificationDropdown.classList.add('hidden');
            }
        });
    }
    
    // Notification toggle
    const notificationButton = document.getElementById('notificationButton');
    const notificationDropdown = document.getElementById('notificationDropdown');
    
    if (notificationButton && notificationDropdown) {
        notificationButton.addEventListener('click', function() {
            notificationDropdown.classList.toggle('hidden');
            // Hide user menu dropdown when notification dropdown is shown
            if (userMenuDropdown) {
                userMenuDropdown.classList.add('hidden');
            }
        });
    }
    
    // Close dropdowns when clicking outside
    document.addEventListener('click', function(event) {
        if (userMenuButton && userMenuDropdown && !userMenuButton.contains(event.target) && !userMenuDropdown.contains(event.target)) {
            userMenuDropdown.classList.add('hidden');
        }
        
        if (notificationButton && notificationDropdown && !notificationButton.contains(event.target) && !notificationDropdown.contains(event.target)) {
            notificationDropdown.classList.add('hidden');
        }
    });
});
</script>