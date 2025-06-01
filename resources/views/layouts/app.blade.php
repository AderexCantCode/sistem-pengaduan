<!DOCTYPE html>
<html lang="en" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }"
      :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Pengaduan - @yield('title')</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- AOS CSS and JS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- Custom Animation Classes -->
    <style>
        .fade-in-up {
            animation: fadeInUp 0.5s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .hover-scale {
            transition: transform 0.2s;
        }

        .hover-scale:hover {
            transform: scale(1.02);
        }

        body {
            font-family: 'Inter', sans-serif;
        }

        .dark {
            color-scheme: dark;
        }

        /* Navbar styles */
        .navbar-fixed {
            position: fixed;
            top: 0;
            right: 0;
            left: 0;
            z-index: 50;
            backdrop-filter: blur(8px);
            background-color: rgba(255, 255, 255, 0.95);
        }

        /* Professional Loading Animation */
        .loading-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: #ffffff;
            z-index: 9999;
            display: flex;
            justify-content: center;
            align-items: center;
            transition: opacity 0.3s ease-out;
        }

        .loading-content {
            text-align: center;
        }

        .loading-logo {
            width: 80px;
            height: 80px;
            margin-bottom: 20px;
            position: relative;
        }

        .loading-circle {
            position: absolute;
            width: 100%;
            height: 100%;
            border: 3px solid transparent;
            border-top-color: #3B82F6;
            border-right-color: #3B82F6;
            border-radius: 50%;
            animation: rotateCircle 1s linear infinite;
        }

        .loading-circle:nth-child(2) {
            width: 70%;
            height: 70%;
            top: 15%;
            left: 15%;
            border-top-color: #60A5FA;
            border-right-color: #60A5FA;
            animation-duration: 0.875s;
        }

        .loading-circle:nth-child(3) {
            width: 40%;
            height: 40%;
            top: 30%;
            left: 30%;
            border-top-color: #93C5FD;
            border-right-color: #93C5FD;
            animation-duration: 0.75s;
        }

        .loading-text {
            color: #1E40AF;
            font-weight: 500;
            letter-spacing: 0.5px;
            margin-top: 16px;
            opacity: 0.9;
            position: relative;
        }

        .loading-text::after {
            content: '...';
            position: absolute;
            animation: loadingDots 1.5s infinite;
        }

        @keyframes rotateCircle {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        @keyframes loadingDots {
            0% { content: '.'; }
            33% { content: '..'; }
            66% { content: '...'; }
        }

        .loading-container.loaded {
            opacity: 0;
            pointer-events: none !important;  /* Force disable interactions immediately */
            visibility: hidden;
            transition: opacity 0.3s ease-out, visibility 0s 0.3s;
        }

        /* Progress bar at the top of the page */
        .progress-bar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(to right, #3B82F6, #60A5FA);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.2s ease-out;
            z-index: 10000;
        }

        .progress-bar.loading {
            animation: progressBar 2s ease-out forwards;
        }

        @keyframes progressBar {
            0% { transform: scaleX(0); }
            50% { transform: scaleX(0.5); }
            80% { transform: scaleX(0.7); }
            100% { transform: scaleX(1); }
        }

        .nav-transition {
            transition: all 0.3s ease-in-out;
        }

        /* Add smooth scrolling for better intersection observer performance */
        html {
            scroll-behavior: smooth;
        }

        .stat-badge {
            @apply inline-flex items-center px-2.5 py-1.5 rounded-md text-sm font-medium transition-all duration-200;
        }

        .stat-badge:hover {
            @apply transform scale-105;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }

        .animate-float {
            animation: float 3s ease-in-out infinite;
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Load Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="min-h-screen transition-colors duration-300 bg-gray-50 dark:bg-gray-900">
    <!-- Progress Bar -->
    <div class="progress-bar"></div>

    <!-- Loading Container -->
    <div class="loading-container">
        <div class="loading-content">
            <div class="loading-logo">
                <div class="loading-circle"></div>
                <div class="loading-circle"></div>
                <div class="loading-circle"></div>
            </div>
            <div class="loading-text">Loading</div>
        </div>
    </div>

    <div class="navbar-fixed">
        @include('partials.navbar')
    </div>
    @include('partials.flash')

    <main class="container mx-auto px-4 py-8 pt-24">
        @yield('content')
    </main>

    <script>
        // Initialize AOS
        AOS.init({
            duration: 800,
            offset: 100,
            once: true
        });

        // Handle Loading Animation with improved timing
        window.addEventListener('load', function() {
            const progressBar = document.querySelector('.progress-bar');
            const loadingContainer = document.querySelector('.loading-container');

            if (!loadingContainer || !progressBar) {
                console.error('Loading elements not found');
                return;
            }

            // Add loading class to progress bar
            progressBar.classList.add('loading');

            // Force pointer-events none immediately
            loadingContainer.style.pointerEvents = 'none';

            // Add loaded class after a short delay
            setTimeout(function() {
                loadingContainer.classList.add('loaded');

                // Hide loading container immediately after transition
                setTimeout(() => {
                    loadingContainer.style.display = 'none';
                    document.body.style.overflow = 'auto'; // Re-enable scrolling
                }, 300); // Match transition duration

                // Reset progress bar
                setTimeout(() => {
                    progressBar.style.transform = 'scaleX(0)';
                }, 200);
            }, 1000); // Reduced from 1500ms for better UX
        });

        // Handle Page Transitions
        document.addEventListener('DOMContentLoaded', function() {
            const links = document.querySelectorAll('a:not([target="_blank"]):not([href^="#"])');

            links.forEach(link => {
                link.addEventListener('click', function(e) {
                    if (this.href.includes(window.location.origin)) {
                        e.preventDefault();
                        const loadingContainer = document.querySelector('.loading-container');
                        const progressBar = document.querySelector('.progress-bar');

                        loadingContainer.classList.remove('loaded');
                        progressBar.classList.add('loading');

                        setTimeout(() => {
                            window.location = this.href;
                        }, 800);
                    }
                });
            });
        });
        document.addEventListener('DOMContentLoaded', function() {
        AOS.init({
            duration: 800,
            easing: 'ease-out',
            once: true
        });
    });
    </script>

    @stack('scripts') <!-- Add this line before closing body tag -->
</body>
</html>
