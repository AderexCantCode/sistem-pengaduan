@extends('layouts.app')

@section('title', $pengaduan->judul)

@section('content')
<div class="min-h-screen bg-gray-50 pt-16"> <!-- Added pt-16 for navbar spacing -->
    <!-- Hero Section with Enhanced Styling -->
    <div class="relative bg-gradient-to-r from-blue-600 to-blue-800 overflow-hidden">
        <!-- Improved Background Particles -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            @for ($i = 1; $i <= 5; $i++)
                <div class="particle absolute rounded-full mix-blend-multiply filter blur-xl opacity-70"
                     style="
                        background: linear-gradient(45deg, #60A5FA, #3B82F6);
                        width: {{ rand(100, 300) }}px;
                        height: {{ rand(100, 300) }}px;
                        left: {{ rand(-20, 120) }}%;
                        top: {{ rand(-20, 120) }}%;
                        animation: float{{ $i }} {{ rand(15, 30) }}s infinite ease-in-out;">
                </div>
            @endfor
        </div>

        <!-- Enhanced Content Container -->
        <div class="relative max-w-4xl mx-auto px-4 py-16">
            <!-- Back Button with Enhanced Styling -->
            <a href="{{ route('dashboard') }}"
               class="group inline-flex items-center space-x-2 text-blue-100 hover:text-white transition-all duration-300">
                <span class="bg-white/10 rounded-full p-2 group-hover:bg-white/20 transition-all duration-300">
                    <i class="fas fa-arrow-left"></i>
                </span>
                <span class="font-medium">Kembali ke Dashboard</span>
            </a>

            <!-- Main Content with Enhanced Animation -->
            <div class="mt-8" data-aos="fade-up" data-aos-duration="1000">
                <!-- Category Badge -->
                <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-blue-100 text-blue-800 mb-4 transform hover:scale-105 transition-all duration-300">
                    <i class="fas fa-folder mr-2"></i>
                    {{ $pengaduan->kategori->nama_kategori }}
                </span>

                <!-- Title with Gradient -->
                <h1 class="text-4xl font-bold text-white mb-6 leading-tight">
                    {{ $pengaduan->judul }}
                </h1>

                <!-- User Info with Enhanced Design -->
                <div class="flex items-center text-blue-100 space-x-6">
                    <div class="flex items-center space-x-3">
                        <div class="relative">
                            <img class="h-12 w-12 rounded-full ring-2 ring-blue-500 ring-offset-2 transform hover:scale-110 transition-all duration-300"
                                 src="https://ui-avatars.com/api/?name={{ urlencode($pengaduan->user->nama) }}&background=random"
                                 alt="{{ $pengaduan->user->nama }}">
                            <div class="absolute -bottom-1 -right-1 h-4 w-4 bg-green-400 rounded-full border-2 border-white"></div>
                        </div>
                        <div>
                            <p class="font-medium text-white">{{ $pengaduan->user->nama }}</p>
                            <p class="text-sm text-blue-200">
                                <i class="far fa-clock mr-1"></i>
                                {{ $pengaduan->created_at->format('d M Y H:i') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enhanced Wave Effect -->
        <div class="absolute bottom-0 left-0 right-0 overflow-hidden">
            <svg class="waves relative w-full h-[50px] md:h-[100px]"
                 xmlns="http://www.w3.org/2000/svg"
                 viewBox="0 24 150 28"
                 preserveAspectRatio="none">
                <defs>
                    <path id="wave"
                          d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z" />
                </defs>
                <g class="parallax">
                    <use href="#wave" x="48" y="0" fill="rgba(249, 250, 251, 0.7)" />
                    <use href="#wave" x="48" y="3" fill="rgba(249, 250, 251, 0.5)" />
                    <use href="#wave" x="48" y="5" fill="rgba(249, 250, 251, 0.3)" />
                    <use href="#wave" x="48" y="7" fill="#f9fafb" />
                </g>
            </svg>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 -mt-8 relative z-10">
        <!-- Enhanced Main Content Card -->
        <div class="bg-white/80 backdrop-blur-xl rounded-2xl shadow-xl p-8 mb-8 transform hover:scale-[1.02] transition-all duration-500"
             data-aos="fade-up"
             data-aos-duration="1000">
            <!-- Replace the Status and Vote Section -->
            <div class="flex flex-wrap items-center justify-between gap-4 mb-8">
                <div class="flex items-center space-x-4">
                    <!-- Status Badge -->
                    @switch($pengaduan->status)
                        @case('terkirim')
                            <div class="relative group">
                                <div class="absolute inset-0 bg-yellow-200 rounded-full blur-md opacity-50 group-hover:opacity-75 transition-opacity duration-300"></div>
                                <span class="relative inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                    <i class="fas fa-paper-plane mr-2 animate-bounce"></i>
                                    Terkirim
                                </span>
                            </div>
                            @break
                        @case('diproses')
                            <div class="relative group">
                                <div class="absolute inset-0 bg-blue-200 rounded-full blur-md opacity-50 group-hover:opacity-75 transition-opacity duration-300"></div>
                                <span class="relative inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                    <i class="fas fa-spinner fa-spin mr-2"></i>
                                    Sedang Diproses
                                </span>
                            </div>
                            @break
                        @case('selesai')
                            <div class="relative group">
                                <div class="absolute inset-0 bg-green-200 rounded-full blur-md opacity-50 group-hover:opacity-75 transition-opacity duration-300"></div>
                                <span class="relative inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-2"></i>
                                    Selesai
                                </span>
                            </div>
                            @break
                    @endswitch

                    <!-- Latest Admin Response -->
                    @if($pengaduan->tanggapans->count() > 0)
                        <div class="relative group">
                            <div class="absolute inset-0 bg-indigo-200 rounded-full blur-md opacity-50 group-hover:opacity-75 transition-opacity duration-300"></div>
                            <div class="relative inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-indigo-50 text-indigo-800">
                                <i class="fas fa-comment-dots mr-2"></i>
                                <span class="truncate max-w-[200px]">
                                    {{ Str::limit($pengaduan->tanggapans->last()->isi_tanggapan, 30) }}
                                </span>
                                <div class="absolute invisible group-hover:visible w-80 bg-white p-4 rounded-xl shadow-xl top-full left-0 mt-2 z-10">
                                    <div class="flex items-center space-x-2 mb-2">
                                        <img class="h-6 w-6 rounded-full"
                                             src="https://ui-avatars.com/api/?name={{ urlencode($pengaduan->tanggapans->last()->admin->name) }}&background=random"
                                             alt="{{ $pengaduan->tanggapans->last()->admin->name }}">
                                        <span class="font-medium text-gray-900">{{ $pengaduan->tanggapans->last()->admin->name }}</span>
                                        <span class="text-sm text-gray-500">
                                            {{ $pengaduan->tanggapans->last()->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                    <p class="text-gray-700">{{ $pengaduan->tanggapans->last()->isi_tanggapan }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Enhanced Vote Buttons -->
                <div class="flex items-center gap-3" id="voteContainer" data-pengaduan-id="{{ $pengaduan->id }}">
                    @auth
                        <div class="flex items-center bg-white/50 backdrop-blur rounded-full p-1.5 shadow-lg hover:shadow-xl transition-all duration-500">
                            @php
                                $userVote = $pengaduan->votes->where('user_id', auth()->id())->first();
                                $isUpvoted = $userVote && $userVote->type === 'upvote';
                                $isDownvoted = $userVote && $userVote->type === 'downvote';
                            @endphp

                            <button type="button"
                                    id="upvoteBtn"
                                    data-voted="{{ $isUpvoted ? 'true' : 'false' }}"
                                    class="group inline-flex items-center px-4 py-2 rounded-full text-sm font-medium transition-all duration-300
                                        {{ $isUpvoted ? 'bg-green-500 text-white' : 'hover:bg-green-50' }}">
                                <i class="fas fa-thumbs-up mr-2 transform group-hover:scale-125 transition-transform duration-300
                                    {{ $isUpvoted ? 'text-white' : 'text-green-500' }}"></i>
                                <span id="upvoteCount" class="min-w-[20px] text-center">
                                    {{ $pengaduan->votes->where('type', 'upvote')->count() }}
                                </span>
                            </button>

                            <div class="h-6 w-px bg-gray-200 mx-1"></div>

                            <button type="button"
                                    id="downvoteBtn"
                                    data-voted="{{ $isDownvoted ? 'true' : 'false' }}"
                                    class="group inline-flex items-center px-4 py-2 rounded-full text-sm font-medium transition-all duration-300
                                        {{ $isDownvoted ? 'bg-red-500 text-white' : 'hover:bg-red-50' }}">
                                <i class="fas fa-thumbs-down mr-2 transform group-hover:scale-125 transition-transform duration-300
                                    {{ $isDownvoted ? 'text-white' : 'text-red-500' }}"></i>
                                <span id="downvoteCount" class="min-w-[20px] text-center">
                                    {{ $pengaduan->votes->where('type', 'downvote')->count() }}
                                </span>
                            </button>
                        </div>

                        <!-- Vote Status Indicator -->
                        <div id="voteStatus" class="hidden items-center text-sm text-gray-500 animate-fade-in">
                            <i class="fas fa-circle-notch fa-spin mr-2"></i>
                            <span>Memproses...</span>
                        </div>
                    @else
                        <a href="{{ route('login') }}"
                           class="group relative inline-flex items-center px-6 py-3 rounded-full overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-r from-blue-500 to-indigo-500 opacity-10 group-hover:opacity-20 transition-opacity duration-300"></div>
                            <i class="fas fa-lock mr-2 group-hover:rotate-12 transition-transform duration-300"></i>
                            <span>Login untuk vote</span>
                        </a>
                    @endauth
                </div>
            </div>

            <!-- Enhanced Content -->
            <div class="prose prose-lg max-w-none mb-8">
                <p class="text-gray-700 leading-relaxed text-lg">{{ $pengaduan->isi }}</p>
            </div>

            <!-- Enhanced Image Display -->
            @if($pengaduan->gambar)
                <div class="mt-8 space-y-4">
                    <h4 class="text-xl font-semibold text-gray-900">Lampiran</h4>
                    <div class="relative group rounded-2xl overflow-hidden bg-gray-50">
                        <img src="{{ asset($pengaduan->gambar) }}"
                             alt="Lampiran Pengaduan"
                             class="w-full object-cover rounded-2xl transform group-hover:scale-105 transition-all duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Replace the Comments Section -->
        <div class="bg-white/80 backdrop-blur-xl rounded-2xl shadow-xl p-8 mb-8" data-aos="fade-up" data-aos-delay="200">
            <div class="flex items-center justify-between mb-8">
                <h3 class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                    Komentar & Diskusi
                </h3>
                <span class="px-4 py-2 bg-blue-50 text-blue-600 rounded-full text-sm font-medium">
                    {{ $comments->count() }} Komentar
                </span>
            </div>

            <!-- Enhanced Comment Form -->
            <form action="{{ route('komentar.store', $pengaduan->id) }}"
                  method="POST"
                  class="mb-12 transform hover:scale-[1.01] transition-all duration-300">
                @csrf
                <div class="flex gap-4">
                    <div class="relative">
                        <!-- Avatar with Animation -->
                        <div class="relative group">
                            <div class="absolute -inset-0.5 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-full opacity-50 group-hover:opacity-100 blur transition-all duration-500 animate-tilt"></div>
                            <img class="relative h-12 w-12 rounded-full ring-2 ring-white"
                                 src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=random"
                                 alt="{{ auth()->user()->name }}">
                        </div>
                        <!-- Online Status Indicator -->
                        <div class="absolute -bottom-1 -right-1 h-4 w-4 bg-green-400 rounded-full border-2 border-white"></div>
                    </div>

                    <div class="flex-1 space-y-3">
                        <div class="relative">
                            <textarea name="isi_komentar"
                                      rows="3"
                                      required
                                      class="w-full rounded-2xl border-gray-200 focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all duration-300 pr-12"
                                      placeholder="Bagikan pendapat Anda..."></textarea>
                            <div class="absolute right-3 bottom-3 text-gray-400">
                                <i class="fas fa-message"></i>
                            </div>
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500">
                                <i class="fas fa-info-circle mr-1"></i>
                                Ketik komentar yang relevan
                            </span>
                            <button type="submit"
                                    class="group relative inline-flex items-center px-5 py-2.5 rounded-xl text-white overflow-hidden">
                                <div class="absolute inset-0 bg-gradient-to-r from-blue-500 to-indigo-500 transition-all duration-300 group-hover:scale-110"></div>
                                <span class="relative flex items-center">
                                    <i class="fas fa-paper-plane mr-2 group-hover:translate-x-1 transition-transform duration-300"></i>
                                    Kirim Komentar
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </form>

            <!-- Enhanced Comments List -->
            <div class="space-y-6">
                @forelse($comments as $komentar)
                    <div class="flex gap-4 transform hover:scale-[1.01] transition-all duration-300"
                         data-aos="fade-up"
                         data-aos-delay="{{ $loop->iteration * 100 }}">
                        <div class="relative group">
                            <!-- Avatar with Gradient Border -->
                            <div class="absolute -inset-0.5 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-full opacity-0 group-hover:opacity-50 blur transition-all duration-500"></div>
                            <img class="relative h-10 w-10 rounded-full ring-2 ring-white"
                                 src="https://ui-avatars.com/api/?name={{ urlencode($komentar->user->name) }}&background=random"
                                 alt="{{ $komentar->user->name }}">
                        </div>

                        <div class="flex-1">
                            <div class="relative group bg-gradient-to-br from-gray-50 to-white rounded-2xl p-6 hover:shadow-lg transition-all duration-300">
                                <!-- Hover Effect Background -->
                                <div class="absolute inset-0 bg-gradient-to-r from-blue-50/50 to-indigo-50/50 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>

                                <div class="relative">
                                    <!-- User Info and Timestamp -->
                                    <div class="flex items-center justify-between mb-3">
                                        <div class="flex items-center space-x-2">
                                            <span class="font-medium text-gray-900">{{ $komentar->user->name }}</span>
                                            <span class="text-sm text-gray-500">•</span>
                                            <span class="text-sm text-gray-500">{{ $komentar->created_at->diffForHumans() }}</span>
                                        </div>

                                        <!-- Optional: Add comment actions -->
                                        <div class="opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                            <button class="text-gray-400 hover:text-gray-600">
                                                <i class="fas fa-ellipsis-h"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Comment Content -->
                                    <p class="text-gray-700 leading-relaxed">{{ $komentar->isi_komentar }}</p>

                                    <!-- Comment Actions -->
                                    <div class="mt-4 flex items-center space-x-4 text-sm">
                                        <button class="text-gray-500 hover:text-blue-600 transition-colors duration-300">
                                            <i class="far fa-heart mr-1"></i> Suka
                                        </button>
                                        <button class="text-gray-500 hover:text-blue-600 transition-colors duration-300">
                                            <i class="far fa-comment mr-1"></i> Balas
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12">
                        <div class="mb-4 relative group">
                            <div class="absolute inset-0 bg-blue-100 rounded-full blur-xl opacity-50 group-hover:opacity-75 transition-opacity duration-300"></div>
                            <i class="fas fa-comments text-6xl text-blue-500 relative animate-bounce"></i>
                        </div>
                        <p class="text-lg text-gray-500 font-medium">Belum ada komentar.</p>
                        <p class="text-gray-400">Jadilah yang pertama memberikan komentar!</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<style>
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

/* Floating Animation */
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

@push('styles')
<style>
@keyframes tilt {
    0%, 100% { transform: rotate(-1deg); }
    50% { transform: rotate(1deg); }
}

.animate-tilt {
    animation: tilt 10s ease-in-out infinite;
}

@keyframes float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
}

.float {
    animation: float 3s ease-in-out infinite;
}

@keyframes pulse-soft {
    0%, 100% { opacity: 0.5; }
    50% { opacity: 0.8; }
}

.pulse-soft {
    animation: pulse-soft 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}
</style>
@endpush

@push('scripts')
<script>
window.addEventListener('DOMContentLoaded', function() {
    // Debug logging
    console.log('Vote script initializing...');

    // Get elements with debug logging
    const container = document.getElementById('voteContainer');
    console.log('Container found:', !!container);

    const upvoteBtn = document.getElementById('upvoteBtn');
    console.log('Upvote button found:', !!upvoteBtn);

    const downvoteBtn = document.getElementById('downvoteBtn');
    console.log('Downvote button found:', !!downvoteBtn);

    const voteCount = document.getElementById('voteCount');
    console.log('Vote count found:', !!voteCount);

    // Get pengaduan ID from container
    const pengaduanId = container?.dataset?.pengaduanId;
    console.log('Pengaduan ID:', pengaduanId);

    // Get CSRF token
    const token = document.querySelector('meta[name="csrf-token"]')?.content;
    console.log('CSRF token found:', !!token);

    // Validate required data
    if (!container || !pengaduanId || !token) {
        console.error('Missing required data:', {
            container: !!container,
            pengaduanId: !!pengaduanId,
            token: !!token
        });
        return;
    }

    let isLoading = false;

    // Get initial vote states from data attributes
    const initialUpvoteState = upvoteBtn.dataset.voted === 'true';
    const initialDownvoteState = downvoteBtn.dataset.voted === 'true';

    // Set initial styles
    updateVoteStyles(initialUpvoteState ? 'upvote' : (initialDownvoteState ? 'downvote' : null));

    async function handleVote(type) {
        if (isLoading) return;

        isLoading = true;
        const btn = type === 'upvote' ? upvoteBtn : downvoteBtn;
        const otherBtn = type === 'upvote' ? downvoteBtn : upvoteBtn;
        const icon = btn.querySelector('i');
        const voteStatus = document.getElementById('voteStatus');

        // Show loading state
        voteStatus.classList.remove('hidden');
        voteStatus.classList.add('flex');
        icon.classList.add('vote-ping');

        try {
            const response = await fetch(`/pengaduan/${pengaduanId}/vote`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': token
                },
                body: JSON.stringify({ vote_type: type })
            });

            if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);

            const data = await response.json();

            // Update vote counts with animation
            const upCount = document.getElementById('upvoteCount');
            const downCount = document.getElementById('downvoteCount');

            upCount.classList.add('animate-bounce-in');
            downCount.classList.add('animate-bounce-in');

            upCount.textContent = data.upvotes;
            downCount.textContent = data.downvotes;

            // Update data attributes
            btn.dataset.voted = data.userVoteType === type ? 'true' : 'false';
            otherBtn.dataset.voted = data.userVoteType === (type === 'upvote' ? 'downvote' : 'upvote') ? 'true' : 'false';

            // Update styles
            updateVoteStyles(data.userVoteType);

            setTimeout(() => {
                upCount.classList.remove('animate-bounce-in');
                downCount.classList.remove('animate-bounce-in');
            }, 300);

        } catch (error) {
            console.error('Vote error:', error);
            alert('Gagal melakukan vote. Silakan coba lagi.');
        } finally {
            isLoading = false;
            icon.classList.remove('vote-ping');
            voteStatus.classList.add('hidden');
            voteStatus.classList.remove('flex');
        }
    }

    function updateVoteStyles(activeType) {
        const upvoteIcon = upvoteBtn.querySelector('i');
        const downvoteIcon = downvoteBtn.querySelector('i');

        // Reset classes
        upvoteBtn.className = 'group inline-flex items-center px-4 py-2 rounded-full text-sm font-medium transition-all duration-300';
        downvoteBtn.className = 'group inline-flex items-center px-4 py-2 rounded-full text-sm font-medium transition-all duration-300';
        upvoteIcon.className = 'fas fa-thumbs-up mr-2 transform group-hover:scale-125 transition-transform duration-300';
        downvoteIcon.className = 'fas fa-thumbs-down mr-2 transform group-hover:scale-125 transition-transform duration-300';

        // Apply active styles
        if (activeType === 'upvote') {
            upvoteBtn.classList.add('bg-green-500', 'text-white');
            upvoteIcon.classList.add('text-white');
            downvoteBtn.classList.add('hover:bg-red-50');
            downvoteIcon.classList.add('text-red-500');
        } else if (activeType === 'downvote') {
            downvoteBtn.classList.add('bg-red-500', 'text-white');
            downvoteIcon.classList.add('text-white');
            upvoteBtn.classList.add('hover:bg-green-50');
            upvoteIcon.classList.add('text-green-500');
        } else {
            upvoteBtn.classList.add('hover:bg-green-50');
            downvoteBtn.classList.add('hover:bg-red-50');
            upvoteIcon.classList.add('text-green-500');
            downvoteIcon.classList.add('text-red-500');
        }
    }

    // Add click handlers
    upvoteBtn.addEventListener('click', () => handleVote('upvote'));
    downvoteBtn.addEventListener('click', () => handleVote('downvote'));

    console.log('Vote script initialized successfully');
});
</script>
@endpush
