@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="bg-white">
    <!-- Hero Section with Parallax Effect -->
    <div class="relative min-h-screen bg-gradient-to-r from-blue-600 to-blue-800 overflow-hidden" x-data="{ scroll: 0 }" @scroll.window="scroll = window.pageYOffset">
        <!-- Animated Background Particles -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            @for ($i = 1; $i <= 5; $i++)
                <div class="absolute rounded-full mix-blend-multiply filter blur-xl opacity-70"
                     style="
                        background: #60A5FA;
                        width: {{ rand(300, 500) }}px;
                        height: {{ rand(300, 500) }}px;
                        left: {{ rand(-20, 120) }}%;
                        top: {{ rand(-20, 120) }}%;
                        animation: float{{ $i }} {{ rand(10, 20) }}s infinite ease-in-out;">
                </div>
            @endfor
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="pt-20 pb-16 md:pt-32 md:pb-28 lg:pt-40 lg:pb-36">
                <div class="text-center lg:text-left" data-aos="fade-up" data-aos-duration="1000">
                    <h1 class="text-4xl md:text-6xl lg:text-7xl font-extrabold text-white leading-tight">
                        <span class="block transform hover:scale-105 transition-transform duration-300">Suara Anda</span>
                        <span class="block text-blue-200 mt-2 transform hover:scale-105 transition-transform duration-300">Perubahan Nyata</span>
                    </h1>
                    <p class="mt-6 text-lg md:text-xl text-blue-100 max-w-2xl mx-auto lg:mx-0" data-aos="fade-up" data-aos-delay="200">
                        Platform pengaduan masyarakat yang memudahkan Anda menyampaikan aspirasi dan mendapatkan tanggapan langsung.
                    </p>

                    <div class="mt-8 flex flex-col sm:flex-row justify-center lg:justify-start gap-4" data-aos="fade-up" data-aos-delay="400">
                        @auth
                            <a href="{{ route('pengaduan.create') }}"
                               class="group relative inline-flex items-center justify-center px-8 py-4 text-lg font-medium text-blue-600 bg-white rounded-xl shadow-lg hover:bg-blue-50 transform hover:-translate-y-1 transition-all duration-300">
                                <span class="absolute inset-0 w-full h-full mt-1 ml-1 transition-all duration-300 ease-in-out bg-blue-600 rounded-xl group-hover:mt-0 group-hover:ml-0"></span>
                                <span class="absolute inset-0 w-full h-full bg-white rounded-xl"></span>
                                <span class="relative flex items-center">
                                    <i class="fas fa-edit mr-2 group-hover:scale-110 transition-transform duration-300"></i>
                                    Buat Pengaduan
                                </span>
                            </a>
                        @else
                            <a href="{{ route('register') }}"
                               class="group relative inline-flex items-center justify-center px-8 py-4 text-lg font-medium text-white bg-blue-500 rounded-xl shadow-lg hover:bg-blue-600 transform hover:-translate-y-1 transition-all duration-300">
                                <span class="absolute inset-0 w-full h-full mt-1 ml-1 transition-all duration-300 ease-in-out bg-blue-800 rounded-xl group-hover:mt-0 group-hover:ml-0"></span>
                                <span class="absolute inset-0 w-full h-full bg-blue-500 rounded-xl"></span>
                                <span class="relative flex items-center">
                                    <i class="fas fa-user-plus mr-2 group-hover:scale-110 transition-transform duration-300"></i>
                                    Daftar Sekarang
                                </span>
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>

        <!-- Animated Wave Effect -->
        <div class="absolute bottom-0 left-0 right-0">
            <svg class="waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto">
                <defs>
                    <path id="gentle-wave" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z" />
                </defs>
                <g class="parallax">
                    <use xlink:href="#gentle-wave" x="48" y="0" fill="rgba(255,255,255,0.7" />
                    <use xlink:href="#gentle-wave" x="48" y="3" fill="rgba(255,255,255,0.5)" />
                    <use xlink:href="#gentle-wave" x="48" y="5" fill="rgba(255,255,255,0.3)" />
                    <use xlink:href="#gentle-wave" x="48" y="7" fill="#fff" />
                </g>
            </svg>
        </div>
    </div>

    <!-- Pengaduan Cards Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-8">Pengaduan Terbaru</h2>

        <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
            @foreach ($pengaduans as $pengaduan)
                <div class="group bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2"
                     data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                    <div class="p-6 relative">
                        <!-- Wave Effect Background -->
                        <div class="absolute inset-0 bg-gradient-to-br from-blue-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                        <!-- Content -->
                        <div class="relative">
                            <!-- Header with User Info & Status -->
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center space-x-3">
                                    <div class="relative">
                                        <div class="h-10 w-10 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white font-bold text-lg transform group-hover:scale-110 transition-transform duration-300">
                                            {{ strtoupper(substr($pengaduan->user->nama, 0, 1)) }}
                                        </div>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $pengaduan->user->nama }}</p>
                                        <p class="text-xs text-gray-500">{{ $pengaduan->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>

                                <!-- Status Badge -->
                                <div class="status-badge
                                    @switch($pengaduan->status)
                                        @case('pending') bg-yellow-100 text-yellow-800 @break
                                        @case('processing') bg-blue-100 text-blue-800 @break
                                        @case('completed') bg-green-100 text-green-800 @break
                                    @endswitch
                                    px-3 py-1 rounded-full text-xs font-medium group-hover:scale-105 transition-transform duration-300">
                                    <i class="fas fa-{{ $pengaduan->status === 'completed' ? 'check' : ($pengaduan->status === 'processing' ? 'spinner fa-spin' : 'clock') }} mr-1"></i>
                                    {{ ucfirst($pengaduan->status) }}
                                </div>
                            </div>

                            <!-- Title & Content -->
                            <h3 class="text-lg font-semibold text-gray-900 mb-2 group-hover:text-blue-600 transition-colors duration-200">
                                {{ $pengaduan->judul }}
                            </h3>
                            <p class="text-gray-600 text-sm mb-4 line-clamp-2 group-hover:line-clamp-none transition-all duration-300">
                                {{ $pengaduan->isi }}
                            </p>

                            <!-- Stats & Action -->
                            <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                                <div class="flex items-center space-x-4">
                                    <span class="stat-badge bg-green-50 text-green-700">
                                        <i class="fas fa-thumbs-up mr-1.5"></i>
                                        {{ $pengaduan->upvotes_count }}
                                    </span>
                                    <span class="stat-badge bg-red-50 text-red-700">
                                        <i class="fas fa-thumbs-down mr-1.5"></i>
                                        {{ $pengaduan->downvotes_count }}
                                    </span>
                                    <span class="stat-badge bg-blue-50 text-blue-700">
                                        <i class="fas fa-comments mr-1.5"></i>
                                        {{ $pengaduan->comments_count }}
                                    </span>
                                </div>

                                <a href="{{ route('pengaduan.show', $pengaduan) }}"
                                   class="inline-flex items-center text-blue-600 hover:text-blue-700 font-medium text-sm group">
                                    <span class="mr-2">Detail</span>
                                    <i class="fas fa-arrow-right transform group-hover:translate-x-2 transition-transform duration-300"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>


<style>
/* Floating Animation for Background Elements */
@for ($i = 1; $i <= 5; $i++)
    @keyframes float#{$i} {
        0%, 100% { transform: translate(0, 0) rotate(0deg); }
        25% { transform: translate({{ rand(-50, 50) }}px, {{ rand(-50, 50) }}px) rotate({{ rand(-15, 15) }}deg); }
        50% { transform: translate({{ rand(-50, 50) }}px, {{ rand(-50, 50) }}px) rotate({{ rand(-15, 15) }}deg); }
        75% { transform: translate({{ rand(-50, 50) }}px, {{ rand(-50, 50) }}px) rotate({{ rand(-15, 15) }}deg); }
    }
@endfor

/* Wave Animation */
.waves {
    position: relative;
    width: 100%;
    height: 15vh;
    margin-bottom: -7px;
    min-height: 100px;
    max-height: 150px;
}

.parallax > use {
    animation: move-forever 25s cubic-bezier(.55,.5,.45,.5) infinite;
}
.parallax > use:nth-child(1) { animation-delay: -2s; animation-duration: 7s; }
.parallax > use:nth-child(2) { animation-delay: -3s; animation-duration: 10s; }
.parallax > use:nth-child(3) { animation-delay: -4s; animation-duration: 13s; }
.parallax > use:nth-child(4) { animation-delay: -5s; animation-duration: 20s; }

@keyframes move-forever {
    0% { transform: translate3d(-90px,0,0); }
    100% { transform: translate3d(85px,0,0); }
}

@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.5; }
}

.animate-pulse {
    animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}

@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

.fa-spin {
    animation: spin 1s linear infinite;
}
</style>
@endsection
