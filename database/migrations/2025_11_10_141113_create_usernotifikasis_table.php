<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

    Schema::create('usernotifikasis', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
    $table->foreignId('pengaduan_id')->nullable()->constrained('pengaduans')->onDelete('cascade');
    $table->string('judul');
    $table->text('pesan');
    $table->enum('status', ['belum_dibaca', 'dibaca'])->default('belum_dibaca');
    $table->timestamps();
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usernotifikasis');
    }
};
