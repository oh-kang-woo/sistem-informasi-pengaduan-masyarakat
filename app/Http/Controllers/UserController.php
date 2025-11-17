<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengaduan;

class UserController extends Controller
{

    public function userDashboard()
    {
        $userId = auth()->id();

        return view('dashboard', [
            'totalPengaduan'  => Pengaduan::where('user_id', $userId)->count(),
            'diproses'        => Pengaduan::where('user_id', $userId)->where('status', 'diproses')->count(),
            'selesai'         => Pengaduan::where('user_id', $userId)->where('status', 'selesai')->count(),
            'pengaduanTerbaru'=> Pengaduan::where('user_id', $userId)->latest()->take(5)->get(),
        ]);
    }

}
