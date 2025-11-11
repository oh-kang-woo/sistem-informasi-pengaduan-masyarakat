<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use App\Models\Kategori;
use App\Models\User;
use App\Models\Usernotifikasi;
use Illuminate\Http\Request;

class PengaduanController extends Controller
{
    public function create()
    {
        $kategoris = Kategori::where('status', 'aktif')->get();
        return view('pengaduan.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'          => 'required|string|max:255',
            'kategori_id'    => 'required|exists:kategoris,id',
            'lokasi'         => 'required|string|max:255',
            'isi_laporan'    => 'required|string',
            'nama'           => 'nullable|string|max:100',
            'no_hp'          => 'required|string|max:20',
            'bukti'          => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $user = User::firstOrCreate(
            ['no_hp' => $request->no_hp],
            ['nama'  => $request->nama]
        );

        if ($request->filled('nama') && $user->nama !== $request->nama) {
            $user->update(['nama' => $request->nama]);
        }

        $buktiPath = null;
        if ($request->hasFile('bukti')) {
            $buktiPath = $request->file('bukti')->store('bukti_pengaduan', 'public');
        }

        $pengaduan = Pengaduan::create([
            'user_id'         => $user->id,
            'kategori_id'     => $request->kategori_id,
            'judul_pengaduan' => $request->judul,
            'lokasi_kejadian' => $request->lokasi,
            'isi_laporan'     => $request->isi_laporan,
            'bukti'           => $buktiPath,
            'status'          => 'Menunggu Verifikasi',
        ]);

        Usernotifikasi::create([
            'user_id'      => $user->id,
            'pengaduan_id' => $pengaduan->id,
            'judul'        => 'Laporan Anda telah diterima',
            'pesan'        => 'Laporan "' . $request->judul . '" telah dikirim dan sedang menunggu verifikasi.',
            'status'       => 'belum_dibaca',
        ]);

        return redirect()->back()->with('success', 'Laporan berhasil dikirim!');
    }

    
}
