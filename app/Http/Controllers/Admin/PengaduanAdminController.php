<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use App\Models\Kategori;
use Illuminate\Http\Request;
use App\Models\UserNotification;
use App\Models\User;

class PengaduanAdminController extends Controller
{
    /**
     * Dashboard Admin
     */
    public function index(Request $request)
    {
        $status = $request->status;
        $kategori = $request->kategori;
        $search = $request->search;

        $query = Pengaduan::with('kategori');

        if ($status) {
            $query->where('status', 'like', "%$status%");
        }

        if ($kategori) {
            $query->where('kategori_id', $kategori);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('judul_pengaduan', 'like', "%$search%")
                  ->orWhere('lokasi_kejadian', 'like', "%$search%");
            });
        }

        $pengaduans = $query->latest()->get();

        $totalMenunggu = Pengaduan::where('status', 'Menunggu Verifikasi')->count();
        $totalProses   = Pengaduan::where('status', 'Diproses')->count();
        $totalSelesai  = Pengaduan::where('status', 'Selesai')->count();
        $totalDitolak  = Pengaduan::where('status', 'Ditolak')->count();

        $kategoris = Kategori::all();

        return view('admin.index', compact(
            'pengaduans',
            'kategoris',
            'totalMenunggu',
            'totalProses',
            'totalSelesai',
            'totalDitolak'
        ));
    }

    /**
     * Halaman Manajemen Laporan
     */
   public function manajemen(Request $request)
    {
        $status = $request->status;
        $kategori = $request->kategori;
        $search = $request->search;

        $query = Pengaduan::with('kategori');

        if ($status) {
            $query->where('status', $status);
        }

        if ($kategori) {
            $query->where('kategori_id', $kategori);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('judul_pengaduan', 'like', "%$search%")
                ->orWhere('lokasi_kejadian', 'like', "%$search%");
            });
        }

        $pengaduans = $query->latest()->get();
        $kategoris = Kategori::all();

        // Tambahkan statistik
        $totalMenunggu = Pengaduan::where('status', 'Menunggu Verifikasi')->count();
        $totalProses   = Pengaduan::where('status', 'Diproses')->count();
        $totalSelesai  = Pengaduan::where('status', 'Selesai')->count();
        $totalDitolak  = Pengaduan::where('status', 'Ditolak')->count();

        return view('admin.laporan.index', compact(
            'pengaduans', 'kategoris',
            'totalMenunggu', 'totalProses', 'totalSelesai', 'totalDitolak'
        ));
    }

    public function show($id)
    {
        $pengaduan = Pengaduan::with(['user', 'kategori'])->findOrFail($id);
        return view('admin.laporan.show', compact('pengaduan'));
    }

    public function updateStatus(Request $request, $id)
    {
        $pengaduan = Pengaduan::findOrFail($id);
        $oldStatus = $pengaduan->status; // simpan status lama
        $pengaduan->status = $request->status;
        $pengaduan->save();

        // Buat array mapping status ke notifikasi
        $statusNotif = [
            'Menunggu Verifikasi' => [
                'title' => 'Pengaduan Menunggu Verifikasi',
                'message' => 'Pengaduan Anda "' . $pengaduan->judul_pengaduan . '" sedang menunggu verifikasi admin.'
            ],
            'Diproses' => [
                'title' => 'Pengaduan Sedang Diproses',
                'message' => 'Pengaduan Anda "' . $pengaduan->judul_pengaduan . '" telah diproses oleh admin.'
            ],
            'Selesai' => [
                'title' => 'Pengaduan Selesai',
                'message' => 'Pengaduan Anda "' . $pengaduan->judul_pengaduan . '" telah selesai ditindaklanjuti.'
            ],
            'Ditolak' => [
                'title' => 'Pengaduan Ditolak',
                'message' => 'Pengaduan Anda "' . $pengaduan->judul_pengaduan . '" ditolak oleh admin.'
            ],
            'Dibatalkan' => [
                'title' => 'Pengaduan Dibatalkan',
                'message' => 'Pengaduan Anda "' . $pengaduan->judul_pengaduan . '" telah dibatalkan.'
            ],
        ];

        // Kirim notifikasi ke user jika ada mapping
        if(isset($statusNotif[$request->status])) {
            UserNotification::create([
                'receiver_id' => $pengaduan->user_id,
                'receiver_role' => 'user',
                'title' => $statusNotif[$request->status]['title'],
                'message' => $statusNotif[$request->status]['message'],
                'link' => route('user.notifikasi.index'),
                'status' => 'unread',
            ]);
        }

        return redirect()->back()->with('success', 'Status pengaduan berhasil diubah dan notifikasi terkirim.');
    }


    public function deleteAll()
{
    Pengaduan::query()->delete();

    return redirect()->route('admin.laporan.index')
        ->with('success', 'Semua laporan berhasil dihapus.');
}




}
