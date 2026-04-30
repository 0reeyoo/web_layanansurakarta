<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Tambah kolom dinas_role ke users
        Schema::table('users', function (Blueprint $table) {
            $table->string('dinas_role')->nullable()->after('role');
            // dinas_role: PUPR, DLH, PERHUBUNGAN, atau null untuk user biasa
        });

        // Tambah kolom dinas ke pengaduans
        Schema::table('pengaduans', function (Blueprint $table) {
            $table->string('dinas')->nullable()->after('kategori');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('dinas_role');
        });

        Schema::table('pengaduans', function (Blueprint $table) {
            $table->dropColumn('dinas');
        });
    }
};
