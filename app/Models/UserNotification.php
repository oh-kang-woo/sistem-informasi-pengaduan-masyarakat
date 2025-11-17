<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserNotification extends Model
{
    use HasFactory;

    protected $fillable = [
        'receiver_id',
        'receiver_role',
        'title',
        'message',
        'link',
        'status',
    ];

    // Agar Blade tetap bisa pakai $notif->judul / $notif->pesan
    public function getJudulAttribute() {
        return $this->title;
    }

    public function getPesanAttribute() {
        return $this->message;
    }

    public function getStatusTextAttribute() {
        return $this->status === 'unread' ? 'belum_dibaca' : 'dibaca';
    }
}


