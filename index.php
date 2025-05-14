<?php
/**
 * PayTrack - Client Payment Tracking System
 * 
 * Main Index File
 * Redirects to login page for unauthenticated users
 * Redirects to appropriate dashboard for authenticated users
 */

// Include configuration and functions
require_once 'config.php';
require_once 'includes/functions.php';
require_once 'includes/auth.php';

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

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

// User is not logged in, show login page with fancy animations
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PayTrack - Payment Tracking System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #26002b, #3a0042, #810041);
        }
        .gradient-text {
            background-image: linear-gradient(135deg, #810041, #f2ab8b);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        .gradient-button {
            background: linear-gradient(135deg, #810041, #f2ab8b);
        }
        .float-animation {
            animation: float 6s ease-in-out infinite;
        }
        .float-animation-delay {
            animation: float 6s ease-in-out 2s infinite;
        }
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }
        .glass-card {
            background: rgba(58, 0, 66, 0.5);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(129, 0, 65, 0.2);
        }
    </style>
</head>
<body class="gradient-bg min-h-screen text-white">
    <div class="relative w-full min-h-screen flex flex-col items-center justify-center px-4 py-12 overflow-hidden">
        <!-- Animated background elements -->
        <div class="absolute top-20 left-10 w-24 h-24 rounded-full bg-[#810041]/20 animate-pulse"></div>
        <div class="absolute bottom-20 right-10 w-32 h-32 rounded-full bg-[#f2ab8b]/20 animate-pulse delay-1000"></div>
        <div class="absolute top-1/4 right-1/4 w-40 h-40 rounded-full bg-[#26002b]/30 animate-pulse delay-700"></div>
        
        <!-- Logo and branding -->
        <div class="text-center mb-8 z-10">
            <div class="inline-block relative">
                <div class="absolute inset-0 blur-xl bg-[#f2ab8b]/30 rounded-full"></div>
                <h1 class="relative text-5xl font-bold gradient-text mb-2">PayTrack</h1>
            </div>
            <p class="text-gray-300 text-lg">Client Payment Tracking System</p>
        </div>
        
        <!-- Floating illustrations -->
        <div class="relative w-full max-w-md mb-10 z-10">
            <div class="flex justify-center">
                <div class="w-32 h-32 bg-[#810041]/30 rounded-2xl flex items-center justify-center float-animation shadow-lg">
                    <i class="fas fa-money-bill-wave text-4xl text-[#f2ab8b]"></i>
                </div>
                <div class="w-32 h-32 bg-[#3a0042]/30 -ml-5 mt-10 rounded-2xl flex items-center justify-center float-animation-delay shadow-lg">
                    <i class="fas fa-project-diagram text-4xl text-[#f2ab8b]"></i>
                </div>
                <div class="w-32 h-32 bg-[#26002b]/30 -ml-5 rounded-2xl flex items-center justify-center float-animation shadow-lg">
                    <i class="fas fa-file-invoice-dollar text-4xl text-[#f2ab8b]"></i>
                </div>
            </div>
        </div>
        
        <!-- Login card -->
        <div class="w-full max-w-md z-10">
            <div class="glass-card rounded-2xl shadow-xl p-8">
                <h2 class="text-2xl font-bold mb-6 text-center text-white">Sign In</h2>
                
                <?php if (isset($_GET['error']) && $_GET['error'] === 'invalid'): ?>
                    <div class="mb-6 bg-red-900/30 border border-red-600 text-red-400 px-4 py-3 rounded-lg">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-circle mr-3"></i>
                            <p>Invalid email or password. Please try again.</p>
                        </div>
                    </div>
                <?php endif; ?>
                
                <form action="login.php" method="POST">
                    <div class="mb-6">
                        <label for="email" class="block text-gray-300 text-sm font-medium mb-2">Email Address</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                <i class="fas fa-envelope"></i>
                            </span>
                            <input type="email" id="email" name="email" class="w-full pl-10 pr-3 py-3 bg-[#26002b]/50 border border-[#810041]/30 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#f2ab8b]/50 focus:border-transparent" placeholder="you@example.com" required>
                        </div>
                    </div>
                    
                    <div class="mb-8">
                        <div class="flex justify-between items-center mb-2">
                            <label for="password" class="block text-gray-300 text-sm font-medium">Password</label>
                            <a href="reset-password.php" class="text-sm text-[#f2ab8b] hover:text-white transition">Forgot password?</a>
                        </div>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                <i class="fas fa-lock"></i>
                            </span>
                            <input type="password" id="password" name="password" class="w-full pl-10 pr-3 py-3 bg-[#26002b]/50 border border-[#810041]/30 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#f2ab8b]/50 focus:border-transparent" placeholder="••••••••" required>
                            <button type="button" id="toggle-password" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-white">
                                <i class="fas fa-eye" id="eye-icon"></i>
                            </button>
                        </div>
                    </div>
                    
                    <button type="submit" class="w-full gradient-button text-white font-medium py-3 px-4 rounded-xl shadow-lg hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-[#f2ab8b]/50 transition-all transform hover:scale-[1.02] active:scale-[0.98]">
                        <div class="flex items-center justify-center">
                            <span>Sign In</span>
                            <i class="fas fa-arrow-right ml-2"></i>
                        </div>
                    </button>
                </form>
            </div>
            
            <div class="mt-8 text-center text-gray-400 text-sm">
                <p>Don't have an account? Contact your administrator</p>
                <p class="mt-4">© 2025 PayTrack. All rights reserved.</p>
            </div>
        </div>
    </div>

    <script>
        // Password visibility toggle
        document.getElementById('toggle-password').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        });
        
        // Subtle background animation
        const createFloatingBubble = () => {
            const bubble = document.createElement('div');
            const size = Math.random() * 100 + 50;
            const left = Math.random() * 100;
            
            bubble.style.width = `${size}px`;
            bubble.style.height = `${size}px`;
            bubble.style.left = `${left}%`;
            bubble.style.bottom = '-100px';
            bubble.style.opacity = '0.05';
            bubble.style.position = 'absolute';
            bubble.style.borderRadius = '50%';
            bubble.style.background = 'white';
            bubble.style.zIndex = '1';
            
            const duration = Math.random() * 10 + 15;
            bubble.style.animation = `float ${duration}s linear forwards`;
            
            document.querySelector('.relative').appendChild(bubble);
            
            setTimeout(() => {
                bubble.remove();
            }, duration * 1000);
        };
        
        // Create floating bubbles at intervals
        setInterval(createFloatingBubble, 3000);
        
        // Add some initial bubbles
        for (let i = 0; i < 5; i++) {
            setTimeout(createFloatingBubble, i * 1000);
        }
    </script>
</body>
</html>