<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Usernotifikasi;

class NotifikasiController extends Controller
{
    public function index()
    {
        $notifications = Usernotifikasi::whereHas('user', fn($q) => $q->where('role', 'admin'))
            ->orderBy('created_at', 'desc')
            ->get();

        $total = $notifications->count();
        $belum_dibaca = $notifications->where('status', 'belum_dibaca')->count();
        $hari_ini = $notifications->filter(fn($n) => $n->created_at->isToday())->count();
        $gagal = 0;

        return view('admin.notifikasi.index', compact('notifications', 'total', 'belum_dibaca', 'hari_ini', 'gagal'));
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
        Usernotifikasi::whereHas('user', fn($q) => $q->where('role','admin'))
            ->update(['status' => 'dibaca']);
        return back()->with('success', 'Semua notifikasi telah dibaca.');
    }

    public function deleteAll()
    {
        Usernotifikasi::whereHas('user', fn($q) => $q->where('role','admin'))->delete();
        return back()->with('success', 'Semua notifikasi berhasil dihapus.');
    }
}
