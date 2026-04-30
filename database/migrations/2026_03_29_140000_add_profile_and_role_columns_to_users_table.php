<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'nik')) {
                $table->string('nik', 16)->unique()->nullable()->after('email');
            }
            if (! Schema::hasColumn('users', 'no_hp')) {
                $table->string('no_hp', 20)->nullable()->after('nik');
            }
            if (! Schema::hasColumn('users', 'alamat')) {
                $table->text('alamat')->nullable()->after('no_hp');
            }
            if (! Schema::hasColumn('users', 'role')) {
                $table->string('role')->default('warga')->after('alamat');
            }
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $drop = [];

            foreach (['nik', 'no_hp', 'alamat', 'role'] as $column) {
                if (Schema::hasColumn('users', $column)) {
                    $drop[] = $column;
                }
            }

            if (! empty($drop)) {
                $table->dropColumn($drop);
            }
        });
    }
};
