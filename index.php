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

// Include header
include_once 'includes/header.php';
?>

<!-- Hero Section with Animated Elements -->
<section class="relative min-h-[90vh] flex flex-col justify-center items-center px-4 overflow-hidden">
    <!-- Animated background elements -->
    <div class="absolute top-20 left-10 w-24 h-24 rounded-full bg-[#810041]/20 animate-pulse"></div>
    <div class="absolute bottom-20 right-10 w-32 h-32 rounded-full bg-[#f2ab8b]/20 animate-pulse delay-1000"></div>
    <div class="absolute top-1/4 right-1/4 w-40 h-40 rounded-full bg-[#26002b]/30 animate-pulse delay-700"></div>
    
    <div class="relative z-10 max-w-md w-full mx-auto text-center">
        <!-- Logo with glow effect -->
        <div class="mb-6">
            <div class="inline-block relative">
                <div class="absolute inset-0 blur-xl bg-[#f2ab8b]/30 rounded-full"></div>
                <h1 class="relative text-5xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-[#810041] to-[#f2ab8b] mb-2">PayTrack</h1>
            </div>
            <h2 class="text-xl text-white">Simplify Your Payment Management</h2>
        </div>
        
        <!-- Floating illustrations -->
        <div class="flex justify-center mb-8">
            <div class="w-24 h-24 bg-[#810041]/30 rounded-2xl flex items-center justify-center float-animation shadow-lg">
                <i class="fas fa-money-bill-wave text-3xl text-[#f2ab8b]"></i>
            </div>
            <div class="w-24 h-24 bg-[#3a0042]/30 -ml-4 mt-8 rounded-2xl flex items-center justify-center float-animation-delay shadow-lg">
                <i class="fas fa-project-diagram text-3xl text-[#f2ab8b]"></i>
            </div>
            <div class="w-24 h-24 bg-[#26002b]/30 -ml-4 rounded-2xl flex items-center justify-center float-animation shadow-lg">
                <i class="fas fa-file-invoice-dollar text-3xl text-[#f2ab8b]"></i>
            </div>
        </div>
        
        <div class="bg-[#26002b]/50 backdrop-blur-md rounded-xl p-6 border border-[#810041]/20 mb-8 shadow-lg">
            <p class="text-gray-300 mb-4">Track payments, manage projects, and stay on top of your finances with our intuitive platform.</p>
            <p class="text-gray-400 text-sm">Designed for freelancers, agencies, and businesses of all sizes.</p>
        </div>
        
        <!-- CTA Button -->
        <a href="login.php" class="inline-block w-full sm:w-auto bg-gradient-to-r from-[#810041] to-[#f2ab8b] text-white font-medium py-3 px-8 rounded-xl shadow-lg hover:opacity-90 transition-all transform hover:scale-[1.02] active:scale-[0.98]">
            <div class="flex items-center justify-center">
                <span>Login to Your Account</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </div>
        </a>
    </div>
</section>

<!-- App Preview with Glowing Border -->
<section class="py-12 px-4">
    <div class="max-w-lg mx-auto relative">
        <div class="absolute -inset-1 bg-gradient-to-r from-[#810041] to-[#f2ab8b] rounded-xl blur-md opacity-75"></div>
        <div class="relative bg-[#26002b]/50 backdrop-blur-md rounded-xl overflow-hidden border border-[#810041]/20 shadow-xl">
            <div class="flex justify-center p-1">
                <!-- Phone mockup for the app preview -->
                <div class="relative border-8 border-[#26002b] rounded-3xl overflow-hidden shadow-lg w-full max-w-xs">
                    <!-- Notch -->
                    <div class="absolute top-0 left-1/2 transform -translate-x-1/2 w-1/3 h-5 bg-[#26002b] rounded-b-xl z-10"></div>
                    
                    <!-- App Screenshot -->
                    <img src="assets/images/app-preview.png" alt="PayTrack App Preview" class="w-full h-auto" onerror="this.src='https://via.placeholder.com/375x812/18001c/f2ab8b?text=PayTrack+App+Interface'">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section with Glass Cards -->
