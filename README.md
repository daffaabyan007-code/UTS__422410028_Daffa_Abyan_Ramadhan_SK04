# UTS Perancangan dan Pemrograman Web Lanjut - SK04: Restorasi Pita Analog

Aplikasi administrasi koleksi pita rekaman analog berbasis **Laravel 12** dan **MySQL** untuk studi kasus **SK04 - Restorasi Pita Analog**.

## Fitur Utama
- **CRUD Lengkap** Koleksi Pita Analog (`analog_tapes`)
- **Relasi One-to-One** Detail Kondisi Awal (`tape_conditions`)
- **Relasi One-to-Many** Rencana Tindakan Restorasi (`restoration_actions`)
- **Pencarian & Filter** berdasarkan kode/nama koleksi, format media, dan kondisi fisik
- **Validasi Form Request** (`StoreAnalogTapeRequest`, `UpdateAnalogTapeRequest`)
- **Service Layer & Database Transaction** (`AnalogTapeService`)
- **Seeder** contoh data awal siap pakai
- **Diagram Dokumentasi** (ERD & Class Diagram di folder `docs/`)

## Cara Memasang ke Proyek Laravel 12 Anda
1. Buat proyek Laravel 12 baru di komputer lokal Anda:
   ```bash
   composer create-project laravel/laravel:^12.0 UTS_NIM_Nama_SK04
   ```
2. Ekstrak file ZIP ini, lalu salin seluruh foldernya (`app/`, `database/`, `resources/`, `routes/`, `docs/`, `README.md`) ke dalam folder proyek Laravel 12 Anda (pilih *Replace/Overwrite* jika diminta).
3. Sesuaikan pengaturan database MySQL pada file `.env`:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=db_restorasi_pita
   DB_USERNAME=root
   DB_PASSWORD=
   ```
4. Jalankan migrasi dan seeder:
   ```bash
   php artisan migrate --seed
   ```
5. Jalankan server lokal:
   ```bash
   php artisan serve
   ```
6. Buka browser dan akses `http://127.0.0.1:8000`.
