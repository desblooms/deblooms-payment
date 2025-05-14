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

<!-- Hero Section -->
<section class="min-h-[75vh] flex flex-col justify-center items-center my-8">
    <div class="glass rounded-xl p-6 md:p-8 max-w-3xl mx-auto border border-[#810041]/20 text-center">
        <h1 class="text-3xl md:text-4xl font-bold mb-4 bg-gradient-to-r from-[#810041] to-[#f2ab8b] text-transparent bg-clip-text">PayTrack</h1>
        <h2 class="text-xl md:text-2xl text-white mb-6">Simplify Your Payment Management</h2>
        
        <div class="mb-8">
            <p class="text-gray-300 mb-4">Track payments, manage projects, and stay on top of your finances with our intuitive platform.</p>
            <p class="text-gray-400 text-sm">Designed for freelancers, agencies, and businesses of all sizes.</p>
        </div>
        
        <div class="grid gap-4 md:grid-cols-2 mt-8">
            <a href="login.php" class="bg-gradient-to-r from-[#810041] to-[#f2ab8b] text-white font-medium py-3 px-6 rounded-lg hover:opacity-90 transition duration-300 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                </svg>
                Login to Your Account
            </a>
            <a href="#features" class="bg-[#3a0042]/50 text-white font-medium py-3 px-6 rounded-lg border border-[#810041]/30 hover:bg-[#810041]/20 transition duration-300 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Learn More
            </a>
        </div>
    </div>
</section>

<!-- App Preview Image -->
<section class="my-16 px-4">
    <div class="max-w-5xl mx-auto relative">
        <div class="absolute -inset-0.5 bg-gradient-to-r from-[#810041] to-[#f2ab8b] rounded-xl blur opacity-30"></div>
        <div class="relative glass rounded-xl overflow-hidden border border-[#810041]/20">
            <img src="assets/images/app-preview.png" alt="PayTrack App Preview" class="w-full h-auto" onerror="this.src='https://via.placeholder.com/1200x600/18001c/f2ab8b?text=PayTrack+App+Preview'">
        </div>
    </div>
</section>

<!-- Features Section -->
<section id="features" class="py-12 px-4">
    <div class="max-w-5xl mx-auto">
        <h2 class="text-2xl md:text-3xl font-bold mb-8 text-center bg-gradient-to-r from-[#810041] to-[#f2ab8b] text-transparent bg-clip-text">Key Features</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Feature 1 -->
            <div class="glass rounded-xl p-6 border border-[#810041]/20 hover:border-[#f2ab8b]/40 transition duration-300">
                <div class="bg-gradient-to-r from-[#810041] to-[#f2ab8b] w-12 h-12 rounded-lg flex items-center justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2 text-white">Project Management</h3>
                <p class="text-gray-400">Organize all your projects in one place with status tracking and deadlines.</p>
            </div>
            
            <!-- Feature 2 -->
            <div class="glass rounded-xl p-6 border border-[#810041]/20 hover:border-[#f2ab8b]/40 transition duration-300">
                <div class="bg-gradient-to-r from-[#810041] to-[#f2ab8b] w-12 h-12 rounded-lg flex items-center justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2 text-white">Invoice Management</h3>
                <p class="text-gray-400">Create, send, and track professional invoices with automated payment reminders.</p>
            </div>
            
            <!-- Feature 3 -->
            <div class="glass rounded-xl p-6 border border-[#810041]/20 hover:border-[#f2ab8b]/40 transition duration-300">
                <div class="bg-gradient-to-r from-[#810041] to-[#f2ab8b] w-12 h-12 rounded-lg flex items-center justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2 text-white">Payment Tracking</h3>
                <p class="text-gray-400">Monitor payment status, record transactions, and generate financial reports.</p>
            </div>
            
            <!-- Feature 4 -->
            <div class="glass rounded-xl p-6 border border-[#810041]/20 hover:border-[#f2ab8b]/40 transition duration-300">
                <div class="bg-gradient-to-r from-[#810041] to-[#f2ab8b] w-12 h-12 rounded-lg flex items-center justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2 text-white">Client Portal</h3>
                <p class="text-gray-400">Give clients access to their projects, invoices, and payment history in real-time.</p>
            </div>
            
            <!-- Feature 5 -->
            <div class="glass rounded-xl p-6 border border-[#810041]/20 hover:border-[#f2ab8b]/40 transition duration-300">
                <div class="bg-gradient-to-r from-[#810041] to-[#f2ab8b] w-12 h-12 rounded-lg flex items-center justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2 text-white">Analytics & Reports</h3>
                <p class="text-gray-400">Gain insights with visual reports on revenue, project status, and client activity.</p>
            </div>
            
            <!-- Feature 6 -->
            <div class="glass rounded-xl p-6 border border-[#810041]/20 hover:border-[#f2ab8b]/40 transition duration-300">
                <div class="bg-gradient-to-r from-[#810041] to-[#f2ab8b] w-12 h-12 rounded-lg flex items-center justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2 text-white">Mobile Friendly</h3>
                <p class="text-gray-400">Access your payment data from anywhere on any device with our responsive design.</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-12 px-4 my-8">
    <div class="max-w-4xl mx-auto glass rounded-xl p-8 border border-[#810041]/20 text-center">
        <h2 class="text-2xl md:text-3xl font-bold mb-4 text-white">Ready to Get Started?</h2>
        <p class="text-gray-300 mb-8 max-w-2xl mx-auto">Join thousands of businesses who use PayTrack to simplify their payment management and improve their cash flow.</p>
        
        <a href="login.php" class="bg-gradient-to-r from-[#810041] to-[#f2ab8b] text-white font-medium py-3 px-8 rounded-lg hover:opacity-90 transition duration-300 inline-block">
            Login to Your Account
        </a>
    </div>
</section>

<?php
// Include footer
include_once 'includes/footer.php';
?>