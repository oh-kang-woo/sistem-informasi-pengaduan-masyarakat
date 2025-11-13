<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use App\Models\Kategori;
use Illuminate\Http\Request;

class PengaduanAdminController extends Controller
{
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
                $q->where('judul_laporan', 'like', "%$search%")
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

    public function manajemen(Request $request)
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

        return view('admin.laporan.index', compact(
            'pengaduans',
            'kategoris',
            'totalMenunggu',
            'totalProses',
            'totalSelesai',
            'totalDitolak'
        ));
    }

    /**
     * 🟢 Update status pengaduan oleh admin
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
        'status' => 'required|in:Menunggu Verifikasi,Diproses,Selesai',
        ]);


        $pengaduan = Pengaduan::findOrFail($id);
        $pengaduan->status = $request->status;
        $pengaduan->save();

        return redirect()->back()->with('success', 'Status pengaduan berhasil diperbarui.');
    }

        // Hapus satu laporan
    public function destroy($id)
    {
        $laporan = Pengaduan::findOrFail($id);
        $laporan->delete();

        return redirect()->route('admin.laporan.index')->with('success', 'Laporan berhasil dihapus.');
    }

    // Hapus semua laporan
    public function deleteAll()
    {
        Pengaduan::query()->delete();
        return redirect()->route('admin.laporan.index')->with('success', 'Semua laporan berhasil dihapus.');
    }

}
