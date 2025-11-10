<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notifikasi;

class NotifikasiController extends Controller
{
    // Menampilkan semua notifikasi
public function index()
{
    $notifikasis = Notifikasi::latest()->get();

    return view('admin.notifikasi.index', [
        'notifikasis' => $notifikasis,
        'total' => Notifikasi::count(),
        'belum_dibaca' => Notifikasi::where('status', 'belum_dibaca')->count(),
        'hari_ini' => Notifikasi::whereDate('created_at', now()->toDateString())->count(),
        'gagal' => 0, // bisa nanti diisi logic real kalau ada log gagal kirim
    ]);
}


    // Tandai satu notifikasi sudah dibaca
    public function markAsRead($id)
    {
        $notif = Notifikasi::findOrFail($id);
        $notif->update(['status' => 'dibaca']);

        return redirect()->back()->with('success', 'Notifikasi telah ditandai sebagai dibaca.');
    }

    // Hapus satu notifikasi
    public function destroy($id)
    {
        Notifikasi::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Notifikasi berhasil dihapus.');
    }

    // Tandai semua notifikasi sudah dibaca
    public function markAllRead()
    {
        Notifikasi::where('status', 'belum_dibaca')->update(['status' => 'dibaca']);
        return redirect()->back()->with('success', 'Semua notifikasi telah ditandai dibaca.');
    }

    // Hapus semua notifikasi
    public function destroyAll()
    {
        Notifikasi::truncate();
        return redirect()->back()->with('success', 'Semua notifikasi telah dihapus.');
    }
}
