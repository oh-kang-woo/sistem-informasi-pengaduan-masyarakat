<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserNotification;
use Carbon\Carbon;

class NotifikasiController extends Controller
{
    public function index()
    {
        $adminId = auth()->id();

        // Ambil semua notifikasi untuk admin
        $notifications = UserNotification::where('receiver_id', $adminId)
            ->where('receiver_role', 'admin')
            ->orderBy('created_at', 'desc')
            ->get();

        // Hitungan utama
        $total = $notifications->count();
        $belum_dibaca = $notifications->where('is_read', false)->count();
        $dibaca = $notifications->where('is_read', true)->count();

        // Hitungan tambahan yang diperlukan oleh Blade
        $hari_ini = $notifications
            ->where('created_at', '>=', Carbon::today())
            ->count();

        // Jika kamu tidak punya field "status gagal", set default 0
        $gagal = 0;

        return view('admin.notifikasi.index', compact(
            'notifications',
            'total',
            'belum_dibaca',
            'dibaca',
            'hari_ini',
            'gagal'
        ));


    }

    public function readAll()
    {
        UserNotification::where('receiver_role', 'admin')
            ->where('status', 'belum_dibaca')
            ->update(['status' => 'dibaca']);

        return redirect()->back()->with('success', 'Semua notifikasi telah ditandai dibaca.');
    }

     public function deleteAll()
    {
        UserNotification::where('receiver_role', 'admin')->delete();

        return redirect()->back()->with('success', 'Semua notifikasi berhasil dihapus.');
    }

    public function destroy($id)
{
    $notif = UserNotification::findOrFail($id);

    // Pastikan notifikasi yang dihapus milik admin
    if ($notif->receiver_role === 'admin') {
        $notif->delete();
    }

    return back()->with('success', 'Notifikasi berhasil dihapus.');
}


}
