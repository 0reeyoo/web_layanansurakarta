# Update Sistem - Pemilihan Lokasi Maps & Admin Dinas

## ✅ Fitur-Fitur Baru yang Ditambahkan

### 1. **Pemilihan Lokasi Kejadian dengan Google Maps-like Interface**
   
   **File yang diubah:** `resources/views/pengaduan/create.blade.php`
   
   **Fitur:**
   - ✅ Search box untuk mencari lokasi (menggunakan Nominatim OpenStreetMap)
   - ✅ Peta interaktif dengan Leaflet.js
   - ✅ Klik pada peta untuk menentukan lokasi
   - ✅ Marker otomatis pada lokasi yang dipilih
   - ✅ Info lokasi terpilih ditampilkan
   - ✅ Latitude dan Longitude tersimpan otomatis
   
   **Teknologi:**
   - Leaflet.js untuk peta
   - Nominatim OpenStreetMap untuk geocoding
   - Debounce search untuk performa optimal

### 2. **Kategori Aduan Lengkap dengan Mapping Dinas**
   
   **File yang diubah:** 
   - `app/Models/Pengaduan.php` - ditambahkan method `getCategories()` dan `getDinas()`
   - `resources/views/pengaduan/create.blade.php` - kategori dinamis dari database
   
   **Kategori:**
   ```
   Jalan Rusak → PUPR
   Penerangan Jalan → PUPR
   Trotoar/Drainase Rusak → PUPR
   Sampah/TPA Penuh → DLH
   Air dan Sanitasi → DLH
   Lampu Lalu Lintas Rusak → PERHUBUNGAN
   Transportasi → PERHUBUNGAN
   ```

### 3. **Sistem Admin Terpisah untuk Setiap Dinas**
   
   **File-File Baru:**
   - `database/migrations/2026_04_27_000001_add_dinas_columns.php`
   - `app/Http/Middleware/CheckDinasRole.php`
   
   **File yang Diubah:**
   - `app/Models/User.php` - tambah `dinas_role` ke fillable
   - `app/Models/Pengaduan.php` - tambah `dinas` ke fillable dan method kategori
   - `app/Http/Kernel.php` - register middleware `CheckDinasRole`
   - `app/Http/Controllers/PengaduanController.php` - otomatis set dinas berdasarkan kategori
   - `app/Http/Controllers/Admin/PengaduanController.php` - filter data berdasarkan dinas
   - `routes/web.php` - tambah route untuk admin PUPR, DLH, PERHUBUNGAN
   - `database/seeders/AdminUserSeeder.php` - tambah seeder admin dinas
   
   **Admin Routes:**
   - `/admin-pupr/*` - Admin PUPR
   - `/admin-dlh/*` - Admin DLH
   - `/admin-perhubungan/*` - Admin Perhubungan
   - `/admin/*` - Admin Super (semua dinas)

### 4. **Database Migration**
   
   **Kolom Baru:**
   - `users.dinas_role` - role dinas admin (PUPR, DLH, PERHUBUNGAN, atau null)
   - `pengaduans.dinas` - dinas yang menangani aduan

### 5. **Seeder Admin Dinas**
   
   **Akun yang Dibuat:**
   ```
   Admin Super: admin@mail.com / password123
   Admin PUPR: admin-pupr@mail.com / password123
   Admin DLH: admin-dlh@mail.com / password123
   Admin Perhubungan: admin-perhubungan@mail.com / password123
   ```

---

## 📊 Perubahan Database

### Migration: `2026_04_27_000001_add_dinas_columns`

```sql
-- Users Table
ALTER TABLE users ADD dinas_role VARCHAR(255) NULL AFTER role;

-- Pengaduans Table
ALTER TABLE pengaduans ADD dinas VARCHAR(255) NULL AFTER kategori;
```

---

## 🔐 Middleware Baru

### CheckDinasRole Middleware

**Fungsi:** Memastikan hanya admin dengan dinas_role yang sesuai dapat mengakses route

**Penggunaan:**
```php
Route::middleware(['auth', 'checkDinasRole:PUPR'])->group(function() {
    // Hanya untuk admin PUPR
});
```

---

## 🔄 Alur Workflow

### User (Pelapor)
1. Login dengan akun user biasa
2. Buka `/pengaduan/buat`
3. Isi data pelapor (auto-filled dari profil)
4. Pilih kategori aduan
5. Cari dan pilih lokasi di peta
6. Upload foto bukti
7. Submit pengaduan
8. Sistem otomatis set dinas berdasarkan kategori

