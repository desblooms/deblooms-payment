<?php
require_once 'config.php';
require_once 'includes/functions.php';
require_once 'includes/header.php';
?>

<div class="min-h-screen bg-gradient-to-br from-[#18001c] to-[#2a0032] text-gray-100 flex flex-col">
    <!-- Hero Section - Mobile First -->
    <section class="flex-grow flex flex-col items-center px-4 py-12 sm:px-6 md:py-16 lg:flex-row lg:justify-center">
        <div class="w-full text-center lg:w-1/2 lg:text-left mb-8 lg:mb-0">
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold mb-4 text-white">
                <span class="bg-clip-text text-transparent bg-gradient-to-r from-[#810041] to-[#f2ab8b]">
                    Project Manager
                </span>
            </h1>
            <p class="text-lg sm:text-xl lg:text-2xl mb-6 text-gray-300">
                Track your projects and payments in one place
            </p>
            <div class="flex flex-col gap-3 sm:flex-row sm:justify-center lg:justify-start">
                <a href="login.php" class="bg-[#810041] hover:bg-[#9a0050] text-white font-medium py-3 px-6 rounded-lg transition duration-300 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                    </svg>
                    Log In
                </a>
                <a href="#features" class="border border-[#f2ab8b] text-[#f2ab8b] hover:bg-[#f2ab8b] hover:text-[#18001c] font-medium py-3 px-6 rounded-lg transition duration-300 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Learn More
                </a>
            </div>
        </div>
        <div class="w-full sm:max-w-md lg:w-1/2 flex justify-center mt-6 lg:mt-0">
            <div class="relative w-full">
                <div class="absolute inset-0 bg-gradient-to-r from-[#810041] to-[#f2ab8b] rounded-lg transform rotate-2 blur-sm"></div>
                <div class="relative bg-[#2a0032] border border-[#3a0042] p-4 sm:p-6 rounded-lg shadow-2xl">
                    <div class="flex justify-between items-center mb-4 sm:mb-6">
                        <div class="flex items-center">
                            <div class="h-8 w-8 sm:h-10 sm:w-10 rounded-full bg-gradient-to-r from-[#810041] to-[#f2ab8b] flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
                                </svg>
                            </div>
                            <h3 class="ml-2 sm:ml-3 text-lg sm:text-xl font-semibold text-white">Project Status</h3>
                        </div>
                        <div class="bg-[#3a0042] p-1 rounded-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#f2ab8b]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                            </svg>
                        </div>
                    </div>
                    <div class="space-y-3 sm:space-y-4">
                        <!-- Project Cards - Optimized for mobile -->
                        <div class="p-2 sm:p-3 bg-[#3a0042] rounded-lg">
                            <div class="flex justify-between items-center mb-2">
                                <h4 class="font-medium text-white text-sm sm:text-base">Website Redesign</h4>
                                <span class="text-xs sm:text-sm text-[#f2ab8b]">70%</span>
                            </div>
                            <p class="text-xs sm:text-sm text-gray-400 mb-1">Due: May 25, 2025</p>
                            <div class="h-1.5 sm:h-2.5 w-full bg-gray-700 rounded-full">
                                <div class="h-1.5 sm:h-2.5 rounded-full bg-gradient-to-r from-[#810041] to-[#f2ab8b]" style="width: 70%"></div>
                            </div>
                        </div>
                        <div class="p-2 sm:p-3 bg-[#3a0042] rounded-lg">
                            <div class="flex justify-between items-center mb-2">
                                <h4 class="font-medium text-white text-sm sm:text-base">Mobile App Development</h4>
                                <span class="text-xs sm:text-sm text-[#f2ab8b]">45%</span>
                            </div>
                            <p class="text-xs sm:text-sm text-gray-400 mb-1">Due: June 10, 2025</p>
                            <div class="h-1.5 sm:h-2.5 w-full bg-gray-700 rounded-full">
                                <div class="h-1.5 sm:h-2.5 rounded-full bg-gradient-to-r from-[#810041] to-[#f2ab8b]" style="width: 45%"></div>
                            </div>
                        </div>
                        <div class="p-2 sm:p-3 bg-[#3a0042] rounded-lg">
                            <div class="flex justify-between items-center mb-2">
                                <h4 class="font-medium text-white text-sm sm:text-base">SEO Optimization</h4>
                                <span class="text-xs sm:text-sm text-[#f2ab8b]">90%</span>
                            </div>
                            <p class="text-xs sm:text-sm text-gray-400 mb-1">Due: May 18, 2025</p>
                            <div class="h-1.5 sm:h-2.5 w-full bg-gray-700 rounded-full">
                                <div class="h-1.5 sm:h-2.5 rounded-full bg-gradient-to-r from-[#810041] to-[#f2ab8b]" style="width: 90%"></div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 sm:mt-6 flex justify-center">
                        <a href="login.php" class="inline-flex items-center text-[#f2ab8b] hover:text-white text-sm sm:text-base">
                            View all projects
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 sm:h-4 sm:w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section - Mobile Optimized -->
    <section id="features" class="py-12 sm:py-16 px-4 sm:px-6 bg-[#22002a]">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-2xl sm:text-3xl font-bold text-center mb-8 sm:mb-12 text-white">
                <span class="bg-clip-text text-transparent bg-gradient-to-r from-[#810041] to-[#f2ab8b]">
                    Features
                </span>
            </h2>
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <!-- Feature Cards - Optimized for mobile -->
                <div class="bg-[#2a0032] p-4 sm:p-6 rounded-lg border border-[#3a0042] transform transition duration-300 hover:scale-105">
                    <div class="bg-gradient-to-r from-[#810041] to-[#f2ab8b] w-10 h-10 sm:w-12 sm:h-12 rounded-lg flex items-center justify-center mb-3 sm:mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <h3 class="text-lg sm:text-xl font-semibold mb-2 text-white">Project Tracking</h3>
                    <p class="text-sm sm:text-base text-gray-400">Monitor project progress in real-time with detailed status updates and milestone tracking.</p>
                </div>
                <div class="bg-[#2a0032] p-4 sm:p-6 rounded-lg border border-[#3a0042] transform transition duration-300 hover:scale-105">
                    <div class="bg-gradient-to-r from-[#810041] to-[#f2ab8b] w-10 h-10 sm:w-12 sm:h-12 rounded-lg flex items-center justify-center mb-3 sm:mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg sm:text-xl font-semibold mb-2 text-white">Payment Management</h3>
                    <p class="text-sm sm:text-base text-gray-400">View invoices, track payments, and get notified about upcoming payment schedules.</p>
                </div>
                <div class="bg-[#2a0032] p-4 sm:p-6 rounded-lg border border-[#3a0042] transform transition duration-300 hover:scale-105">
                    <div class="bg-gradient-to-r from-[#810041] to-[#f2ab8b] w-10 h-10 sm:w-12 sm:h-12 rounded-lg flex items-center justify-center mb-3 sm:mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                        </svg>
                    </div>
                    <h3 class="text-lg sm:text-xl font-semibold mb-2 text-white">Secure Access</h3>
                    <p class="text-sm sm:text-base text-gray-400">Individual client logins ensure that your project information remains private and secure.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section - Mobile Friendly -->
    <section class="py-12 sm:py-16 px-4 sm:px-6">
        <div class="max-w-4xl mx-auto bg-gradient-to-r from-[#810041] to-[#f2ab8b] rounded-xl p-1">
            <div class="bg-[#2a0032] rounded-lg p-6 sm:p-8 text-center">
                <h2 class="text-2xl sm:text-3xl font-bold mb-3 sm:mb-4 text-white">Ready to get started?</h2>
                <p class="text-sm sm:text-base text-gray-300 mb-5 sm:mb-6 max-w-lg mx-auto">Log in to your client portal to view your projects, track payments, and stay updated on progress.</p>
                <a href="login.php" class="inline-block bg-gradient-to-r from-[#810041] to-[#f2ab8b] text-white font-medium py-2 sm:py-3 px-6 sm:px-8 rounded-lg transition duration-300 transform hover:scale-105 hover:shadow-lg text-sm sm:text-base">
                    Log In Now
                </a>
            </div>
        </div>
    </section>

    <!-- Testimonials Section - Mobile First -->
    <section class="py-12 sm:py-16 px-4 sm:px-6 bg-[#22002a]">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-2xl sm:text-3xl font-bold text-center mb-8 sm:mb-12 text-white">
                <span class="bg-clip-text text-transparent bg-gradient-to-r from-[#810041] to-[#f2ab8b]">
                    Client Testimonials
                </span>
            </h2>
            <div class="grid gap-6 md:grid-cols-2">
                <!-- Testimonial Cards - Mobile optimized -->
                <div class="bg-[#2a0032] p-4 sm:p-6 rounded-lg border border-[#3a0042]">
                    <div class="flex items-center mb-3 sm:mb-4">
                        <div class="h-10 w-10 sm:h-12 sm:w-12 rounded-full bg-gradient-to-r from-[#810041] to-[#f2ab8b] flex items-center justify-center text-white font-bold text-base sm:text-lg">
                            SB
                        </div>
                        <div class="ml-3 sm:ml-4">
                            <h4 class="text-base sm:text-lg font-semibold text-white">Sarah Brown</h4>
                            <p class="text-xs sm:text-sm text-gray-400">Marketing Director</p>
                        </div>
                    </div>
                    <p class="text-sm sm:text-base text-gray-300 italic">"This platform has completely transformed how we manage our projects. The payment tracking is seamless, and having a dedicated portal for each client is game-changing."</p>
                    <div class="mt-3 sm:mt-4 flex text-[#f2ab8b]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                    </div>
                </div>
               