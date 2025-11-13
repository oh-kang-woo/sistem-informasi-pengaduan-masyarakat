<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Usernotifikasi;

class NotifikasiController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Ambil notifikasi milik user yang login
        $notifications = Usernotifikasi::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        // Statistik sederhana
        $total        = $notifications->count();
        $belum_dibaca = $notifications->where('status', 'belum_dibaca')->count();
        $hari_ini     = $notifications->whereDate('created_at', now())->count();
        $gagal        = 0;

        return view('user.notifikasi.index', compact('notifications', 'total', 'belum_dibaca', 'hari_ini', 'gagal'));
    }

    public function read(Usernotifikasi $notification)
{
    $notification->update(['status' => 'dibaca']);
    return back()->with('success', 'Notifikasi telah dibaca.');
}

public function destroy(Usernotifikasi $notification)
{
    $notification->delete();
    return back()->with('success', 'Notifikasi berhasil dihapus.');
}

public function readAll()
{
    Usernotifikasi::where('user_id', auth()->id())
        ->update(['status' => 'dibaca']);
    return back()->with('success', 'Semua notifikasi telah dibaca.');
}

public function deleteAll()
{
    Usernotifikasi::where('user_id', auth()->id())->delete();
    return back()->with('success', 'Semua notifikasi berhasil dihapus.');
}

}
