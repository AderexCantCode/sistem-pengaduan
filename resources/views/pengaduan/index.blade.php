@extends('layouts.app')

@section('title', 'Daftar Pengaduan')

@section('content')
<div x-data="pengaduanData()">
    <!-- Hero Section with Animated Background -->
    <div class="relative bg-gradient-to-r from-blue-600 to-blue-800 overflow-hidden">
        <div class="absolute inset-0">
            <div class="absolute inset-0 bg-blue-600 mix-blend-multiply"></div>
            <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-blue-800 opacity-50"></div>
            <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23FFF' fill-opacity='0.1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 relative">
            <div class="text-center">
                <h1 class="text-4xl font-bold text-white mb-4" data-aos="fade-up">
                    Daftar Pengaduan Masyarakat
                </h1>
                <p class="text-xl text-blue-100 max-w-2xl mx-auto mb-8" data-aos="fade-up" data-aos-delay="100">
                    Temukan dan pantau pengaduan dari seluruh masyarakat
                </p>

                <!-- Search Bar with Animation -->
                <div class="max-w-3xl mx-auto" data-aos="fade-up" data-aos-delay="200">
                    <div class="relative">
                        <input type="text"
                               x-model="searchQuery"
                               placeholder="Cari pengaduan..."
                               class="w-full px-6 py-4 rounded-full border-2 border-white/30 bg-white/10 text-white placeholder-white/70 focus:outline-none focus:border-white/50 transition-all duration-300">
                        <button class="absolute right-4 top-1/2 transform -translate-y-1/2">
                            <i class="fas fa-search text-white/70"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enhanced Wave Effect -->
        <div class="absolute bottom-0 left-0 right-0">
            <svg class="waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                viewBox="24 24 150 28" preserveAspectRatio="none" shape-rendering="auto">
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


    <!-- Stats Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-8 relative z-10">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4" data-aos="fade-up">
            <!-- Total Pengaduan -->
            <div class="bg-white rounded-xl shadow-lg p-6 transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Pengaduan</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['total_pengaduan'] }}</p>
                    </div>
                    <div class="bg-blue-100 p-3 rounded-full">
                        <i class="fas fa-file-alt text-blue-600 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex space-x-4 text-sm">
                    <span class="text-yellow-600">
                        <i class="fas fa-paper-plane mr-1"></i>{{ $stats['terkirim_count'] }} Terkirim
                    </span>
                    <span class="text-blue-600">
                        <i class="fas fa-cog mr-1"></i>{{ $stats['diproses_count'] }} Diproses
                    </span>
                    <span class="text-green-600">
                        <i class="fas fa-check-circle mr-1"></i>{{ $stats['selesai_count'] }} Selesai
                    </span>
                </div>
            </div>

            <!-- Total Upvotes -->
            <div class="bg-white rounded-xl shadow-lg p-6 transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Upvotes</p>
                        <p class="text-2xl font-bold text-green-600">{{ $stats['total_upvotes'] }}</p>
                    </div>
                    <div class="bg-green-100 p-3 rounded-full">
                        <i class="fas fa-thumbs-up text-green-600 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 text-sm text-gray-500">
                    <i class="fas fa-chart-line mr-1"></i>
                    {{ number_format(($stats['total_pengaduan'] > 0 ? $stats['total_upvotes'] / $stats['total_pengaduan'] : 0) * 100, 1) }}% ratio
                </div>
            </div>

            <!-- Total Downvotes -->
            <div class="bg-white rounded-xl shadow-lg p-6 transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Downvotes</p>
                        <p class="text-2xl font-bold text-red-600">{{ $stats['total_downvotes'] }}</p>
                    </div>
                    <div class="bg-red-100 p-3 rounded-full">
                        <i class="fas fa-thumbs-down text-red-600 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 text-sm text-gray-500">
                    <i class="fas fa-chart-line mr-1"></i>
                    {{ number_format(($stats['total_pengaduan'] > 0 ? $stats['total_downvotes'] / $stats['total_pengaduan'] : 0) * 100, 1) }}% ratio
                </div>
            </div>

            <!-- Total Comments -->
            <div class="bg-white rounded-xl shadow-lg p-6 transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Komentar</p>
                        <p class="text-2xl font-bold text-purple-600">{{ $stats['total_comments'] }}</p>
                    </div>
                    <div class="bg-purple-100 p-3 rounded-full">
                        <i class="fas fa-comments text-purple-600 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 text-sm text-gray-500">
                    <i class="fas fa-calculator mr-1"></i>
                    {{ number_format(($stats['total_pengaduan'] > 0 ? $stats['total_comments'] / $stats['total_pengaduan'] : 0), 1) }} per pengaduan
                </div>
            </div>
        </div>
    </div>

    <!-- Category Filter Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-8 relative z-10">
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Category Filter -->
                <div class="relative">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-folder mr-2"></i>Kategori
                    </label>
                    <select x-model="selectedCategory"
                            class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200">
                        <option value="">📁 Semua Kategori</option>
                        <template x-for="kategori in kategoris" :key="kategori.id">
                            <option :value="kategori.id" x-text="kategori.nama_kategori"></option>
                        </template>
                    </select>
                </div>

                <!-- Status Filter -->
                <div class="relative">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-filter mr-2"></i>Status
                    </label>
                    <select x-model="selectedStatus"
                            class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200">
                        <option value="">🔄 Semua Status</option>
                        <option value="terkirim">📤 Terkirim</option>
                        <option value="diproses">⚙️ Diproses</option>
                        <option value="selesai">✅ Selesai</option>
                    </select>
                </div>
            </div>

            <!-- Active Filters -->
            <div class="mt-4 flex flex-wrap gap-2" x-show="selectedCategory || selectedStatus">
                <!-- Category Filter Tag -->
                <div x-show="selectedCategory"
                     class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-blue-50 text-blue-700">
                    <span>Kategori: </span>
                    <span x-text="kategoris.find(k => k.id == selectedCategory)?.nama_kategori" class="ml-1 font-medium"></span>
                    <button @click="selectedCategory = ''"
                            class="ml-2 hover:text-blue-800">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <!-- Status Filter Tag -->
                <div x-show="selectedStatus"
                     class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-blue-50 text-blue-700">
                    <span>Status: </span>
                    <span x-text="capitalizeFirst(selectedStatus)" class="ml-1 font-medium"></span>
                    <button @click="selectedStatus = ''"
                            class="ml-2 hover:text-blue-800">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Pengaduan Grid -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3" x-show="filteredPengaduans().length > 0">
            <template x-for="pengaduan in filteredPengaduans()" :key="pengaduan.id">
                <div class="group bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2"
                     :class="{ 'animate-pulse': pengaduan.status === 'processing' }"
                     data-aos="fade-up">
                    <div class="p-6 relative">
                        <!-- Wave Effect Background -->
                        <div class="absolute inset-0 bg-gradient-to-br from-blue-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                        <div class="relative">
                            <!-- Header with User Info & Status -->
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center space-x-3">
                                    <div class="relative">
                                        <div class="h-10 w-10 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white font-bold text-lg transform group-hover:scale-110 transition-transform duration-300"
                                             x-text="pengaduan.user.nama.charAt(0).toUpperCase()">
                                        </div>
                                        <div class="absolute -bottom-1 -right-1 h-4 w-4 bg-green-400 rounded-full border-2 border-white"></div>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900 group-hover:text-blue-600 transition-colors duration-200"
                                           x-text="pengaduan.user.nama"></p>
                                        <p class="text-xs text-gray-500 flex items-center">
                                            <i class="far fa-clock mr-1 group-hover:scale-110 transition-transform duration-200"></i>
                                            <span x-text="formatDate(pengaduan.created_at)"></span>
                                        </p>
                                    </div>
                                </div>

                                <!-- Enhanced Status Badge -->
                                <div :class="{
                                    'inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium transition-all duration-300': true,
                                    'bg-yellow-100 text-yellow-800 group-hover:bg-yellow-200': pengaduan.status === 'terkirim',
                                    'bg-blue-100 text-blue-800 group-hover:bg-blue-200': pengaduan.status === 'diproses',
                                    'bg-green-100 text-green-800 group-hover:bg-green-200': pengaduan.status === 'selesai'
                                }">
                                    <i :class="{
                                        'mr-1.5': true,
                                        'fas fa-paper-plane animate-pulse': pengaduan.status === 'terkirim',
                                        'fas fa-cog fa-spin': pengaduan.status === 'diproses',
                                        'fas fa-check-circle': pengaduan.status === 'selesai'
                                    }"></i>
                                    <span x-text="capitalizeFirst(pengaduan.status)"></span>
                                </div>
                            </div>

                            <!-- Enhanced Content -->
                            <div class="mb-4">
                                <h3 class="text-lg font-semibold text-gray-900 mb-2 group-hover:text-blue-600 transition-colors duration-200 line-clamp-2"
                                    x-text="pengaduan.judul"></h3>
                                <div class="relative">
                                    <p class="text-gray-600 text-sm line-clamp-3 group-hover:line-clamp-none transition-all duration-300"
                                       x-text="pengaduan.isi"></p>
                                    <div class="absolute bottom-0 left-0 right-0 h-8 bg-gradient-to-t from-white group-hover:opacity-0 transition-opacity duration-300"></div>
                                </div>
                            </div>

                            <!-- Category Tag -->
                            <div class="mb-4">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700 group-hover:bg-blue-100 transition-colors duration-200">
                                    <i class="fas fa-folder mr-1.5"></i>
                                    <span x-text="pengaduan.kategori.nama_kategori"></span>
                                </span>
                            </div>

                            <!-- Interactive Stats Bar -->
                            <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                                <div class="flex items-center space-x-2">
                                    <!-- Upvotes -->
                                    <button class="stats-button bg-green-50 text-green-700 hover:bg-green-100"
                                            :class="{ 'ring-2 ring-green-500 ring-offset-2': pengaduan.user_vote === 'upvote' }">
                                        <i class="fas fa-thumbs-up mr-1.5 transform group-hover:scale-110 transition-transform duration-200"></i>
                                        <span x-text="pengaduan.upvotes_count || 0"></span>
                                    </button>

                                    <!-- Downvotes -->
                                    <button class="stats-button bg-red-50 text-red-700 hover:bg-red-100"
                                            :class="{ 'ring-2 ring-red-500 ring-offset-2': pengaduan.user_vote === 'downvote' }">
                                        <i class="fas fa-thumbs-down mr-1.5 transform group-hover:scale-110 transition-transform duration-200"></i>
                                        <span x-text="pengaduan.downvotes_count || 0"></span>
                                    </button>

                                    <!-- Comments -->
                                    <span class="stats-button bg-blue-50 text-blue-700">
                                        <i class="fas fa-comments mr-1.5 transform group-hover:scale-110 transition-transform duration-200"></i>
                                        <span x-text="pengaduan.comments_count || 0"></span>
                                    </span>
                                </div>

                                <!-- Enhanced Detail Link -->
                                <a :href="'/pengaduan/' + pengaduan.id"
                                   class="inline-flex items-center px-4 py-2 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 transition-all duration-300 group">
                                    <span class="mr-2">Detail</span>
                                    <i class="fas fa-arrow-right transform group-hover:translate-x-2 transition-transform duration-300"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>

    <!-- Enhanced Empty State -->
    <template x-if="filteredPengaduans().length === 0">
        <div class="text-center py-16 px-4" data-aos="fade-up">
            <div class="text-gray-400 mb-6 transform hover:scale-110 transition-transform duration-300">
                <i class="fas fa-inbox text-8xl"></i>
            </div>
            <h3 class="text-2xl font-medium text-gray-900 mb-3">Tidak ada pengaduan ditemukan</h3>
            <p class="text-gray-500 mb-8">Coba ubah filter atau buat pengaduan baru</p>
            <a href="{{ route('pengaduan.create') }}"
               class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transform hover:-translate-y-1 transition-all duration-300">
                <i class="fas fa-plus mr-2"></i> Buat Pengaduan
            </a>
        </div>
    </template>
