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
        $belumDibaca = $notifications->where('status', 'unread')->count();

        // Perlu tindakan → notifikasi dari pengaduan yang sedang diproses atau menunggu
        $perluTindakan = $notifications->filter(function ($n) {
            $keywords = ['menunggu', 'diproses', 'ditolak']; // status pengaduan
            foreach ($keywords as $word) {
                if (str_contains(strtolower($n->judul), $word) || str_contains(strtolower($n->pesan), $word)) {
                    return true;
                }
            }
            return false;
        })->count();

        return view('notifikasi', compact(
            'notifications',
            'total',
            'belumDibaca',
            'perluTindakan'
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
