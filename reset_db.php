<?php
require __DIR__.'/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
Illuminate\Support\Facades\DB::statement('DROP DATABASE IF EXISTS db_layanan_suakarta');
Illuminate\Support\Facades\DB::statement('CREATE DATABASE db_layanan_suakarta CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');
echo "ok\n";
