<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PayTrack - Smart Payment Tracking System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'battleship-gray': '#868F83',
                        'yellow-green': '#B2C451',
                        'sage': '#C9CF94',
                        'silver': '#B7B7B5',
                        'black-olive': '#353732',
                        'mindaro': '#E7FE66',
                        'eerie-black': '#1C1F0A',
                        'mindaro-2': '#E6FB78',
                        'ebony': '#676548',
                        'mint-cream': '#EAEFEA',
                    },
                    fontFamily: {
                        'poppins': ['Poppins', 'sans-serif']
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'pulse-slow': 'pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                        'slide-in': 'slideIn 0.6s ease-out forwards',
                        'fade-in': 'fadeIn 0.8s ease-out forwards',
                        'bounce-slow': 'bounce 3s infinite',
                        'spin-slow': 'spin 8s linear infinite',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-10px)' }
                        },
                        slideIn: {
                            '0%': { transform: 'translateY(20px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' }
                        },
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' }
                        }
                    },
                }
            }
        }
    </script>
    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #C9CF94 0%, #E7FE66 100%);
        }
        
        .glass-card {
            backdrop-filter: blur(16px) saturate(180%);
            background-color: rgba(255, 255, 255, 0.75);
            border-radius: 16px;
            border: 1px solid rgba(209, 213, 219, 0.3);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15);
        }
        
        .card-hover-effect {
            transition: all 0.3s ease;
        }
        
        .card-hover-effect:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 20px rgba(0, 0, 0, 0.1);
        }
        
        .animated-gradient {
            background: linear-gradient(-45deg, #C9CF94, #E7FE66, #B2C451, #E6FB78);
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
        
        .text-shadow {
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        .circle-pattern {
            position: absolute;
            border-radius: 50%;
            filter: blur(60px);
            z-index: -1;
            opacity: 0.6;
        }
        
        /* Loading animation */
        .loader {
            width: 100%;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            position: fixed;
            background: linear-gradient(135deg, #C9CF94 0%, #E7FE66 100%);
            z-index: 1000;
            transition: opacity 0.5s ease-out;
        }
        
        .loader-hidden {
            opacity: 0;
            pointer-events: none;
        }
        
        .loader-circle {
            width: 50px;
            height: 50px;
            border: 5px solid #1C1F0A;
            border-top: 5px solid #E7FE66;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        /* Progress bar */
        .progress-bar {
            height: 4px;
            background-color: #E7FE66;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 100;
            width: 0%;
            transition: width 0.3s ease-out;
        }
        
        /* Mobile menu */
        .mobile-menu {
            transform: translateX(-100%);
            transition: transform 0.3s ease-out;
        }
        
        .mobile-menu.active {
            transform: translateX(0);
        }
        
        /* Notification dot animation */
        .notification-dot {
            position: absolute;
            top: -2px;
            right: -2px;
            width: 8px;
            height: 8px;
            background-color: #E7FE66;
            border-radius: 50%;
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(231, 254, 102, 0.7);
            }
            
            70% {
                transform: scale(1);
                box-shadow: 0 0 0 10px rgba(231, 254, 102, 0);
            }
            
            100% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(231, 254, 102, 0);
            }
        }
        
        /* Hero text animation */
        .animate-typing {
            overflow: hidden;
            border-right: 3px solid #E7FE66;
            white-space: nowrap;
            animation: typing 3.5s steps(40, end), blink-caret 0.75s step-end infinite;
        }
        
        @keyframes typing {
            from { width: 0 }
            to { width: 100% }
        }
        
        @keyframes blink-caret {
            from, to { border-color: transparent }
            50% { border-color: #E7FE66 }
        }
    </style>
</head>
<body class="animated-gradient min-h-screen flex flex-col overflow-x-hidden">
    <!-- Loading Screen -->
    <div class="loader" id="loader">
        <div class="loader-circle"></div>
    </div>
    
    <!-- Progress bar -->
    <div class="progress-bar" id="progressBar"></div>
    
    <!-- Background patterns -->
    <div class="circle-pattern bg-yellow-green w-64 h-64 top-20 -left-20 animate-spin-slow"></div>
    <div class="circle-pattern bg-mindaro w-96 h-96 bottom-40 -right-40 animate-spin-slow"></div>
    
    <header class="bg-eerie-black py-4 px-4 shadow-lg sticky top-0 z-50">
        <div class="container mx-auto flex justify-between items-center">
            <div class="flex items-center">
                <div class="mr-2 text-mindaro text-3xl animate-float">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h1 class="text-white text-xl font-bold">Pay<span class="text-mindaro">Track</span></h1>
            </div>
            <nav class="hidden md:block">
                <div class="flex items-center space-x-6">
                    <a href="#features" class="text-white hover:text-mindaro transition duration-300">Features</a>
                    <a href="#pricing" class="text-white hover:text-mindaro transition duration-300">Pricing</a>
                    <a href="#testimonials" class="text-white hover:text-mindaro transition duration-300">Testimonials</a>
                    <a href="login.php" class="bg-mindaro text-eerie-black px-5 py-2 rounded-full font-medium hover:bg-mindaro-2 transition duration-300 shadow-lg">
                        Login
                    </a>
                </div>
            </nav>
            <button id="mobileMenuButton" class="md:hidden text-white text-xl">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </header>
    
    <!-- Mobile menu -->
    <div id="mobileMenu" class="mobile-menu fixed top-0 left-0 h-full w-4/5 bg-eerie-black z-50 p-6">
        <div class="flex justify-end mb-6">
            <button id="closeMenuButton" class="text-white text-xl">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="flex flex-col space-y-6">
            <a href="#features" class="text-white hover:text-mindaro transition duration-300 text-lg">Features</a>
            <a href="#pricing" class="text-white hover:text-mindaro transition duration-300 text-lg">Pricing</a>
            <a href="#testimonials" class="text-white hover:text-mindaro transition duration-300 text-lg">Testimonials</a>
            <a href="login.php" class="bg-mindaro text-eerie-black px-5 py-2 rounded-full font-medium hover:bg-mindaro-2 transition duration-300 shadow-lg text-center mt-4">
                Login
            </a>
        </div>
    </div>

    <main class="flex-grow flex flex-col items-center justify-center px-4 py-10 relative">
        <!-- Hero Section -->
        <div class="max-w-lg w-full mb-16">
            <div class="glass-card overflow-hidden mb-6 opacity-0 animate-fade-in" style="animation-delay: 0.2s">
                <div class="p-8">
                    <div class="flex items-center justify-center mb-6">
                        <div class="relative">
                            <div class="text-6xl text-yellow-green animate-float">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <div class="notification-dot"></div>
                        </div>
                    </div>
                    <h2 class="text-2xl md:text-3xl font-bold text-black-olive text-center mb-6 text-shadow">
                        <span class="block">Track Payments.</span>
                        <span class="block mt-1">Manage Projects.</span>
                        <span class="block mt-1 text-yellow-green">Grow Business.</span>
                    </h2>
                    <p class="text-battleship-gray text-center mb-8">
                        The all-in-one platform for managing client projects and payments. Get a clear view of your business at a glance.
                    </p>
                    <div class="flex flex-col space-y-4">
                        <a href="login.php" class="bg-mindaro text-eerie-black text-center py-3 px-6 rounded-lg font-medium hover:bg-mindaro-2 transition duration-300 shadow-lg flex items-center justify-center space-x-2 transform hover:scale-105">
                            <span>Login to Your Account</span>
                            <i class="fas fa-arrow-right"></i>
                        </a>
                        <div class="text-center text-battleship-gray text-sm">
                            <p>Administrator? <a href="admin/login.php" class="text-yellow-green hover:underline">Login here</a></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mockup Display -->
            <div class="relative my-12 opacity-0 animate-fade-in" style="animation-delay: 0.4s">
                <div class="flex justify-center">
                    <div class="relative border-8 border-eerie-black rounded-3xl shadow-2xl w-64 h-auto overflow-hidden">
                        <div class="bg-eerie-black h-6 relative">
                            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-16 h-1.5 bg-silver rounded-full"></div>
                        </div>
                        <img src="/api/placeholder/320/640" alt="PayTrack App" class="w-full object-cover" />
                        <div class="bg-eerie-black h-6"></div>
                    </div>
                </div>
                <!-- Animated circles -->
                <div class="absolute -top-4 -left-4 w-12 h-12 bg-mindaro rounded-full opacity-70 animate-pulse-slow"></div>
                <div class="absolute -bottom-4 -right-4 w-16 h-16 bg-yellow-green rounded-full opacity-70 animate-float"></div>
            </div>
        </div>

        <!-- Features Section -->
        <div id="features" class="container mx-auto my-12">
            <h2 class="text-2xl font-bold text-eerie-black text-center mb-10">Powerful Features</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="glass-card p-6 card-hover-effect opacity-0 animate-slide-in" style="animation-delay: 0.1s">
                    <div class="text-yellow-green text-3xl mb-3 animate-float">
                        <i class="fas fa-wallet"></i>
                    </div>
                    <h3 class="font-bold text-black-olive mb-2">Track Payments</h3>
                    <p class="text-sm text-battleship-gray">Monitor all incoming payments and keep track of your project finances in real-time with intuitive dashboards.</p>
                </div>
                
                <div class="glass-card p-6 card-hover-effect opacity-0 animate-slide-in" style="animation-delay: 0.2s">
                    <div class="text-yellow-green text-3xl mb-3 animate-float">
                        <i class="fas fa-tasks"></i>
                    </div>
                    <h3 class="font-bold text-black-olive mb-2">Manage Projects</h3>
                    <p class="text-sm text-battleship-gray">Keep all your projects organized with status updates, milestone tracking, and progress visualization.</p>
                </div>
                
                <div class="glass-card p-6 card-hover-effect opacity-0 animate-slide-in" style="animation-delay: 0.3s">
                    <div class="text-yellow-green text-3xl mb-3 animate-float">
                        <i class="fas fa-file-invoice-dollar"></i>
                    </div>
                    <h3 class="font-bold text-black-olive mb-2">Easy Invoicing</h3>
                    <p class="text-sm text-battleship-gray">Create and send professional invoices to clients with just a few clicks. Auto-reminders for pending payments.</p>
                </div>
                
                <div class="glass-card p-6 card-hover-effect opacity-0 animate-slide-in" style="animation-delay: 0.4s">
                    <div class="text-yellow-green text-3xl mb-3 animate-float">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    <h3 class="font-bold text-black-olive mb-2">Insightful Reports</h3>
                    <p class="text-sm text-battleship-gray">Get powerful insights about your business performance with detailed analytics and visualized data.</p>
                </div>
                
                <div class="glass-card p-6 card-hover-effect opacity-0 animate-slide-in" style="animation-delay: 0.5s">
                    <div class="text-yellow-green text-3xl mb-3 animate-float">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <h3 class="font-bold text-black-olive mb-2">Mobile Optimized</h3>
                    <p class="text-sm text-battleship-gray">Access your dashboard on the go with our fully responsive mobile interface designed for phones and tablets.</p>
                </div>
                
                <div class="glass-card p-6 card-hover-effect opacity-0 animate-slide-in" style="animation-delay: 0.6s">
                    <div class="text-yellow-green text-3xl mb-3 animate-float">
                        <i class="fas fa-bell"></i>
                    </div>
                    <h3 class="font-bold text-black-olive mb-2">Smart Notifications</h3>
                    <p class="text-sm text-battleship-gray">Stay informed with timely alerts about payment receipts, approaching deadlines, and client activity.</p>
                </div>
            </div>
        </div>
        
        <!-- How It Works -->
        <div class="container mx-auto my-16">
            <h2 class="text-2xl font-bold text-eerie-black text-center mb-10">How It Works</h2>
            <div class="flex flex-col md:flex-row items-center justify-center space-y-8 md:space-y-0 md:space-x-8">
                <div class="glass-card p-6 text-center w-full md:w-1/3 opacity-0 animate-fade-in" style="animation-delay: 0.2s">
                    <div class="w-16 h-16 rounded-full bg-yellow-green flex items-center justify-center mx-auto mb-4 text-white text-2xl font-bold">1</div>
                    <h3 class="font-bold text-black-olive mb-2">Create Project</h3>
                    <p class="text-sm text-battleship-gray">Add new projects, set milestones, and invite clients to collaborate.</p>
                </div>
                
                <div class="glass-card p-6 text-center w-full md:w-1/3 opacity-0 animate-fade-in" style="animation-delay: 0.4s">
                    <div class="w-16 h-16 rounded-full bg-yellow-green flex items-center justify-center mx-auto mb-4 text-white text-2xl font-bold">2</div>
                    <h3 class="font-bold text-black-olive mb-2">Generate Invoice</h3>
                    <p class="text-sm text-battleship-gray">Create professional invoices based on project progress or completed milestones.</p>
                </div>
                
                <div class="glass-card p-6 text-center w-full md:w-1/3 opacity-0 animate-fade-in" style="animation-delay: 0.6s">
                    <div class="w-16 h-16 rounded-full bg-yellow-green flex items-center justify-center mx-auto mb-4 text-white text-2xl font-bold">3</div>
                    <h3 class="font-bold text-black-olive mb-2">Track Results</h3>
                    <p class="text-sm text-battleship-gray">Monitor payments, analyze performance, and grow your business with data insights.</p>
                </div>
            </div>
        </div>
        
        <!-- Testimonials Section -->
        <div id="testimonials" class="container mx-auto my-16">
            <h2 class="text-2xl font-bold text-eerie-black text-center mb-10">What Our Clients Say</h2>
            <div class="glass-card p-8 opacity-0 animate-fade-in" style="animation-delay: 0.3s">
                <div class="flex flex-col items-center text-center">
                    <div class="w-20 h-20 rounded-full overflow-hidden mb-4">
                        <img src="/api/placeholder/200/200" alt="Client" class="w-full h-full object-cover" />
                    </div>
                    <div class="text-yellow-green mb-2">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="text-battleship-gray italic mb-4">"PayTrack transformed how we manage client payments. The mobile interface makes it easy to check project status and payment history while on the go."</p>
                    <h4 class="font-bold text-black-olive">Sarah Johnson</h4>
                    <p class="text-sm text-battleship-gray">Design Studio Owner</p>
                </div>
            </div>
        </div>
        
        <!-- CTA Section -->
        <div class="container mx-auto my-16">
            <div class="glass-card p-8 text-center opacity-0 animate-fade-in" style="animation-delay: 0.3s">
                <h2 class="text-2xl font-bold text-black-olive mb-4">Ready to streamline your payment tracking?</h2>
                <p class="text-battleship-gray mb-6">Join thousands of businesses using PayTrack to manage projects and payments efficiently.</p>
                <a href="login.php" class="inline-block bg-mindaro text-eerie-black py-3 px-8 rounded-lg font-medium hover:bg-mindaro-2 transition duration-300 shadow-lg transform hover:scale-105">
                    Get Started Today
                </a>
            </div>
        </div>
    </main>

    <footer class="bg-eerie-black text-mint-cream py-8 mt-auto">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-center mb-8">
                <div class="flex items-center mb-4 md:mb-0">
                    <div class="mr-2 text-mindaro text-2xl">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h1 class="text-white text-xl font-bold">Pay<span class="text-mindaro">Track</span></h1>
                </div>
                <div class="flex space-x-4">
                    <a href="#" class="text-mint-cream hover:text-mindaro transition duration-300">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="text-mint-cream hover:text-mindaro transition duration-300">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="text-mint-cream hover:text-mindaro transition duration-300">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="text-mint-cream hover:text-mindaro transition duration-300">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div>
                    <h3 class="text-mindaro font-semibold mb-3">Company</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-mint-cream hover:text-mindaro transition duration-300">About Us</a></li>
                        <li><a href="#" class="text-mint-cream hover:text-mindaro transition duration-300">Our Team</a></li>
                        <li><a href="#" class="text-mint-cream hover:text-mindaro transition duration-300">Careers</a></li>
                        <li><a href="#" class="text-mint-cream hover:text-mindaro transition duration-300">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-mindaro font-semibold mb-3">Resources</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-mint-cream hover:text-mindaro transition duration-300">Blog</a></li>
                        <li><a href="#" class="text-mint-cream hover:text-mindaro transition duration-300">Help Center</a></li>
                        <li><a href="#" class="text-mint-cream hover:text-mindaro transition duration-300">Tutorials</a></li>
                        <li><a href="#" class="text-mint-cream hover:text-mindaro transition duration-300">API Documentation</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-mindaro font-semibold mb-3">Legal</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-mint-cream hover:text-mindaro transition duration-300">Terms of Service</a></li>
                        <li><a href="#" class="text-mint-cream hover:text-mindaro transition duration-300">Privacy Policy</a></li>
                        <li><a href="#" class="text-mint-cream hover:text-mindaro transition duration-300">Cookie Policy</a></li>
                        <li><a href="#" class="text-mint-cream hover:text-mindaro transition duration-300">GDPR Compliance</a></li>
                    </ul>
                </div>
            </div>
            <div class="text-center text-sm border-t border-gray-700 pt-6">
                <p>&copy; <?php echo date('Y'); ?> PayTrack. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Page load animation
        window.addEventListener('load', function() {
            setTimeout(function() {
                document.getElementById('loader').classList.add('loader-hidden');
            }, 1000);
        });
        
        // Progress bar on scroll
        window.addEventListener('scroll', function() {
            const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
            const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            const scrolled = (winScroll / height) * 100;
            document.getElementById('progressBar').style.width = scrolled + '%';
        });
        
        // Mobile menu toggle
        document.getElementById('mobileMenuButton').addEventListener('click', function() {
            document.getElementById('mobileMenu').classList.add('active');
        });
        
        document.getElementById('closeMenuButton').addEventListener('click', function() {
            document.getElementById('mobileMenu').classList.remove('active');
        });
        
        // Scroll animation
        const observerOptions = {
            root: null,
            rootMargin: '0px',
            threshold: 0.1
        };
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.animationPlayState = 'running';
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);
        
        document.querySelectorAll('.animate-slide-in, .animate-fade-in').forEach(element => {
            element.style.animationPlayState = 'paused';
            observer.observe(element);
        });
        
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
                
                // Close mobile menu if open
                document.getElementById('mobileMenu').classList.remove('active');
            });
        });
    </script>
</body>
</html>