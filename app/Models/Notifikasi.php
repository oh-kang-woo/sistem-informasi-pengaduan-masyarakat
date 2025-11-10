<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'pesan',
        'status',
        'user_id',
    ];

    // Relasi opsional ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
