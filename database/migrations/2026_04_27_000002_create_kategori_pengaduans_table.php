<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kategori_pengaduans', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('dinas');
            $table->boolean('is_active')->default(true);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->unique(['nama', 'dinas']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kategori_pengaduans');
    }
};