</div>


<!-- Scripts Section -->
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script>
    moment.locale('id');

    document.addEventListener('alpine:init', () => {
        Alpine.data('pengaduanData', () => ({
            searchQuery: '',
            selectedCategory: '',
            selectedStatus: '',
            pengaduans: @json($pengaduans),
            kategoris: @json($kategoris), // Add this line

            formatDate(date) {
                return moment(date).fromNow();
            },

            capitalizeFirst(string) {
                return string.charAt(0).toUpperCase() + string.slice(1);
            },

            filteredPengaduans() {
                return this.pengaduans.filter(p => {
                    const matchesSearch = this.searchQuery === '' ||
                        p.judul.toLowerCase().includes(this.searchQuery.toLowerCase());
                    const matchesCategory = this.selectedCategory === '' ||
                        p.kategori_id.toString() === this.selectedCategory;
                    const matchesStatus = this.selectedStatus === '' ||
                        p.status === this.selectedStatus;
                    return matchesSearch && matchesCategory && matchesStatus;
                });
            }
        }));
    });
</script>
@endpush

<style>
.waves {
    position: relative;
    width: 100%;
    height: 28px;
    margin-bottom: -7px;
    min-height: 28px;
    max-height: 28px;
}
.parallax > use {
    animation: move-forever 25s cubic-bezier(.55,.5,.45,.5) infinite;
}
.parallax > use:nth-child(1) {
    animation-delay: -2s;
    animation-duration: 7s;
}
.parallax > use:nth-child(2) {
    animation-delay: -3s;
    animation-duration: 10s;
}
.parallax > use:nth-child(3) {
    animation-delay: -4s;
    animation-duration: 13s;
}
.parallax > use:nth-child(4) {
    animation-delay: -5s;
    animation-duration: 20s;
}
@keyframes move-forever {
    0% { transform: translate3d(-90px,0,0); }
    100% { transform: translate3d(85px,0,0); }
}

.stats-button {
    @apply inline-flex items-center px-2.5 py-1.5 rounded-md text-sm font-medium transition-all duration-200;
}

.stats-button:hover {
    @apply transform scale-105;
}

.stats-button i {
    @apply transition-transform duration-200;
}

.stats-button:hover i {
    @apply scale-110;
}

/* Gradient overlay for text */
.text-gradient {
    background: linear-gradient(to right, #1d4ed8, #3b82f6);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

/* Card hover effect */
.card-hover {
    transition: all 0.3s ease;
}

.card-hover:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
}
</style>
@endsection
