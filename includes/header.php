<?php
// Make sure we have a session started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include functions if not already included
if (!function_exists('getBasePath')) {
    include_once 'functions.php';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PayTrack - Payment Tracking System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#7F3DFF', // Vibrant purple
                        secondary: '#FCAC12', // Vibrant yellow/orange
                        success: '#00A86B', // Vibrant green
                        warning: '#FD3C4A', // Vibrant red
                        darkbg: '#1E1E1E', // Dark background
                        darkcard: '#2B2B2B', // Dark card background
                        darkinput: '#333333', // Dark input background
                    }
                }
            }
        }
    </script>
    <style>
        body {
            background-color: #1E1E1E;
            color: #FFFFFF;
            font-family: 'SF Pro Display', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        }
        /* Custom progress bar */
        .progress-ring {
            transition: stroke-dashoffset 0.3s;
            transform: rotate(-90deg);
            transform-origin: 50% 50%;
        }
    </style>
</head>
<body class="bg-darkbg min-h-screen">

<?php if(isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])): ?>
    <!-- Top Navigation for Logged in users -->
    <header class="fixed top-0 left-0 right-0 z-50 bg-darkbg border-b border-gray-800">
        <div class="px-4 py-3 flex items-center justify-between">
            <div class="flex items-center">
                <?php if(isset($_SERVER['HTTP_REFERER'])): ?>
                <a href="<?php echo $_SERVER['HTTP_REFERER']; ?>" class="mr-3 text-gray-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <?php endif; ?>
                
                <h1 class="text-lg font-semibold text-white">
                    <?php 
                    // Get current page title
                    $currentPage = basename($_SERVER['PHP_SELF']);
                    switch($currentPage) {
                        case 'dashboard.php':
                            echo 'Dashboard';
                            break;
                        case 'projects.php':
                            echo 'Projects';
                            break;
                        case 'clients.php':
                            echo 'Clients';
                            break;
                        case 'payments.php':
                            echo 'Payments';
                            break;
                        case 'invoices.php':
                            echo 'Invoices';
                            break;
                        case 'profile.php':
                            echo 'My Profile';
                            break;
                        case 'project-details.php':
                            echo 'Project Details';
                            break;
                        case 'client-details.php':
                            echo 'Client Details';
                            break;
                        case 'invoice-details.php':
                            echo 'Invoice Details';
                            break;
                        default:
                            echo 'PayTrack';
                    }
                    ?>
                </h1>
            </div>
            
            <div class="flex items-center space-x-3">
                <!-- Notifications -->
                <div class="relative">
                    <button class="text-gray-300 hover:text-white transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        
                        <?php $notificationCount = isset($_SESSION['user_id']) ? getUnreadNotificationCount($_SESSION['user_id']) : 0; ?>
                        <?php if($notificationCount > 0): ?>
                        <span class="absolute -top-1 -right-1 bg-warning text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                            <?php echo $notificationCount; ?>
                        </span>
                        <?php endif; ?>
                    </button>
                </div>
                
                <!-- User profile -->
                <a href="<?php echo getBasePath(); ?>/<?php echo $_SESSION['user_role'] === 'admin' ? 'admin' : 'client'; ?>/profile.php" class="flex items-center">
                    <div class="w-8 h-8 rounded-full bg-primary flex items-center justify-center">
                        <span class="text-white font-semibold">
                            <?php echo isset($_SESSION['user_name']) ? substr($_SESSION['user_name'], 0, 1) : 'U'; ?>
                        </span>
                    </div>
                </a>
            </div>
        </div>
    </header>
    
    <!-- Spacing for fixed header -->
    <div class="pt-14"></div>
<?php endif; ?>

<!-- Main Content Container -->
<main class="container mx-auto px-4 py-6">