<section id="features" class="py-12 px-4">
    <div class="max-w-md mx-auto">
        <h2 class="text-2xl font-bold mb-8 text-center text-transparent bg-clip-text bg-gradient-to-r from-[#810041] to-[#f2ab8b]">Key Features</h2>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <!-- Feature 1 -->
            <div class="bg-[#26002b]/50 backdrop-blur-md rounded-xl p-5 border border-[#810041]/20 hover:border-[#f2ab8b]/40 transition duration-300 shadow-lg">
                <div class="bg-gradient-to-r from-[#810041] to-[#f2ab8b] w-12 h-12 rounded-lg flex items-center justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold mb-2 text-white">Project Management</h3>
                <p class="text-gray-400 text-sm">Track all your projects with status updates and deadline reminders.</p>
            </div>
            
            <!-- Feature 2 -->
            <div class="bg-[#26002b]/50 backdrop-blur-md rounded-xl p-5 border border-[#810041]/20 hover:border-[#f2ab8b]/40 transition duration-300 shadow-lg">
                <div class="bg-gradient-to-r from-[#810041] to-[#f2ab8b] w-12 h-12 rounded-lg flex items-center justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold mb-2 text-white">Invoice Management</h3>
                <p class="text-gray-400 text-sm">Create and track professional invoices with auto-reminders.</p>
            </div>
            
            <!-- Feature 3 -->
            <div class="bg-[#26002b]/50 backdrop-blur-md rounded-xl p-5 border border-[#810041]/20 hover:border-[#f2ab8b]/40 transition duration-300 shadow-lg">
                <div class="bg-gradient-to-r from-[#810041] to-[#f2ab8b] w-12 h-12 rounded-lg flex items-center justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold mb-2 text-white">Payment Tracking</h3>
                <p class="text-gray-400 text-sm">Monitor payment status and record transactions instantly.</p>
            </div>
            
            <!-- Feature 4 -->
            <div class="bg-[#26002b]/50 backdrop-blur-md rounded-xl p-5 border border-[#810041]/20 hover:border-[#f2ab8b]/40 transition duration-300 shadow-lg">
                <div class="bg-gradient-to-r from-[#810041] to-[#f2ab8b] w-12 h-12 rounded-lg flex items-center justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold mb-2 text-white">Client Portal</h3>
                <p class="text-gray-400 text-sm">Give clients real-time access to projects and invoices.</p>
            </div>
        </div>
    </div>
</section>

<!-- Testimonial Section -->
<section class="py-12 px-4">
    <div class="max-w-md mx-auto">
        <div class="bg-[#26002b]/50 backdrop-blur-md rounded-xl p-6 border border-[#810041]/20 shadow-lg relative overflow-hidden">
            <!-- Decorative elements -->
            <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-r from-[#810041] to-[#f2ab8b] opacity-10 rounded-bl-full"></div>
            <div class="absolute bottom-0 left-0 w-16 h-16 bg-gradient-to-r from-[#810041] to-[#f2ab8b] opacity-10 rounded-tr-full"></div>
            
            <div class="relative z-10">
                <svg class="w-10 h-10 text-[#f2ab8b]/30 mb-4" fill="currentColor" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10 8c-4.418 0-8 3.582-8 8s3.582 8 8 8c4.418 0 8-3.582 8-8s-3.582-8-8-8zm0 14c-3.314 0-6-2.686-6-6s2.686-6 6-6c3.314 0 6 2.686 6 6s-2.686 6-6 6zM24 8c-4.418 0-8 3.582-8 8s3.582 8 8 8c4.418 0 8-3.582 8-8s-3.582-8-8-8zm0 14c-3.314 0-6-2.686-6-6s2.686-6 6-6c3.314 0 6 2.686 6 6s-2.686 6-6 6z"></path>
                </svg>
                
                <p class="text-gray-300 mb-6 italic">PayTrack has completely transformed how we manage our client payments. The real-time tracking and automated reminders have improved our cash flow by 40%.</p>
                
                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-r from-[#810041] to-[#f2ab8b] flex items-center justify-center text-white font-bold">S</div>
                    <div class="ml-3">
                        <h4 class="text-white font-medium">Sarah Johnson</h4>
                        <p class="text-gray-400 text-sm">Creative Director</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Final CTA Section -->
<section class="py-12 px-4 mb-10">
    <div class="max-w-md mx-auto bg-[#26002b]/50 backdrop-blur-md rounded-xl p-6 border border-[#810041]/20 text-center shadow-lg">
        <h2 class="text-2xl font-bold mb-4 text-white">Ready to Get Started?</h2>
        <p class="text-gray-300 mb-6">Join thousands of businesses who use PayTrack to simplify their payment management.</p>
        
        <a href="login.php" class="inline-block w-full bg-gradient-to-r from-[#810041] to-[#f2ab8b] text-white font-medium py-3 px-6 rounded-xl shadow-lg hover:opacity-90 transition-all transform hover:scale-[1.02] active:scale-[0.98]">
            <div class="flex items-center justify-center">
                <span>Login to Your Account</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </div>
        </a>
    </div>
</section>

<style>
    /* Animation styles */
    .float-animation {
        animation: float 6s ease-in-out infinite;
    }
    .float-animation-delay {
        animation: float 6s ease-in-out 2s infinite;
    }
    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-15px); }
        100% { transform: translateY(0px); }
    }
</style>

<?php
// Include footer
include_once 'includes/footer.php';
?>