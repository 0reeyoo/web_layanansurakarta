<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pengaduans', function (Blueprint $table) {
            $table->id();
            // Menghubungkan ke tabel users (siapa yang melapor)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Data Pelapor
            $table->string('nama_pelapor');
            $table->string('ktp', 16);
            $table->string('no_telp');
            $table->text('alamat_pelapor');
            
            // Detail Pengaduan
            $table->string('kategori');
            $table->date('tanggal_kejadian');
            $table->text('deskripsi');
            
            // Lokasi Peta & Lampiran
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('foto_bukti')->nullable();
            
            // Status Laporan
            $table->string('status')->default('Menunggu');
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pengaduans');
    }
};