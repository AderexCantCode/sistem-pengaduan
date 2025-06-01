@extends('layouts.app')

@section('title', 'Detail Pengaduan')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Hero Section -->
    <div class="relative bg-gradient-to-r from-blue-600 to-blue-800 pb-32 overflow-hidden">
        <!-- Animated Background Particles -->
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

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <a href="{{ route('admin.dashboard') }}"
               class="inline-flex items-center text-blue-100 hover:text-white transition-colors duration-200">
                <i class="fas fa-arrow-left mr-2"></i> Kembali ke Dashboard
            </a>
            <div class="mt-4" data-aos="fade-up">
                <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-blue-100 text-blue-800 mb-4">
                    {{ $pengaduan->kategori->nama_kategori ?? 'Uncategorized' }}
                </span>
                <h1 class="text-3xl font-bold text-white mb-4">{{ $pengaduan->judul }}</h1>
                <div class="flex items-center text-blue-100 text-sm space-x-4">
                    <div class="flex items-center">
                        <img class="h-8 w-8 rounded-full ring-2 ring-white"
                             src="https://ui-avatars.com/api/?name={{ urlencode($pengaduan->user->name) }}&background=random"
                             alt="{{ $pengaduan->user->name }}">
                        <span class="ml-2">{{ $pengaduan->user->name }}</span>
                    </div>
                    <span>•</span>
                    <span>{{ $pengaduan->created_at->format('d M Y H:i') }}</span>
                </div>
            </div>
        </div>

        <!-- Wave Effect -->
        <div class="absolute bottom-0 left-0 right-0">
            <svg class="waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                 viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto">
                <defs>
                    <path id="gentle-wave" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z" />
                </defs>
                <g class="parallax">
                    <use xlink:href="#gentle-wave" x="48" y="0" fill="rgba(249, 250, 251, 0.7)" />
                    <use xlink:href="#gentle-wave" x="48" y="3" fill="rgba(249, 250, 251, 0.5)" />
                    <use xlink:href="#gentle-wave" x="48" y="5" fill="rgba(249, 250, 251, 0.3)" />
                    <use xlink:href="#gentle-wave" x="48" y="7" fill="#f9fafb" />
                </g>
            </svg>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 -mt-8 relative z-10">
        <!-- Main Content Card -->
        <div class="bg-white rounded-xl shadow-xl p-6 mb-8" data-aos="fade-up">
            <!-- Status Badge -->
            <div class="flex justify-between items-center mb-6">
                <div class="flex items-center space-x-2">
                    @switch($pengaduan->status)
                        @case('pending')
                            <span class="px-4 py-2 rounded-full bg-yellow-100 text-yellow-800">
                                <i class="fas fa-clock mr-2"></i> Pending
                            </span>
                            @break
                        @case('proses')
                            <span class="px-4 py-2 rounded-full bg-blue-100 text-blue-800">
                                <i class="fas fa-spinner fa-spin mr-2"></i> Diproses
                            </span>
                            @break
                        @case('selesai')
                            <span class="px-4 py-2 rounded-full bg-green-100 text-green-800">
                                <i class="fas fa-check-circle mr-2"></i> Selesai
                            </span>
                            @break
                    @endswitch
                </div>
                <div class="flex items-center space-x-4">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-blue-100 text-blue-800">
                        <i class="fas fa-thumbs-up mr-1"></i>
                        {{ $pengaduan->upvotes_count ?? 0 }}
                    </span>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-red-100 text-red-800">
                        <i class="fas fa-thumbs-down mr-1"></i>
                        {{ $pengaduan->downvotes_count ?? 0 }}
                    </span>
                </div>
            </div>

            <!-- Content -->
            <div class="prose max-w-none mb-8">
                <p class="text-gray-700 leading-relaxed">{{ $pengaduan->isi }}</p>
            </div>

            <!-- Attachments -->
            @if($pengaduan->gambar)
                <div class="mb-8">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4">Lampiran</h4>
                    <div class="group relative rounded-xl overflow-hidden bg-gray-50">
                        <img src="{{ asset($pengaduan->gambar) }}"
                             alt="Lampiran Pengaduan"
                             class="w-full rounded-lg max-h-96 object-cover transform group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </div>
                </div>
            @endif

            <!-- Tanggapan Form -->
            <div class="border-t pt-6">
                <h3 class="text-xl font-bold text-gray-900 mb-6">Berikan Tanggapan</h3>

                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-lg flex items-center">
                        <i class="fas fa-check-circle mr-2"></i>
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('admin.pengaduan.tanggapi', $pengaduan->id) }}" method="POST"
                      class="space-y-6">
                    @csrf
                    <div class="mb-6">
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                            Update Status
                        </label>
                        <select name="status" id="status" class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 transition-colors duration-200">
                            <option value="terkirim" {{ $pengaduan->status == 'terkirim' ? 'selected' : '' }}>
                                Terkirim
                            </option>
                            <option value="diproses" {{ $pengaduan->status == 'diproses' ? 'selected' : '' }}>
                                Sedang Diproses
                            </option>
                            <option value="selesai" {{ $pengaduan->status == 'selesai' ? 'selected' : '' }}>
                                Selesai
                            </option>
                        </select>
                    </div>

                    <div>
                        <label for="tanggapan" class="block text-sm font-medium text-gray-700 mb-2">
                            Tanggapan
                        </label>
                        <textarea name="tanggapan" id="tanggapan" rows="4"
                                  class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 transition-colors duration-200"
                                  placeholder="Tulis tanggapan Anda..."
                                  required>{{ old('tanggapan') }}</textarea>
                    </div>

                    <button type="submit"
                            class="w-full bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-3 rounded-xl hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-all duration-200 flex items-center justify-center">
                        <i class="fas fa-paper-plane mr-2"></i>
                        Kirim Tanggapan
                    </button>
                </form>
            </div>

            <!-- Previous Tanggapan -->
            @if($pengaduan->tanggapans->count() > 0)
                <div class="border-t mt-8 pt-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">Riwayat Tanggapan</h3>
                    <div class="space-y-4">
                        @foreach($pengaduan->tanggapans as $tanggapan)
                            <div class="bg-gray-50 rounded-xl p-6 hover:bg-gray-100 transition-all duration-200"
                                 data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex items-center space-x-3">
                                        <img class="h-10 w-10 rounded-full ring-2 ring-gray-200"
                                             src="https://ui-avatars.com/api/?name={{ urlencode($tanggapan->admin->name) }}&background=random"
                                             alt="{{ $tanggapan->admin->name }}">
                                        <div>
                                            <div class="font-medium text-gray-900">{{ $tanggapan->admin->name }}</div>
                                            <div class="text-sm text-gray-500">Admin</div>
                                        </div>
                                    </div>
                                    <span class="text-sm text-gray-500">
                                        {{ $tanggapan->created_at->format('d M Y H:i') }}
                                    </span>
                                </div>
                                <p class="text-gray-700">{{ $tanggapan->isi_tanggapan }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
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
</style>
@endsection
