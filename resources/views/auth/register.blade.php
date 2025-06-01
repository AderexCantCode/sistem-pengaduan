@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="min-h-screen bg-gradient-to-r from-blue-600 to-blue-800 relative overflow-hidden">
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

    <div class="relative min-h-screen flex items-center justify-center px-4">
        <div class="max-w-md w-full" data-aos="fade-up" data-aos-duration="1000">
            <div class="bg-white/95 backdrop-blur-xl p-8 rounded-2xl shadow-2xl transform transition-all duration-500 hover:shadow-blue-500/25">
                <div class="text-center mb-8" data-aos="fade-down" data-aos-delay="200">
                    <h2 class="text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-blue-800">
                        Buat Akun Baru
                    </h2>
                    <p class="text-gray-600 mt-2">Daftar untuk mulai menggunakan layanan</p>
                </div>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Nama -->
                    <div class="mb-6" data-aos="fade-up" data-aos-delay="300">
                        <label class="block text-gray-700 text-sm font-semibold mb-2" for="nama">
                            Nama Lengkap
                        </label>
                        <div class="group relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-blue-500 transition-colors duration-200">
                                <i class="fas fa-user"></i>
                            </div>
                            <input class="form-input w-full pl-10 pr-4 py-3 border-2 rounded-xl focus:outline-none focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all duration-200 @error('nama') border-red-500 @enderror"
                                   type="text"
                                   name="nama"
                                   id="nama"
                                   value="{{ old('nama') }}"
                                   placeholder="Masukkan nama lengkap"
                                   required
                                   autofocus>
                        </div>
                        @error('nama')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="mb-6" data-aos="fade-up" data-aos-delay="400">
                        <label class="block text-gray-700 text-sm font-semibold mb-2" for="email">
                            Email
                        </label>
                        <div class="group relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-blue-500 transition-colors duration-200">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <input class="form-input w-full pl-10 pr-4 py-3 border-2 rounded-xl focus:outline-none focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all duration-200 @error('email') border-red-500 @enderror"
                                   type="email"
                                   name="email"
                                   id="email"
                                   value="{{ old('email') }}"
                                   placeholder="nama@email.com"
                                   required>
                        </div>
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-6" data-aos="fade-up" data-aos-delay="500">
                        <label class="block text-gray-700 text-sm font-semibold mb-2" for="password">
                            Password
                        </label>
                        <div class="group relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-blue-500 transition-colors duration-200">
                                <i class="fas fa-lock"></i>
                            </div>
                            <input class="form-input w-full pl-10 pr-10 py-3 border-2 rounded-xl focus:outline-none focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all duration-200 @error('password') border-red-500 @enderror"
                                   type="password"
                                   name="password"
                                   id="password"
                                   placeholder="••••••••"
                                   required>
                            <button type="button"
                                    onclick="togglePassword('password')"
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-blue-500 transition-colors duration-200">
                                <i class="fas fa-eye" id="toggleIcon-password"></i>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-6" data-aos="fade-up" data-aos-delay="600">
                        <label class="block text-gray-700 text-sm font-semibold mb-2" for="password_confirmation">
                            Konfirmasi Password
                        </label>
                        <div class="group relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-blue-500 transition-colors duration-200">
                                <i class="fas fa-lock"></i>
                            </div>
                            <input class="form-input w-full pl-10 pr-10 py-3 border-2 rounded-xl focus:outline-none focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all duration-200"
                                   type="password"
                                   name="password_confirmation"
                                   id="password_confirmation"
                                   placeholder="••••••••"
                                   required>
                            <button type="button"
                                    onclick="togglePassword('password_confirmation')"
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-blue-500 transition-colors duration-200">
                                <i class="fas fa-eye" id="toggleIcon-confirmation"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Role Selection -->
                    <div class="mb-6" data-aos="fade-up" data-aos-delay="700">
                        <label class="block text-gray-700 text-sm font-semibold mb-2">
                            Role
                        </label>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="relative">
                                <input type="radio" name="role" id="role_masyarakat" value="masyarakat"
                                       class="peer absolute opacity-0"
                                       {{ old('role') == 'masyarakat' ? 'checked' : '' }} required>
                                <label for="role_masyarakat"
                                       class="block p-4 text-center border-2 rounded-xl cursor-pointer transition-all duration-200
                                              peer-checked:border-blue-500 peer-checked:bg-blue-50 peer-checked:text-blue-600
                                              hover:border-blue-200">
                                    <i class="fas fa-users mb-2"></i>
                                    <span class="block text-sm">Masyarakat</span>
                                </label>
                            </div>
                            <div class="relative">
                                <input type="radio" name="role" id="role_admin" value="admin"
                                       class="peer absolute opacity-0"
                                       {{ old('role') == 'admin' ? 'checked' : '' }}>
                                <label for="role_admin"
                                       class="block p-4 text-center border-2 rounded-xl cursor-pointer transition-all duration-200
                                              peer-checked:border-blue-500 peer-checked:bg-blue-50 peer-checked:text-blue-600
                                              hover:border-blue-200">
                                    <i class="fas fa-user-shield mb-2"></i>
                                    <span class="block text-sm">Admin</span>
                                </label>
                            </div>
                        </div>
                        @error('role')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div data-aos="fade-up" data-aos-delay="800">
                        <button type="submit"
                                class="group relative w-full bg-gradient-to-r from-blue-600 to-blue-800 text-white px-4 py-3 rounded-xl overflow-hidden transition-all duration-300 hover:shadow-lg hover:shadow-blue-500/50 active:scale-95">
                            <div class="absolute right-0 w-12 h-32 -mt-12 transition-all duration-1000 transform translate-x-12 bg-white opacity-10 rotate-12 group-hover:-translate-x-40"></div>
                            <div class="relative flex items-center justify-center">
                                <i class="fas fa-user-plus mr-2 group-hover:animate-bounce"></i>
                                <span>Daftar Sekarang</span>
                            </div>
                        </button>
                    </div>
                </form>

                <p class="text-center mt-8 text-gray-600" data-aos="fade-up" data-aos-delay="900">
                    Sudah punya akun?
                    <a href="{{ route('login') }}"
                       class="text-blue-600 hover:text-blue-700 font-medium transition-colors duration-200 relative group">
                        Login disini
                        <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-blue-600 transition-all duration-200 group-hover:w-full"></span>
                    </a>
                </p>
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
                <use xlink:href="#gentle-wave" x="48" y="0" fill="rgba(255,255,255,0.7" />
                <use xlink:href="#gentle-wave" x="48" y="3" fill="rgba(255,255,255,0.5)" />
                <use xlink:href="#gentle-wave" x="48" y="5" fill="rgba(255,255,255,0.3)" />
                <use xlink:href="#gentle-wave" x="48" y="7" fill="#fff" />
            </g>
        </svg>
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

@push('scripts')
<script>
function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(`toggleIcon-${inputId === 'password' ? 'password' : 'confirmation'}`);

    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}
</script>
@endpush
@endsection
