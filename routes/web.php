<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\DashboardController;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout'); // Moved here

// Authenticated routes
Route::middleware('auth')->group(function () {
    // Routes accessible by both masyarakat and admin
    Route::get('/pengaduan', [PengaduanController::class, 'index'])->name('pengaduan.index');

    // Masyarakat only routes with proper ordering
    Route::middleware('masyarakat')->group(function () {
        Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
        // Create route must come before show route to avoid conflict
        Route::get('/pengaduan/create', [PengaduanController::class, 'create'])->name('pengaduan.create');
        Route::post('/pengaduan', [PengaduanController::class, 'store'])->name('pengaduan.store');
    });

    // Dynamic routes should come after static routes
    Route::get('/pengaduan/{pengaduan}', [PengaduanController::class, 'show'])->name('pengaduan.show');
    Route::post('/pengaduan/{pengaduan}/komentar', [PengaduanController::class, 'comment'])->name('komentar.store');
    Route::post('/pengaduan/{pengaduan}/vote', [PengaduanController::class, 'vote'])->name('pengaduan.vote');

    // Admin routes
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/pengaduan/{pengaduan}', [AdminController::class, 'show'])->name('pengaduan.show');
        Route::post('/pengaduan/{pengaduan}/tanggapi', [AdminController::class, 'tanggapi'])->name('pengaduan.tanggapi');
    });

    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        // ... other admin routes
    });
});
