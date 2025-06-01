<nav x-data="{
    isOpen: false,
    userMenuOpen: false,
    scrolled: false,
    init() {
        window.addEventListener('scroll', () => {
            this.scrolled = window.scrollY > 0;
        });
    }
}"
    class="navbar-fixed bg-white/80 backdrop-blur shadow-lg">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo -->
            <a href="{{ route('home') }}"
               class="group flex items-center space-x-3 transition-transform duration-300 hover:scale-105">
                <div class="relative">
                    <i class="fas fa-comments text-3xl text-blue-500 group-hover:text-blue-600 transform transition-all duration-500"
                       x-ref="logoIcon"></i>
                    <div class="absolute -top-1 -right-1 w-3 h-3">
                        <span class="absolute inline-flex w-full h-full rounded-full opacity-75 animate-ping bg-green-400"></span>
                        <span class="relative inline-flex rounded-full w-3 h-3 bg-green-500"></span>
                    </div>
                </div>
                <div class="overflow-hidden">
                    <span class="text-xl font-bold tracking-wider bg-gradient-to-r from-blue-600 to-blue-400 bg-clip-text text-transparent">
                        Pengaduan
                    </span>
                    <div class="h-0.5 w-0 group-hover:w-full transition-all duration-500 ease-out bg-gradient-to-r from-blue-600 to-blue-400"></div>
                </div>
            </a>

            <!-- Navigation Links -->
            <div class="hidden md:flex md:items-center md:space-x-8">
                @php
                    $navItems = [
                        ['route' => 'home', 'icon' => 'home', 'text' => 'Beranda'],
                        ['route' => 'pengaduan.index', 'icon' => 'list-alt', 'text' => 'Daftar Pengaduan'],
                        // Check if user is admin and direct to appropriate dashboard
                        auth()->check() ? (
                            auth()->user()->role === 'admin' ?
                            ['route' => 'admin.dashboard', 'icon' => 'shield-alt', 'text' => 'Dashboard Admin'] :
                            ['route' => 'dashboard', 'icon' => 'user', 'text' => 'Dashboard']
                        ) : null
                    ];
                @endphp

                @foreach($navItems as $item)
                    @if($item)
                        <a href="{{ route($item['route']) }}"
                           class="group relative flex items-center px-4 py-2 rounded-lg transition-all duration-300 hover:-translate-y-0.5 hover:bg-blue-50">
                            <i class="fas fa-{{ $item['icon'] }} text-lg mr-2 text-blue-500 group-hover:text-blue-600 transition-all duration-300 group-hover:scale-110"></i>
                            <span class="relative font-medium text-gray-700">
                                {{ $item['text'] }}
                                <span class="absolute bottom-0 left-0 w-full h-0.5 transform scale-x-0 transition-transform duration-300 origin-left group-hover:scale-x-100 bg-blue-600"></span>
                            </span>
                        </a>
                    @endif
                @endforeach

                @auth
                    <!-- User Menu -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center space-x-3 focus:outline-none">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=random"
                                 alt="{{ auth()->user()->name }}"
                                 class="h-10 w-10 rounded-full ring-2 ring-blue-500 ring-offset-2">
                            <span class="font-medium text-gray-700">{{ auth()->user()->name }}</span>
                            <i class="fas fa-chevron-down text-gray-400"></i>
                        </button>

                        <!-- Dropdown menu -->
                        <div x-show="open"
                             @click.away="open = false"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute right-0 w-48 mt-2 py-2 bg-white rounded-xl shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                        class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 flex items-center">
                                    <i class="fas fa-sign-out-alt mr-2 text-blue-500"></i>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <!-- Login/Register Buttons -->
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('login') }}"
                           class="group px-4 py-2 rounded-lg transition-all duration-300 hover:-translate-y-0.5 hover:bg-blue-50 text-gray-600">
                            <span class="relative font-medium">
                                Login
                                <span class="absolute bottom-0 left-0 w-full h-0.5 transform scale-x-0 transition-transform duration-300 origin-left group-hover:scale-x-100 bg-blue-600"></span>
                            </span>
                        </a>
                        <a href="{{ route('register') }}"
                           class="group relative px-6 py-2 rounded-xl overflow-hidden transition-all duration-300 hover:shadow-lg hover:-translate-y-0.5 bg-gradient-to-r from-blue-600 to-blue-500 text-white">
                            <span class="relative z-10 font-medium">Register</span>
                            <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-300 bg-gradient-to-r from-blue-700 to-blue-600"></div>
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</nav>

<style>
    @keyframes wiggle {
        0%, 100% { transform: rotate(0deg); }
        25% { transform: rotate(-10deg); }
        75% { transform: rotate(10deg); }
    }
    .animate-wiggle {
        animation: wiggle 0.5s ease-in-out;
    }
</style>

<script>
    // Add smooth scroll behavior
    document.addEventListener('DOMContentLoaded', function() {
        const links = document.querySelectorAll('a[href^="#"]');
        links.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    });
</script>
