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
        // Filter opsional
        $status = $request->status;
        $kategori = $request->kategori;
        $search = $request->search;

        // Query dasar
        $query = Pengaduan::with('kategori');

        if ($status) {
            $query->where('status', 'like', "%$status%");
        }

        if ($kategori) {
            $query->where('kategori_id', $kategori);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%$search%")
                  ->orWhere('lokasi', 'like', "%$search%");
            });
        }

        $pengaduans = $query->latest()->get();

        // Statistik
        $totalMenunggu = Pengaduan::where('status', 'Menunggu Verifikasi')->count();
        $totalProses   = Pengaduan::where('status', 'Sedang Diproses')->count();
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
}
