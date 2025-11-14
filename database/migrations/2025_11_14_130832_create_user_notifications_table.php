<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_notifications', function (Blueprint $table) {
            $table->id();

            // penerima notifikasi (user/admin)
            $table->foreignId('receiver_id')->constrained('users')->onDelete('cascade');
            $table->enum('receiver_role', ['admin', 'user'])->default('user');

            // konten notifikasi
            $table->string('title');
            $table->text('message')->nullable();
            $table->string('link')->nullable();

            // status: unread/read
            $table->enum('status', ['unread', 'read'])->default('unread');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_notifications');
    }
};
