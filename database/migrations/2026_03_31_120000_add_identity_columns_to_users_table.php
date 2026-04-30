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
                $table->string('nik', 16)->nullable()->unique()->after('email');
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
            if (Schema::hasColumn('users', 'no_hp')) {
                $table->dropColumn('no_hp');
            }

            if (Schema::hasColumn('users', 'nik')) {
                $table->dropColumn('nik');
            }

            if (Schema::hasColumn('users', 'alamat')) {
                $table->dropColumn('alamat');
            }

            if (Schema::hasColumn('users', 'role')) {
                $table->dropColumn('role');
            }
        });
    }
};
