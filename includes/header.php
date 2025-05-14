<?php
/**
 * Header Template
 * 
 * Main header template for the PayTrack application
 * Includes navigation and user information
 */

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: /login.php');
    exit;
}

// Get user data
$userRole = $_SESSION['user_role'] ?? '';
$userName = $_SESSION['user_name'] ?? 'User';
$userInitial = strtoupper(substr($userName, 0, 1));

// Determine which navigation to show based on user role
$isAdmin = ($userRole === 'admin');
$isClient = ($userRole === 'client');

// Count unread notifications
$notificationCount = getUnreadNotificationCount($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PayTrack - Track Your Projects & Payments</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'gray-custom': '#868F83',
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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #EAEFEA;
        }
        
        .active-nav {
            background-color: #E7FE66;
            color: #1C1F0A;
        }
        
        .dropdown {
            display: none;
        }
        
        .dropdown.show {
            display: block;
        }
        
        /* Hide scrollbar for Chrome, Safari and Opera */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        /* Hide scrollbar for IE, Edge and Firefox */
        .no-scrollbar {
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;  /* Firefox */
        }
    </style>
</head>
<body class="bg-mint-cream min-h-screen">
    <header class="bg-black-olive text-white shadow-md">
        <div class="container mx-auto px-4 py-3">
            <div class="flex justify-between items-center">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="<?php echo $isAdmin ? '/admin/index.php' : '/client/index.php'; ?>" class="flex items-center">
                        <span class="text-mindaro font-bold text-2xl">Pay</span>
                        <span class="text-white font-bold text-2xl">Track</span>
                    </a>
                </div>
                
                <!-- Right Menu (Profile & Notifications) -->
                <div class="flex items-center space-x-4">
                    <!-- Notifications -->
                    <div class="relative">
                        <button id="notificationDropdownButton" class="relative p-2 rounded-full hover:bg-ebony focus:outline-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            <?php if ($notificationCount > 0): ?>
                                <span class="absolute top-0 right-0 bg-yellow-green text-eerie-black text-xs rounded-full h-5 w-5 flex items-center justify-center">
                                    <?php echo $notificationCount; ?>
                                </span>
                            <?php endif; ?>
                        </button>
                        
                        <!-- Notification Dropdown -->
                        <div id="notificationDropdown" class="dropdown absolute right-0 mt-2 w-80 bg-white rounded-md shadow-lg overflow-hidden z-50 text-black-olive">
                            <div class="p-3 bg-black-olive text-white font-medium flex justify-between">
                                <span>Notifications</span>
                                <?php if ($notificationCount > 0): ?>
                                    <a href="#" class="text-sm text-mindaro hover:text-mindaro-2">Mark all as read</a>
                                <?php endif; ?>
                            </div>
                            <div class="max-h-64 overflow-y-auto no-scrollbar">
                                <?php 
                                $notifications = getNotifications($_SESSION['user_id'], 5);
                                if (!empty($notifications)): 
                                    foreach ($notifications as $notification):
                                        $bgClass = $notification['read'] ? 'bg-white' : 'bg-mint-cream';
                                ?>
                                <div class="<?php echo $bgClass; ?> hover:bg-gray-50 border-b border-gray-100">
                                    <a href="#" class="block p-3">
                                        <div class="flex items-start">
                                            <div class="flex-shrink-0 mr-3">
                                                <?php 
                                                switch ($notification['level']):
                                                    case 'success':
                                                        echo '<div class="w-8 h-8 rounded-full bg-green-100 text-green-500 flex items-center justify-center"><i class="fas fa-check"></i></div>';
                                                        break;
                                                    case 'warning':
                                                        echo '<div class="w-8 h-8 rounded-full bg-yellow-100 text-yellow-500 flex items-center justify-center"><i class="fas fa-exclamation-triangle"></i></div>';
                                                        break;
                                                    case 'error':
                                                        echo '<div class="w-8 h-8 rounded-full bg-red-100 text-red-500 flex items-center justify-center"><i class="fas fa-times"></i></div>';
                                                        break;
                                                    default:
                                                        echo '<div class="w-8 h-8 rounded-full bg-blue-100 text-blue-500 flex items-center justify-center"><i class="fas fa-info"></i></div>';
                                                endswitch;
                                                ?>
                                            </div>
                                            <div class="flex-1">
                                                <p class="font-medium text-sm"><?php echo $notification['title']; ?></p>
                                                <p class="text-xs text-gray-500 mt-1"><?php echo $notification['message']; ?></p>
                                                <p class="text-xs text-gray-400 mt-1"><?php echo $notification['time']; ?></p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <?php 
                                    endforeach; 
                                else: 
                                ?>
                                <div class="p-4 text-center text-gray-500">
                                    No notifications
                                </div>
                                <?php endif; ?>
                            </div>
                            <div class="p-2 bg-white border-t border-gray-100">
                                <a href="#" class="block text-center text-sm text-black-olive hover:text-ebony p-2">
                                    View all notifications
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Profile -->
                    <div class="relative">
                        <button id="profileDropdownButton" class="flex items-center focus:outline-none">
                            <div class="w-8 h-8 rounded-full bg-yellow-green text-eerie-black flex items-center justify-center font-bold">
                                <?php echo $userInitial; ?>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        
                        <!-- Profile Dropdown -->
                        <div id="profileDropdown" class="dropdown absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg overflow-hidden z-50 text-black-olive">
                            <div class="p-3 bg-black-olive text-white font-medium">
                                <p><?php echo $userName; ?></p>
                                <p class="text-xs text-gray-400 mt-1"><?php echo ucfirst($userRole); ?></p>
                            </div>
                            <div>
                                <a href="<?php echo $isAdmin ? '/admin/settings.php' : '/client/profile.php'; ?>" class="block p-3 text-sm hover:bg-gray-100">
                                    <div class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        Settings
                                    </div>
                                </a>
                                <a href="/logout.php" class="block p-3 text-sm hover:bg-gray-100 border-t border-gray-100">
                                    <div class="flex items-center text-red-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                        Logout
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    
    <!-- Navigation -->
    <nav class="bg-ebony text-white shadow-md">
        <div class="container mx-auto">
            <div class="overflow-x-auto no-scrollbar">
                <div class="flex space-x-1 py-1 px-2 min-w-max">
                    <?php if ($isAdmin): ?>
                        <a href="/admin/index.php" class="px-4 py-2 rounded-md text-sm font-medium whitespace-nowrap transition-colors <?php echo isCurrentPage('index.php') ? 'active-nav' : ''; ?>">
                            <i class="fas fa-tachometer-alt mr-1"></i> Dashboard
                        </a>
                        <a href="/admin/clients.php" class="px-4 py-2 rounded-md text-sm font-medium whitespace-nowrap transition-colors <?php echo isCurrentPage('clients.php') || isCurrentPage('all-clients.php') ? 'active-nav' : ''; ?>">
                            <i class="fas fa-users mr-1"></i> Clients
                        </a>
                        <a href="/admin/projects.php" class="px-4 py-2 rounded-md text-sm font-medium whitespace-nowrap transition-colors <?php echo isCurrentPage('projects.php') || isCurrentPage('all-projects.php') ? 'active-nav' : ''; ?>">
                            <i class="fas fa-project-diagram mr-1"></i> Projects
                        </a>
                        <a href="/admin/payments.php" class="px-4 py-2 rounded-md text-sm font-medium whitespace-nowrap transition-colors <?php echo isCurrentPage('payments.php') || isCurrentPage('all-payments.php') ? 'active-nav' : ''; ?>">
                            <i class="fas fa-money-bill-wave mr-1"></i> Payments
                        </a>
                        <a href="/admin/reports.php" class="px-4 py-2 rounded-md text-sm font-medium whitespace-nowrap transition-colors <?php echo isCurrentPage('reports.php') ? 'active-nav' : ''; ?>">
                            <i class="fas fa-chart-bar mr-1"></i> Reports
                        </a>
                        <a href="/admin/settings.php" class="px-4 py-2 rounded-md text-sm font-medium whitespace-nowrap transition-colors <?php echo isCurrentPage('settings.php') ? 'active-nav' : ''; ?>">
                            <i class="fas fa-cog mr-1"></i> Settings
                        </a>
                    <?php elseif ($isClient): ?>
                        <a href="/client/index.php" class="px-4 py-2 rounded-md text-sm font-medium whitespace-nowrap transition-colors <?php echo isCurrentPage('index.php') ? 'active-nav' : ''; ?>">
                            <i class="fas fa-tachometer-alt mr-1"></i> Dashboard
                        </a>
                        <a href="/client/project-details.php" class="px-4 py-2 rounded-md text-sm font-medium whitespace-nowrap transition-colors <?php echo isCurrentPage('project-details.php') ? 'active-nav' : ''; ?>">
                            <i class="fas fa-project-diagram mr-1"></i> Projects
                        </a>
                        <a href="/client/invoices.php" class="px-4 py-2 rounded-md text-sm font-medium whitespace-nowrap transition-colors <?php echo isCurrentPage('invoices.php') ? 'active-nav' : ''; ?>">
                            <i class="fas fa-file-invoice-dollar mr-1"></i> Invoices
                        </a>
                        <a href="/client/payment-history.php" class="px-4 py-2 rounded-md text-sm font-medium whitespace-nowrap transition-colors <?php echo isCurrentPage('payment-history.php') ? 'active-nav' : ''; ?>">
                            <i class="fas fa-money-bill-wave mr-1"></i> Payments
                        </a>
                        <a href="/client/profile.php" class="px-4 py-2 rounded-md text-sm font-medium whitespace-nowrap transition-colors <?php echo isCurrentPage('profile.php') ? 'active-nav' : ''; ?>">
                            <i class="fas fa-user mr-1"></i> Profile
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>
    
    <!-- Main Content -->
    <main class="container mx-auto px-4 py-6">
        <!-- Page content will go here -->