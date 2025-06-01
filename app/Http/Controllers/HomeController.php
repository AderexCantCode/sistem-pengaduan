<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use App\Models\Kategori;
use App\Models\Vote;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $query = Pengaduan::with([
            'user:id,nama',
            'kategori:id,nama_kategori',
            'tanggapans',
            'votes'
        ])
        ->select([
            'id',
            'judul',
            'isi',
            'status',
            'kategori_id',
            'user_id',
            'created_at'
        ])
        ->withCount([
            'votes as upvotes_count' => function($query) {
                $query->where('type', 'upvote');
            },
            'votes as downvotes_count' => function($query) {
                $query->where('type', 'downvote');
            },
            'tanggapans as comments_count'
        ])
        ->latest()
        ->take(3); // Show only 6 recent complaints

        $pengaduans = $query->get();

        // Get statistics
        $stats = [
            'total_pengaduan' => $pengaduans->count(),
            'total_upvotes' => $pengaduans->sum('upvotes_count'),
            'total_downvotes' => $pengaduans->sum('downvotes_count'),
            'total_comments' => $pengaduans->sum('comments_count'),
            'pending_count' => $pengaduans->where('status', 'pending')->count(),
            'processing_count' => $pengaduans->where('status', 'processing')->count(),
            'completed_count' => $pengaduans->where('status', 'completed')->count(),
        ];

        // Get categories for filtering
        $kategoris = Kategori::select(['id', 'nama_kategori'])->get();

        return view('home', compact('pengaduans', 'kategoris', 'stats'));
    }

    public function dashboard()
    {
        $userId = auth()->id();

        // Get paginated pengaduan for current user
        $pengaduans = Pengaduan::with(['tanggapans', 'upvotes'])
            ->where('user_id', $userId)
            ->latest()
            ->paginate(15);

        // Get statistics for current user
        $totalPengaduan = Pengaduan::where('user_id', $userId)->count();
        $terkirim = Pengaduan::where('user_id', $userId)->where('status', 'terkirim')->count();
        $diproses = Pengaduan::where('user_id', $userId)->where('status', 'diproses')->count();
        $selesai = Pengaduan::where('user_id', $userId)->where('status', 'selesai')->count();

        return view('dashboard', compact(
            'pengaduans',
            'totalPengaduan',
            'terkirim',
            'diproses',
            'selesai'
        ));
    }
}