### Admin Dinas
1. Login dengan email admin dinas
2. Masuk ke dashboard admin-[dinas]
3. Lihat pengaduan yang masuk untuk dinas mereka
4. Ubah status pengaduan (Menunggu → Diproses → Selesai)
5. View detail pengaduan dengan lokasi di peta

---

## 📍 Fitur Maps Detail

### Search Lokasi
- User mengetik nama lokasi (minimal 3 karakter)
- Sistem mencari menggunakan Nominatim API
- Hasil search ditampilkan dalam dropdown
- Klik result → marker bergerak ke lokasi dan simpan koordinat

### Click on Map
- User klik sembarang titik pada peta
- Marker muncul di titik tersebut
- Koordinat latitude & longitude otomatis tersimpan
- Info lokasi terpilih ditampilkan

### Fitur Tambahan
- View dapat di-zoom dalam/out
- Peta centered pada lokasi yang dipilih
- Default lokasi: Surakarta (center -7.5666, 110.8243)
- Zoom level 13 (default), 15 (saat select lokasi)

---

## 🚀 Cara Implementasi

### 1. Run Migration
```bash
php artisan migrate
```

### 2. Seed Admin Users
```bash
php artisan db:seed --class=AdminUserSeeder
```

Atau reset semua data:
```bash
php artisan migrate:fresh --seed
```

### 3. Testing

**User Admin PUPR:**
- URL: `http://localhost:8000/admin-pupr/dashboard`
- Email: `admin-pupr@mail.com`
- Password: `password123`
- Akses: Pengaduan kategori Jalan, Penerangan Jalan, Drainase

**User Admin DLH:**
- URL: `http://localhost:8000/admin-dlh/dashboard`
- Email: `admin-dlh@mail.com`
- Password: `password123`
- Akses: Pengaduan kategori Sampah, Air & Sanitasi

**User Admin PERHUBUNGAN:**
- URL: `http://localhost:8000/admin-perhubungan/dashboard`
- Email: `admin-perhubungan@mail.com`
- Password: `password123`
- Akses: Pengaduan kategori Lampu Lalu Lintas, Transportasi

---

## 📝 Files Modified/Created

### Created:
- ✅ `database/migrations/2026_04_27_000001_add_dinas_columns.php`
- ✅ `app/Http/Middleware/CheckDinasRole.php`
- ✅ `resources/views/auth/login-admin-dinas.blade.php`
- ✅ `ADMIN_DINAS_GUIDE.md`

### Modified:
- ✅ `app/Models/User.php`
- ✅ `app/Models/Pengaduan.php`
- ✅ `app/Http/Kernel.php`
- ✅ `app/Http/Controllers/PengaduanController.php`
- ✅ `app/Http/Controllers/Admin/PengaduanController.php`
- ✅ `resources/views/pengaduan/create.blade.php`
- ✅ `routes/web.php`
- ✅ `database/seeders/AdminUserSeeder.php`

---

## 🔍 Testing Checklist

- [ ] Migration berhasil dijalankan
- [ ] Akun admin dinas berhasil dibuat
- [ ] User bisa login dan akses form pengaduan
- [ ] Search lokasi berfungsi
- [ ] Click pada peta menyimpan koordinat
- [ ] Kategori aduan lengkap
- [ ] Admin PUPR hanya lihat aduan PUPR
- [ ] Admin DLH hanya lihat aduan DLH
- [ ] Admin PERHUBUNGAN hanya lihat aduan PERHUBUNGAN
- [ ] Status pengaduan bisa diubah
- [ ] Logout berfungsi dengan baik

---

## 📱 Mobile Responsive

Semua fitur sudah responsive untuk:
- Desktop (1024px+)
- Tablet (768px - 1023px)
- Mobile (< 768px)

---

## ⚠️ Catatan Penting

1. **API Nominatim** menggunakan bounding box Surakarta. Jika ingin ubah area, edit nilai `viewbox` di JavaScript maps
2. **Koordinat Default:** -7.5666, 110.8243 (Surakarta)
3. **Zoom Default:** Level 13 (city view)
4. **API Nominatim** gratis namun memiliki rate limit. Untuk production, pertimbangkan menggunakan Google Maps API dengan budget

---

## 🎨 UI/UX Improvements

- Search box dengan icon search
- Dropdown hasil search yang cantik
- Info lokasi terpilih ditampilkan dengan styling khusus
- Map responsive dan user-friendly
- Tooltip dan placeholder text yang membantu
- Error handling untuk failed search

---

Generated: 2026-04-27
Version: 1.0
