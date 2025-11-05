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
        Schema::create('pengaduans', function (Blueprint $table) {
        $table->id();
        $table->string('judul');
        $table->foreignId('kategori_id')->nullable()->constrained('kategoris')->onDelete('set null');
        $table->string('lokasi');
        $table->text('isi_laporan');
        $table->string('bukti')->nullable(); // path file bukti upload
        $table->string('no_hp');
        $table->enum('status', ['Menunggu Verifikasi', 'Diproses', 'Selesai'])->default('Menunggu Verifikasi');
        $table->timestamps();
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengaduans');
    }
};
