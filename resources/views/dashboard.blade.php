@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Hero Section with Glass Effect -->
    <div class="relative bg-gradient-to-r from-blue-600 to-blue-800 rounded-2xl overflow-hidden mb-8 shadow-xl backdrop-blur-lg">
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

        <div class="relative px-6 py-12 sm:px-8 sm:py-16">
            <div class="text-white" data-aos="fade-up">
                <h1 class="text-3xl sm:text-4xl font-bold flex items-center">
                    <i class="fas fa-user-circle mr-3 text-blue-200"></i>
                    Selamat datang, {{ auth()->user()->name }}!
                </h1>
                <p class="mt-2 text-blue-100 text-lg">
                    Pantau dan kelola pengaduan Anda dengan mudah
                </p>
            </div>

            <!-- Quick Actions -->
            <div class="mt-8 flex flex-wrap gap-4" data-aos="fade-up" data-aos-delay="100">
                <a href="{{ route('pengaduan.create') }}"
                   class="group relative inline-flex items-center px-6 py-3 text-lg font-medium text-blue-600 bg-white rounded-xl shadow-lg hover:bg-blue-50 transform hover:-translate-y-1 transition-all duration-300">
                    <span class="absolute inset-0 w-full h-full mt-1 ml-1 transition-all duration-300 ease-in-out bg-blue-600 rounded-xl group-hover:mt-0 group-hover:ml-0"></span>
                    <span class="absolute inset-0 w-full h-full bg-white rounded-xl"></span>
                    <span class="relative flex items-center">
                        <i class="fas fa-plus mr-2 group-hover:scale-110 transition-transform duration-300"></i>
                        Buat Pengaduan
                    </span>
                </a>

                <a href="#pengaduan-list"
                   class="group relative inline-flex items-center px-6 py-3 text-lg font-medium text-white border-2 border-white/50 rounded-xl hover:bg-white/10 transform hover:-translate-y-1 transition-all duration-300">
                    <span class="relative flex items-center">
                        <i class="fas fa-list-alt mr-2 group-hover:scale-110 transition-transform duration-300"></i>
                        Lihat Pengaduan
                    </span>
                </a>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <!-- Total Pengaduan -->
        <div class="bg-white rounded-xl shadow-sm p-6 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1" data-aos="fade-up" data-aos-delay="0">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-full">
                    <i class="fas fa-file-alt text-blue-500 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-gray-500 text-sm">Total Pengaduan</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $totalPengaduan ?? 0 }}</h3>
                </div>
            </div>
        </div>

        <!-- Terkirim -->
        <div class="bg-white rounded-xl shadow-sm p-6 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1" data-aos="fade-up" data-aos-delay="100">
            <div class="flex items-center">
                <div class="p-3 bg-indigo-100 rounded-full">
                    <i class="fas fa-paper-plane text-indigo-500 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-gray-500 text-sm">Terkirim</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $terkirim ?? 0 }}</h3>
                </div>
            </div>
        </div>

        <!-- Diproses -->
        <div class="bg-white rounded-xl shadow-sm p-6 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1" data-aos="fade-up" data-aos-delay="200">
            <div class="flex items-center">
                <div class="p-3 bg-yellow-100 rounded-full">
                    <i class="fas fa-clock text-yellow-500 text-xl animate-spin-slow"></i>
                </div>
                <div class="ml-4">
                    <p class="text-gray-500 text-sm">Diproses</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $diproses ?? 0 }}</h3>
                </div>
            </div>
        </div>

        <!-- Selesai -->
        <div class="bg-white rounded-xl shadow-sm p-6 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1" data-aos="fade-up" data-aos-delay="300">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-full">
                    <i class="fas fa-check-circle text-green-500 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-gray-500 text-sm">Selesai</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $selesai ?? 0 }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Pengaduan List with Enhanced UI -->
    <div id="pengaduan-list" class="bg-white rounded-xl shadow-lg overflow-hidden" data-aos="fade-up" data-aos-delay="400">
        <div class="p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-6 flex items-center">
                <i class="fas fa-list-alt text-blue-500 mr-2"></i>
                Riwayat Pengaduan
            </h2>

            <!-- Filter and Search -->
            <div class="flex flex-wrap gap-4 mb-6">
                <div class="flex-1 min-w-[200px]">
                    <input type="text"
                           placeholder="Cari pengaduan..."
                           class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 transition-colors duration-200">
                </div>
                <select class="rounded-xl border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 transition-colors duration-200">
                    <option value="">Semua Status</option>
                    <option value="terkirim">Terkirim</option>
                    <option value="diproses">Diproses</option>
                    <option value="selesai">Selesai</option>
                </select>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider rounded-tl-lg">Tanggal</th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul</th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggapan</th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dukungan</th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider rounded-tr-lg">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($pengaduans as $pengaduan)
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $pengaduan->created_at->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $pengaduan->judul }}</div>
                                    <div class="text-sm text-gray-500">{{ Str::limit($pengaduan->isi, 50) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @switch($pengaduan->status)
                                        @case('terkirim')
                                            <span class="px-3 py-1 inline-flex items-center rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                <i class="fas fa-paper-plane mr-1"></i> Terkirim
                                            </span>
                                            @break
                                        @case('diproses')
                                            <span class="px-3 py-1 inline-flex items-center rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
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
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $pengaduan->tanggapans->count() }} tanggapan
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center text-sm text-gray-500">
                                        <span class="font-medium">{{ $pengaduan->upvotes()->count() }}</span>
                                        <i class="fas fa-thumbs-up text-blue-500 ml-1"></i>
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('pengaduan.show', $pengaduan->id) }}"
                                       class="inline-flex items-center text-blue-600 hover:text-blue-900 group">
                                        Detail
                                        <i class="fas fa-arrow-right ml-1 transform group-hover:translate-x-1 transition-transform duration-200"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <i class="fas fa-inbox text-gray-400 text-5xl mb-4"></i>
                                        <p class="text-gray-500 text-lg mb-4">Belum ada pengaduan</p>
                                        <a href="{{ route('pengaduan.create') }}"
                                           class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-colors duration-200">
                                            <i class="fas fa-plus mr-2"></i> Buat Pengaduan Baru
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Enhanced Pagination -->
            <div class="mt-6">
                {{ $pengaduans->links() }}
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

.animate-spin-slow {
    animation: spin 3s linear infinite;
}

@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}
</style>
@endsection
