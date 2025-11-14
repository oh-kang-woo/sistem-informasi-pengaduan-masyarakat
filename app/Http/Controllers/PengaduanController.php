<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Pengaduan;
use App\Models\Kategori;
use App\Models\UserNotification;
use App\Models\User;

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
        $user = auth()->user();

        $validated = $request->validate([
            'judul_pengaduan' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
            'lokasi_kejadian' => 'required|string|max:255',
            'isi_laporan' => 'required|string',
            'bukti' => 'nullable|mimes:jpg,jpeg,png,pdf|max:5120',
            'no_hp' => 'required|string|max:20',
        ]);

        // Simpan no_hp user jika belum ada
        if (!$user->no_hp) {
            $user->no_hp = $validated['no_hp'];
            $user->save();
        } elseif ($validated['no_hp'] !== $user->no_hp) {
            return back()
                ->withErrors(['no_hp' => 'Nomor HP tidak boleh diubah.'])
                ->withInput();
        }


        DB::beginTransaction();
        try {
            // Upload bukti jika ada
            $buktiPath = $request->hasFile('bukti')
                ? $request->file('bukti')->store('bukti_pengaduan', 'public')
                : null;

            // Simpan pengaduan dan ambil hasilnya
            $pengaduan = Pengaduan::create([
                'user_id' => $user->id,
                'kategori_id' => $validated['kategori_id'],
                'judul_pengaduan' => $validated['judul_pengaduan'],
                'lokasi_kejadian' => $validated['lokasi_kejadian'],
                'isi_laporan' => $validated['isi_laporan'],
                'bukti' => $buktiPath,
                'status' => 'Menunggu Verifikasi',
            ]);

            // notifikasi ke semua admin
            $admins = User::where('role', 'admin')->get();
            foreach ($admins as $admin) {
                UserNotification::create([
                    'receiver_id' => $admin->id,
                    'receiver_role' => 'admin',
                    'title' => 'Pengaduan Baru',
                    'message' => $user->name . ' mengirim: ' . $pengaduan->judul_pengaduan,
                    'link' => route('admin.laporan.show', $pengaduan->id),
                    'status' => 'unread',
                ]);
            }

            // notifikasi ke user (konfirmasi terkirim)
            UserNotification::create([
                'receiver_id' => $user->id,
                'receiver_role' => 'user',
                'title' => 'Pengaduan Terkirim',
                'message' => 'Pengaduan Anda telah terkirim dan akan diverifikasi oleh admin.',
                'link' => route('user.notifikasi.index'),
                'status' => 'unread',
            ]);

            DB::commit();

            return redirect()
                ->route('pengaduan.create')
                ->with('success', 'Pengaduan berhasil dikirim dan admin diberi notifikasi.');

        } catch (\Exception $e) {
            DB::rollback();
            dd($e->getMessage());
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
