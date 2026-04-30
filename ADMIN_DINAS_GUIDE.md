# Sistem Admin Dinas Layanan Surakarta

## Akun Admin yang Tersedia

Setelah menjalankan `php artisan migrate:fresh --seed`, akun admin berikut akan tersedia:

### 1. Admin Super (Semua Dinas)
- **Email:** admin@mail.com
- **Password:** password123
- **URL Dashboard:** /admin/dashboard
- **Akses:** Semua pengaduan

### 2. Admin PUPR (Dinas Pekerjaan Umum dan Penataan Ruang)
- **Email:** admin-pupr@mail.com
- **Password:** password123
- **URL Dashboard:** /admin-pupr/dashboard
- **Akses:** 
  - Jalan Rusak
  - Penerangan Jalan
  - Trotoar/Drainase Rusak

### 3. Admin DLH (Dinas Lingkungan Hidup)
- **Email:** admin-dlh@mail.com
- **Password:** password123
- **URL Dashboard:** /admin-dlh/dashboard
- **Akses:**
  - Sampah/TPA Penuh
  - Air dan Sanitasi

### 4. Admin PERHUBUNGAN (Dinas Perhubungan)
- **Email:** admin-perhubungan@mail.com
- **Password:** password123
- **URL Dashboard:** /admin-perhubungan/dashboard
- **Akses:**
  - Lampu Lalu Lintas Rusak
  - Transportasi

## Fitur-Fitur Baru

### 1. Pemilihan Lokasi dengan Google Maps-like Interface
- User dapat mencari lokasi menggunakan search box
- User dapat klik pada peta untuk memilih lokasi
- Lokasi terpilih ditampilkan dengan marker dan informasi koordinat

### 2. Kategori Aduan Lengkap
- Jalan Rusak → PUPR
- Penerangan Jalan → PUPR
- Trotoar/Drainase Rusak → PUPR
- Sampah/TPA Penuh → DLH
- Air dan Sanitasi → DLH
- Lampu Lalu Lintas Rusak → PERHUBUNGAN
- Transportasi → PERHUBUNGAN

### 3. Sistem Admin Terpisah
- Setiap dinas memiliki admin terpisah
- Admin hanya dapat melihat dan mengelola pengaduan untuk dinasnya
- Statistik dan dashboard menampilkan data sesuai dinas

## Cara Kerja

### Untuk User (Pelapor)
1. User melakukan login
2. User membuka form pengaduan (/pengaduan/buat)
3. User memilih kategori aduan
4. User mencari dan memilih lokasi kejadian di peta
5. User upload bukti foto
6. User submit pengaduan

### Untuk Admin
1. Admin login sesuai dengan dinas mereka
2. Admin dapat melihat pengaduan yang masuk sesuai dinas
3. Admin dapat mengubah status pengaduan (Menunggu → Diproses → Selesai)
4. Admin hanya dapat mengakses pengaduan yang sesuai dengan dinas mereka

## Database Migration

Run migration baru:
```bash
php artisan migrate
```

Ini akan menambahkan:
- Kolom `dinas_role` ke table `users`
- Kolom `dinas` ke table `pengaduans`

## Seeding Data

Untuk membuat akun admin:
```bash
php artisan db:seed --class=AdminUserSeeder
```

Atau untuk reset database dan seed:
```bash
php artisan migrate:fresh --seed
```

## Middleware

### CheckDinasRole
Middleware baru yang mengecek apakah user memiliki `dinas_role` yang sesuai dengan route.

Contoh penggunaan:
```php
Route::middleware(['auth', 'checkDinasRole:PUPR'])->group(function() {
    // hanya untuk admin PUPR
});
```

## API Routes

### Admin PUPR Routes
- GET `/admin-pupr/pengaduan` - List pengaduan
- GET `/admin-pupr/pengaduan/proses` - Pengaduan sedang diproses
- GET `/admin-pupr/pengaduan/selesai` - Pengaduan selesai
- GET `/admin-pupr/pengaduan/{id}` - Detail pengaduan
- POST `/admin-pupr/pengaduan/{id}/status` - Update status
- GET `/admin-pupr/dashboard` - Dashboard
- POST `/admin-pupr/logout` - Logout

### Admin DLH Routes
- GET `/admin-dlh/pengaduan` - List pengaduan
- GET `/admin-dlh/pengaduan/proses` - Pengaduan sedang diproses
- GET `/admin-dlh/pengaduan/selesai` - Pengaduan selesai
- GET `/admin-dlh/pengaduan/{id}` - Detail pengaduan
- POST `/admin-dlh/pengaduan/{id}/status` - Update status
- GET `/admin-dlh/dashboard` - Dashboard
- POST `/admin-dlh/logout` - Logout

### Admin PERHUBUNGAN Routes
- GET `/admin-perhubungan/pengaduan` - List pengaduan
- GET `/admin-perhubungan/pengaduan/proses` - Pengaduan sedang diproses
- GET `/admin-perhubungan/pengaduan/selesai` - Pengaduan selesai
- GET `/admin-perhubungan/pengaduan/{id}` - Detail pengaduan
- POST `/admin-perhubungan/pengaduan/{id}/status` - Update status
- GET `/admin-perhubungan/dashboard` - Dashboard
- POST `/admin-perhubungan/logout` - Logout
