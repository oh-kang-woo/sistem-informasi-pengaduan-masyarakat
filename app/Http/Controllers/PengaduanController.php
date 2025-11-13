<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use App\Models\Kategori;
use App\Models\Usernotifikasi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengaduanController extends Controller
{


    /**
     * Tampilkan form pengaduan
     */
    public function create()
    {
        $kategoris = Kategori::where('status', 'aktif')->get();
        return view('pengaduan.create', compact('kategoris'));
    }

    /**
     * Simpan pengaduan baru
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'judul_pengaduan' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
            'lokasi_kejadian' => 'required|string|max:255',
            'isi_laporan' => 'required|string',
            'bukti' => 'nullable|mimes:jpg,jpeg,png,pdf|max:5120',
            'no_hp' => 'required|string|max:20|unique:users,no_hp,' . auth()->id(),
        ]);

        // Update no_hp user
        $user = auth()->user();
        $user->no_hp = $validated['no_hp'];
        $user->save();

        DB::beginTransaction();
        try {
            // Upload bukti jika ada
            $buktiPath = $request->hasFile('bukti') ? $request->file('bukti')->store('bukti_pengaduan','public') : null;

            // Simpan pengaduan
            $pengaduan = Pengaduan::create([
                'user_id' => $user->id,
                'kategori_id' => $validated['kategori_id'],
                'judul_pengaduan' => $validated['judul_pengaduan'],
                'lokasi_kejadian' => $validated['lokasi_kejadian'],
                'isi_laporan' => $validated['isi_laporan'],
                'bukti' => $buktiPath,
                'status' => 'Menunggu Verifikasi',
            ]);

            // Notifikasi untuk user
            Usernotifikasi::create([
                'user_id' => $user->id,
                'pengaduan_id' => $pengaduan->id,
                'judul' => 'Laporan Anda telah diterima',
                'pesan' => 'Laporan "' . $validated['judul_pengaduan'] . '" telah dikirim dan sedang menunggu verifikasi.',
                'status' => 'belum_dibaca',
            ]);

            // Notifikasi untuk semua admin
            $admins = User::where('role', 'admin')->get();
            foreach($admins as $admin){
                Usernotifikasi::create([
                    'user_id' => $admin->id,
                    'pengaduan_id' => $pengaduan->id,
                    'judul' => 'Pengaduan Baru',
                    'pesan' => 'Ada pengaduan baru: "' . $validated['judul_pengaduan'] . '" dari user ' . $user->nama,
                    'status' => 'belum_dibaca',
                ]);
            }

            DB::commit();
            return redirect()->back()->with('success','Laporan berhasil dikirim!');

        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan laporan.']);
        }
    }
}
