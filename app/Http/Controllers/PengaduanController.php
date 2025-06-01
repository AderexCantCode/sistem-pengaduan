<?php
namespace App\Http\Controllers;

use App\Models\Pengaduan;
use App\Models\Kategori;
use App\Models\Komentar;
use App\Models\Vote;
use App\Enums\VoteType;
use Illuminate\Http\Request;

class PengaduanController extends Controller
{
    public function create()
    {
        $kategoris = Kategori::select(['id', 'nama_kategori'])->get();
        return view('pengaduan.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        // Debug logging
        \Log::info('Request data:', [
            'has_file' => $request->hasFile('gambar'),
            'file_data' => $request->file('gambar'),
            'all_data' => $request->all()
        ]);

        $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
        ]);

        try {
            // Create pengaduan with correct initial status
            $pengaduan = Pengaduan::create([
                'user_id' => auth()->id(),
                'kategori_id' => $request->kategori_id,
                'judul' => $request->judul,
                'isi' => $request->isi,
                'status' => 'terkirim', // Changed from 'pending' to 'terkirim'
            ]);

            // Handle image upload if present
            if ($request->hasFile('gambar')) {
                // Get the file instance
                $file = $request->file('gambar');

                // Generate unique filename with timestamp and original name
                $filename = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());

                // Ensure directory exists
                $path = public_path('gambar');
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }

                // Move uploaded file
                $file->move($path, $filename);

                // Update database with file path
                $pengaduan->update([
                    'gambar' => 'gambar/' . $filename
                ]);

                \Log::info('File uploaded successfully:', [
                    'filename' => $filename,
                    'path' => $path
                ]);
            }

            return redirect()->route('pengaduan.show', $pengaduan)
                ->with('success', 'Pengaduan berhasil dibuat!');
        } catch (\Exception $e) {
            \Log::error('Error creating pengaduan:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()
                ->withInput()
                ->with('error', 'Gagal membuat pengaduan: ' . $e->getMessage());
        }
    }

    public function show(Pengaduan $pengaduan)
    {
        $pengaduan->load([
            'user',
            'kategori',
            'tanggapans.admin',
            'upvotes',
            'downvotes'
        ]);

        $comments = $pengaduan->komentars()
            ->with('user')
            ->latest()
            ->paginate(10);

        return view('pengaduan.show', compact('pengaduan', 'comments'));
    }

    public function vote(Request $request, Pengaduan $pengaduan)
    {
        $request->validate([
            'vote_type' => ['required', 'string', 'in:' . implode(',', VoteType::values())]
        ]);

        $vote = Vote::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'pengaduan_id' => $pengaduan->id,
            ],
            ['type' => $request->vote_type]
        );

        return response()->json([
            'success' => true,
            'votes_count' => $pengaduan->votes()->count(),
            'userVoteType' => $vote->type
        ]);
    }

    public function comment(Request $request, Pengaduan $pengaduan)
    {
        $request->validate([
            'isi_komentar' => 'required|string'
        ]);

        $pengaduan->komentars()->create([
            'user_id' => auth()->id(),
            'isi_komentar' => $request->isi_komentar
        ]);

        return back()->with('success', 'Komentar berhasil ditambahkan');
    }

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
        ->latest();


        $pengaduans = $query->get();

        // Update statistics with correct status values
        $stats = [
            'total_pengaduan' => $pengaduans->count(),
            'total_upvotes' => $pengaduans->sum('upvotes_count'),
            'total_downvotes' => $pengaduans->sum('downvotes_count'),
            'total_comments' => $pengaduans->sum('comments_count'),
            'terkirim_count' => $pengaduans->where('status', 'terkirim')->count(),
            'diproses_count' => $pengaduans->where('status', 'diproses')->count(),
            'selesai_count' => $pengaduans->where('status', 'selesai')->count(),
        ];

        $kategoris = Kategori::select(['id', 'nama_kategori'])->get();

        return view('pengaduan.index', compact('pengaduans', 'kategoris', 'stats'));
    }

    // Add this method to handle image updates
    public function updateGambar(Request $request, Pengaduan $pengaduan)
    {
        $request->validate([
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240',
        ]);

        // Delete old image if exists
        if ($pengaduan->gambar) {
            $oldPath = public_path($pengaduan->gambar);
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }
        }

        // Handle new image upload
        $file = $request->file('gambar');
        $filename = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
        $file->move(public_path('gambar'), $filename);

        // Update pengaduan with new image path
        $pengaduan->update([
            'gambar' => 'gambar/' . $filename
        ]);

        return back()->with('success', 'Gambar berhasil diperbarui!');
    }
}
