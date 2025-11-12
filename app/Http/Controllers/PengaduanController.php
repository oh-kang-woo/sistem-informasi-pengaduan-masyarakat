<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use App\Models\Kategori;
use App\Models\Usernotifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengaduanController extends Controller
{
    /**
     * Tampilkan form pengaduan.
     */
    public function create()
    {
        $kategoris = Kategori::where('status', 'aktif')->get();
        return view('pengaduan.create', compact('kategoris'));
    }

    /**
     * Simpan data pengaduan baru (gunakan user yang sedang login).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul'          => 'required|string|max:255',
            'kategori_id'    => 'required|exists:kategoris,id',
            'lokasi'         => 'required|string|max:255',
            'isi_laporan'    => 'required|string',
            'bukti'          => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        DB::beginTransaction();
        try {
            // Upload bukti (jika ada)
            $buktiPath = null;
            if ($request->hasFile('bukti')) {
                $buktiPath = $request->file('bukti')->store('bukti_pengaduan', 'public');
            }

            // Buat pengaduan baru dengan user login
            $pengaduan = Pengaduan::create([
                'user_id'         => auth()->id(),
                'kategori_id'     => $validated['kategori_id'],
                'judul_pengaduan' => $validated['judul'],
                'lokasi_kejadian' => $validated['lokasi'],
                'isi_laporan'     => $validated['isi_laporan'],
                'bukti'           => $buktiPath,
                'status'          => 'Menunggu Verifikasi',
            ]);

            // Buat notifikasi untuk user login
            Usernotifikasi::create([
                'user_id'      => auth()->id(),
                'pengaduan_id' => $pengaduan->id,
                'judul'        => 'Laporan Anda telah diterima',
                'pesan'        => 'Laporan "' . $validated['judul'] . '" telah dikirim dan sedang menunggu verifikasi.',
                'status'       => 'belum_dibaca',
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'Laporan berhasil dikirim!');
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan laporan.']);
        }
    }
}
