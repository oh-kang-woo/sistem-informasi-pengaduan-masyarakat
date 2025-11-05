<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use App\Models\Kategori;
use Illuminate\Http\Request;

class PengaduanController extends Controller
{
    // Tampilkan form
    public function create()
    {
        $kategoris = Kategori::all();
        return view('pengaduan.create', compact('kategoris'));
    }

    // Simpan pengaduan
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
            'lokasi' => 'required|string|max:255',
            'isi_laporan' => 'required|string',
            'no_hp' => 'required|string|max:20',
            'bukti' => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $buktiPath = null;
        if ($request->hasFile('bukti')) {
            $buktiPath = $request->file('bukti')->store('bukti_pengaduan', 'public');
        }

        Pengaduan::create([
            'judul' => $request->judul,
            'kategori_id' => $request->kategori_id,
            'lokasi' => $request->lokasi,
            'isi_laporan' => $request->isi_laporan,
            'bukti' => $buktiPath,
            'no_hp' => $request->no_hp,
            'status' => 'Menunggu Verifikasi',
        ]);

        return redirect()->back()->with('success', 'Laporan berhasil dikirim!');
    }
}
