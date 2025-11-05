<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'kategori_id',
        'lokasi',
        'isi_laporan',
        'bukti',
        'no_hp',
        'status'
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }
}
