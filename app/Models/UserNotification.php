<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserNotification extends Model
{
    protected $table = 'user_notifications';

    protected $fillable = [
        'receiver_id',
        'receiver_role',
        'title',
        'message',
        'link',
        'status',
    ];

    // Blade compatibility
    public function getJudulAttribute() {
        return $this->title;
    }

    public function getPesanAttribute() {
        return $this->message;
    }

    // Status compatibility
    public function getStatusTextAttribute() {
        return $this->status === 'unread' ? 'belum_dibaca' : 'dibaca';
    }
}
