<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    use HasFactory;

   protected $fillable = [
    'user_id',
    'kategori_id',
    'judul_pengaduan',
    'lokasi_kejadian',
    'isi_laporan',
    'bukti',
    'status'
    ];


    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }



}
