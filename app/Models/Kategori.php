<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategoris';

    protected $fillable = [
        'nama_kategori',
        'deskripsi',
        'warna_kelas',
        'status',
    ];

    public function pengaduans()
{
    return $this->hasMany(\App\Models\Pengaduan::class, 'kategori_id');
}

}
