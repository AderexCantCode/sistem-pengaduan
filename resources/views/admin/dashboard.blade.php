@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Hero Section -->
    <div class="relative bg-gradient-to-r from-blue-600 to-blue-800 pb-32 overflow-hidden">
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            @for ($i = 1; $i <= 3; $i++)
                <div class="absolute rounded-full mix-blend-multiply filter blur-xl opacity-70"
                     style="
                        background: #60A5FA;
                        width: {{ rand(200, 300) }}px;
                        height: {{ rand(200, 300) }}px;
                        left: {{ rand(-20, 120) }}%;
                        top: {{ rand(-20, 120) }}%;
                        animation: float{{ $i }} {{ rand(10, 20) }}s infinite ease-in-out;">
                </div>
            @endfor
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="relative">
                <h1 class="text-3xl font-bold text-white mb-2" data-aos="fade-right">
                    Selamat Datang, Admin!
                </h1>
                <p class="text-blue-100 max-w-2xl" data-aos="fade-right" data-aos-delay="100">
                    Monitor dan kelola semua pengaduan masyarakat dari dashboard ini.
                </p>
            </div>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-24 relative z-10">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <!-- Total Users Card -->
            <div class="bg-white rounded-xl shadow-lg p-6 transform hover:scale-105 transition-all duration-300"
                 data-aos="fade-up" data-aos-delay="100">
                <div class="flex items-center">
                    <div class="p-4 bg-gradient-to-br from-blue-400 to-blue-600 rounded-xl shadow-blue-400/20 shadow-lg">
                        <i class="fas fa-users text-white text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-gray-500 text-sm font-medium">Total Users</p>
                        <h3 class="text-2xl font-bold text-gray-800">
                            <span class="counter">{{ $totalUsers }}</span>
                        </h3>
                    </div>
                </div>
            </div>

            <!-- Terkirim Card -->
            <div class="bg-white rounded-xl shadow-lg p-6 transform hover:scale-105 transition-all duration-300"
                 data-aos="fade-up" data-aos-delay="200">
                <div class="flex items-center">
                    <div class="p-4 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-xl shadow-yellow-400/20 shadow-lg">
                        <i class="fas fa-paper-plane text-white text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-gray-500 text-sm font-medium">Terkirim</p>
                        <h3 class="text-2xl font-bold text-gray-800">
                            <span class="counter">{{ $terkirim }}</span>
                        </h3>
                    </div>
                </div>
            </div>

            <!-- Diproses Card -->
            <div class="bg-white rounded-xl shadow-lg p-6 transform hover:scale-105 transition-all duration-300"
                 data-aos="fade-up" data-aos-delay="300">
                <div class="flex items-center">
                    <div class="p-4 bg-gradient-to-br from-blue-400 to-blue-600 rounded-xl shadow-blue-400/20 shadow-lg">
                        <i class="fas fa-spinner fa-spin text-white text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-gray-500 text-sm font-medium">Diproses</p>
                        <h3 class="text-2xl font-bold text-gray-800">
                            <span class="counter">{{ $diproses }}</span>
                        </h3>
                    </div>
                </div>
            </div>

            <!-- Selesai Card -->
            <div class="bg-white rounded-xl shadow-lg p-6 transform hover:scale-105 transition-all duration-300"
                 data-aos="fade-up" data-aos-delay="400">
                <div class="flex items-center">
                    <div class="p-4 bg-gradient-to-br from-green-400 to-green-600 rounded-xl shadow-green-400/20 shadow-lg">
                        <i class="fas fa-check-circle text-white text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-gray-500 text-sm font-medium">Selesai</p>
                        <h3 class="text-2xl font-bold text-gray-800">
                            <span class="counter">{{ $selesai }}</span>
                        </h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pengaduan Table Card -->
        <div class="bg-white rounded-xl shadow-lg mb-8" data-aos="fade-up" data-aos-delay="500">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold text-gray-800">Daftar Pengaduan</h2>
                    <form method="GET" class="flex items-center space-x-2">
                        <div class="relative">
                            <input type="text"
                                   name="search"
                                   value="{{ request('search') }}"
                                   placeholder="Cari pengaduan..."
                                   class="pl-10 pr-4 py-2 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all duration-200">
                            <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div>
                        <select name="status"
                                onchange="this.form.submit()"
                                class="border-2 border-gray-200 rounded-xl px-4 py-2 focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all duration-200">
                            <option value="">Semua Status</option>
                            <option value="terkirim" {{ request('status') == 'terkirim' ? 'selected' : '' }}>Terkirim</option>
                            <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
                            <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                        <button type="submit" class="hidden"></button>
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider rounded-tl-xl">
                                    Tanggal
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Pelapor
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Judul
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider rounded-tr-xl">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($pengaduans as $pengaduan)
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $pengaduan->created_at->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <img class="h-10 w-10 rounded-full ring-2 ring-gray-200"
                                                 src="https://ui-avatars.com/api/?name={{ urlencode($pengaduan->user->name) }}&background=random"
                                                 alt="{{ $pengaduan->user->name }}">
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $pengaduan->user->name }}
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    {{ $pengaduan->user->email }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $pengaduan->judul }}</div>
                                        <div class="text-sm text-gray-500">{{ Str::limit($pengaduan->isi, 50) }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @switch($pengaduan->status)
                                            @case('terkirim')
                                                <span class="px-3 py-1 inline-flex items-center rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                    <i class="fas fa-paper-plane mr-1"></i> Terkirim
                                                </span>
                                                @break
                                            @case('diproses')
                                                <span class="px-3 py-1 inline-flex items-center rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    <i class="fas fa-spinner fa-spin mr-1"></i> Diproses
                                                </span>
                                                @break
                                            @case('selesai')
                                                <span class="px-3 py-1 inline-flex items-center rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    <i class="fas fa-check-circle mr-1"></i> Selesai
                                                </span>
                                                @break
                                        @endswitch
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('admin.pengaduan.show', $pengaduan->id) }}"
                                           class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-700 rounded-xl hover:bg-blue-200 transition-colors duration-200">
                                            <i class="fas fa-reply mr-2"></i>
                                            Tanggapi
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-10 text-center">
                                        <div class="flex flex-col items-center">
                                            <div class="bg-gray-100 rounded-full p-3 mb-4">
                                                <i class="fas fa-inbox text-4xl text-gray-400"></i>
                                            </div>
                                            <p class="text-gray-500 text-lg">Tidak ada pengaduan</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $pengaduans->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@keyframes float1 {
    0%, 100% { transform: translate(0, 0) rotate(0deg); }
    50% { transform: translate(20px, -20px) rotate(5deg); }
}
@keyframes float2 {
    0%, 100% { transform: translate(0, 0) rotate(0deg); }
    50% { transform: translate(-20px, 20px) rotate(-5deg); }
}
@keyframes float3 {
    0%, 100% { transform: translate(0, 0) rotate(0deg); }
    50% { transform: translate(15px, 15px) rotate(3deg); }
}

.counter {
    display: inline-block;
    animation: countUp 2s ease-out forwards;
}

@keyframes countUp {
    from {
        transform: translateY(20px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Counter animation
    const counters = document.querySelectorAll('.counter');
    counters.forEach(counter => {
        const target = parseInt(counter.innerText);
        let count = 0;
        const duration = 2000; // 2 seconds
        const increment = target / (duration / 16); // 60fps

        const timer = setInterval(() => {
            count += increment;
            if (count >= target) {
                counter.innerText = target;
                clearInterval(timer);
            } else {
                counter.innerText = Math.floor(count);
            }
        }, 16);
    });
});
</script>
@endpush
@endsection
