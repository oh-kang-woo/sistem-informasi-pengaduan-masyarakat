<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kategori;

class KategoriController extends Controller
{
    /**
     * Menampilkan halaman kategori dengan filter dan pencarian.
     */
    public function index(Request $request)
    {
        // Ambil nilai filter dari form
        $status = $request->get('status');
        $search = $request->get('search');

        // Query dasar dengan menghitung total laporan
        $query = Kategori::withCount([
            'pengaduans as total_laporan',
            'pengaduans as laporan_selesai' => function ($q) {
                $q->where('status', 'selesai');
            },
            'pengaduans as laporan_proses' => function ($q) {
                $q->whereIn('status', ['proses', 'verifikasi']);
            },
        ]);

        // Filter berdasarkan status jika dipilih
        if (!empty($status)) {
            $query->where('status', $status);
        }

        // Filter berdasarkan pencarian nama kategori
        if (!empty($search)) {
            $query->where('nama_kategori', 'like', '%' . $search . '%');
        }

        // Ambil hasil dengan urutan terbaru
        $kategori_list = $query->orderBy('created_at', 'desc')->get();

        // Hitung statistik untuk bagian atas dashboard
        $total_kategori = Kategori::count();
        $total_aktif = Kategori::where('status', 'aktif')->count();
        $total_nonaktif = Kategori::where('status', 'nonaktif')->count();

        return view('admin.kategori.index', compact(
            'kategori_list',
            'total_kategori',
            'total_aktif',
            'total_nonaktif'
        ));
    }


    /**
     * Menampilkan form tambah kategori.
     */
    public function create()
    {
        return view('admin.kategori.create');
    }

    /**
     * Menyimpan kategori baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'warna_kelas' => 'required|string|max:100',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        Kategori::create($validated);

        return redirect()->route('admin.kategori.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }
}
