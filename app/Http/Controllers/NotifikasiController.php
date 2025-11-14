<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\UserNotification;

class NotifikasiController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        $notifications = UserNotification::where('receiver_id', $userId)
            ->where('receiver_role', 'user')
            ->latest()
            ->get();

        $total = $notifications->count();
        $belum_dibaca = $notifications->where('status', 'unread')->count();
        $hari_ini = $notifications->where('created_at', '>=', now()->startOfDay())->count();
        $gagal = 0; // kalau mau nanti ditambahkan

        return view('user.notifikasi.index', compact(
            'notifications', 'total', 'belum_dibaca', 'hari_ini', 'gagal'
        ));
    }

    public function markAsRead($id)
    {
        UserNotification::where('id', $id)->update(['status' => 'read']);
        return back();
    }

    public function markAll()
    {
        UserNotification::where('receiver_id', auth()->id())
            ->where('receiver_role', 'user')
            ->update(['status' => 'read']);

        return back();
    }

    public function destroy($id)
    {
        UserNotification::find($id)->delete();
        return back();
    }

    public function deleteAll()
    {
        UserNotification::where('receiver_id', auth()->id())->delete();
        return back();
    }
}
