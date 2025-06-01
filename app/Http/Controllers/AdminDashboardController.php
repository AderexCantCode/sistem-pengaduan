<?php
<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use App\Models\User;
use App\Models\Kategori;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_pengaduan' => Pengaduan::count(),
            'pending_pengaduan' => Pengaduan::where('status', 'pending')->count(),
            'processed_pengaduan' => Pengaduan::where('status', 'processing')->count(),
            'completed_pengaduan' => Pengaduan::where('status', 'completed')->count(),
            'total_users' => User::where('role', 'masyarakat')->count(),
        ];

        $recent_pengaduans = Pengaduan::with(['user:id,nama', 'kategori:id,nama_kategori'])
            ->latest()
            ->take(5)
            ->get();

        $kategori_stats = Kategori::withCount('pengaduans')
            ->get()
            ->map(function ($kategori) {
                return [
                    'name' => $kategori->nama_kategori,
                    'count' => $kategori->pengaduans_count
                ];
            });

        return view('admin.dashboard', compact('stats', 'recent_pengaduans', 'kategori_stats'));
    }
}
