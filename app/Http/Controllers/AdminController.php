<?php
namespace App\Http\Controllers;

use App\Models\Pengaduan;
use App\Models\Tanggapan;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        // Get statistics
        $totalUsers = User::where('role', '!=', 'admin')->count();
        $terkirim = Pengaduan::where('status', 'terkirim')->count();
        $diproses = Pengaduan::where('status', 'diproses')->count();
        $selesai = Pengaduan::where('status', 'selesai')->count();

        // Build query for pengaduan list with filters
        $query = Pengaduan::with(['user', 'kategori'])->latest();

        // Apply status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Apply search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%')
                  ->orWhere('isi', 'like', '%' . $search . '%')
                  ->orWhereHas('user', function($q2) use ($search) {
                      $q2->where('nama', 'like', '%' . $search . '%')
                         ->orWhere('email', 'like', '%' . $search . '%');
                  });
            });
        }

        // Get paginated results and append query parameters
        $pengaduans = $query->paginate(10)->appends($request->all());

        return view('admin.dashboard', compact(
            'totalUsers',
            'terkirim',
            'diproses',
            'selesai',
            'pengaduans'
        ));
    }

    public function index()
    {
        $data = [
            'pengaduans' => Pengaduan::with(['user', 'kategori'])
                ->latest()
                ->paginate(10),

            // Get total registered users (excluding admins)
            'totalUsers' => User::where('role', '!=', 'admin')->count(),

            // Get counts for each pengaduan status
            'terkirim' => Pengaduan::where('status', 'terkirim')->count(),
            'diproses' => Pengaduan::where('status', 'diproses')->count(),
            'selesai' => Pengaduan::where('status', 'selesai')->count(),
        ];

        return view('admin.dashboard', $data);
    }

    public function show(Pengaduan $pengaduan)
    {
        $pengaduan->load(['user', 'kategori', 'tanggapans.admin', 'komentars.user']);
        return view('admin.show', compact('pengaduan'));
    }

    public function tanggapi(Request $request, Pengaduan $pengaduan)
    {
        // Update validation rules to match ENUM values
        $request->validate([
            'tanggapan' => 'required|string',
            'status' => 'required|in:terkirim,diproses,selesai'
        ]);

        try {
            // Create tanggapan
            Tanggapan::create([
                'pengaduan_id' => $pengaduan->id,
                'admin_id' => auth()->id(),
                'isi_tanggapan' => $request->tanggapan
            ]);

            // Update pengaduan status
            $pengaduan->update([
                'status' => $request->status
            ]);

            return back()->with('success', 'Tanggapan berhasil dikirim dan status diperbarui');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengirim tanggapan: ' . $e->getMessage());
        }
    }
}
